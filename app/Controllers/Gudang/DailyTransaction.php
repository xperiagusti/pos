<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class DailyTransaction extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel     = new UserModel();
    }

    public function index()
    {
        $data['title'] = "SiBabad - Input Transaksi Harian";

        $user = $this->userModel->find(session()->get('id_user'));

        if ($user && $user['role'] !== 'Administrator') {
            session()->setFlashdata('message', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
            return redirect()->to(base_url('auth/logged_out'));
        }
        return view('admin/body/transaction/index-daily', $data);
    }
}
