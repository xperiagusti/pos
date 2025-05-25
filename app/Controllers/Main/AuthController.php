<?php

namespace App\Controllers\Main;

use App\Controllers\BaseController;
use App\Models\OnlineStatusModel;
use App\Models\KaryawanModel;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;
    protected $onlineModel;
    protected $karyawanModel;

    public function __construct()
    {
        $this->karyawanModel = new KaryawanModel();
        $this->userModel     = new UserModel();
        $this->onlineModel   = new OnlineStatusModel();
    }

    public function loginPage()
    {
        $isLoggedIn = session()->get('isLoggedIn');

        // Jika pengguna sudah login, redirect kembali ke halaman sebelumnya
        if ($isLoggedIn) {
            $previousUrl = session('previous_url') ?? '/';
            return redirect()->to($previousUrl);
        }

        $data['title'] = 'SiBabad - Login';
        session()->set('previous_url', previous_url()); // Simpan URL sebelumnya di session
        return view('authentication/auth-landing', $data);
    }

    public function processLogin()
    {
        $UsernameOrEmail = $this->request->getVar('email');
        $Pass            = $this->request->getVar('password');
        date_default_timezone_set('Asia/Jakarta');

        $user = $this->userModel->where('email', $UsernameOrEmail)
            ->orWhere('username', $UsernameOrEmail)
            ->first();

        if ($user && password_verify($Pass, $user['password'])) {
            if ($user['is_verified'] == '1') {
                if ($user['role'] == 'Administrator') {
                    $sessionData = [
                        'id_user'    => $user['id_user'],
                        'username'   => $user['username'],
                        'email'      => $user['email'],
                        'isLoggedIn' => true,
                        'role'       => $user['role']
                    ];
                    session()->set($sessionData);
                    $loggedInTime   = date('Y-m-d H:i:s');
                    $existingOnline = $this->onlineModel->where('id_user', $user['id_user'])->first();
                    if ($existingOnline) {
                        $dataOnlineUpdate = [
                            'status'    => '1',
                            'logged_in' => $loggedInTime
                        ];
                        $this->onlineModel->update($existingOnline['id_online'], $dataOnlineUpdate);
                    } else {
                        $dataOnline = [
                            'id_user'   => $user['id_user'],
                            'status'    => '1',
                            'logged_in' => $loggedInTime
                        ];
                        $this->onlineModel->insert($dataOnline);
                    }
                    return redirect()->to('/sibabad');
                } elseif ($user['role'] == 'Kasir') {
                    $sessionData = [
                        'id_user'    => $user['id_user'],
                        'username'   => $user['username'],
                        'email'      => $user['email'],
                        'isLoggedIn' => true,
                        'role'       => $user['role']
                    ];
                    session()->set($sessionData);
                    $loggedInTime   = date('Y-m-d H:i:s');
                    $existingOnline = $this->onlineModel->where('id_user', $user['id_user'])->first();
                    if ($existingOnline) {
                        $dataOnlineUpdate = [
                            'status'    => '1',
                            'logged_in' => $loggedInTime
                        ];
                        $this->onlineModel->update($existingOnline['id_online'], $dataOnlineUpdate);
                    } else {
                        $dataOnline = [
                            'id_user'   => $user['id_user'],
                            'status'    => '1',
                            'logged_in' => $loggedInTime
                        ];
                        $this->onlineModel->insert($dataOnline);
                    }
                    return redirect()->to('/sibabad2');
                } elseif ($user['role'] == 'Gudang') {
                    $sessionData = [
                        'id_user'    => $user['id_user'],
                        'username'   => $user['username'],
                        'email'      => $user['email'],
                        'isLoggedIn' => true,
                        'role'       => $user['role']
                    ];
                    session()->set($sessionData);
                    $loggedInTime   = date('Y-m-d H:i:s');
                    $existingOnline = $this->onlineModel->where('id_user', $user['id_user'])->first();
                    if ($existingOnline) {
                        $dataOnlineUpdate = [
                            'status'    => '1',
                            'logged_in' => $loggedInTime
                        ];
                        $this->onlineModel->update($existingOnline['id_online'], $dataOnlineUpdate);
                    } else {
                        $dataOnline = [
                            'id_user'   => $user['id_user'],
                            'status'    => '1',
                            'logged_in' => $loggedInTime
                        ];
                        $this->onlineModel->insert($dataOnline);
                    }
                    return redirect()->to('/sibabad3');
                } else {
                    session()->setFlashdata('unauthorized', 'You are not authorized to access this dashboard.');
                    return redirect()->to('auth/login');
                }
            } else {
                session()->setFlashdata('unverif', 'Akun Anda belum terverifikasi. Silakan hubungi Administrator!');
                return redirect()->to('auth/login');
            }
        } else {
            session()->setFlashdata('failed', 'Email, Nama Pengguna Atau Kata Sandi salah.');
            return redirect()->to('auth/login');
        }
    }

    public function LogOut()
    {
        date_default_timezone_set('Asia/Jakarta');

        $UserId = session('id_user');

        $loggedInTime = date('Y-m-d H:i:s');

        // Check if there is an existing online status for the user
        $existingOnline = $this->onlineModel->where('id_user', $UserId)->first();

        if ($existingOnline) {
            // Update existing online status
            $dataOnlineUpdate = [
                'id_user'    => $UserId,
                'status'     => '0',
                'logged_out' => $loggedInTime
            ];
            $this->onlineModel->update($existingOnline['id_online'], $dataOnlineUpdate);
        }

        session()->destroy();
        return redirect()->to('/');
    }
}