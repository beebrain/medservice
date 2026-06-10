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
     * Label Mapping
     * การแปลงค่า prediction เป็น label
     */
    public array $labels = [
        0 => 'Normal',
        1 => 'Abnormal'
    ];
}
