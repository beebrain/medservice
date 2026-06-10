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
        'Rejectoption',
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

        $result = $this->db->table('dataamenia')->countAll();
        return $result;
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
