<?= $this->extend('kasir/templates/sale-template') ?>
<?= $this->section('content') ?>

<style>
    .col-form-label {
        font-weight: 700;
        font-size: 1.25rem;
        text-align: left;
    }

    .page-content {
        padding: 1rem 0.8rem 1rem;
    }

    .card{
        font-size: 1.25rem;
    }

    .button-aksi .btn{
        font-size: 1.25rem;
    }
</style>
<div class="page-wrapper">
    <div class="page-content">
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2">
            <div class="col-xl-8">

                <div class="row mb-1">
                    <label for="input35" class="col-sm-2 col-form-label">SCAN BARCODE</label>
                    <div class="col-sm-7 mb-1">
                        <input type="hidden" id="iditem">
                        <input type="hidden" id="nama">
                        <input type="hidden" id="satuan">
                        <input type="hidden" id="harga">
                        <input type="hidden" id="harga_grosir">
                        <input type="hidden" id="harga_khusus">
                        <input type="hidden" id="qty_grosir">
                        <input type="hidden" id="qty_khusus">
                        <input type="hidden" id="stok">
                        <input type="hidden" id="level">
                        <input type="hidden" id="level_1">
                        <input type="hidden" id="level_2">
                        <input type="hidden" id="level_3">
                        <input type="text" class="form-control" id="barcode" name="barcode"
                            placeholder="MASUKKAN BARCODE / NAMA BARANG" autofocus autocomplete="off">
                    </div>
                    <div class="col-sm-2 mb-1">
                        <input type="number" class="form-control" name="jumlah" id="jumlah" value="1" min="1">
                    </div>
                    <div class="col-sm-1 mb-1">
                        <button type="button" id="tambah" class="btn btn-primary" disabled>ADD</button>
                    </div>

                </div>
                <div class="row mb-1">
                    <label for="input35" class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <span class="text-muted" id="tampil-stok"></span>

                    </div>
                </div>
                <br>

                <div class="row mb-1">
                    <label for="input35" class="col-sm-2 col-form-label">PELANGGAN</label>
                    <div class="col-sm-9 mb-1">
                        <select name="pelanggan" id="pelanggan" class="form-select">
                            <?php foreach (esc($pelanggan) as $data): ?>
                                    <option value="<?= esc($data->id_customer) ?>"><?= esc($data->customer); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" id="list_pelanggan" data-bs-target="#pelangganModal"
                            data-bs-toggle="modal" class="btn btn-info">[...]</button>
                    </div>
                </div>

                <div class="row mb-1">
                    <label for="input35" class="col-sm-2 col-form-label">N0. STRUK</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="invoice">
                    </div>
                    <label for="input35" class="col-sm-1 col-form-label">CETAK</label>
                    <div class="col-sm-2">
                        <select name="cetak" id="cetak" class="form-select">
                            <option value="1">YA</option>
                            <option value="2">TIDAK</option>
                        </select>
                    </div>
                    <label for="input35" class="col-sm-1 col-form-label">DISKON</label>
                    <div class="col-sm-2">
                        <input type="number" class="form-control" name="diskon" id="diskon" autocomplete="off"
                            placeholder="0" min="0" disabled="">
                    </div>
                </div>

                <div class="row mb-1" style="display:none">
                    <label for="input35" class="col-sm-2 col-form-label">TIPE</label>
                    <div class="col-sm-4">
                        <select name="tipe" id="tipe" class="form-select">
                            <option value="Penjualan">PENJUALAN</option>
                            <option value="Retur">RETUR</option>
                        </select>
                    </div>
                </div>

            </div>

            <input type="hidden" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">

            <input type="hidden" class="form-control" name="user" id="user" value="<?= session('username') ?>"
                disabled="">

            <input type="hidden" class="form-control" name="total_item" id="total_item">


            <div class="col-xl-4">
                <div class="card" style="background-color:#f4f4f4">
                    <div class="card-body">
                        <div class="row mb-1">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="tampilkan_total" placeholder="0" readonly
                                    style="font-size:2rem; background-color:#5793ccba">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="input35" class="col-sm-3 col-form-label">BAYAR</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="tunai" id="tunai" placeholder="0"
                                    disabled="">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label for="input35" class="col-sm-3 col-form-label">KEMBALI</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="kembalian" id="kembalian" value="0"
                                    value="0" min="0" readonly style="background-color:#46e6c19c">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 table-striped" id="tabel-keranjang">
                                <thead style="background-color:#81add7">
                                    <tr>
                                        <th scope="col" style="background-color:#81add7"></th>
                                        <th scope="col">BARCODE</th>
                                        <th scope="col">NAMA PRODUK</th>
                                        <th scope="col">SATUAN</th>
                                        <th scope="col">HARGA</th>
                                        <th scope="col">JUMLAH</th>
                                        <th scope="col">DISC ITEM (%)</th>
                                        <th scope="col">NOTES</th>
                                        <th scope="col">TOTAL</th>
                                        <th scope="col">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"><span id="total_item_tabel">0</span></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"><span id="sub_total_tabel">0</span></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
            <div class="col" style="display:none">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="input35" class="col-sm-4 col-form-label">SUB TOTAL</label>
                            <div class="col-sm-8">
                                <input type="hidden" class="form-control" name="sub_total" id="sub_total" value="0"
                                    disabled="">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="input35" class="col-sm-4 col-form-label">TOTAL AKHIR</label>
                            <div class="col-sm-8">
                                <input type="hidden" class="form-control" name="total_akhir" id="total_akhir" value="0"
                                    disabled="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2">
            <div class="col-xl-4">
                <div class="card radius-10 px-4">
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="input3" class="form-label"><b>Catatan</b></label>
                            <textarea class="form-control" name="catatan" id="catatan" placeholder="Catatan ..." rows="3"
                                disabled=""></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8"> 
                <div class="container-button-aksi " style="display: flex;
                    flex-wrap: wrap;
                    justify-content: right;
                    max-width: none;
                    gap: 20px;
                    margin: 0 auto;">
                    <div class="button-aksi mb-2">
                        <button class="btn  btn-outline-secondary" id="batal" disabled
                            style="--bs-btn-border-color: ##f4f4f4;box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;"><img
                                src="<?= base_url('assets/images/delete.png') ?>" height="40px">
                            CLEAR [F1]</button>
                    </div>
                    <div class="button-aksi mb-2">
                        <button class="btn btn-outline-secondary" id="arsip" type="button" data-bs-target="#arsipModal"
                            data-bs-toggle="modal"
                            style="--bs-btn-border-color: ##f4f4f4;box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;">
                            <img src="<?= base_url('assets/images/archive.png') ?>" height="40px">
                            ARSIP [F2]</button>
                    </div>
                    <div class="button-aksi mb-2">
                        <button class="btn btn-outline-secondary" id="stok"
                            style="--bs-btn-border-color: ##f4f4f4;box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;"
                            type="button" data-bs-target="#stockModal" data-bs-toggle="modal"><img
                                src="<?= base_url('assets/images/packages.png') ?>" height="40px">
                            STOK [F3]</button>
                    </div>
                    <div class="button-aksi mb-2">
                        <button class="btn btn-outline-secondary" id="bayar_non_tunai" disabled
                            style="--bs-btn-border-color: ##f4f4f4;box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;"><img
                                src="https://cdn-icons-png.flaticon.com/512/2949/2949862.png" height="40px">
                            NON TUNAI [F4]</button>
                    </div>
                    <div class="button-aksi mb-2">
                        <button class="btn btn-outline-secondary" id="bayar_tunai" disabled
                            style="--bs-btn-border-color: ##f4f4f4;box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;"><img
                                src="<?= base_url('assets/images/cash_icon.png') ?>" height="40px">
                            TUNAI [F6]</button>
                    </div>
                    <div class="button-aksi mb-2">
                        <button class="btn btn-outline-secondary" id="kas_masuk" data-bs-target="#kasmasuk_Modal"
                            data-bs-toggle="modal"
                            style="--bs-btn-border-color: ##f4f4f4;box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;"><img
                                src="<?= base_url('assets/images/saving-money.png') ?>" height="40px">
                            KAS MASUK [F7]</button>
                    </div>
                    <div class="button-aksi mb-2">
                        <button class="btn btn-outline-secondary" id="kas_keluar" data-bs-target="#kaskeluar_Modal"
                            data-bs-toggle="modal"
                            style="--bs-btn-border-color: ##f4f4f4;box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;"><img
                                src="<?= base_url('assets/images/spending-money.png') ?>" height="40px">
                            KAS KELUAR [F8]</button>
                    </div>
                    <div class="button-aksi mb-2">
                        <button class="btn btn-outline-secondary" id="transaksi_harian" data-bs-target="#transaksiharianModal"
                            data-bs-toggle="modal"
                            style="--bs-btn-border-color: ##f4f4f4;box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;"><img
                                src="<?= base_url('assets/images/sale-time.png') ?>" height="40px">
                            TRANSAKSI HARIAN [F9]</button>
                    </div>


                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modal-item-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-keyboard="false">
    <div class="modal-dialog modal-md">
        <?= form_open('', ['csrf_id' => 'token']); ?>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">EDIT PRODUK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row g-3">
                <input type="hidden" id="item_id" name="item_id">
                <input type="hidden" id="item_stok" name="item_stok">
                <input type="hidden" id="item_level" name="item_level">
                <input type="hidden" id="item_box_minus" name="item_box_minus">
                <input type="hidden" id="item_pcs_minus" name="item_pcs_minus">
                <input type="hidden" id="item_slop_minus" name="item_slop_minus">

                <div class="col-md-6">
                    <label for="input1" class="form-label">BARCODE</label>
                    <input type="text" name="item_barcode" class="form-control" id="item_barcode" readonly>
                </div>

                <div class="col-md-6">
                    <label for="input1" class="form-label">NAMA PRODUK</label>
                    <input type="text" name="item_nama" class="form-control" id="item_nama" readonly>
                </div>

                <div class="col-md-6">
                    <label for="input1" class="form-label">HARGA</label>
                    <input type="text" name="item_harga" class="form-control" id="item_harga" readonly>
                </div>

                <div class="col-md-6">
                    <label for="input1" class="form-label">JUMLAH</label>
                    <input type="number" name="item_jumlah" class="form-control" id="item_jumlah">
                    <span class="text-muted" id="tampil-konversi"></span>
                </div>

                <div class="col-md-12">
                    <label for="input1" class="form-label">TOTAL SEBELUM DISKON</label>
                    <input type="text" name="harga_sebelum_diskon" class="form-control" id="harga_sebelum_diskon"
                        readonly>
                </div>

                <div class="col-md-12">
                    <label for="input1" class="form-label">DISKON ITEM (%)</label>
                    <input type="text" name="item_diskon" class="form-control" id="item_diskon" min="0">
                </div>

                <div class="col-md-12">
                    <label for="input1" class="form-label">TOTAL SETELAH DISKON</label>
                    <input type="text" name="harga_setelah_diskon" class="form-control" id="harga_setelah_diskon"
                        class="form-control" min="0" readonly>
                </div>

                <div class="col-md-12">
                    <label for="input1" class="form-label">NOTES</label>
                    <input type="text" name="item_notes" class="form-control" id="item_notes"
                        class="form-control">
                </div>

                <div class="col-md-12 mt-3">
                    <button type="button" class="btn btn-success" id="edit-keranjang"><i class="fa fa-paper-plane"></i>
                        SIMPAN</button>

                </div>

            </div>
        </div>
        <!-- /.modal-content -->
        <?= form_close(); ?>
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal Produk -->
<div class="modal fade" id="stockModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Stok Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="table-responsive mt-3">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>NO</th>
                                <th>BARCODE</th>
                                <th>NAMA PRODUK</th>
                                <th>JUMLAH STOCK</th>
                                <th>HARGA JUAL</th>
                                <th>QTY GROSIR</th>
                                <th>HARGA GROSIR</th>
                                <th>QTY KHUSUS</th>
                                <th>HARGA KHUSUS</th>
                                <th>TANGGAL EXPIRED</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($stock as $st): ?>
                                    <tr>
                                        <td class="text-center">
                                            <?= $i++ ?>
                                        </td>
                                        <td class="text-center">
                                            <?= $st['s_barcode'] ?>
                                        </td>
                                        <td>
                                            <?= strtoupper($st['p_name']) ?> <i>(
                                                <?= strtoupper($st['p_unit_type']) ?> )
                                            </i>
                                        </td>
                                        <td class="text-center">
                                            <?= $st['s_stock'] ?>
                                        </td>
                                        <td class="text-center">
                                            <?= rupiah($st['s_price']) ?>
                                        </td>
                                        <td class="text-center">
                                            <?= $st['s_qty_grosir'] ?>
                                        </td>
                                        <td class="text-center">
                                            <?= rupiah($st['s_price_grosir']) ?>
                                        </td>
                                        <td class="text-center">
                                            <?= $st['s_qty_khusus'] ?>
                                        </td>
                                        <td class="text-center">
                                            <?= rupiah($st['s_price_khusus']) ?>
                                        </td>
                                        <?php if ($st['s_date_expired'] == '0000-00-00'): ?>
                                                <td class="text-center"></td>
                                        <?php else: ?>
                                                <td class="text-center">
                                                    <?= date("d F Y", strtotime($st['s_date_expired'])) ?>
                                                </td>
                                        <?php endif; ?>


                                    </tr>
                            <?php endforeach ?>
                        </tbody>
                        <tfoot class="text-center">
                            <tr>
                                <th>NO</th>
                                <th>BARCODE</th>
                                <th>NAMA PRODUK</th>
                                <th>JUMLAH STOCK</th>
                                <th>HARGA JUAL</th>
                                <th>QTY GROSIR</th>
                                <th>HARGA GROSIR</th>
                                <th>QTY KHUSUS</th>
                                <th>HARGA KHUSUS</th>
                                <th>TANGGAL EXPIRED</th>

                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>


        </div>
    </div>
