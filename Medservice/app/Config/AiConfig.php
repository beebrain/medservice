<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class AiConfig extends BaseConfig
{
    /**
     * Reject Options สำหรับกรณี Normal (prediction = 0)
     * ตัวเลือกที่แสดงเมื่อผู้ใช้ไม่เห็นด้วยกับผลการประเมิน "ปกติ"
     */
    public array $rejectOptionsNormal = [
        'Thalassemia Trait (TT)',
        'Thalassemia Disease (TD)',
        'Iron Deficiency Anemia (IDA)',
        'Other'
    ];

    /**
     * Reject Options สำหรับกรณี Abnormal (prediction = 1)
     * ตัวเลือกที่แสดงเมื่อผู้ใช้ไม่เห็นด้วยกับผลการประเมิน "ผิดปกติ"
     */
    public array $rejectOptionsAbnormal = [
        'Normal'
    ];

    /**
     * Suggestion Messages
     * ข้อความแนะนำตามผลการประเมิน
     */
    public array $suggestions = [
        'normal'   => 'ปกติ ไม่จำเป็นต้องตรวจเพิ่มเติม',
        'abnormal' => 'ส่งตรวจเพิ่มเติม'
    ];

    /**
     * ขอบเขตค่าที่ "เป็นไปได้ทางสรีรวิทยา" ใช้กันข้อมูลขยะเท่านั้น
     * ไม่ใช่ช่วงอ้างอิงปกติ (ช่วงปกติแคบกว่านี้มาก อยู่ใน REF_RANGES ฝั่ง view)
     * รูปแบบ: [ต่ำสุด, สูงสุด, หน่วย]
     */
    public array $cbcLimits = [
        'RBC'  => [1.0, 8.0,   '×10⁶/μL'],
        'HB'   => [2.0, 25.0,  'g/dL'],
        'HCT'  => [5.0, 70.0,  '%'],
        'MCV'  => [40.0, 140.0, 'fL'],
        'MCH'  => [10.0, 50.0, 'pg'],
        'MCHC' => [20.0, 45.0, 'g/dL'],
        'RDW'  => [8.0, 40.0,  '%'],
    ];

    /**
     * อายุเป็นเดือน 0 ถึง 16 ปี (แอปนี้ใช้กับเด็ก)
     */
    public array $ageLimitMonths = [0, 192];

    /**
     * Label Mapping
     * การแปลงค่า prediction เป็น label
     */
    public array $labels = [
        0 => 'Normal',
        1 => 'Abnormal'
    ];
}
