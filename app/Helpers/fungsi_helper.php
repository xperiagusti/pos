<?php


if (!function_exists('rupiah')) {
    // format rupiah indonesia
    function rupiah($nominal)
    {
        return number_format($nominal, 0, ',', '.');
    }
}

if (!function_exists('get_user')) {
    /**
     * Menampilkan data user yang sedang login
     */
    function get_user($kolom = '')
    {
        $model = model('App\Models\UserModel');
        $data = $model->where('id', session()->get('id'))->get()->getRow();
        if ($kolom == '') {
            return $data;
        } else {
            return $data->{$kolom};
        }
    }
}

if (!function_exists('get_logo')) {
    /**
     * Menampilkan data user yang sedang login
     */
    function get_logo()
    {
        $model = model('App\Models\KeahlianModel');
        $data = $model->find(1);
        return $data['logo'];
    }
}

if (!function_exists('get_foto_karyawan')) {
    /**
     * Mendapatkan URL foto karyawan berdasarkan id_user
     *
     * @param int $id_user ID user
     * @return string URL foto karyawan
     */
    function get_foto_karyawan($id_user)
    {
        $model = model('App\Models\KaryawanModel');
        $karyawan = $model->getKaryawanByUserId($id_user);

        if ($karyawan && isset($karyawan['foto']) && !empty($karyawan['foto'])) {
            return base_url('uploads/foto_karyawan/' . $karyawan['foto']);
        }

        return base_url('path_default_foto');
    }
}

if (!function_exists('get_nama_karyawan')) {
    /**
     * Mendapatkan nama karyawan berdasarkan id_user
     *
     * @param int $id_user ID user
     * @return string Nama karyawan
     */
    function get_nama_karyawan($id_user)
    {
        $model = model('App\Models\KaryawanModel');
        $karyawan = $model->getKaryawanByUserId($id_user);

        if ($karyawan && isset($karyawan['nama']) && !empty($karyawan['nama'])) {
            return $karyawan['nama'];
        }

        return 'Nama Default';
    }
}

if (!function_exists('get_noktp_karyawan')) {
    /**
     * Mendapatkan nama karyawan berdasarkan id_user
     *
     * @param int $id_user ID user
     * @return string Nama karyawan
     */
    function get_noktp_karyawan($id_user)
    {
        $model = model('App\Models\KaryawanModel');
        $karyawan = $model->getKaryawanByUserId($id_user);

        if ($karyawan && isset($karyawan['noktp']) && !empty($karyawan['noktp'])) {
            return $karyawan['noktp'];
        }

        return 'Nama Default';
    }
}

if (!function_exists('get_alamat_karyawan')) {
    /**
     * Mendapatkan nama karyawan berdasarkan id_user
     *
     * @param int $id_user ID user
     * @return string Nama karyawan
     */
    function get_alamat_karyawan($id_user)
    {
        $model = model('App\Models\KaryawanModel');
        $karyawan = $model->getKaryawanByUserId($id_user);

        if ($karyawan && isset($karyawan['alamat']) && !empty($karyawan['alamat'])) {
            return $karyawan['alamat'];
        }

        return 'Nama Default';
    }
}

if (!function_exists('get_nohp_karyawan')) {
    /**
     * Mendapatkan nama karyawan berdasarkan id_user
     *
     * @param int $id_user ID user
     * @return string Nama karyawan
     */
    function get_nohp_karyawan($id_user)
    {
        $model = model('App\Models\KaryawanModel');
        $karyawan = $model->getKaryawanByUserId($id_user);

        if ($karyawan && isset($karyawan['nohp']) && !empty($karyawan['nohp'])) {
            return $karyawan['nohp'];
        }

        return 'Nama Default';
    }
}

if (!function_exists('get_nama_shift_karyawan')) {
    /**
     * Mendapatkan nama karyawan berdasarkan id_user
     *
     * @param int $id_user ID user
     * @return string Nama karyawan
     */
    function get_nama_shift_karyawan($id_user)
    {
        $model = model('App\Models\KaryawanModel');
        $karyawan = $model->getKaryawanWithShiftByUserId($id_user);

        if ($karyawan && isset($karyawan['nama_shift']) && !empty($karyawan['nama_shift'])) {
            return $karyawan['nama_shift'];
        }

        return 'Tidak Ditemukan';
    }
}

if (!function_exists('get_nama_perusahaan')) {
    /**
     * Menampilkan data user yang sedang login
     */
    function get_nama_perusahaan()
    {
        $model = model('App\Models\ProfilModel');
        $data = $model->find(1);
        return $data['nama_perusahaan'];
    }
}

if (!function_exists('get_alamat')) {
    /**
     * Menampilkan data user yang sedang login
     */
    function get_alamat()
    {
        $model = model('App\Models\ProfilModel');
        $data = $model->find(1);
        return $data['alamat'];
    }
}

if (!function_exists('get_no_rek')) {
    function get_no_rek()
    {
        $model = model('App\Models\BiodataModel');
        $data = $model->find(1);
        return $data['biodata'];
    }
}

if (!function_exists('get_an_rek')) {
    function get_an_rek()
    {
        $model = model('App\Models\BiodataModel');
        $data = $model->find(1);
        return $data['footer'];
    }
}

if (!function_exists('get_kontak')) {
    /**
     * Menampilkan data user yang sedang login
     */
    function get_kontak()
    {
        $model = model('App\Models\UserModel');
        $data = $model->find(1);
        return $data['kontak'];
    }
}


if (!function_exists('get_stok_habis')) {
    /**
     * Menampilkan data user yang sedang login
     */
    function get_stok_habis()
    {
        $model = model('App\Models\StockProductModel');
        $numRows = $model->item_habis()->getNumRows();
        return $numRows > 0 ? $numRows : 0;
    }
}

if (!function_exists('get_stok_habis2')) {
    /**
     * Menampilkan data user yang sedang login
     */
    function get_stok_habis2()
    {
        $model = model('App\Models\StockProductModel');
        $result = $model->item_hampir_habis();
        return count($result);
    }
}

if (!function_exists('get_stok_expired')) {
    /**
     * Menampilkan data user yang sedang login
     */
    function get_stok_expired()
    {
        $model = model('App\Models\StockProductModel');
        $result = $model->item_hampir_expired();
        return count($result);
    }
}

if (!function_exists('get_stok_expired2')) {
    /**
     * Menampilkan data user yang sedang login
     */
    function get_stok_expired2()
    {
        $model = model('App\Models\StockProductModel');
        $result = $model->item_expired();
        return count($result);
    }
}