</div>

<!-- Modal Arsip -->
<div class="modal fade" id="arsipModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DAFTAR ARSIP TRANSAKSI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="table_arsip" class="table table-striped table-bordered " style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>NO</th>
                                <th>INVOICE</th>
                                <th>TANGGAL</th>
                                <th>TOTAL AKHIR</th>
                                <th>JENIS</th>
                                <th>KASIR</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="text-center tableSupplier">
                            <?php $i = 1; foreach ($transaksi as $st): ?>
                                    <tr>
                                        <td>
                                            <?= $i++ ?>
                                        </td>
                                        <td>
                                            <?= $st['invoice'] ?>
                                        </td>
                                        <td>
                                            <?= date("d F Y H:i", strtotime($st['created_at'])) ?>
                                        </td>
                                        <td>
                                            <?= rupiah($st['final_price']) ?>
                                        </td>
                                        <td>
                                            <?= strtoupper($st['tipe']) ?> |
                                            <?= strtoupper($st['jenis']) ?>
                                        </td>
                                        <td>
                                            <?= strtoupper($st['username']) ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('sibabad2/sale/detailTransaksi/') . $st['id_sale'] ?>"
                                                type="button" class="btn btn-primary btn-sm">
                                                <span class="bx bx-detail"></span>
                                            </a>
                                            <?php if ($st['tipe'] == 'Penjualan'): ?>
                                                <a href="<?= base_url('sibabad2/transaction-sale/cetakTransaksi/') . $st['id_sale'] ?>"
                                                    type="button" class="btn btn-warning btn-sm">
                                                    <span class="bx bx-printer"></span>
                                                </a>
                                            <?php elseif ($st['tipe'] == 'Retur-refund'): ?>
                                                <a href="<?= base_url('sibabad2/refund/cetakTransaksi/') . $st['invoice'] ?>"
                                                    type="button" class="btn btn-warning btn-sm">
                                                    <span class="bx bx-printer"></span>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?= base_url('sibabad2/tukar/cetakTransaksi/') . $st['invoice'] ?>"
                                                    type="button" class="btn btn-warning btn-sm">
                                                    <span class="bx bx-printer"></span>
                                                </a>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                            <?php endforeach ?>
                        </tbody>
                        <tfoot class="text-center">
                            <tr>
                                <th>NO</th>
                                <th>INVOICE</th>
                                <th>TANGGAL</th>
                                <th>TOTAL AKHIR</th>
                                <th>JENIS</th>
                                <th>KASIR</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pelanggan -->
