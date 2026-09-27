<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * บันทึกที่มาของแถว: คำขอนั้นถือคีย์ของแอปมาหรือไม่
 *
 * /predict และ /confirm เปิดรับโดยไม่ต้องยืนยันตัวตนมาตลอด (ไม่มีทั้ง Filters,
 * controller และ reverse proxy) ใครก็เขียนแถวลงชุดข้อมูลวิจัยได้ด้วย curl
 * ตัวเลขจำนวนเคสจึงไม่มีอะไรรับประกันว่ามาจากการคัดกรองเด็กจริง
 *
 * ธงนี้ไม่ได้ปิดช่องนั้น มันทำให้ "แยกออก" ได้ตอน export
 * บังคับยืนยันตัวตนทันทีจะทำให้แอปที่ลงเครื่องไปแล้วใช้ไม่ได้ทั้งหมด
 * จึงเก็บสถิติไว้แทน แล้วให้เวอร์ชันใหม่ของแอปส่งคีย์มา
 *
 * ขอบเขตที่มันบอกได้จริง — คีย์ฝังอยู่ในไฟล์แอป คนที่แกะไฟล์แอปอ่านได้
 * 1 = คำขอนี้ถือคีย์ที่ตรงกับ ai.clientKey บน server มา
 *     ยกระดับจาก "ใครก็ได้ที่มี curl" เป็น "คนที่แกะไฟล์แอปแล้ว" เท่านั้น
 * 0 = ไม่ถือคีย์มา หรือคีย์ไม่ตรง หรือ server ยังไม่ได้ตั้งคีย์
 *     รวมถึงคำขอจากหน้าเว็บ ซึ่งตั้งใจไม่ให้ถือคีย์ เพราะคีย์ในหน้าเว็บคือคีย์สาธารณะ
 *     ถ้าให้เว็บถือคีย์เดียวกัน ธงนี้จะไม่เหลือความหมายอะไรเลย
 * นี่ไม่ใช่การยืนยันตัวผู้ใช้ และไม่ได้บอกว่าเป็นเคสจริง
 */
class AddClientVerifiedToDataamenia extends Migration
{
    public function up()
    {
        $this->forge->addColumn('dataamenia', [
            'PredictVerified' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 0,
                'after'      => 'Predict',
            ],
            // null = ยังไม่มีใครให้ความคิดเห็นกับแถวนี้ คนละเรื่องกับ "ให้มาแบบไม่ verified"
            'ConfirmVerified' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
                'default'    => null,
                'after'      => 'Rejectoption',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('dataamenia', ['PredictVerified', 'ConfirmVerified']);
    }
}
