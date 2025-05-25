<?= $this->extend('admin/templates/index-template') ?>
<?= $this->section('content') ?>

<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Form</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/sibabad') ?>"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Inovice Penjualan</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Form Detail Invoice</h5>

                        <div class="row mb-3">
                            <label for="dateOrder" class="col-sm-4 col-form-label">Tanggal dan Waktu</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="<?=date("d F Y H:i", strtotime(esc($transaksi[0]['tanggal'])))?>" readonly>                        
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="codeOrder" class="col-sm-4 col-form-label">Kode</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="<?=esc($transaksi[0]['invoice']);?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="codeOrder" class="col-sm-4 col-form-label">Pelanggan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="<?=esc($transaksi[0]['pelanggan']);?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="codeOrder" class="col-sm-4 col-form-label">Kasir</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="<?=esc($transaksi[0]['kasir']);?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="codeOrder" class="col-sm-4 col-form-label">IP Address</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="<?=esc($transaksi[0]['ip_address']);?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-xl-12 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <table class="table mb-0 table-borderless mt-3">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Harga Produk</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Diskon Produk %</th>
                                        <th scope="col">Harga</th>
                                    </tr>
                                    
                                </thead>
                                <tbody class="text-center">
                                    <?php $i=1;
                                    foreach ($transaksi as $data) : ?>
                                    <tr>
                                        <!-- Isi kolom-kolom produk yang ditambahkan melalui modal -->
                                        <td><?= $i ?></td>
                                        <td><?=esc($data['item']);?></td>
                                        <td><?=rupiah(esc($data['harga']));?></td>
                                        <td><?=esc($data['jumlah']);?></td>
                                        <td><?=rupiah(esc($data['diskon_item']));?></td>
                                        <td><?=rupiah(esc($data['subtotal']));?></td>
                                    </tr>
                                    
                                    <?php endforeach; ?>
                                    <tr>
                                        <td class="col" colspan="4" rowspan="5"></td>
                                        <td class="col"><b>Sub Total</b></td>
                                        <td class="col"><?=rupiah(esc($transaksi[0]['total_harga']));?></td>
                                    </tr>
                                    <tr>
                                        <td class="col"><b>Diskon Pembelian</b></td>
                                        <td class="col"><?=rupiah(esc($transaksi[0]['diskon']));?>%</td>
                                    </tr>
                                    <tr>
                                        <td class="col"><b>Total Akhir</b></td>
                                        <td class="col"><?=rupiah(esc($transaksi[0]['total_akhir']));?></td>
                                    </tr>
                                    <tr>
                                        <td class="col"><b>Tunai</b></td>
                                        <td class="col"><?=rupiah(esc($transaksi[0]['tunai']));?></td>
                                    </tr>
                                    <tr>
                                        <td class="col"><b>Kembalian</b></td>
                                        <td class="col"><?=rupiah(esc($transaksi[0]['kembalian']));?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<?= $this->endSection() ?>