<div class="modal fade" id="pelangganModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">TAMBAH PELANGGAN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="card">
                        <div class="card-body p-4">
                            <form action="">
                                <input type="hidden" name="id_customer" id="id_customer">
                                <div class="row mb-3">
                                    <label for="uName" class="col-sm-3 col-form-label">NAMA PELANGGAN</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="customer_name" class="form-control" id="customer_name">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="uName" class="col-sm-3 col-form-label">TELEPON</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="telp" class="form-control" id="telp">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="uName" class="col-sm-3 col-form-label">ALAMAT</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="address" class="form-control" id="address">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <button type="button" class="btn btn-primary btnSave">SIMPAN DATA</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body p-4">
                            <table class="table mb-0 table-striped mt-3" id="tabel_pelanggan">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">NAMA PELANGGAN</th>
                                        <th scope="col">TELEPON</th>
                                        <th scope="col">ALAMAT</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php foreach ($customer as $cust): ?>
                                            <tr>
                                                <td>
                                                    <?= strtoupper($cust['customer_name']) ?>
                                                </td>
                                                <td>
                                                    <?= $cust['telp'] ?>
                                                </td>
                                                <td>
                                                    <?= $cust['address'] ?>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm btnEditCustomer"
                                                        data-customer_name="<?= $cust['customer_name'] ?>"
                                                        data-telp="<?= $cust['telp'] ?>" data-address="<?= $cust['address'] ?>"
                                                        data-id="<?= $cust['id_customer'] ?>">
                                                        <span class="bx bx-pencil"></span>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm btnDeleteCustomer"
                                                        data-id_customer="<?= $cust['id_customer'] ?>">
                                                        <span class="bx bx-trash"></span>
                                                    </button>
                                                </td>
                                            </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="kasmasuk_Modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">TAMBAH KAS MASUK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="card">
                        <div class="card-body p-4">
                            <form action="">
                                <input type="hidden" name="id_kas" id="id_kas">
                                <input type="hidden" name="kas_tipe" id="kas_tipe" value="Kas-Masuk">
                                <div class="row mb-3">
                                    <label for="uName" class="col-sm-4 col-form-label">KODE</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="kas_kode" class="form-control" id="kas_kode"
                                            value="<?= $kode_kas_masuk ?>" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="uName" class="col-sm-4 col-form-label">KETERANGAN</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="kas_name" class="form-control" id="kas_name">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="uName" class="col-sm-4 col-form-label">JUMLAH NOMINAL (Rp.)</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="kas_total" class="form-control" id="kas_total">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-8">
                                        <button type="button" class="btn btn-primary btnSaveKasMasuk">SIMPAN
                                            DATA</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped mt-3" id="table_kas_masuk">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col">NO</th>
                                            <th scope="col">KODE</th>
                                            <th scope="col">TANGGAL</th>
                                            <th scope="col">KETERANGAN</th>
                                            <th scope="col">JUMLAH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach ($kas_masuk as $kas): ?>
                                                <tr>
                                                    <td>
                                                        <?= $i++ ?>
                                                    </td>
                                                    <td>
                                                        <?= $kas['kode'] ?>
                                                    </td>
                                                    <td>
                                                        <?= date("d F Y H:i", strtotime($kas['created_at'])) ?>
                                                    </td>
                                                    <td>
                                                        <?= $kas['kas_name'] ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= rupiah($kas['kas_total']) ?>
                                                    </td>
                                                </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal KAS KELUAR -->
<div class="modal fade" id="kaskeluar_Modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">TAMBAH KAS KELUAR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="card">
                        <div class="card-body p-4">
                            <form action="">
                                <input type="hidden" name="id_kas_keluar" id="id_kas_keluar">
                                <input type="hidden" name="kas_keluar_tipe" id="kas_keluar_tipe" value="Kas-Keluar">
                                <div class="row mb-3">
                                    <label for="uName" class="col-sm-4 col-form-label">KODE</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="kas_keluar_kode" class="form-control"
                                            id="kas_keluar_kode" value="<?= $kode_kas_keluar ?>" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="uName" class="col-sm-4 col-form-label">KETERANGAN</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="kas_keluar_name" class="form-control"
                                            id="kas_keluar_name">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="uName" class="col-sm-4 col-form-label">JUMLAH NOMINAL (Rp.)</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="kas_keluar_total" class="form-control"
                                            id="kas_keluar_total">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-8">
                                        <button type="button" class="btn btn-primary btnSaveKasKeluar">SIMPAN
                                            DATA</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped mt-3" id="table_kas_keluar">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col">NO</th>
                                            <th scope="col">KODE</th>
                                            <th scope="col">TANGGAL</th>
                                            <th scope="col">KETERANGAN</th>
                                            <th scope="col">JUMLAH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach ($kas_keluar as $kas): ?>
                                                <tr>
                                                    <td>
                                                        <?= $i++ ?>
                                                    </td>
                                                    <td>
                                                        <?= $kas['kode'] ?>
                                                    </td>
                                                    <td>
                                                        <?= date("d F Y H:i", strtotime($kas['created_at'])) ?>
                                                    </td>
                                                    <td>
                                                        <?= $kas['kas_name'] ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= rupiah($kas['kas_total']) ?>
                                                    </td>
                                                </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="buyReport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <?= form_open(base_url('sibabad2/kasir/sale/akhiriShift'), ['csrf_id' => 'token']); ?>

        <div class="modal-content border-0">
            <div class="modal-header">
                <h5 class="modal-title">Detail Shift</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                

                <div class="form-group row">
                    <label for="codeOrder" class="col-sm-4 col-form-label text-left">Nama - Posisi</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $prof['nama']; ?> - <?= $prof['posisi']; ?>"
                            disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="dateOrder" class="col-sm-4 col-form-label text-left">Waktu Shift</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control"
                            value="Pukul <?= date_format(date_create($prof['mulai_shift']), 'H:i') ?> - <?= date_format(date_create($prof['selesai_shift']), 'H:i') ?>"
                            disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="dateOrder" class="col-sm-4 col-form-label text-left">Total Penjualan</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control"
                            value="<?= rupiah($rincianPenjualan['penjualan']) ?>" disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="dateOrder" class="col-sm-4 col-form-label text-left">Penjualan Tunai</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control"
                            value="<?= rupiah($rincianPenjualan['penjualan_tunai']) ?>" disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="dateOrder" class="col-sm-4 col-form-label text-left">Penjualan Non Tunai</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control"
                            value="<?= rupiah($rincianPenjualan['penjualan_non_tunai']) ?>" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="dateOrder" class="col-sm-4 col-form-label text-left">Retur</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control"
                            value="<?= rupiah($rincianPenjualan['retur']) ?>" disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="dateOrder" class="col-sm-4 col-form-label text-left">Total Kas Masuk</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control"
                            value="<?= rupiah($rincianKas['kas_masuk']) ?>" disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="dateOrder" class="col-sm-4 col-form-label text-left">Total Kas Keluar</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control"
                            value="<?= rupiah($rincianKas['kas_keluar']) ?>" disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="dateOrder" class="col-sm-4 col-form-label text-left">Total Transaksi</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control"
                            value="<?= rupiah(($rincianPenjualan['penjualan'] + $rincianKas['kas_masuk']) - ($rincianPenjualan['retur'] + $rincianKas['kas_keluar'])) ?>" disabled>
                    </div>
                </div>

                </br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered " style="width:100%" id="tabel-rekap">
                        <thead class="text-center">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Kode</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Kasir</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbodySS>
                            <?php $i = 1; foreach ($transaksi2 as $data): ?>
                                    <tr>
                                        <td>
                                            <?= $i ?>
                                        </td>
                                        <td>
                                            <?= $data['kode'] ?>
                                        </td>
                                        <td>
                                            <?= $data['tanggal'] ?>
                                        </td>
                                        <td>
                                            <?= $data['jenis'] ?>
                                        </td>
                                        <td>
                                            <?= $data['nama'] ?>
                                        </td>
                                        <td>
                                            <?= "Rp " . number_format($data['total_harga'], 2, ',', '.') ?>
                                        </td>
                                    </tr>
                                    <?php $i++; endforeach; ?>
                            </tbody>
                    </table>
                </div>
                </br>

                <input type="hidden" name="kondisi" value="0">
            </div>

            <div class="modal-footer">
                <div class="col-md-12 mt-3 text-center">
                    <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Akhiri
                        Shift</button>
                </div>
            </div>
        </div>

        <?= form_close(); ?>
    </div>
