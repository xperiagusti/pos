<?= $this->extend('admin/templates/index-template') ?>
<?= $this->section('content') ?>

<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Form</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/sibabad') ?>"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Rekap Transaksi Harian</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-9 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Form Transaksi Harian</h5>
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
                        <form class="mt-3" action="<?= base_url('sibabad/coa/saveCoaData') ?>" method="post" onsubmit="return validateForm()">
                            <div class="row mb-3">
                                <label for="trxDate" class="col-sm-3 col-form-label">Tanggal Transaksi</label>
                                <div class="col-sm-8">
                                    <input type="date" id="trxDate" class="form-control" name="d_trx_date">
                                    <?php if (session()->get('errors')) : ?>
                                        <?php $errors = session()->get('errors'); ?>
                                        <?php if (isset($errors['d_trx_date'])) : ?>
                                            <div class="alert alert-danger text-center">
                                                <?= $errors['d_trx_date'] ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="trxDetail" class="col-sm-3 col-form-label">Keterangan</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="d_trx_detail" id="trxDetail" cols="30" rows="2" placeholder="Masukkan keterangan transaksi. Contoh: Pembelian barang dari PT.XXX"></textarea>
                                    <?php if (session()->get('errors')) : ?>
                                        <?php $errors = session()->get('errors'); ?>
                                        <?php if (isset($errors['d_trx_detail'])) : ?>
                                            <div class="alert alert-danger text-center">
                                                <?= $errors['d_trx_detail'] ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Display None Pemasukkan -->
                            <div id="inFunding">
                                <div class="row mb-3">
                                    <label for="trxType" class="col-sm-3 col-form-label">Jenis Transaksi</label>
                                    <div class="col-sm-4">
                                        <select name="d_trx_type" class="form-select" id="trxType">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="Pemasukan">Pemasukan</option>
                                            <option value="Pengeluaran">Pengeluaran</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="trxCategory" class="col-sm-3 col-form-label">Kategori Transaksi</label>
                                    <div class="col-sm-4">
                                        <select name="d_trx_type" class="form-select" id="trxCategory">
                                            <option value="" selected disabled>--Pilih--</option>
                                            <option value="Bank">Bank</option>
                                            <option value="Kas">Kas</option>
                                            <option value="Piutang/ Tempo">Piutang/ Tempo</option>
                                            <option value="Barang & Kas">Barang & Kas</option>
                                            <option value="Barang & Bank">Barang & Bank</option>
                                            <option value="Cek">Cek</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="trxBalance" class="col-sm-3 col-form-label">Nominal/ Total</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="d_balance" id="trxBalance" placeholder="0">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <div class="d-md-flex d-grid align-items-center gap-3">
                                            <button type="button" class="btn btn-primary px-4">Simpan Data</button>
                                            <button type="button" class="btn btn-warning px-4">Lihat Rekap Pembelian</button>
                                            <button type="button" class="btn btn-success px-4">Lihat Rekap Penjualan</button>
                                            <button type="reset" class="btn btn-light px-4">Bersihkan Form</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Style Display Pengeluaran -->
                            <div id="outFunding" style="display: none;">
                                <h1>Test</h1>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>