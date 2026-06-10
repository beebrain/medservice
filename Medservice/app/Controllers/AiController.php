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

        // API Configuration - Use internal docker network
        $apiURL = 'http://n8n:5678/webhook/predict-relay';

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
        $label = $apiData['label'] ?? 'Unknown';
        $confidence = $apiData['confidence'] ?? 0;

        log_message('info', 'API Response - Prediction: ' . $prediction . ' | Label: ' . $label . ' | Confidence: ' . $confidence);

        // Set reject options from config based on prediction value
        $rejectOptions = ($prediction == 0)
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
        $suggestionKey = ($prediction == 1) ? 'abnormal' : 'normal';
        $suggestion = $config->suggestions[$suggestionKey] ?? '';

        // Prepare final response with all API data
        $finalResponse = [
            'id' => $recordId,
            'prediction' => $prediction,
            'label' => $label,
            'confidence' => $confidence,
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

        try {
            $id = $this->request->getPost("id");
            $rejectOption = $this->request->getPost("RejectOption");

            if (empty($id)) {
                return $this->response->setStatusCode(400)
                    ->setJSON(['error' => 'ID is required']);
            }

            if (empty($rejectOption)) {
                return $this->response->setStatusCode(400)
                    ->setJSON(['error' => 'RejectOption is required']);
            }

            $anemiaModel = new Amenemiamodel();

            // Prepare update data
            $updateData = ['Rejectoption' => $rejectOption];

            // If user disagrees, update both Rejectoption and Predict with the selected option

            $anemiaModel->update($id, $updateData);

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
     * Map reject option to prediction label
     *
     * @param string $rejectOption Selected reject option
     * @return string Prediction label
     */
    private function mapRejectOptionToLabel(string $rejectOption): string
    {
        $option = strtolower(trim($rejectOption));

        // Map options to proper labels (รองรับทั้งชื่อย่อและชื่อเต็ม)
        $labelMap = [
            'normal' => 'Normal',
            'abnormal' => 'Abnormal',
            'thalassemia trait (tt)' => 'Thalassemia Trait (TT)',
            'thalassemia disease (td)' => 'Thalassemia Disease (TD)',
            'iron deficiency anemia (ida)' => 'Iron Deficiency Anemia (IDA)',
            'other' => 'Other',
            // รองรับชื่อย่อแบบเดิมด้วย
            'tt' => 'Thalassemia Trait (TT)',
            'td' => 'Thalassemia Disease (TD)',
            'ida' => 'Iron Deficiency Anemia (IDA)',
            // รองรับชื่อเต็มแบบไม่มีวงเล็บ
            'thalassemia trait' => 'Thalassemia Trait (TT)',
            'thalassemia disease' => 'Thalassemia Disease (TD)',
            'iron deficiency anemia' => 'Iron Deficiency Anemia (IDA)'
        ];

        return $labelMap[$option] ?? ucfirst($option);
    }

    /**
     * Get the total count of requests
     */
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