</div>

<div class="modal fade" id="mulaishift" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">
        <?= form_open(base_url('sibabad2/kasir/sale/mulaiShift'), ['csrf_id' => 'token']); ?>

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Selamat datang !
                    <?= $popup['nama']; ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Selamat datang di shift Anda! Silakan tekan tombol "Mulai Shift" untuk memulai.</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="kondisi" value="1">
                <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Mulai Shift</button>
            </div>
        </div>

        <?= form_close(); ?>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script src="<?= base_url('assets/js/penjualan.js') ?>"></script> -->
<script src="<?= base_url('assets/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/autoNumeric.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.hotkeys.js') ?>"></script>


<script>
    let auto_numeric = new AutoNumeric('#tunai', {
        decimalCharacter: ",",
        decimalPlaces: 0,
        digitGroupSeparator: ".",
    });

    var barcode = '';
    var interval;
    document.addEventListener('keydown', function (evt) {
        if (interval)
            clearInterval(interval);
        if (evt.code == 'Enter') {
            if (barcode)
                handleBarcode(barcode);
            barcode = '';
            return;
        }
        if (evt.key != 'Shift')
            barcode += evt.key;
        interval = setInterval(() => barcode = '', 20);
    });

    function handleBarcode(scanned_barcode) {
        barcode = scanned_barcode; // Simpan kode barcode dari pemindaian
        $('#barcode').val(barcode); // Isikan nilai barcode ke dalam input #barcode
    }
</script>

<!-- Tabel -->
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#table_arsip').DataTable({
            "lengthMenu": [
                [5, 10, 20],
                [5, 10, 20]
            ]
        });
        $('#table_kas_masuk').DataTable({
            "lengthMenu": [
                [5, 10, 20],
                [5, 10, 20]
            ]
        });
        $('#example').DataTable({
            "lengthMenu": [
                [5, 10, 20],
                [5, 10, 20]
            ]
        });

        $('#tabel-rekap').DataTable({
            "lengthMenu": [
                [5, 10, 20],
                [5, 10, 20]
            ]
        });
        $('#table_kas_keluar').DataTable({
            "lengthMenu": [
                [5, 10, 20],
                [5, 10, 20]
            ]
        });
        $('#tabel_pelanggan').DataTable({
            "lengthMenu": [
                [5, 10, 20],
                [5, 10, 20]
            ]
        });
    });
</script>

<!-- SHORTCUT KEY -->
<script type="text/javascript">
    function domo() {



        $('*').bind('keydown', 'Ctrl+a', function () {
            $('#bayar').trigger('click');
            return false;
        });

        $(document).on('keydown', function (e) {
            if (e.ctrlKey && e.key === 'z') {
                e.preventDefault();
                $('#barcode').focus();
                return false;
            }
        });

        //Reset atau Hapus Semua Barang
        $(document).on('keydown', function (e) {
            if (e.key === 'F1') {
                e.preventDefault();
                $('#batal').trigger('click');
                return false;
            }
        });

        //Buka Modal Stock Produk
        $(document).on('keydown', function (e) {
            if (e.key === 'F3') {
                e.preventDefault();
                $('#stockModal').modal('show');
                return false;
            }
        });

        //Buka Modal Arsip
        $(document).on('keydown', function (e) {
            if (e.key === 'F4') {
                e.preventDefault();
                $('#bayar_non_tunai').trigger('click');
                return false;
            }
        });

        $(document).on('keydown', function (e) {
            if (e.key === 'F6') {
                e.preventDefault();
                $('#bayar_tunai').trigger('click');
                return false;
            }
        });

        $(document).on('keydown', function (e) {
            if (e.key === 'F7') {
                e.preventDefault();
                $('#kas_masuk').trigger('click');
                return false;
            }
        });

        $(document).on('keydown', function (e) {
            if (e.key === 'F8') {
                e.preventDefault();
                $('#kas_keluar').trigger('click');
                return false;
            }
        });


        $(document).on('keydown', function (e) {
            if (e.key === 'F2') {
                e.preventDefault();
                $('#arsipModal').modal('show');
                return false;
            }
        });

        $(document).on('keydown', function (e) {
            if (e.ctrlKey && e.key === 'x') {
                e.preventDefault();
                $('#tunai').focus();
                return false;
            }
        });
    }

    jQuery(document).ready(domo);
</script>


