<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table      = 'customer';
    protected $primaryKey = 'id_customer';
    // protected $useSoftDeletes = true;
    protected $allowedFields = ['customer_name', 'sex', 'telp', 'address'];
    protected $useTimestamps = true;

    // public function __construct()
    // {
    //     $this->db = \Config\Database::connect();
    // }

    public function detailPelanggan($id = null)
    {
        // $builder = $this->db->table($this->table);
        // $builder->select('id_customer AS id, nama_customer AS customer');
        // return $builder->get()->getResultArray();
        $builder = $this->builder($this->table)->select('id_customer, customer_name AS customer, sex, telp AS telp, address');
        if (empty($id)) {
            return $builder->get()->getResult();
        } else {
            return $builder->where('id', $id)->get(1)->getRow();
        }
    }

    // public function tambahCustomer($data)
    // {
    //     return $this->insert($data);
    // }

    // public function editCustomer($data)
    // {
    //     return $this->save($data);
    // }

    // public function hapusData($id)
    // {
    //     return $this->db->table($this->table)->delete($id);
    // }
}
