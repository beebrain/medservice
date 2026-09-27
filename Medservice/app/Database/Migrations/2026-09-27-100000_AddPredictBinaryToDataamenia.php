<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * คอลัมน์ label แบบ binary สำหรับงานวิจัย คำนวณจาก Predict ตอนอ่าน
 *
 * ปัญหาที่แก้: คอลัมน์ Predict เก็บคำตอบจากโมเดล 3 ยุคที่ใช้สเกลไม่เหมือนกัน
 *   ยุค A  ก.ค.2024 - 19 พ.ย.2025   '0','1','2','3','4'     โมเดล 5 คลาส   427 แถว
 *   ยุค B  20 พ.ย.2025 - 2 ม.ค.2026 '0','1'                 binary เป็นเลข 138 แถว
 *   ยุค C  2 ม.ค.2026 - ปัจจุบัน     'Normal','Abnormal'     binary ข้อความ 286 แถว
 * ใครเปิด export ออกมาจะเจอป้ายสามระบบปนกันในคอลัมน์เดียว และเลข '2','3','4'
 * ไม่มีที่ยืนใน AiConfig::$labels ของวันนี้ (มีแค่ 0=>Normal, 1=>Abnormal)
 *
 * เกณฑ์การรวมสเกล ยืนยันโดยเจ้าของโครงการ (2026-09-27):
 *   0 = ปกติ, ค่าอื่นทั้งหมด = ผิดปกติ
 * ใช้ได้ทั้งยุค A และ B เพราะทั้งสองยุคใช้ 0 แทนปกติเหมือนกัน
 *
 * ทำเป็น generated column แทนการเขียนค่าลงไป เพราะ
 *   - ไม่มีสถานะที่สองให้หลุดจากกัน ค่าที่อ่านได้มาจาก Predict เสมอ
 *   - VIRTUAL ไม่กินที่เก็บ คำนวณตอน SELECT
 *   - export ผ่าน phpMyAdmin หยิบคอลัมน์นี้ไปได้ตรง ๆ ไม่ต้องจำสูตร
 *   - ย้อนกลับได้ด้วยการ drop คอลัมน์ ข้อมูลต้นทางไม่ถูกแตะ
 *
 * NULL คงเป็น NULL — 3 แถวที่ input ครบแต่โมเดลไม่ตอบ (id 342, 595, 597)
 * เป็นร่องรอยว่าโมเดลเคยล่มโดยไม่แจ้ง ไม่ใช่ผลการคัดกรอง จึงต้องไม่ถูกนับเป็นปกติ
 */
class AddPredictBinaryToDataamenia extends Migration
{
    public function up()
    {
        // forge ยังสร้าง generated column ให้ไม่ได้ จึงเขียน SQL ตรง
        $this->db->query(
            "ALTER TABLE dataamenia
             ADD COLUMN PredictBinary VARCHAR(8)
             AS (CASE
                   WHEN Predict IS NULL THEN NULL
                   WHEN Predict IN ('0', 'Normal') THEN 'Normal'
                   ELSE 'Abnormal'
                 END) VIRTUAL AFTER Predict"
        );
    }

    public function down()
    {
        $this->forge->dropColumn('dataamenia', 'PredictBinary');
    }
}