<!-- PROSES SALE / KASIR -->
<script>
    $(function () {
        if (window.location == `<?= base_url('sibabad2/sale/index') ?>`) {
            $('body').addClass('sidebar-collapse')
            $('.content-header').remove()
            $('.content').addClass('pt-2')
        }

        function rupiah(nominal) {
            let number_string = nominal.toString(), // convert nominal ke string
                sisa = number_string.length % 3, // cek jumlah digit bukan kelipatan 3
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g)
            if (ribuan) {
                let separator = sisa ? '.' : ''
                rupiah += separator + ribuan.join('.')
            }
            return rupiah
        }

        /**
         * Menampilkan detail isi keranjang
         */
        function detailKeranjang() {
            let keranjang = ''
            $.ajax({
                url: `<?= base_url('sibabad2/sale/keranjang') ?>`,

                dataType: 'json',
                success: function (response) {
                    $('#invoice').val(response.invoice) // menampilkan no invoice
                    $('#tampilkan_total').val(rupiah(response.sub_total)) // menampilkan total harga
                    $('#sub_total').val(response.sub_total) // isi value sub_total
                    $('#sub_total_tabel').text(response.sub_total) // isi value sub_total
                    $('#total_item_tabel').text(response.total_item) // isi value sub_total
                    $('#total_item').val(response.total_item)
                    $('#total_akhir').val(response.sub_total) // isi value total_akhir
                    // menampilkan detail keranjang
                    if (response.keranjang.length === 0) {
                        keranjang =
                            `<tr><td colspan="10" class="text-center"  style="vertical-align:middle;height:350px" >KERANJANG MASIH KOSONG</td></tr>`
                        $('#diskon').prop('disabled', true)
                        $('#tunai').prop('disabled', true)
                        $('#catatan').prop('disabled', true)
                        $('#batal').prop('disabled', true)
                    } else {
                        $('#diskon').prop('disabled', false)
                        $('#tunai').prop('disabled', false)
                        $('#catatan').prop('disabled', false)
                        $('#batal').prop('disabled', false)
                        // $("#tunai").val(0);
                        var noUrut = 1;
                        $.each(response.keranjang, function (i, data) {
                            keranjang += `<tr style="font-weight: 700;">
                            <td style="background-color:#81add7">${noUrut++}</td>
                          <td>${data.barcode}</td>
                          <td>${data.nama.toUpperCase()}</td>
                          <td>${data.satuan.toUpperCase()}</td>
                          <td>${data.harga}</td>
                          <td>${data.jumlah}</td>
                          <td>${data.diskon}</td>
                          <td>${data.notes}</td>
                          <td>${data.total}</td>
                          <td>
                              <button class="btn btn-success btn-sm" id="edit-item" data-bs-toggle="modal" data-bs-target="#modal-item-edit" data-id="${data.id}" data-barcode="${data.barcode}" data-item="${data.nama}" data-level="${data.level}" data-box_minus="${data.box_minus}" data-slop_minus="${data.slop_minus}" data-pcs_minus="${data.pcs_minus}" data-harga="${data.harga}" data-jumlah="${data.jumlah}" data-diskon="${data.diskon}"  data-notes="${data.notes}" data-subtotal="${data.total}" data-stok="${data.stok}"><i class="bx bx-pencil"></i></button>
                              <button class="btn btn-danger btn-sm" id="hapus-item" data-id="${data.id}"><i class="bx bx-trash"></i></button>
                          </td>
                          </tr>`
                        })
                    }
                    $('#tabel-keranjang tbody').html(keranjang)
                },
            })
        }
        detailKeranjang() // pertama halaman dibuka load detail keranjang

        // Cari item berdasarkan barcode
        $('#barcode').autocomplete({
            source: `<?= base_url('sibabad2/sale/barcode') ?>`,
            autoFocus: true,
            select: function (e, ui) {
                $.ajax({
                    url: `<?= base_url('sibabad2/sale/detail') ?>`,
                    type: 'get',
                    data: {
                        barcode: ui.item.value,
                    },
                    success: function (response) {
                        $('#iditem').val(response.iditem)
                        $('#barcode').val(response.barcode)
                        $('#nama').val(response.item)
                        $('#satuan').val(response.satuan)
                        $('#level').val(response.level)
                        $('#harga').val(response.harga)
                        $('#harga_grosir').val(response.harga_grosir)
                        $('#harga_khusus').val(response.harga_khusus)
                        $('#qty_grosir').val(response.qty_grosir)
                        $('#qty_khusus').val(response.qty_khusus)
                        $('#level_1').val(response.level_1)
                        $('#level_2').val(response.level_2)
                        $('#level_3').val(response.level_3)
                        $('#stok').val(response.stok)
                        $('#tampil-stok').text(
                            `${response.item} | ${response.satuan} | Stok : ${response.stok}`
                        )
                        if (response.stok == 0) {
                            $('#tambah').prop('disabled', true)
                        } else {
                            $('#tambah').prop('disabled', false).focus()
                        }
                    },
                })
            },
        })

        $('#jumlah').on('input', function (e) {
            let jumlah = parseInt(e.target.value);
            let barcode = $('#barcode').val();
            let iditem = $('#iditem').val();

            if (isNaN(jumlah) || jumlah == 0) {
                $('#tambah').prop('disabled', true);
            } else {
                $.ajax({
                    url: `<?= base_url('sibabad2/sale/cekStok') ?>`,
                    data: {
                        barcode: barcode,
                        iditem: iditem
                    },
                    success: (respon) => {
                        if (jumlah > respon.stok) {
                            Swal.fire({
                                title: `Jumlah melebihi stok, maksimal ${respon.stok}`,
                                icon: 'warning',
                            }).then((res) => {
                                e.target.value = 1;
                            });
                        }
                    },
                });
                $('#tambah').prop('disabled', false);
            }
        });


        $('#tambah').on('click', function (e) {
            tambahKeKranjang()
        })
        $('#jumlah').on('keypress', function (e) {
            if (e.keyCode === 13 && e.target.value != '') {
                tambahKeKranjang()
            }
        })

        function tambahKeKranjang() {
            let iditem = $('#iditem').val()
            let barcode = $('#barcode').val()
            let nama = $('#nama').val()
            let satuan = $('#satuan').val()
            let harga_normal = $('#harga').val()
            let harga_grosir = $('#harga_grosir').val()
            let harga_khusus = $('#harga_khusus').val()
            let qty_khusus = $('#qty_khusus').val()
            let qty_grosir = $('#qty_grosir').val()
            let stok = parseInt($('#stok').val())
            let jumlah = parseInt($('#jumlah').val())
            let level = $('#level').val()
            let level_1 = $('#level_1').val()
            let level_2 = $('#level_2').val()
            let level_3 = $('#level_3').val()
            let harga
            let box_minus
            let pcs_minus
            let slop_minus

            if (jumlah >= qty_khusus) {
                harga = harga_khusus
            } else if (jumlah >= qty_grosir && jumlah < qty_khusus) {
                harga = harga_grosir
            } else {
                harga = harga_normal
            }

            if (level == '3') {
                box_minus = jumlah / level_3;
                slop_minus = jumlah / level_2;
                pcs_minus = jumlah;
            } else if (level == '1') {
                box_minus = jumlah;
                pcs_minus = jumlah * level_3;
                slop_minus = jumlah * level_2;
            } else {
                box_minus = jumlah / level_2;
                pcs_minus = jumlah * (level_3 / level_2);
                slop_minus = jumlah;
            }

            $.ajax({
                url: `<?= base_url('sibabad2/sale/tambahKeranjang') ?>`,
                method: 'post',
                data: {
                    [$('#token').attr('name')]: $('#token').val(),
                    iditem: iditem,
                    barcode: barcode,
                    nama: nama,
                    satuan: satuan,
                    level: level,
                    harga: harga,
                    harga_normal: harga_normal,
                    harga_grosir: harga_grosir,
                    harga_khusus: harga_khusus,
                    qty_khusus: qty_khusus,
                    qty_grosir: qty_grosir,
                    jumlah: jumlah,
                    stok: stok,
                    box_minus: box_minus,
                    pcs_minus: pcs_minus,
                    slop_minus: slop_minus,
                    level_1: level_1,
                    level_2: level_2,
                    level_3: level_3
                },
                success: function (response) {
                    if (response.status) {
                        detailKeranjang()
                        // $('#jumlah').val('').prop('disabled', true)
                        $('#tambah').prop('disabled', true)
                        $('#barcode').val('').focus()
                        $('#produk').val('')
                        $('#satuan').val('')
                        $('#tampil-stok').text('')
                        toastr.success(response.pesan, 'Sukses', {
                            timeOut: 500
                        })
                    } else {
                        toastr.error(response.pesan)
                    }
                },
            })
        }

        // hapus item di keranjang
        $('.content').on('click', '#hapus-item', function () {
            Swal.fire({
                title: 'Yakin ingin menghapus item ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Konfirmasi!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `<?= base_url('sibabad2/sale/hapusItem') ?>`,
                        type: 'post',
                        data: {
                            [$('#token').attr('name')]: $('#token').val(),
                            iditem: $(this).data('id'),
                        },
                        success: function (response) {
                            if (response.status) {
                                detailKeranjang()
                                $('#tunai').val(0)
                                toastr.success(response.pesan, 'Sukses', {
                                    timeOut: 500
                                })
                            } else {
                                toastr.error(response.pesan, 'Error', {
                                    timeOut: 500
                                })
                            }
                        },
                    })
                }
            })
        })

       // modal form edit item keranjang
       $('.content').on('click', '#edit-item', function () {
            // mengambil data dari tombol select, input ke tiap-tiap elemet
            $('#item_id').val($(this).data('id'))
            $('#item_barcode').val($(this).data('barcode'))
            $('#item_nama').val($(this).data('item'))
            $('#item_level').val($(this).data('level'))
            $('#item_box_minus').val($(this).data('box_minus'))
            $('#item_slop_minus').val($(this).data('slop_minus'))
            $('#item_pcs_minus').val($(this).data('pcs_minus'))
            $('#item_harga').val($(this).data('harga'))
            $('#item_jumlah')
                .val($(this).data('jumlah'))
                .prop('max', $(this).data('stok'))
            $('#item_stok').val($(this).data('stok'))
            $('#modal-stok').text('Stok produk ' + $(this).data('stok'))
            $('#item_diskon').val($(this).data('diskon'))
            $('#item_notes').val($(this).data('notes'))
            $('#harga_sebelum_diskon').val($(this).data('subtotal'))
            $('#harga_setelah_diskon').val($(this).data('subtotal'))
        })

        // update isi keranjang
        $('.wrapper').on('click', '#edit-keranjang', function () {
            $.ajax({
                url: `<?= base_url('sibabad2/sale/ubahItem') ?>`,
                type: 'post',
                dataType: 'json',
                data: $('form').serialize(),
                success: function (response) {
                    $('#modal-item-edit').modal('hide')
                    $('#barcode').focus()
                    detailKeranjang()
                    toastr.success(response.pesan, 'Sukses', {
                        timeOut: 500
                    })
                },
            })
        })

        function modal_edit_item() {
            let item_id = $('#item_id').val()
            let barcode = $('#item_barcode').val()
            let level = $('#item_level').val()
            let box_minus = $('#item_box_minus').val()
            let slop_minus = $('#item_slop_minus').val()
            let pcs_minus = $('#item_pcs_minus').val()
            let jumlah = $('#item_jumlah').val()
            let harga = $('#item_harga').val()
            let stok = $('#item_stok').val()
            let item_diskon = $('#item_diskon').val()
           
            $.ajax({
                url: `<?= base_url('sibabad2/sale/cekHarga') ?>`,
                data: {
                    item_id: item_id,
                    jumlah: jumlah,
                    harga: harga
                },
                success: (respon) => {
                    $('#item_harga').val(respon.harga_item);
                },
            })

            $.ajax({
                url: `<?= base_url('sibabad2/sale/cekLevel') ?>`,
                data: {
                    barcode: barcode,
                    level: level,
                    jumlah: jumlah
                },
                success: (respon) => {
                    $('#item_box_minus').val(respon.box_minus);
                    $('#item_slop_minus').val(respon.slop_minus);
                    $('#item_pcs_minus').val(respon.pcs_minus);
                },

            })



            if (parseInt(jumlah) > parseInt(stok)) {
                toastr.error('Jumlah melebihi stok, maksimal ' + stok, '', {
                    timeOut: 500,
                })
                $('#item_jumlah').val(1)
            } else if (jumlah == '' || jumlah < 1) {
                toastr.error('Jumlah minimal 1', '', {
                    timeOut: 500
                })
                $('#item_jumlah').val(1)
            }

            let harga_sebelum_diskon = jumlah * harga
            $('#harga_sebelum_diskon').val(harga_sebelum_diskon)
            if (item_diskon == '' || item_diskon == 0) {
                $('#item_diskon').val(0)
                $('#harga_setelah_diskon').val(harga_sebelum_diskon)
            } else {
                hasil_diskon = (item_diskon / 100) * harga_sebelum_diskon
                $('#harga_setelah_diskon').val(harga_sebelum_diskon - hasil_diskon)
            }
        }

        /**
         * Hitung kalkulasi diskon, total belanja dan kembalian
         */
        function kalkulasi() {
            let sub_total = $('#sub_total').val(),
                diskon_akhir = ($('#diskon').val() / 100) * sub_total,
                total_akhir = sub_total - diskon_akhir,
                tunai = $('#tunai').val().replace('.', ''),
                kembalian =
                    tunai - total_akhir > 0 ?
                        rupiah(tunai - total_akhir) :
                        tunai - total_akhir

            $('#total_akhir').val(total_akhir)
            $('#tampilkan_total').val(rupiah(total_akhir))
            tunai != 0 ? $('#kembalian').val(kembalian) : $('#kembalian').val(0)
            if (tunai == 0 || tunai == '') {
                $('#bayar_tunai').prop('disabled', true)
                $('#bayar_non_tunai').prop('disabled', true)
            } else if (kembalian < 0) {
                $('#bayar_tunai').prop('disabled', true)
                $('#bayar_non_tunai').prop('disabled', true)
            } else {
                $('#bayar_tunai').prop('disabled', false)
                $('#bayar_non_tunai').prop('disabled', false)
            }
        }

        // jika kolom diskon dan tunai di edit load kalkulasi
        $('.wrapper').on('keyup mouseup', '#diskon, #tunai', function (e) {
            kalkulasi()
        })
        // jika kolom jumlah dan diskon di edit update isi total otomatis
        $('.wrapper').on('keyup mouseup', '#item_jumlah, #item_diskon', function () {
            modal_edit_item()
        })



        // batalkan pembayaran
        $('.wrapper').on('click', '#batal', function () {
            Swal.fire({
                title: 'Yakin ingin membatalkan transaksi?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Konfirmasi!',
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `<?= base_url('sibabad2/sale/hapusTransaksi') ?>`,
                        success: function (response) {
                            detailKeranjang()
                            $('#pelanggan').val('')
                            $('#diskon').val(0)
                            $('#tunai').val(0)
                            $('#kembalian').val(0)
                            $('#barcode').focus()
                            toastr.success(response.pesan, '', {
                                timeOut: 500
                            })
                        },
                    })
                }
            })
        })

        // proses pembayaran
        $('.wrapper').on('click', '#bayar_tunai', function () {
            let invoice = $('#invoice').val()
            let id_pelanggan = $('#pelanggan').val()
            let subtotal = $('#sub_total').val()
            let diskon = $('#diskon').val()
            let total_akhir = $('#total_akhir').val()
            let tunai = $('#tunai').val()
            let kembalian = $('#kembalian').val()
            let catatan = $('#catatan').val()
            let tanggal = $('#tanggal').val()
            let total_item = $('#total_item').val()
            let tipe = $('#tipe').val()
            let jenis = 'Tunai'
            let cetak = $('#cetak').val()

            if (tunai < 1) {
                toastr.error('Jumlah uang tunai belum diinput', '', {
                    timeOut: 500
                })
                $('#tunai').focus()
            } else {
                // semua sudah oke
                Swal.fire({
                    title: 'Yakin proses transaksi sudah benar?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Konfirmasi!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `<?= base_url('sibabad2/sale/bayarTransaksi') ?>`,
                            type: 'post',
                            dataType: 'json',
                            data: {
                                [$('#token').attr('name')]: $('#token').val(),
                                invoice: invoice,
                                id_pelanggan: id_pelanggan,
                                subtotal: subtotal,
                                diskon: diskon,
                                total_akhir: total_akhir,
                                tunai: tunai,
                                kembalian: kembalian,
                                catatan: catatan,
                                tanggal: tanggal,
                                total_item: total_item,
                                tipe: tipe,
                                jenis: jenis,
                                cetak: cetak
                            },
                            success: function (response) {
                                if (response.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sukses!',
                                        text: `${response.pesan}`,
                                        // confirmButtonText: 'Konfirmasi'
                                        showConfirmButton: false,
                                        timer: 1500,
                                    }).then((res) => {
                                        if (cetak == '1') {
                                            window.open(
                                                `<?= base_url('sibabad2/sale/cetakTransaksi/') ?>${response.idpenjualan}`
                                            );
                                        }
                                        location.reload(true)
                                    })
                                } else {
                                    toastr.error(response.pesan)
                                }
                            },
                        })
                    }
                })
            }
        })

        $('.wrapper').on('click', '#bayar_non_tunai', function () {
            let invoice = $('#invoice').val()
            let id_pelanggan = $('#pelanggan').val()
            let subtotal = $('#sub_total').val()
            let diskon = $('#diskon').val()
            let total_akhir = $('#total_akhir').val()
            let tunai = $('#tunai').val()
            let kembalian = $('#kembalian').val()
            let catatan = $('#catatan').val()
            let tanggal = $('#tanggal').val()
            let total_item = $('#total_item').val()
            let tipe = $('#tipe').val()
            let jenis = 'Non-Tunai'
            let cetak = $('#cetak').val()

            if (tunai < 1) {
                toastr.error('Jumlah uang tunai belum diinput', '', {
                    timeOut: 500
                })
                $('#tunai').focus()
            } else {
                // semua sudah oke
                Swal.fire({
                    title: 'Yakin proses transaksi sudah benar?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Konfirmasi!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `<?= base_url('sibabad2/sale/bayarTransaksi') ?>`,
                            type: 'post',
                            dataType: 'json',
                            data: {
                                [$('#token').attr('name')]: $('#token').val(),
                                invoice: invoice,
                                id_pelanggan: id_pelanggan,
                                subtotal: subtotal,
                                diskon: diskon,
                                total_akhir: total_akhir,
                                tunai: tunai,
                                kembalian: kembalian,
                                catatan: catatan,
                                tanggal: tanggal,
                                total_item: total_item,
                                tipe: tipe,
                                jenis: jenis
                            },
                            success: function (response) {
                                if (response.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sukses!',
                                        text: `${response.pesan}`,
                                        // confirmButtonText: 'Konfirmasi'
                                        showConfirmButton: false,
                                        timer: 1500,
                                    }).then((res) => {
                                        if (cetak == '1') {
                                            window.open(
                                                `<?= base_url('sibabad2/sale/cetakTransaksi/') ?>${response.idpenjualan}`
                                            );
                                        }

                                        location.reload(true)
                                    })
                                } else {
                                    toastr.error(response.pesan)
                                }
                            },
                        })
                    }
                })
            }
        })
    })
