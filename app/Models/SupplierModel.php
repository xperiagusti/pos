<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table = "supplier";
    protected $primaryKey = "id_supplier";
    protected $allowedFields = ['id_user', 's_name', 's_pabx', 's_email', 's_pic', 's_pic_contact', 's_type', 's_nation', 's_province', 's_city', 's_district', 's_subdistrict', 's_address', 's_zip_code', 'created_at', 'updated_at'];
}
