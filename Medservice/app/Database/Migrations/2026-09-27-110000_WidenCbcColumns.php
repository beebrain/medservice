<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * ขยายคอลัมน์ค่าเลือดจาก varchar(5) เป็น varchar(8)
 *
 * บั๊กที่แก้: MCV ช่วงที่อนุญาตคือ 40-140 และฟอร์มรับทศนิยม 2 ตำแหน่ง
 * (formatter ฝั่งแอปคือ ^\d{0,3}(\.\d{0,2})?$ ฝั่งเว็บเป็น type=text ไม่จำกัดเลย)
 * MCV = 102.35 จึงเป็นค่าที่ถูกต้องทางคลินิกและผ่าน validateCbcInput ทุกข้อ
 * แต่ยาว 6 ตัวอักษร ชน varchar(5) และ sql_mode มี STRICT_TRANS_TABLES
 * MySQL จึงโยน error ไม่ตัดเงียบ — insert ล้ม ไม่มี try/catch รอบนั้นใน predict()
 * ผลคือหมอรอโมเดลทำงานเสร็จแล้วได้ 500 ดิบกลับมา และเคสนั้นหายไปทั้งเคส
 * MCV > 100 เกิดได้จริงในเด็ก (macrocytic anemia) ไม่ใช่เคสสมมติ
 *
 * แก้ที่คอลัมน์ ไม่ใช่ที่ validation เพราะค่านั้นถูกต้อง คอลัมน์เล็กเกินไปเอง
 * การตีตกค่าที่ถูกต้องเพื่อให้เข้าช่องที่เล็กเกิน คือย้ายบั๊กไปให้ผู้ใช้แบก
 *
 * 8 ตัวอักษรพอสำหรับเพดานทุกช่องใน AiConfig::$cbcLimits ที่ทศนิยม 2 ตำแหน่ง
 * (ยาวสุดคือ MCV 140.99 = 6) เหลือที่เผื่อไว้อีก 2
 *
 * ขยายอย่างเดียว ไม่ตัดข้อมูลเดิม ย้อนกลับใน down() ได้เพราะไม่มีค่าไหน
 * ยาวเกิน 5 อยู่แล้วในตอนนี้
 *
 * ทางที่ถูกกว่านี้ในระยะยาว: เปลี่ยนเป็น DECIMAL ซึ่งจะกันค่าที่ไม่ใช่ตัวเลข
 * ได้ที่ระดับฐานข้อมูลเลย ไม่ใช่แค่ที่ชั้นแอป — แต่นั่นเปลี่ยนชนิดข้อมูลของ
 * ตารางวิจัยและเปลี่ยนสิ่งที่ CI4 อ่านได้ (string เป็น float) ควรทำแยกรอบ
 */
class WidenCbcColumns extends Migration
{
    private array $columns = ['RBC', 'HB', 'HCT', 'MCV', 'MCH', 'MCHC', 'RDW'];

    public function up()
    {
        foreach ($this->columns as $c) {
            $this->db->query("ALTER TABLE dataamenia MODIFY `$c` VARCHAR(8) NOT NULL");
        }
    }

    public function down()
    {
        foreach ($this->columns as $c) {
            $this->db->query("ALTER TABLE dataamenia MODIFY `$c` VARCHAR(5) NOT NULL");
        }
    }
}