</script>


<!-- CRUD CUSTOMER -->
<script>
    $(document).ready(function () {
        $('.btnSave').on('click', function () {
            var customer_name = $('#customer_name').val();
            var telp = $('#telp').val();
            var address = $('#address').val();
            var id_customer = $('#id_customer').val();

            if (customer_name !== '') {
                $.ajax({
                    url: '<?= base_url('sibabad2/customer/saveCustomer') ?>', // URL untuk POST
                    method: 'POST',
                    data: {
                        customer_name: customer_name,
                        telp: telp,
                        address: address,
                        id_customer: id_customer
                    }, // Data yang akan dikirim
                    dataType: 'json',
                    success: function (data) {
                        // Tangani respons dari server jika diperlukan
                        if (data.status === 'success') {
                            // Tampilkan notifikasi sukses dengan SweetAlert
                            Swal.fire({
                                icon: 'success',
                                title: 'Data berhasil disimpan',
                                text: data.message,
                            });

                            window.location.href = '<?= base_url('sibabad2/sale/index') ?>'
                        } else if (data.status === 'error') {
                            if (data.message.u_name && data.message.u_name[0] ===
                                'Nama pelanggan tidak boleh sama.') {
                                // Tampilkan notifikasi bahwa tidak boleh ada nama jurnal yang sama
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Data gagal disimpan',
                                    text: 'Tidak boleh ada nama pelanggan yang sama.',
                                });
                                $('#customer_name').val('');
                                $('#telp').val('');
                                $('#address').val('');
                            } else {
                                // Tampilkan pesan error umum jika ada error lain
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Data gagal disimpan',
                                    text: 'Tidak boleh ada nama pelanggan yang sama.',
                                });
                                $('#customer_name').val('');
                                $('#telp').val('');
                                $('#address').val('');
                            }
                        }
                    },
                    error: function () {
                        console.log('Terjadi kesalahan saat mengirim data.');
                    }
                });
            } else {
                // Tampilkan notifikasi data tidak boleh kosong dengan SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Data tidak boleh kosong',
                    text: 'Mohon isi semua kolom.',
                });
            }

        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.btnEditCustomer').on('click', function () {
            var customer_name = $(this).data('customer_name');
            var telp = $(this).data('telp');
            var address = $(this).data('address');
            var id_customer = $(this).data('id');
            $('#customer_name').val(customer_name);
            $('#telp').val(telp);
            $('#address').val(address);
            $('#id_customer').val(id_customer);
        });
    });
