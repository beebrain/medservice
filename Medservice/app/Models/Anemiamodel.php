<?php

namespace App\Models;

use CodeIgniter\Model;

class Anemiamodel extends Model
{
    protected $table            = 'dataamenia';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; // Or 'object' if you prefer
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'Ages_mo_all',
        'RBC',
        'HB',
        'HCT',
        'MCV',
        'MCH',
        'MCHC',
        'RDW',
        'Predict',
        'PredictVerified',
        'Rejectoption',
        'ConfirmVerified',
        'Agree',
        'created_at' // Assuming you want to handle this in your application
    ];

    protected bool $allowEmptyInserts = true;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';


    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function countRecord()
    {

        // ไม่นับแถวที่โมเดลไม่ได้ให้ผล (Predict='Unknown')
        // เก็บแถวไว้เป็นร่องรอยว่าระบบเคยล่ม แต่ไม่ใช่ "เคสที่ประเมินแล้ว"
        // และไม่ควรปนเข้าชุดข้อมูลวิจัย
        $result = $this->db->table('dataamenia')
            ->where('Predict !=', 'Unknown')
            ->countAllResults();
        return $result;
    }

    /**
     * นับเฉพาะแถวที่คำขอถือคีย์ของแอปมา
     *
     * ตัวเลขรวมจาก countRecord() บอกไม่ได้ว่ามาจากไหน เพราะ /predict
     * เปิดรับโดยไม่ต้องยืนยันตัวตน ใครยิง curl เข้ามาก็ถูกนับ
     * ตัวนี้คือขอบล่างที่อ้างที่มาได้ ไม่ใช่จำนวนเคสจริง (ดูคำอธิบายขอบเขต
     * ในไฟล์ migration AddClientVerifiedToDataamenia)
     */
    public function countVerified()
    {
        return $this->db->table('dataamenia')
            ->where('Predict !=', 'Unknown')
            ->where('PredictVerified', 1)
            ->countAllResults();
    }

    public function insertdata($data)

    {
        $tableamenia = $this->db->table('dataamenia');
        $tableamenia->insert($data);
    }


    public function updatedata($data)
    {
        $tableamenia = $this->db->table('dataamenia');
    }
}
