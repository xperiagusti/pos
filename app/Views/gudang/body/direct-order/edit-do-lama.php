<?= $this->extend('gudang/templates/index-template') ?>
<?= $this->section('content') ?>

<style>
td.merged-cell {
    border-top: none !important;
    border-bottom: none !important;
    padding: 0 !important;
}

td.merged-cell>a,
td.merged-cell>button {
    margin-right: 5px;
}

td.merged-cell>a:last-child,
td.merged-cell>button:last-child {
    margin-right: 0;
}
</style>

<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Form</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/sibabad3') ?>"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Pembelian Langsung</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Form Pemb. Langsung</h5>
                        <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success text-center">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('update')) : ?>
                        <div class="alert alert-success text-center">
                            <?= session()->getFlashdata('update') ?>
                        </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('success-delete')) : ?>
                        <div class="alert alert-success text-center">
                            <?= session()->getFlashdata('success-delete') ?>
                        </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('error-delete')) : ?>
                        <div class="alert alert-danger text-center">
                            <?= session()->getFlashdata('error-delete') ?>
                        </div>
                        <?php endif; ?>

                        <form class="mt-3" action="<?= base_url('sibabad3/coa/saveCoaData') ?>" method="post"
                            onsubmit="return validateForm()">
                            <div class="row mb-3">
                                <label for="dateOrder" class="col-sm-3 col-form-label">Tgl Pembelian</label>
                                <div class="col-sm-5">
                                    <input type="date" class="form-control" id="dateOrder"
                                        value="<?= $getDO[0]->do_date ?? '' ?>">
                                    <!-- Tampilkan data lainnya di sini sesuai kebutuhan -->
                                    <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['do_date'])) : ?>
                                    <div class="alert alert-danger text-center">
                                        <?= $errors['do_date'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="codeOrder" class="col-sm-3 col-form-label">Kode Pembelian</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="codeOrder"
                                        placeholder="KODE.001/PEMB/XXX" value="<?= $getDO[0]->do_code ?? '' ?>">
                                    <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['do_code'])) : ?>
                                    <div class="alert alert-danger text-center">
                                        <?= $errors['do_code'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="paymentMethod" class="col-sm-3 col-form-label">Metode Bayar</label>
                                <div class="col-sm-5">
                                    <select name="" id="paymentMethod" class="form-select">
                                        <option value="" selected disabled><?= $getDO[0]->coa_name ?? '' ?></option>
                                        <?php
                                        // Mengumpulkan nama rekening yang sesuai dengan kondisi
                                        $filtered_coa = [];
                                        foreach ($coa as $co) {
                                            if (strpos($co['coa_name'], 'Bank') === 0 || $co['coa_name'] === 'Kas' || $co['coa_name'] === 'Hutang Dagang') {
                                                $filtered_coa[] = $co;
                                            }
                                        }

                                        // Mengurutkan array nama rekening secara alfabetis
                                        usort($filtered_coa, function ($a, $b) {
                                            return strcmp($a['coa_name'], $b['coa_name']);
                                        });

                                        // Menampilkan opsi dalam urutan alfabetis
                                        foreach ($filtered_coa as $co) : ?>
                                        <option value="<?= $co['id_coa'] ?>" data-id="<?= $co['id_coa'] ?>">
                                            <?= $co['coa_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['id_coa'])) : ?>
                                    <div class="alert alert-danger text-center">
                                        <?= $errors['id_coa'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="supplierOrder" class="col-sm-3 col-form-label">Pilih Supplier</label>
                                <div class="col-sm-5">
                                    <select id="supplierOrder" class="form-select">
                                        <option value="" selected disabled><?= $getDO[0]->s_name ?? '' ?></option>
                                        <?php foreach ($sups as $sup) : ?>
                                        <option value="<?= $sup['id_supplier'] ?>"><?= $sup['s_name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['id_supplier'])) : ?>
                                    <div class="alert alert-danger text-center">
                                        <?= $errors['id_supplier'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="col-sm-3">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#supplierModal">+ Supplier</button>
                                </div>
                                <?php if (!empty($getDO[0]->do_shipment) && !empty($getDO[0]->do_courier)) : ?>
                                <!-- Tampilkan jika do_shipment dan do_courier ada isinya -->
                                <div class="row mt-4">
                                    <label for="codeOrder" class="col-sm-8 col-form-label">Apakah pada pembelian ini
                                        terdapat ongkos kirim ?</label>
                                    <div class="row col-sm-3">
                                        <select name="" id="shippingOption" class="form-select col-sm-3"
                                            onchange="toggleShipmentSection()">
                                            <option value="0">Tidak</option>
                                            <option value="1" selected>Ya</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="shipmentSection" class="mt-3">
                                    <div class="row mb-3">
                                        <label for="shippingFee" class="col-sm-3 col-form-label">Ongkos Kirim
                                            (Rp.)</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="shippingFee" placeholder="0"
                                                value="<?= $getDO[0]->do_shipment ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="shippingCourier" class="col-sm-3 col-form-label">Kurir</label>
                                        <div class="col-sm-9">
                                            <select name="" id="shippingCourier" class="form-select">
                                                <option value="-" selected disabled><?= $getDO[0]->do_courier ?>
                                                </option>
                                                <option value="JNE">JNE</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php else : ?>
                                <!-- Tampilkan jika do_shipment dan do_courier tidak ada isinya -->
                                <div class="row mt-4">
                                    <label for="shippingOptionEmpty" class="col-sm-8 col-form-label">Apakah pada
                                        pembelian ini terdapat ongkos kirim ?</label>
                                    <div class="row col-sm-3">
                                        <select name="" id="shippingOptionEmpty" class="form-select col-sm-3"
                                            onchange="toggleShipmentSectionEmpty()">
                                            <option value="0" selected>Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="shipmentSection" style="display: none;" class="mt-3">
                                    <div class="row mb-3">
                                        <label for="shippingFee" class="col-sm-3 col-form-label">Ongkos Kirim
                                            (Rp.)</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="shippingFee" placeholder="0">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="shippingCourier" class="col-sm-3 col-form-label">Kurir</label>
                                        <div class="col-sm-9">
                                            <select name="" id="shippingCourier" class="form-select">
                                                <option value="-" selected disabled>--Pilih--</option>
                                                <option value="JNE">JNE</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Option Shipping -->
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <form action="<?= base_url('sibabad3/direct_order/updateData/') . $getDO[0]->id_do ?>"
                                method="post">
                                <?php if (session()->get('errors')) : ?>
                                <?php $errors = session()->get('errors'); ?>
                                <?php if (isset($errors['id_product'])) : ?>
                                <div class="alert alert-danger text-center">
                                    <?= $errors['id_product'] ?>
                                </div>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if (session()->get('errors')) : ?>
                                <?php $errors = session()->get('errors'); ?>
                                <?php if (isset($errors['dop_qty'])) : ?>
                                <div class="alert alert-danger text-center mt-2">
                                    <?= $errors['dop_qty'] ?>
                                </div>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if (session()->get('errors')) : ?>
                                <?php $errors = session()->get('errors'); ?>
                                <?php if (isset($errors['dop_price'])) : ?>
                                <div class="alert alert-danger text-center mt-2">
                                    <?= $errors['dop_price'] ?>
                                </div>
                                <?php endif; ?>
                                <?php endif; ?>
                                <input type="hidden" name="do_date" id="hiddenDOPDATE"
                                    value="<?= $getDO[0]->do_date ?>">
                                <input type="hidden" name="do_code" id="hiddenDOPCODE"
                                    value="<?= $getDO[0]->do_code ?>">
                                <input type="hidden" name="id_coa" id="hiddenIDCOA" value="<?= $getDO[0]->id_coa ?>">
                                <input type="hidden" name="id_supplier" id="hiddenIDSUPPLIER"
                                    value="<?= $getDO[0]->id_supplier ?>">
                                <input type="hidden" name="do_shipment" id="hiddenDOPSHIPMENT"
                                    value="<?= $getDO[0]->do_shipment ?>">
                                <input type="hidden" name="do_courier" id="hiddenDOPCOURIER"
                                    value="<?= $getDO[0]->do_courier ?>">
                                <div class="d-flex justify-content-end">
                                    <a href="" class="btn btn-warning" data-bs-target="#buyReport"
                                        data-bs-toggle="modal">Lihat Laporan Pembelian</a>
                                    <button type="button" class="btn btn-success" data-bs-target="#productModal"
                                        data-bs-toggle="modal" style="margin-left: 10px;">Pilih Produk</button>
                                    <button type="submit" class="btn btn-primary" style="margin-left: 10px;">Simpan
                                        Pembelian</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table mb-0 table-striped mt-3 receiveProduct">
                                        <thead class="text-center">
                                            <tr>
                                                <th scope="col" style="display: none;">ID Produk</th>
                                                <th scope="col">Nama Produk</th>
                                                <th scope="col">Satuan</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($getDO as $product) : ?>
                                            <tr data-source="modal">
                                                <!-- Isi kolom-kolom produk yang ditambahkan melalui modal -->
                                                <td style="display: none;"><?= $product->id_product ?></td>
                                                <td><?= $product->p_name ?><input type="hidden" name="id_product[]"
                                                        value="<?= $product->id_product ?>"></td>
                                                <td><?= $product->p_unit_type ?></td>
                                                <td><?= $product->dop_qty ?><input type="hidden" name="dop_qty[]"
                                                        value="<?= $product->dop_qty ?>"></td>
                                                <td><?= $product->p_price ?></td>
                                                <td><?= $product->dop_total ?><input type="hidden" name="dop_total[]"
                                                        value="<?= $product->dop_total ?>"></td>
                                                <td>
                                                    <button data-id_do_products="<?= $product->id_do_products ?>"
                                                        id="btnDeleteProduct" type="button"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Supplier -->
<div class="modal fade" id="supplierModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Form Supplier</h5>
                        <form class="row g-3" action="<?= base_url('sibabad3/supplier/saveData') ?>" method="post"
                            enctype="multipart/form-data">
                            <div class="col-md-4">
                                <label for="clientName" class="form-label">Nama Supplier</label>
                                <input type="text" name="s_name" class="form-control" id="clientName"
                                    placeholder="Nama Supplier">
                                <?php if (session()->get('errors')) : ?>
                                <?php $errors = session()->get('errors'); ?>
                                <?php if (isset($errors['s_name'])) : ?>
                                <div class="alert alert-danger text-center">
                                    <?= $errors['s_name'] ?>
                                </div>
                                <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4">
                                <label for="clientPABX" class="form-label">PABX</label>
                                <input type="text" name="s_pabx" class="form-control" id="clientPABX"
                                    placeholder="(024) - 7621681">
                            </div>
                            <div class="col-md-4">
                                <label for="clientEmail" class="form-label">Email</label>
                                <input type="email" name="s_email" class="form-control" id="clientEmail"
                                    placeholder="alamat@mail.com">
                            </div>
                            <div class="col-md-4">
                                <label for="picName" class="form-label">Nama PIC</label>
                                <input type="text" name="s_pic" class="form-control" id="picName"
                                    placeholder="Nama PIC">
                                <?php if (session()->get('errors')) : ?>
                                <?php $errors = session()->get('errors'); ?>
                                <?php if (isset($errors['s_pic'])) : ?>
                                <div class="alert alert-danger text-center">
                                    <?= $errors['s_pic'] ?>
                                </div>
                                <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4">
                                <label for="picContact" class="form-label">Kontak PIC</label>
                                <input type="text" name="s_pic_contact" class="form-control" id="picContact"
                                    placeholder="Kontak PIC">
                                <?php if (session()->get('errors')) : ?>
                                <?php $errors = session()->get('errors'); ?>
                                <?php if (isset($errors['s_pic_contact'])) : ?>
                                <div class="alert alert-danger text-center">
                                    <?= $errors['s_pic_contact'] ?>
                                </div>
                                <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4">
                                <label for="clientType" class="form-label">Jenis Supplier</label>
                                <select name="s_type" id="clientType" class="form-select">
                                    <option value="--" selected disabled>Pilih Jenis</option>
                                    <option value="Badan Usaha">Badan Usaha</option>
                                    <option value="Perorangan">Perorangan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="clientNation" class="form-label">Negara</label>
                                <select id="clientNation" name="s_nation" class="form-select">
                                    <option selected disabled>Kewarganegaraan</option>
                                    <option value="Indonesia">Indonesia</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="clientProvince" class="form-label">Provinsi</label>
                                <select id="clientProvince" name="s_province" class="form-select">
                                    <option selected disabled>Pilih Provinsi</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="clientCity" class="form-label">Kota</label>
                                <select id="clientCity" name="s_city" class="form-select">
                                    <option selected disabled>Pilih Kota</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="clientDistrict" class="form-label">Kecamatan</label>
                                <select id="clientDistrict" name="s_district" class="form-select">
                                    <option selected disabled>Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="clientSubDistrict" class="form-label">Kelurahan</label>
                                <select id="clientSubDistrict" name="s_subdistrict" class="form-select">
                                    <option selected disabled>Pilih Kelurahan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="clientAddress" class="form-label">Alamat Perusahaan (Lengkap RT RW)</label>
                                <input type="text" name="s_address" class="form-control" id="clientAddress"
                                    placeholder="Alamat Perusahaan (Lengkap RT RW)">
                            </div>
                            <div class="col-md-3">
                                <label for="clientZipCode" class="form-label">Kode Pos</label>
                                <input type="text" name="s_zip_code" class="form-control" id="clientZipCode"
                                    placeholder="Kode Pos">
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="d-md-flex justify-content-end gap-3">
                                    <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
                                    <button type="reset" class="btn btn-light px-4">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Produk -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <div class="btnChooseProd">
                            <button class="btn btn-primary">Pilih Produk (0 dipilih)</button>
                        </div>

                        <div class="table-responsive mt-3">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" style="display: none;">ID Produk</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Satuan</th>
                                        <th scope="col">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($prods as $prod) : ?>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="idProduct"
                                                    data-idproduct="<?= $prod['id_product'] ?>">
                                            </div>
                                        </td>
                                        <td style="display: none;"><?= $prod['id_product'] ?></td>
                                        <td><?= $prod['p_name'] ?></td>
                                        <td><?= $prod['p_unit_type'] ?></td>
                                        <td><?= $prod['p_price'] ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" style="display: none;">ID Produk</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Satuan</th>
                                        <th scope="col">Harga</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!--  Modal Lap. Pembelian -->
<div class="modal fade" id="buyReport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Riwayat Pembelian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-end">
                            <button id="filterButton" class="btn btn-dark btn-sm">
                                <span class="bx bx-filter-alt"></span>
                            </button>
                        </div>

                        <div id="filterOptions" style="display: none;">
                            <div class="justify-content-end">
                                <div class="row mb-3">
                                    <label for="searchInput" class="col-sm-3 col-form-label">Cari</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="searchInput" class="form-control"
                                            placeholder="Kata kunci...">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="dateFrom" class="col-sm-3 col-form-label">Filter Tanggal</label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control" id="dateFrom">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="dateTo" class="col-sm-3 col-form-label">Filter Tanggal</label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control" id="dateTo">
                                    </div>

                                    <div class="col-sm-3">
                                        <button id="refreshData" class="btn btn-primary btn-sm">Refresh Data</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table id="tableData" class="table table-striped table-bordered mt-2" style="width:100%">
                            <thead class="text-center">
                                <tr>
                                    <th>Tgl Pembelian</th>
                                    <th>Kode Pembelian</th>
                                    <th>Nama Barang</th>
                                    <th>Kuantiti</th>
                                    <th>Harga Barang</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center tableBuyReport">
                                <?php
                                $mergedOrder = [];

                                foreach ($logOrder as $index => $log) {
                                    $logID = $log->id_do;

                                    if (!isset($mergedOrder[$logID])) {
                                        $mergedOrder[$logID] = [
                                            'do_date' => $log->do_date,
                                            'do_code' => $log->do_code,
                                            'actions' => [],
                                        ];
                                    }

                                    $mergedOrder[$logID]['actions'][] = [
                                        'p_name' => $log->p_name,
                                        'dop_qty' => $log->dop_qty,
                                        'p_price' => $log->p_price,
                                        'dop_total' => $log->dop_total,
                                    ];
                                }

                                foreach ($mergedOrder as $logID => $mergedLog) {
                                    $rowspan = count($mergedLog['actions']);

                                    echo '<tr>';
                                    echo '<td rowspan="' . $rowspan . '">' . $mergedLog['do_date'] . '</td>';
                                    echo '<td rowspan="' . $rowspan . '">' . $mergedLog['do_code'] . '</td>';

                                    foreach ($mergedLog['actions'] as $actionIndex => $action) {
                                        if ($actionIndex > 0) {
                                            echo '<tr>';
                                        }

                                        echo '<td>' . $action['p_name'] . '</td>';
                                        echo '<td>' . $action['dop_qty'] . '</td>';
                                        echo '<td>' . $action['p_price'] . '</td>';
                                        echo '<td>' . $action['dop_total'] . '</td>';

                                        if ($actionIndex === 0) {
                                            echo '<td rowspan="' . $rowspan . '">';
                                            echo '<a href="' . base_url('sibabad3/direct_order/editDO/') . $logID . '" class="btn btn-primary btn-sm"><span class="bx bx-pencil"></span></a>';
                                            echo '<button class="btn btn-danger btn-sm" onclick="showDeleteConfirmation(this, ' . $logID . ')"><span class="bx bx-trash"></span></button>';
                                            echo '<a href="' . base_url('sibabad3/direct_order/viewPDF/') . $logID . '" class="btn btn-success btn-sm">';
                                            echo '<span class="bx bx-file"></span>';
                                            echo '</a>';
                                            echo '</td>';
                                        }

                                        if ($actionIndex > 0) {
                                            echo '</tr>';
                                        }
                                    }

                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                            <tfoot class="text-center">
                                <tr>
                                    <th>Tgl Pembelian</th>
                                    <th>Kode Pembelian</th>
                                    <th>Nama Barang</th>
                                    <th>Kuantiti</th>
                                    <th>Harga Barang</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
$(document).ready(function() {
    const inputNPWP = $('#clientNPWP');

    inputNPWP.on('input', function() {
        const inputValue = $(this).val().replace(/\D/g,
            ''); // Hanya menyimpan angka, menghapus karakter non-digit

        // Batasi jumlah karakter yang dapat dimasukkan (maksimal 20 karakter)
        const limitedValue = inputValue.substr(0, 20);

        // Format NPWP sesuai placeholder
        const formattedNPWP = formatNPWP(limitedValue);

        // Update nilai input
        $(this).val(formattedNPWP);
    });
});

function formatNPWP(npwp) {
    // Memformat sesuai placeholder
    let formatted = npwp.replace(/^(\d{0,2})?(\d{0,3})?(\d{0,3})?(\d{0,1})?(\d{0,3})?(\d{0,3})?(\d{0,2})?/, function(
        match,
        p1,
        p2,
        p3,
        p4,
        p5,
        p6,
        p7
    ) {
        let result = '';
        if (p1) result += p1;
        if (p2) result += '.' + p2;
        if (p3) result += '.' + p3;
        if (p4) result += '.' + p4;
        if (p5) result += '-' + p5;
        if (p6) {
            // Hapus spasi setelah 5 digit angka ke-6
            const p6WithoutSpaces = p6.replace(/\s/g, '');
            result += '.' + p6WithoutSpaces.slice(0, 3) + '.' + p6WithoutSpaces.slice(3, 6);
        }
        // Hapus titik di paling belakang jika ada
        result = result.replace(/\.$/, '');
        return result;
    });

    return formatted;
}
</script>

<script>
$(document).ready(function() {
    // Fungsi untuk mengisi select box dengan data provinsi
    function populateSelectBox(data) {
        var select = document.getElementById("clientProvince");
        if (data.length > 0) {
            data.forEach(function(province) {
                var option = document.createElement("option");
                option.value = province.name; // Menggunakan nama provinsi sebagai value
                option.text = province.name;
                option.dataset.provinceId = province.id; // Menyimpan provinsi_id sebagai data atribut
                select.appendChild(option);
            });
        } else {
            var option = document.createElement("option");
            option.disabled = true;
            option.text = "Tidak ada data provinsi";
            select.appendChild(option);
        }
    }

    // Mengambil data provinsi dari API menggunakan fetch API
    fetch('https://api.goapi.id/v1/regional/provinsi', {
            method: 'GET',
            headers: {
                'accept': 'application/json',
                'X-API-KEY': 'xx9LHWjIklZ5jxmmcD1lLp6Twpk0Ys'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Memproses data provinsi dari "data" pada respons JSON
            var provinsi = data.data;
            populateSelectBox(provinsi);
        })
        .catch(error => {
            console.error("Error retrieving provinsi data:", error);
        });
});

$(document).ready(function() {
    function populateCitySelectBox(select, data) {
        select.empty();
        select.append(new Option("Pilih Kota", ""));
        $.each(data, function(index, city) {
            var option = new Option(city.name, city.name); // Use 'city.name' as the option text
            option.setAttribute("data-city-id", city.id); // Set a custom attribute to store the city ID
            select.append(option);
        });
    }

    function fetchCitiesByProvince(provinceId) {
        $.ajax({
            url: "https://api.goapi.id/v1/regional/kota",
            method: "GET",
            headers: {
                'accept': 'application/json',
                'X-API-KEY': 'xx9LHWjIklZ5jxmmcD1lLp6Twpk0Ys'
            },
            dataType: "json",
            data: {
                provinsi_id: provinceId
            },
            success: function(data) {
                var select = $("#clientCity");
                populateCitySelectBox(select, data.data); // Panggil fungsi yang sesuai
            },
            error: function(xhr, status, error) {
                console.error("Error retrieving city data:", error);
            }
        });
    }

    $("#clientProvince").change(function() {
        var selectedProvinceId = $(this).find(":selected").data("provinceId");
        if (selectedProvinceId) {
            fetchCitiesByProvince(selectedProvinceId);
        } else {
            var select = $("#clientCity");
            populateSelectBox(select, []);
        }
    });

});

$(document).ready(function() {
    function populateDistrictSelectBox(select, data) {
        select.empty();
        select.append(new Option("Pilih Kecamatan", ""));
        $.each(data, function(index, district) {
            var option = new Option(district.name, district
                .name); // Use 'district.name' as the option text
            option.setAttribute("data-district-id", district
                .id); // Set a custom attribute to store the district ID
            select.append(option);
        });
    }

    function fetchDistrictByCity(cityId) {
        $.ajax({
            url: "https://api.goapi.id/v1/regional/kecamatan",
            method: "GET",
            headers: {
                'accept': 'application/json',
                'X-API-KEY': 'xx9LHWjIklZ5jxmmcD1lLp6Twpk0Ys'
            },
            dataType: "json",
            data: {
                kota_id: cityId
            },
            success: function(data) {
                var select = $("#clientDistrict");
                populateDistrictSelectBox(select, data.data); // Panggil fungsi yang sesuai
            },
            error: function(xhr, status, error) {
                console.error("Error retrieving district data:", error);
            }
        });
    }

    $("#clientCity").change(function() {
        var selectedCityId = $(this).find(":selected").data("cityId");
        if (selectedCityId) {
            fetchDistrictByCity(selectedCityId);
        } else {
            var select = $("#clientDistrict");
            populateSelectBox(select, []);
        }
    });
});

$(document).ready(function() {
    function populateSelectBox(select, data) {
        select.empty();
        select.append(new Option("Pilih Kelurahan", ""));
        $.each(data, function(index, subdistrict) {
            var option = new Option(subdistrict.name, subdistrict
                .name); // Use 'subdistrict.name' as the option text
            option.setAttribute("data-subdistrict-name", subdistrict
                .name); // Set a custom attribute to store the subdistrict name
            select.append(option);
        });
    }

    function fetchSubDistrictByDistrict(districtId) {
        $.ajax({
            url: "https://api.goapi.id/v1/regional/kelurahan",
            method: "GET",
            headers: {
                'accept': 'application/json',
                'X-API-KEY': 'xx9LHWjIklZ5jxmmcD1lLp6Twpk0Ys'
            },
            dataType: "json",
            data: {
                kecamatan_id: districtId
            },
            success: function(data) {
                var select = $("#clientSubDistrict");
                populateSelectBox(select, data.data);
            },
            error: function(xhr, status, error) {
                console.error("Error retrieving subdistrict data:", error);
            }
        });
    }

    $("#clientDistrict").change(function() {
        var selectedDistrictName = $(this).find(":selected").data(
            "districtId"); // Get the selected district ID
        if (selectedDistrictName) {
            fetchSubDistrictByDistrict(selectedDistrictName); // Fetch data berdasarkan district ID
        } else {
            var select = $("#clientSubDistrict");
            populateSelectBox(select, []);
        }
    });
});
</script>

<script>
var pPrice = document.getElementById('pPrice');
pPrice.addEventListener('keyup', function(e) {
    this.value = formatRupiah(this.value);
});

function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/g);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
</script>

<script>
var shippingFee = document.getElementById('shippingFee');
shippingFee.addEventListener('keyup', function(e) {
    this.value = formatRupiah(this.value);
});

function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/g);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
</script>

<script>
function toggleShipmentSection() {
    var selectElement = document.getElementById("shippingOption");
    var shipmentSection = document.getElementById("shipmentSection");

    if (selectElement.value === "1") {
        shipmentSection.style.display = "block"; // Tampilkan bagian pengiriman
    } else {
        shipmentSection.style.display = "none"; // Sembunyikan bagian pengiriman
    }
}

function toggleShipmentSectionEmpty() {
    var selectElementEmpty = document.getElementById("shippingOptionEmpty");
    var shipmentSectionEmpty = document.getElementById("shipmentSection");

    if (selectElementEmpty.value === "1") {
        shipmentSection.style.display = "block"; // Tampilkan bagian pengiriman
    } else {
        shipmentSectionEmpty.style.display = "none"; // Sembunyikan bagian pengiriman
    }
}
</script>

<script>
$(document).ready(function() {
    var jumlahDipilih = 0;

    $('.form-check-input').on('change', function() {
        jumlahDipilih = 0;
        $('.form-check-input').each(function() {
            if ($(this).is(':checked')) {
                jumlahDipilih++;
            }
        });
        $('.btnChooseProd button').text('Pilih Produk (' + jumlahDipilih + ' dipilih)');
    });

    $('.receiveProduct tbody').on('click', '.deleteFromModal', function() {
        $(this).closest('tr').remove();
    });

    $('.btnChooseProd button').on('click', function() {
        var namaProduk = [];
        var satuanProduk = [];
        var hargaProduk = [];
        var idProduk = [];

        $('.form-check-input:checked').each(function() {
            var row = $(this).closest('tr');
            namaProduk.push(row.find('td:eq(2)')
                .text()); // Ubah indeks menjadi 1 untuk Nama Produk
            satuanProduk.push(row.find('td:eq(3)')
                .text()); // Ubah indeks menjadi 2 untuk Satuan
            hargaProduk.push(row.find('td:eq(4)').text()); // Ubah indeks menjadi 4 untuk Harga
            idProduk.push($(this).data('idproduct'));

            $(this).closest('tr').remove();
        });

        for (var i = 0; i < namaProduk.length; i++) {
            var newRow = '<tr>';
            newRow += '<td style="display: none;">' + idProduk[i] + '</td>';
            newRow += '<td>' + namaProduk[i] + '</td>';
            newRow += '<td>' + satuanProduk[i] + '</td>';
            newRow +=
                '<td><input type="text" name="dop_qty[]" class="form-control qty-input" style="width:70px;"> <input type="hidden" name="id_product[]" class="form-control" value="' +
                idProduk[i] + '"></td>';
            newRow +=
                '<td><input type="text" name="p_price[]" class="form-control" style="width:150px;" value=' +
                hargaProduk[i] + '>'
            '</td>';
            newRow +=
                '<td><input disabled type="text" class="form-control total-input" style="width:150px;"> <input type="hidden" name="dop_total[]" class="form-control total-input" style="width:250px;"></td>';
            newRow += '<td><i class="bx bx-trash" style="cursor:pointer;"></i></td>';
            newRow += '</tr>';

            $('.receiveProduct tbody').append(newRow);
        }

        jumlahDipilih = 0;

        $('.receiveProduct tbody').on('input', '.qty-input, input[name="p_price[]"]', function() {
            var row = $(this).closest('tr');
            var qty = parseFloat(row.find('.qty-input').val().replace(',', '.')) || 0;
            var hargaText = row.find('input[name="p_price[]"]').val().replace(/\./g, '')
                .replace(',', '.');
            var harga = parseFloat(hargaText) || 0;

            if (qty >= 0 && harga >= 0) {
                var total = qty * harga;
                var formattedTotal = total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                row.find('.total-input').val(formattedTotal);
            } else {
                row.find('.total-input').val('');
            }
        });

        $('.receiveProduct tbody').on('focus', '.qty-input', function() {
            // Simpan nilai awal qty saat input difokuskan
            $(this).data('prev-value', $(this).val());
        });

        $('.receiveProduct tbody').on('blur', '.qty-input', function() {
            // Cek apakah nilai qty telah berubah, jika tidak, jangan bersihkan total-input
            if ($(this).val() === $(this).data('prev-value')) {
                return;
            }
        });

        $('.btnChooseProd button').text('Pilih Produk (0 dipilih)');
        $('#productModal').modal('hide');
    });
});
</script>

<script>
$(document).ready(function() {
    // Ketika ada perubahan pada elemen dropdown dengan ID supplier
    $('#supplierOrder').on('change', function() {
        // Dapatkan nilai ID supplier yang dipilih
        var selectedSupplierID = $(this).val();

        // Set nilai ID supplier ke elemen input dengan ID hiddenIDSUPPLIER
        $('#hiddenIDSUPPLIER').val(selectedSupplierID);
    });
});

$(document).ready(function() {
    $('#paymentMethod').on('change', function() {
        var selectedCoaID = $(this).find(':selected').data('id');
        $('#hiddenIDCOA').val(selectedCoaID);
    });
});

$(document).ready(function() {
    $('#codeOrder').on('input', function() {
        var selectedDOCode = $(this).val();

        $('#hiddenDOPCODE').val(selectedDOCode);
    });
});

$(document).ready(function() {
    $('#dateOrder').on('change', function() {
        var selectedDateOrder = $(this).val();

        $('#hiddenDOPDATE').val(selectedDateOrder);
    });
});

$(document).ready(function() {
    $('#shippingFee').on('keyup', function() {
        var selectedDOCode = $(this).val();

        $('#hiddenDOPSHIPMENT').val(selectedDOCode);
    });
});

$(document).ready(function() {
    $('#shippingCourier').on('change', function() {
        var selectedDOCode = $(this).val();

        $('#hiddenDOPCOURIER').val(selectedDOCode);
    });
});
</script>

<script>
$(document).ready(function() {
    // Event delegation untuk tombol "Simpan Jurnal"
    $(document).on('click', '#saveButton', function() {
        // Dapatkan nilai dari kedua input
        var dopQty = $('#DOPQty').val();
        var dopPrice = $('#DOPPrice').val();

        // Periksa apakah kedua input kosong
        if (dopQty.trim() === '' || dopPrice.trim() === '') {
            // Tampilkan SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Kuantiti dan Harga produk tidak boleh kosong!'
            });
        } else {
            // Jika tidak kosong, lanjutkan dengan proses penyimpanan atau tindakan lainnya
            // ...
        }
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const filterButton = document.getElementById("filterButton");
    const filterOptions = document.getElementById("filterOptions");

    filterButton.addEventListener("click", function() {
        if (filterOptions.style.display === "none" || filterOptions.style.display === "") {
            // Jika elemen belum ditampilkan, tampilkan mereka
            filterOptions.style.display = "block";
        } else {
            // Jika elemen sudah ditampilkan, sembunyikan mereka
            filterOptions.style.display = "none";
        }
    });
});
</script>

<!-- Keyword -->
<script>
const reportLogOrder = <?= $reportOrderJson ?>;
let dateRange = null;

function searchJournal() {
    const searchInput = $('#searchInput').val().toLowerCase();
    let filteredResults = reportLogOrder;

    if (dateRange) {
        const [startDate, endDate] = dateRange.map(date => formatDate(date));
        filteredResults = filteredResults.filter(result => {
            const doDate = formatDate(result.do_date);
            return doDate >= startDate && doDate <= endDate;
        });
    }

    filteredResults = filteredResults.filter(result => {
        return (
            result.do_date.toLowerCase().includes(searchInput) ||
            result.do_code.toLowerCase().includes(searchInput) ||
            result.p_name.toLowerCase().includes(searchInput) ||
            result.dop_qty.toLowerCase().includes(searchInput) ||
            result.p_price.toLowerCase().includes(searchInput) ||
            result.dop_total.toLowerCase().includes(searchInput)
        );
    });

    updateTable(filteredResults);
}

function updateTable(searchResults) {
    const tableBody = $('.tableBuyReport');
    tableBody.empty();

    let previousDate = null;
    let previousCode = null;

    searchResults.forEach(result => {
        const {
            do_date,
            do_code,
            p_name,
            dop_qty,
            p_price,
            dop_total,
            id_do
        } = result;

        if (do_date !== previousDate || do_code !== previousCode) {
            // Open new row
            const row = `
                <tr>
                    <td>${do_date}</td>
                    <td>${do_code}</td>
                    <td>${p_name}</td>
                    <td>${dop_qty}</td>
                    <td>${p_price}</td>
                    <td>${dop_total}</td>
                    <td>
                        <a href="editDO/${id_do}" class="btn btn-primary btn-sm"><span class="bx bx-pencil"></span></a>
                        <button class="btn btn-danger btn-sm" onclick="showDeleteConfirmation(this, ${id_do})"><span class="bx bx-trash"></span></button>
                    </td>
                </tr>
            `;

            tableBody.append(row);

            previousDate = do_date;
            previousCode = do_code;
        } else {
            // Continue existing row
            const row = `
                <tr>
                    <td></td>
                    <td></td>
                    <td>${p_name}</td>
                    <td>${dop_qty}</td>
                    <td>${p_price}</td>
                    <td>${dop_total}</td>
                </tr>
            `;

            tableBody.append(row);
        }
    });
}

$('#searchInput').on('input', searchJournal);

function handleDateRange(selectedDates, dateStr, instance) {
    dateRange = selectedDates;
    console.log("Selected Dates:", dateRange); // Tambahkan ini
    searchJournal(); // Panggil searchJournal setiap kali rentang tanggal berubah
}

// Fungsi untuk mengubah format tanggal ke "Y-m-d"
function formatDate(date) {
    // Konversi tanggal ke format "Y-m-d" di sini
    return date.split(' ')[0];
}

$("#dateRange").on('change', function() {
    dateRange = this.value;
    console.log("Selected Date Range:", dateRange);
});

$("#dateRange").flatpickr({
    mode: "range",
    altInput: true,
    altFormat: "Y-m-d",
    dateFormat: "Y-m-d",
    onChange: handleDateRange
});

updateTable(reportLogOrder);
</script>

<script>
// Mendefinisikan variabel data JSON yang sudah ada
let reportDateOrder = <?= $reportOrderJson ?>;

// Fungsi untuk memfilter data berdasarkan tanggal
function filterDataByDate(startDate, endDate, jsonData) {
    return jsonData.filter(item => {
        const itemDate = new Date(item.do_date);
        return itemDate >= startDate && itemDate <= endDate;
    });
}

// Fungsi untuk menampilkan data yang sesuai ke dalam tabel
function updateTableBasedOnDate() {
    const dateFromInput = new Date(document.getElementById('dateFrom').value);
    const dateToInput = new Date(document.getElementById('dateTo').value);

    if (!dateFromInput || !dateToInput) {
        alert('Mohon masukkan tanggal yang valid.');
        return;
    }

    const filteredData = filterDataByDate(dateFromInput, dateToInput, reportDateOrder);
    updateTable(filteredData);
}

// Event listener untuk memanggil fungsi di atas saat tanggal 'dateTo' berubah
document.getElementById('dateTo').addEventListener('change', updateTableBasedOnDate);

// Event listener untuk memastikan 'dateTo' selalu lebih besar dari atau sama dengan 'dateFrom'
document.getElementById('dateFrom').addEventListener('change', function() {
    const dateFromInput = new Date(this.value);
    const dateToInput = new Date(document.getElementById('dateTo').value);

    if (dateToInput < dateFromInput) {
        alert('Tanggal "dateTo" harus lebih besar dari atau sama dengan tanggal "dateFrom".');
        document.getElementById('dateTo').value = this
            .value; // Atur tanggal 'dateTo' ke 'dateFrom' jika tidak valid
    }
});

// Event listener untuk memastikan 'dateTo' tidak kurang dari 'dateFrom'
document.getElementById('dateTo').addEventListener('change', function() {
    const dateFromInput = new Date(document.getElementById('dateFrom').value);
    const dateToInput = new Date(this.value);

    if (dateToInput < dateFromInput) {
        alert('Tanggal "dateTo" harus lebih besar dari atau sama dengan tanggal "dateFrom".');
        this.value = dateFromInput
            .toLocaleDateString(); // Atur tanggal 'dateTo' ke tanggal 'dateFrom' jika tidak valid
    }
});

// Event listener untuk tombol "Refresh Data"
document.getElementById('refreshData').addEventListener('click', function() {
    // Kembalikan data ke data asli
    reportDateOrder = <?= $reportOrderJson ?>;
    // Perbarui tabel dengan data asli
    updateTable(reportDateOrder);

    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    document.getElementById('searchInput').value = '';
});

// Fungsi untuk menginisialisasi tabel pada awal halaman dimuat
function initializeTable() {
    updateTable(reportDateOrder);
}

// Panggil fungsi inisialisasi tabel saat halaman dimuat
window.addEventListener('DOMContentLoaded', initializeTable);
</script>

<script>
$(document).ready(function() {
    $(document).on('click', '#btnDeleteProduct', function() {
        const DoID = $(this).data('id_do_products');

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
                    url: `<?= base_url('sibabad3/direct_order/deleteDO/') ?>${DoID}`,
                    method: 'DELETE',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: 'Data berhasil dihapus.',
                                icon: 'success'
                            }).then(() => {
                                // Redirect or perform any other action after deletion
                                window.location.href =
                                    `<?= base_url('sibabad3/direct_order/editDO/') . $getDO[0]->id_do ?>`;
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting product data:', status,
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