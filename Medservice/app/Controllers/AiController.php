<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Anemiamodel as Amenemiamodel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\AiConfig;

class AiController extends Controller
{
    /**
     * Handle OPTIONS request for CORS preflight
     */
    public function options()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Max-Age: 3600");
        return $this->response->setStatusCode(200);
    }

    /**
     * Predict anemia from input data
     */
    public function predict()
    {
        // Set CORS headers
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        if ($this->tooManyRequests()) {
            return $this->response
                ->setStatusCode(429)
                ->setJSON([
                    'error'   => 'Too many requests. Please try again in a moment.',
                    'message' => 'ส่งข้อมูลถี่เกินไป กรุณารอสักครู่แล้วลองใหม่'
                ]);
        }

        // Get input data - support both JSON and form POST
        $contentType = $this->request->getHeaderLine('Content-Type');
        if (strpos($contentType, 'application/json') !== false) {
            $inputdata = $this->request->getJSON(true);
        } else {
            $inputdata = $this->request->getPost();
        }

        // Validate input data
        if (empty($inputdata)) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['error' => 'No input data provided']);
        }

        // ตรวจค่าก่อนยิงหาโมเดล ฝั่ง browser ข้ามได้ ฝั่งนี้ข้ามไม่ได้
        if ($invalid = $this->validateCbcInput($inputdata)) {
            log_message('warning', 'Predict rejected - ' . $invalid . ' | Data: ' . json_encode($inputdata));
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['error' => $invalid, 'message' => 'ค่าที่กรอกอยู่นอกช่วงที่เป็นไปได้']);
        }

        // API Configuration — required from .env (n8n.predictURL)
        $apiURL = env('n8n.predictURL') ?: throw new \RuntimeException('n8n.predictURL not set in .env');

        // Log request
        log_message('info', 'Predict Request - URL: ' . $apiURL);
        log_message('info', 'Predict Request - Data: ' . json_encode($inputdata));

        // Call API
        $apiResponse = $this->callPredictionAPI($apiURL, $inputdata);

        if ($apiResponse['error']) {
            return $this->response
                ->setStatusCode($apiResponse['httpCode'])
                ->setJSON([
                    'error' => $apiResponse['message'],
                    'details' => $apiResponse['details']
                ]);
        }

        // ไม่มี prediction = โมเดลไม่ได้ให้ผลอะไรกลับมา
        // ต้องหยุดตรงนี้ ห้ามไหลต่อ เพราะ processAPIResponse จะ:
        //   1) แต่ง label='Unknown', confidence=0 ขึ้นมาเอง
        //   2) insert แถวลงฐานข้อมูลด้วย Predict='Unknown' (แถวขยะที่ถูกนับใน get-count)
        //   3) ตกเข้า branch 'normal' เพราะ PHP ตีความ null == 0 เป็น true
        //      -> suggestion = "ปกติ ไม่จำเป็นต้องตรวจเพิ่มเติม" ทั้งที่ไม่มีผลแปลเลย
        // ตอบ 502 ให้ client รู้ว่าเป็นความผิดพลาดของ upstream ไม่ใช่ผลการคัดกรอง
        // isset คืน true ให้ false, "", "abc", [] ด้วย แล้วค่าพวกนั้น (int) cast เป็น 0
        // จะตกเข้า branch Normal -> "ปกติ ไม่จำเป็นต้องตรวจเพิ่มเติม"
        // จึงต้องตรวจว่าเป็นตัวเลขและเป็น 0 หรือ 1 เท่านั้น
        $rawPrediction = $apiResponse['data']['prediction'] ?? null;
        if (!is_numeric($rawPrediction)
            || !in_array((int) $rawPrediction, [0, 1], true)) {
            log_message('error', 'Upstream returned no usable prediction: '
                . json_encode($apiResponse['data']));
            return $this->response
                ->setStatusCode(502)
                ->setJSON([
                    'error'   => 'no_prediction',
                    'message' => 'ระบบแปลผลไม่ตอบกลับ กรุณาลองใหม่อีกครั้ง',
                ]);
        }

        // Initialize model and save data with prediction after API success
        $anemiaModel = new Amenemiamodel();

        // Process API response and save to database
        $processedData = $this->processAPIResponse($apiResponse['data'], $inputdata, $anemiaModel);

        // Return response
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($processedData, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * จำกัดจำนวนครั้งต่อ IP กันการยิงถล่มและข้อมูลขยะ
     * ponytail: ใช้ throttler ของ CI4 ที่มีอยู่แล้ว ไม่ต้องเขียนตัวนับเอง
     * เพดานตั้งสูงพอให้คลินิกที่ออกเน็ตผ่าน IP เดียวกันหลายคนใช้ได้ตามปกติ
     */
    private function tooManyRequests(int $perMinute = 60): bool
    {
        $throttler = \Config\Services::throttler();

        if ($throttler->check(md5($this->request->getIPAddress()), $perMinute, MINUTE) === false) {
            log_message('warning', 'Rate limited: ' . $this->request->getIPAddress());

            return true;
        }

        return false;
    }

    /**
     * ตรวจว่าค่าที่ส่งมาเป็นไปได้ทางสรีรวิทยา
     *
     * @return string|null ข้อความบอกสิ่งที่ผิด หรือ null ถ้าผ่าน
     */
    private function validateCbcInput(array $data): ?string
    {
        $config = new AiConfig();

        $age = $data['Ages_mo_all'] ?? null;
        [$ageMin, $ageMax] = $config->ageLimitMonths;

        if (!is_numeric($age) || (float) $age < $ageMin || (float) $age > $ageMax) {
            return sprintf('Ages_mo_all must be a number between %d and %d months', $ageMin, $ageMax);
        }

        foreach ($config->cbcLimits as $field => [$min, $max, $unit]) {
            if (!isset($data[$field]) || !is_numeric($data[$field])) {
                return $field . ' is required and must be a number';
            }

            $value = (float) $data[$field];
            if ($value < $min || $value > $max) {
                return sprintf('%s must be between %s and %s %s', $field, $min, $max, $unit);
            }
        }

        return null;
    }

    /**
     * Call prediction API
     *
     * @param string $url API endpoint
     * @param array $data Input data
     * @return array Response with error flag, data, and HTTP code
     */
    private function callPredictionAPI(string $url, array $data): array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        $curlErrno = curl_errno($ch);
        curl_close($ch);

        // Log response
        log_message('info', 'Predict Response - HTTP Code: ' . $httpCode);
        log_message('info', 'Predict Response - Body: ' . $response);

        if ($curlError) {
            log_message('error', 'CURL Error: ' . $curlError . ' (Code: ' . $curlErrno . ')');
            return [
                'error' => true,
                'httpCode' => 500,
                'message' => 'Connection failed',
                'details' => $curlError
            ];
        }

        if ($httpCode !== ResponseInterface::HTTP_OK) {
            log_message('error', 'HTTP Error: ' . $httpCode . ' - Response: ' . $response);
            return [
                'error' => true,
                'httpCode' => $httpCode,
                'message' => 'API request failed',
                'details' => substr($response, 0, 200)
            ];
        }

        // Decode JSON response
        $decodedData = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', 'JSON Decode Error: ' . json_last_error_msg());
            return [
                'error' => true,
                'httpCode' => 500,
                'message' => 'Invalid JSON response',
                'details' => json_last_error_msg()
            ];
        }

        return [
            'error' => false,
            'httpCode' => 200,
            'data' => $decodedData
        ];
    }

    /**
     * Process API response and prepare final output
     *
     * @param array $apiData Data from API (prediction, confidence, label)
     * @param array $inputdata Original input data from user
     * @param Amenemiamodel $model Database model
     * @return array Processed response data
     */
    private function processAPIResponse(array $apiData, array $inputdata, Amenemiamodel $model): array
    {
        // Load config
        $config = new AiConfig();

        // Get prediction value from API (0 or 1)
        $prediction = $apiData['prediction'] ?? null;
        // label คือสิ่งที่หมออ่านและสิ่งที่ลงฐานข้อมูลวิจัย จึงต้อง derive จาก
        // prediction ที่ผ่าน guard มาแล้ว ไม่ใช่รับค่าดิบจาก upstream
        //   - upstream ส่ง prediction:1 + label:"Normal" -> แบนเนอร์สีผิดปกติแต่เขียนว่า Normal
        //   - upstream ไม่ส่ง label -> ลง DB เป็น 'Unknown' แล้วโดน countRecord() คัดทิ้ง
        //     ทั้งที่เป็นเคสที่ประเมินสำเร็จ = ตัวนับขาดและข้อมูลวิจัยหายแถว
        // $config->labels มีอยู่แล้วแต่ไม่เคยถูกใช้ ต่อสายให้เรียบร้อย
        $label = $config->labels[(int) $prediction] ?? 'Unknown';
        $upstreamLabel = $apiData['label'] ?? null;
        if ($upstreamLabel !== null && $upstreamLabel !== $label) {
            log_message('warning', sprintf(
                'Label mismatch: upstream="%s" derived="%s" prediction=%s',
                $upstreamLabel, $label, var_export($prediction, true)
            ));
        }
        // null ไม่ใช่ 0 — ให้แอปแยกออกว่า "ไม่มีค่า" กับ "มั่นใจ 0%" คนละเรื่อง
        $confidence = $apiData['confidence'] ?? null;

        log_message('info', 'API Response - Prediction: ' . $prediction . ' | Label: ' . $label . ' | Confidence: ' . $confidence);

        // Set reject options from config based on prediction value
        // === แทน == กัน null/"0" หลุดเข้า branch ผิด
        $rejectOptions = ((int) $prediction === 0)
            ? $config->rejectOptionsNormal
            : $config->rejectOptionsAbnormal;

        log_message('info', 'Reject Options: ' . json_encode($rejectOptions));

        // Merge input data with prediction label from API
        $dataToInsert = array_merge($inputdata, [
            'Predict' => $label
        ]);

        // Insert to database with prediction
        $recordId = $model->insert($dataToInsert);

        log_message('info', 'Data inserted to database - Record ID: ' . $recordId . ' | Predict: ' . $label);

        // Set suggestion from config based on prediction
        $suggestionKey = ((int) $prediction === 1) ? 'abnormal' : 'normal';
        $suggestion = $config->suggestions[$suggestionKey] ?? '';

        // Prepare final response with all API data
        $finalResponse = [
            'id' => $recordId,
            // normalize ก่อนส่งออก — guard ใช้ is_numeric ซึ่ง "1" ผ่านได้
            // ฝั่งแอป (raw['prediction'] as num?) จะโยน TypeError กับสตริง
            // แล้วข้อความ Dart ดิบ ๆ จะไปโผล่ในกล่อง error ที่หมออ่าน
            // json_encode ก็คืน false ทั้งก้อนถ้า confidence เป็น Infinity/NaN
            'prediction' => (int) $prediction,
            'label' => $label,
            'confidence' => (is_numeric($confidence) && is_finite((float) $confidence))
                ? (float) $confidence
                : null,
            'rejectOptions' => $rejectOptions,
            'suggestion' => $suggestion
        ];

        log_message('info', 'Final Response: ' . json_encode($finalResponse));

        return $finalResponse;
    }

    /**
     * Confirm or reject prediction
     */
    public function confirm()
    {
        // Set CORS headers
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        if ($this->tooManyRequests()) {
            return $this->response
                ->setStatusCode(429)
                ->setJSON([
                    'error'   => 'Too many requests. Please try again in a moment.',
                    'message' => 'ส่งข้อมูลถี่เกินไป กรุณารอสักครู่แล้วลองใหม่'
                ]);
        }

        try {
            $id = $this->request->getPost("id");
            $rejectOption = $this->request->getPost("RejectOption");

            if (empty($id)) {
                return $this->response->setStatusCode(400)
                    ->setJSON(['error' => 'ID is required', 'message' => 'ไม่พบรหัสรายการ']);
            }

            if (empty($rejectOption)) {
                return $this->response->setStatusCode(400)
                    ->setJSON(['error' => 'RejectOption is required', 'message' => 'ไม่ได้ระบุคำตอบ']);
            }

            // รับเฉพาะค่าที่เป็นตัวเลือกจริงที่ส่งให้ผู้ใช้ ไม่งั้น label ที่จะเอาไปเทรนเชื่อไม่ได้
            $config  = new AiConfig();
            $allowed = array_merge(
                ['confirm'],
                $config->rejectOptionsNormal,
                $config->rejectOptionsAbnormal
            );

            // แอป Android ส่ง 'Confirm' ตัวใหญ่ เว็บส่ง 'confirm' ตัวเล็ก
            // เทียบแบบไม่สนตัวพิมพ์ แล้วเก็บรูปแบบมาตรฐานลง DB ให้เหมือนกันหมด
            $canonical = null;
            foreach ($allowed as $option) {
                if (strcasecmp($rejectOption, $option) === 0) {
                    $canonical = $option;
                    break;
                }
            }

            if ($canonical === null) {
                log_message('warning', 'Confirm rejected - invalid option: ' . $rejectOption);
                return $this->response->setStatusCode(400)
                    ->setJSON(['error' => 'Invalid RejectOption', 'message' => 'คำตอบไม่อยู่ในตัวเลือกที่กำหนด']);
            }

            $rejectOption = $canonical;

            $anemiaModel = new Amenemiamodel();
            $row = $anemiaModel->find($id);

            if ($row === null) {
                return $this->response->setStatusCode(404)
                    ->setJSON(['error' => 'Record not found', 'message' => 'ไม่พบรายการนี้ในระบบ']);
            }

            // ตอบได้ครั้งเดียวต่อ record แก้คำตอบไม่ได้
            $existing = $row['rejectoption'] ?? ($row['Rejectoption'] ?? null);

            if ($existing !== null && $existing !== '') {
                // ส่งซ้ำด้วยคำตอบเดิม เช่นแอป retry ตอนเน็ตหลุด ถือว่าสำเร็จ ไม่ใช่ error
                if (strcasecmp($existing, $rejectOption) === 0) {
                    log_message('info', 'Confirm repeated with same answer. ID: ' . $id);

                    return $this->response->setJSON([
                        'info'         => 'unchanged',
                        'success'      => true,
                        'id'           => $id,
                        'rejectOption' => $existing,
                        'message'      => 'บันทึกความคิดเห็นไว้แล้ว'
                    ]);
                }

                log_message('info', 'Confirm ignored - already answered. ID: ' . $id);

                return $this->response->setStatusCode(409)
                    ->setJSON([
                        'error'   => 'Feedback already recorded',
                        'message' => 'รายการนี้ให้ความคิดเห็นไปแล้ว แก้ไขไม่ได้'
                    ]);
            }

            $anemiaModel->update($id, ['Rejectoption' => $rejectOption]);

            log_message('info', 'Feedback saved - ID: ' . $id . ' | Option: ' . $rejectOption);

            $response = [
                "info" => "updated",
                "success" => true,
                "id" => $id,
                "rejectOption" => $rejectOption,
                "message" => ($rejectOption === 'confirm')
                    ? "ผู้ใช้เห็นด้วยกับผลการประเมิน"
                    : "ผู้ใช้ไม่เห็นด้วย - ควรเป็น: " . $rejectOption
            ];

            return $this->response
                ->setContentType('application/json')
                ->setJSON($response);
        } catch (\Exception $e) {
            log_message('error', 'Confirm Error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)
                ->setContentType('application/json')
                ->setJSON([
                    'error' => 'Update failed',
                    'message' => $e->getMessage()
                ]);
        }
    }

    /**
     * Get the total count of requests
     */
    /**
     * GET /ai/reference-ranges
     *
     * ส่งช่วงอ้างอิงให้ client ดึงไปใช้ จะได้ไม่ต้องฝังเกณฑ์ไว้ทั้งในเว็บและในแอป
     * แอปควร cache ไว้แล้วเทียบด้วย version ถ้าดึงไม่ได้ให้ใช้ค่าที่ฝังไว้เป็น fallback
     * (เกณฑ์เป็นข้อมูลความปลอดภัยทางคลินิก ห้ามปล่อยให้แปลผลไม่ได้เพราะเน็ตล่ม)
     */
    public function referenceRanges()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        $config = new \Config\ReferenceRangeConfig();

        return $this->response
            ->setContentType('application/json')
            ->setJSON([
                'version' => $config->version,
                'groups'  => $config->groups,
                'items'   => $config->items,
            ]);
    }

    public function getCount()
    {
        // Set CORS headers
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        $anemiaModel = new Amenemiamodel();
        $count = $anemiaModel->countRecord();

        return $this->response
            ->setContentType('application/json')
            ->setJSON(['count' => $count]);
    }
}