</script>

<script>
    $(document).ready(function () {
        $(document).on('click', '.btnDeleteCustomer', function () {
            const id_customer = $(this).data('id_customer');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda tidak dapat mengembalikan data yang dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform the delete action using AJAX
                    $.ajax({
                        url: `<?= base_url('sibabad2/customer/deleteCustomer/') ?>${id_customer}`,
                        method: 'DELETE',
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Terhapus!',
                                    text: 'Data berhasil dihapus.',
                                    icon: 'success'
                                }).then(() => {
                                    // Redirect or perform any other action after deletion
                                    window.location.href =
                                        '<?= base_url('sibabad2/sale/index') ?>';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat menghapus data.',
                                    icon: 'error'
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error deleting customer data:', status,
                                error);
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    });
</script>

<!-- Pengaturan SHIFT -->
<script>
    $(document).ready(function () {
        // Fungsi untuk menampilkan popup
        function tampilkanPopup() {
            $('#buyReport').modal('show');
        }

        // Fungsi untuk menyembunyikan popup
        function tutupPopup() {
            $('#buyReport').modal('hide');
        }

        function cekWaktu() {
            var selesaiShift = '<?= date_format(date_create($prof['mulai_shift']), 'H:i') ?>';
            var mulaiShift = '<?= date_format(date_create($prof['selesai_shift']), 'H:i') ?>';
            var sekarang = new Date().toLocaleTimeString('en-US', {
                hour12: false
            });
            var nilai = '<?= $prof['kondisi']; ?>';

            // Cek apakah waktu sekarang berada di dalam jendela waktu shift
            var diDalamWaktuShift = (selesaiShift >= mulaiShift)
                ? (sekarang >= mulaiShift && sekarang <= selesaiShift)
                : (sekarang >= mulaiShift || sekarang <= selesaiShift);

            // Cek apakah tombol seharusnya diaktifkan
            if (diDalamWaktuShift && nilai === '1') {
                $('#akhiriShiftBtn').prop('disabled', false);
            } else {
                $('#akhiriShiftBtn').prop('disabled', true);
                tutupPopup(); // Tutup popup jika tombol dinonaktifkan
            }
        }

        // Event handler untuk tombol "AKHIRI SHIFT"
        $('#akhiriShiftBtn').click(function () {
            tampilkanPopup();
        });

        // Panggil cekWaktu saat halaman dimuat
        cekWaktu();
    });


    $(document).ready(function () {
        // Fungsi untuk menampilkan popup
        function tampilkanPopup() {
            $('#mulaishift').modal('show');
        }

        // Fungsi untuk menyembunyikan popup
        function tutupPopup() {
            $('#mulaishift').modal('hide');
        }

        function cekWaktu() {
            var selesaiShift = '<?= date_format(date_create($popup['selesai_shift']), 'H:i') ?>';
            var mulaiShift = '<?= date_format(date_create($popup['mulai_shift']), 'H:i') ?>';
            var sekarang = new Date().toLocaleTimeString('en-US', {
                hour12: false
            });
            var nilai = '<?= $popup['kondisi']; ?>';

            if (selesaiShift >= mulaiShift) {
                if (sekarang >= mulaiShift && sekarang <= selesaiShift && nilai === '0') {
                    tampilkanPopup();
                } else {
                    tutupPopup();
                }
            } else {
                if ((sekarang >= mulaiShift || sekarang <= selesaiShift) && nilai === '0') {
                    tampilkanPopup();
                } else {
                    tutupPopup();
                }
            }
        }

        // Panggil cekWaktu saat halaman dimuat
        cekWaktu();

    });
</script>

<!-- CRUD KAS KELUAR -->
<script>
    $(document).ready(function () {
        $('.btnSaveKasKeluar').on('click', function () {
            var kas_kode = $('#kas_keluar_kode').val();
            var kas_name = $('#kas_keluar_name').val();
            var kas_total = $('#kas_keluar_total').val();
            var kas_tipe = $('#kas_keluar_tipe').val();
            var id_kas = $('#id_kas_keluar').val();

            if (kas_name !== '') {
                $.ajax({
                    url: '<?= base_url('sibabad2/kas/saveKas') ?>', // URL untuk POST
                    method: 'POST',
                    data: {
                        kas_name: kas_name,
                        kas_kode: kas_kode,
                        kas_total: kas_total,
                        kas_tipe: kas_tipe,
                        id_kas: id_kas
                    }, // Data yang akan dikirim
                    dataType: 'json',
                    success: function (data) {
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Data berhasil disimpan',
                                text: data.message,
                            });

                            window.location.href = '<?= base_url('sibabad2/sale/index') ?>'
                        } else if (data.status === 'error') {
                            if (data.message.kas_kode && data.message.kas_kodes[0] ===
                                'Kode Kas tidak boleh sama.') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Data gagal disimpan',
                                    text: 'Tidak boleh ada kode kas yang sama.',
                                });
                                $('#kas_keluar_kode').val('');
                                $('#kas_keluar_name').val('');
                                $('#kas_keluar_total').val('');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Data gagal disimpan',
                                    text: 'Tidak boleh ada kode kasSS yang sama.',
                                });
                                $('#kas_keluar_kode').val('');
                                $('#kas_keluar_name').val('');
                                $('#kas_keluar_total').val('');
                            }
                        }
                    },
                    error: function () {
                        console.log('Terjadi kesalahan saat mengirim data.');
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Data tidak boleh kosong',
                    text: 'Mohon isi semua kolom.',
                });
            }

        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.btnEditKasKeluar').on('click', function () {
            var kas_kode = $(this).data('kas_kode');
            var kas_name = $(this).data('kas_name');
            var kas_total = $(this).data('kas_total');
            var id_kas = $(this).data('id_kas');
            $('#kas_keluar_kode').val(kas_kode);
            $('#kas_keluar_name').val(kas_name);
            $('#kas_keluar_total').val(kas_total);
            $('#id_kas_keluar').val(id_kas);
        });
    });
