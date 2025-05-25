<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
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
}
