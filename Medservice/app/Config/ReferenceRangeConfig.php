<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * ช่วงอ้างอิงค่าเม็ดเลือดแดงของโครงการ Kid CBC Checker
 * กำหนดโดยแพทย์ที่ปรึกษาโครงการ (รพ.อุตรดิตถ์)
 *
 * แหล่งความจริงเพียงที่เดียว (single source of truth)
 * ทั้งหน้าเว็บ (Views/index.php) และ endpoint /ai/reference-ranges อ่านจากไฟล์นี้
 * เพื่อไม่ให้ต้องแก้หลายที่แล้วหลุดจากกัน
 *
 * ถ้าแพทย์ปรับเกณฑ์: แก้ที่นี่ที่เดียว แล้วขยับ $version
 * แอปฝั่ง client ใช้ $version ตัดสินใจว่าจะโหลดชุดใหม่หรือใช้ cache เดิม
 */
class ReferenceRangeConfig extends BaseConfig
{
    /** ขยับทุกครั้งที่แก้ค่าในไฟล์นี้ */
    public string $version = '2026-09-27';

    /**
     * กลุ่มอายุ — maxAgeMonths คือขอบบน (รวมค่านั้น) null = กลุ่มสุดท้าย
     */
    public array $groups = [
        ['key' => 'g1', 'maxAgeMonths' => 72,   'labelTh' => 'อายุ ≤ 6 ปี', 'labelEn' => '≤ 6 y'],
        ['key' => 'g2', 'maxAgeMonths' => null, 'labelTh' => 'อายุ > 6 ปี', 'labelEn' => '> 6 y'],
    ];

    /**
     * ช่วงอ้างอิงต่อค่าเลือด
     * รูปแบบ: key, label, unit, ranges => [กลุ่ม => [ต่ำสุด, สูงสุด]]
     */
    public array $items = [
        ['key' => 'Hb',   'label' => 'Hb',   'unit' => 'g/dL',    'ranges' => ['g1' => [11.0, 13.9], 'g2' => [11.3, 14.3]]],
        ['key' => 'Hct',  'label' => 'Hct',  'unit' => '%',       'ranges' => ['g1' => [32.0, 39.0], 'g2' => [33.0, 41.0]]],
        ['key' => 'RBC',  'label' => 'RBC',  'unit' => '×10⁶/μL', 'ranges' => ['g1' => [3.96, 4.92], 'g2' => [3.98, 5.15]]],
        ['key' => 'MCV',  'label' => 'MCV',  'unit' => 'fL',      'ranges' => ['g1' => [72.0, 86.0], 'g2' => [76.0, 86.0]]],
        ['key' => 'MCH',  'label' => 'MCH',  'unit' => 'pg',      'ranges' => ['g1' => [25.5, 30.6], 'g2' => [25.7, 30.6]]],
        ['key' => 'MCHC', 'label' => 'MCHC', 'unit' => 'g/dL',    'ranges' => ['g1' => [33.2, 36.0], 'g2' => [33.5, 36.1]]],
        ['key' => 'RDW',  'label' => 'RDW',  'unit' => '%',       'ranges' => ['g1' => [11.9, 14.9], 'g2' => [12.0, 14.1]]],
    ];

    /**
     * แปลงเป็นรูปแบบแบนที่ JS ฝั่งเว็บใช้อยู่เดิม: { key, label, unit, g1:[], g2:[] }
     * ทำให้ไม่ต้องแก้ตรรกะ renderReferenceRanges ที่ใช้งานได้ดีอยู่แล้ว
     */
    public function toLegacyJsRows(): array
    {
        $rows = [];
        foreach ($this->items as $it) {
            $row = ['key' => $it['key'], 'label' => $it['label'], 'unit' => $it['unit']];
            foreach ($it['ranges'] as $g => $minmax) {
                $row[$g] = $minmax;
            }
            $rows[] = $row;
        }
        return $rows;
    }
}