</script>

<script>
    $(document).ready(function () {
        $(document).on('click', '.btnDeleteKasKeluar', function () {
            const id_kas = $(this).data('id_kas');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda tidak dapat mengembalikan data yang dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform the delete action using AJAX
                    $.ajax({
                        url: `<?= base_url('sibabad2/kas/deleteKas/') ?>${id_kas}`,
                        method: 'DELETE',
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Terhapus!',
                                    text: 'Data berhasil dihapus.',
                                    icon: 'success'
                                }).then(() => {
                                    // Redirect or perform any other action after deletion
                                    window.location.href =
                                        '<?= base_url('sibabad2/sale/index') ?>';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat menghapus data.',
                                    icon: 'error'
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error deleting kas data:', status,
                                error);
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    });
</script>

<!-- CRUD KAS MASUK -->
<script>
    $(document).ready(function () {
        $('.btnSaveKasMasuk').on('click', function () {
            var kas_kode = $('#kas_kode').val();
            var kas_name = $('#kas_name').val();
            var kas_total = $('#kas_total').val();
            var kas_tipe = $('#kas_tipe').val();
            var id_kas = $('#id_kas').val();

            if (kas_name !== '') {
                $.ajax({
                    url: '<?= base_url('sibabad2/kas/saveKas') ?>', // URL untuk POST
                    method: 'POST',
                    data: {
                        kas_name: kas_name,
                        kas_kode: kas_kode,
                        kas_total: kas_total,
                        kas_tipe: kas_tipe,
                        id_kas: id_kas
                    }, // Data yang akan dikirim
                    dataType: 'json',
                    success: function (data) {
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Data berhasil disimpan',
                                text: data.message,
                            });

                            window.location.href = '<?= base_url('sibabad2/sale/index') ?>'
                        } else if (data.status === 'error') {
                            if (data.message.kas_kode && data.message.kas_kodes[0] ===
                                'Kode Kas tidak boleh sama.') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Data gagal disimpan',
                                    text: 'Tidak boleh ada kode kas yang sama.',
                                });
                                $('#kas_kode').val('');
                                $('#kas_name').val('');
                                $('#kas_total').val('');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Data gagal disimpan',
                                    text: 'Tidak boleh ada nama pelanggan yang sama.',
                                });
                                $('#kas_kode').val('');
                                $('#kas_name').val('');
                                $('#kas_total').val('');
                            }
                        }
                    },
                    error: function () {
                        console.log('Terjadi kesalahan saat mengirim data.');
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Data tidak boleh kosong',
                    text: 'Mohon isi semua kolom.',
                });
            }

        });
    });
</script>

<script>
    $(document).ready(function () {
        $('.btnEditKasMasuk').on('click', function () {
            var kas_kode = $(this).data('kas_kode');
            var kas_name = $(this).data('kas_name');
            var kas_total = $(this).data('kas_total');
            var id_kas = $(this).data('id_kas');
            $('#kas_kode').val(kas_kode);
            $('#kas_name').val(kas_name);
            $('#kas_total').val(kas_total);
            $('#id_kas').val(id_kas);
        });
    });
</script>

<script>
    $(document).ready(function () {
        $(document).on('click', '.btnDeleteKasMasuk', function () {
            const id_kas = $(this).data('id_kas');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda tidak dapat mengembalikan data yang dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform the delete action using AJAX
                    $.ajax({
                        url: `<?= base_url('sibabad2/kas/deleteKas/') ?>${id_kas}`,
                        method: 'DELETE',
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Terhapus!',
                                    text: 'Data berhasil dihapus.',
                                    icon: 'success'
                                }).then(() => {
                                    // Redirect or perform any other action after deletion
                                    window.location.href =
                                        '<?= base_url('sibabad2/sale/index') ?>';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat menghapus data.',
                                    icon: 'error'
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error deleting kas data:', status,
                                error);
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    });
</script>


<?= $this->endSection() ?>