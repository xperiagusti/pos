<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProfilModel;
use App\Models\BiodataModel;
use App\Models\SosialModel;
use App\Models\KeahlianModel;
use App\Models\UserModel;

class ProfilController extends BaseController
{
    protected $profilModel;
    protected $biodataModel;
    protected $sosialModel;
    protected $keahlianModel;
    protected $userModel;

    public function __construct()
    {
        $this->profilModel   = new ProfilModel();
        $this->biodataModel  = new BiodataModel();
        $this->sosialModel   = new SosialModel();
        $this->keahlianModel = new KeahlianModel();
        $this->userModel     = new UserModel();
    }

    public function index()
    {
        $data['title'] = "SiBabad - Dashboard Analytics";

        $profilModel   = new ProfilModel();
        $biodataModel  = new BiodataModel();
        $sosialModel   = new SosialModel();
        $userModel     = new UserModel();
        $keahlianModel = new KeahlianModel();

              $id_keahlian  = 1;
              $id_profil    = 1;
              $id_biodata   = 1;
              $id_sosial    = 1;
              $id_user      = session('id_user');
        $data['prof']       = $profilModel->getProfileById($id_profil);
        $data['bio']        = $biodataModel->getBiodataById($id_biodata);
        $data['sos']        = $sosialModel->getSosialById($id_sosial);
        $data['kea']        = $keahlianModel->getKeahlianById($id_keahlian);
        $data['user']       = $userModel->getUserById($id_user);
        $data['id_profil']  = $id_profil;
        $data['id_biodata'] = $id_biodata;

        $user = $this->userModel->find(session()->get('id_user'));

        if ($user && $user['role'] !== 'Administrator') {
            session()->setFlashdata('message', 'Anda tidak memiliki izin untuk melakukan aksi ini.');
            return redirect()->to(base_url('auth/logged_out'));
        }

        return view('admin/body/profil/index-profil', $data);
    }

    public function saveProfil()
    {
        $id_profil = 1;

        $nama_perusahaan = $this->request->getPost('nama_perusahaan');
        $alamat          = $this->request->getPost('alamat');
        $kecamatan       = $this->request->getPost('kecamatan');
        $provinsi        = $this->request->getPost('provinsi');
        $kode_pos        = $this->request->getPost('kode_pos');
        $email           = $this->request->getPost('email');
        $id_user         = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        $profilModel = new ProfilModel();
        $data        = [
            'id_user'         => $id_user,
            'nama_perusahaan' => $nama_perusahaan,
            'alamat'          => $alamat,
            'kecamatan'       => $kecamatan,
            'provinsi'        => $provinsi,
            'kode_pos'        => $kode_pos,
            'email'           => $email,
            'updated_at'      => date('Y-m-d H:i:s')
        ];

        $profilModel->update($id_profil, $data);

        ///adminrolenya

        // Set pesan sukses
        session()->setFlashdata('success', 'Data berhasil diperbarui');

        // Redirect ke metode index di profilController
        return redirect()->to(base_url('admin/profil/index'));
    }

    public function userProfil()
    {
        $nama_lengkap   = $this->request->getPost('nama_lengkap');
        $email          = $this->request->getPost('email');
        $kontak         = $this->request->getPost('kontak');
        $alamat_lengkap = $this->request->getPost('alamat_lengkap');
        date_default_timezone_set('Asia/Jakarta');

        $userModel = new UserModel();
        $data      = [
            'nama_lengkap'   => $nama_lengkap,
            'kontak'         => $kontak,
            'email'          => $email,
            'alamat_lengkap' => $alamat_lengkap,
            'updated_at'     => date('Y-m-d H:i:s')
        ];

        $userModel->update(session('id_user'), $data);

        ///adminrolenya

        // Set pesan sukses
        session()->setFlashdata('success', 'Data berhasil diperbarui');

        // Redirect ke metode index di profilController
        return redirect()->to(base_url('admin/profil/index'));
    }

    public function biodataProfil()
    {
        $id_biodata = 1;

        $biodata = $this->request->getPost('biodata');
        $footer  = $this->request->getPost('footer');
        $id_user = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        $biodataModel = new BiodataModel();
        $data         = [
            'id_user'    => $id_user,
            'biodata'    => $biodata,
            'footer'     => $footer,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $biodataModel->update($id_biodata, $data);

        ///adminrolenya

        // Set pesan sukses
        session()->setFlashdata('success', 'Data berhasil diperbarui');

        // Redirect ke metode index di profilController
        return redirect()->to(base_url('admin/profil/index'));
    }

    public function sosialProfil()
    {
        $id_sosial = 1;

        $nama_sosmed = $this->request->getPost('nama_sosmed');
        $url         = $this->request->getPost('url');
        $icon        = $this->request->getPost('icon');
        $id_user     = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        $sosialModel = new SosialModel();
        $data        = [
            'id_user'     => $id_user,
            'nama_sosmed' => $nama_sosmed,
            'url'         => $url,
            'icon'        => $icon,
            'updated_at'  => date('Y-m-d H:i:s')
        ];

        $sosialModel->update($id_sosial, $data);

        ///adminrolenya

        // Set pesan sukses
        session()->setFlashdata('success', 'Data berhasil diperbarui');

        // Redirect ke metode index di profilController
        return redirect()->to(base_url('admin/profil/index'));
    }

    public function keahlianProfil()
    {
        $keahlianModel = new KeahlianModel();

        // Tangani upload gambar
        $logo = $this->request->getFile('logo');

        if ($logo->isValid() && !$logo->hasMoved()) {
            // Hapus semua file di folder uploads/logo_perusahaan
            $path  = ROOTPATH . 'public/uploads/logo_perusahaan/';
            $files = glob($path . '*');                             // Dapatkan semua nama file dalam folder
            foreach ($files as $file) { // Loop untuk menghapus semua file
                if (is_file($file))
                    unlink($file); // Hapus file
            }

            $newName = 'logo_perusahaan.' . $logo->getExtension();  // Ganti nama file dengan 'logo_perusahaan'
            $logo->move($path, $newName);

            $data['logo'] = $newName;  // Simpan nama file dalam basis data
        } else {
            $data['logo'] = '';  // Logo tetap tidak berubah
        }

        $id_keahlian = 1;
        $keahlian    = $this->request->getPost('keahlian');
        $persentase  = $this->request->getPost('persentase');
        $id_user     = session('id_user');
        date_default_timezone_set('Asia/Jakarta');

        $dataToUpdate = [
            'id_user'    => $id_user,
            'keahlian'   => $keahlian,
            'persentase' => $persentase,
            'logo'       => $data['logo'],
            // Menggunakan data logo baru atau yang sudah ada
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Tambahkan kondisi where agar tidak terjadi pembaruan tanpa klausa where
        $keahlianModel->where('id_keahlian', $id_keahlian)->set($dataToUpdate)->update();

        ///adminrolenya

        session()->setFlashdata('success', 'Data berhasil diperbarui');

        return redirect()->to(base_url('admin/profil/index'));
    }

}