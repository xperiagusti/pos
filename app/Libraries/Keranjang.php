<?php

namespace App\Libraries;

class Keranjang {

    public static function tambah($id = null, array $item)
    {
        $item['total'] = ($item['harga'] * $item['jumlah']);
        $item['diskon'] = 0;
        $item['notes'] = '';
        if (session()->has('keranjang')) {
            // session keranjang sudah ada
            $index = self::_cek_keranjang($id);
            $keranjang = array_values(session('keranjang'));
            if($index == -1){
                // tambah item baru ke keranjang
                array_push($keranjang, $item);
            } else {
                $jumlah = ($keranjang[$index]['jumlah'] + $item['jumlah']);

                //Cek harga Jika Jumlah Berubah
                if ($jumlah >= $item['qty_khusus']) {
                    $harga = $item['harga_khusus'];
                } else if ($jumlah >= $item['qty_grosir'] && $jumlah < $item['qty_khusus']) {
                    $harga = $item['harga_grosir'];
                } else {
                   $harga = $item['harga_normal'];
                }

                // Cek produk minus jika Jumlah Berubah
                if ($item['level'] == '3') {
                    $box_minus = $jumlah / $item['level_3'];
                    $slop_minus = $jumlah / $item['level_2'];
                    $pcs_minus = $jumlah;
                } else if ($item['level'] == '1') {
                    $box_minus = $jumlah;
                    $pcs_minus = $jumlah * $item['level_3'];
                    $slop_minus = $jumlah * $item['level_2'];
                } else {
                    $box_minus = $jumlah / $item['level_2'];
                    $pcs_minus = $jumlah * ($item['level_3'] / $item['level_2']);
                    $slop_minus = $jumlah;
                }

                // update quantity, cek jika quantity melebihi stok return error
                if($jumlah >= $keranjang[$index]['stok']){
                    return 'error';
                } else {
                    $keranjang[$index]['box_minus'] = $box_minus;
                    $keranjang[$index]['pcs_minus'] = $pcs_minus;
                    $keranjang[$index]['slop_minus'] = $slop_minus;
                    $keranjang[$index]['harga'] = $harga;
                    $keranjang[$index]['jumlah'] = $jumlah;
                    // // hitung total
                    $keranjang[$index]['total'] = ($harga * $jumlah);
                }
            }
            return session()->set('keranjang', $keranjang);
        } else {
            // session keranjang belum ada
            $keranjang = array($item);
            return session()->set('keranjang', $keranjang);
        }
    }

    public static function ubah($id, $item)
    {
        $index = self::_cek_keranjang($id);
        $keranjang = array_values(session('keranjang'));
        if($index > -1){
            $keranjang[$index]['harga'] = $item['harga'];
            $keranjang[$index]['box_minus'] = $item['box_minus'];
            $keranjang[$index]['slop_minus'] = $item['slop_minus'];
            $keranjang[$index]['pcs_minus'] = $item['pcs_minus'];
            $keranjang[$index]['harga'] = $item['harga'];
            $keranjang[$index]['jumlah'] = $item['jumlah'];
			$keranjang[$index]['diskon'] = $item['diskon'];
            $keranjang[$index]['notes'] = $item['notes'];
			$keranjang[$index]['total'] = $item['total'];
            
            return session()->set('keranjang', $keranjang);
        }
    }

    public static function hapus($id = null)
    {
        $index = self::_cek_keranjang($id);
        if ($index < 0) {
            return false;
        }
		$keranjang = array_values(session('keranjang'));
		unset($keranjang[$index]); // hapus item dari keranjang
		session()->set('keranjang', $keranjang);
        return true;
    }

    public static function keranjang()
    {
        $session = session('keranjang');
		return is_array($session) ? array_values($session): array();
    }

    public static function sub_total()
    {
        $total = 0;
		$session = session('keranjang');
		$items = is_array($session)? array_values($session): array();
		foreach($items as $item){
			$total += $item['total'];
		}
		return $total;
    }

    public static function total_item()
    {
        $total = 0;
		$session = session('keranjang');
		$items = is_array($session)? array_values($session): array();
		foreach($items as $item){
			$total += $item['jumlah'];
		}
		return $total;
    }

    private static function _cek_keranjang($id = null)
    {
        // cek array isi keranjang
        $items = array_values(session('keranjang'));
		for($i = 0; $i < count($items); $i++){
			if($items[$i]['id'] == $id){
				return $i;
			}
		}
		return -1;
    }

}