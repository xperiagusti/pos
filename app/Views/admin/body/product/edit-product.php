<?= $this->extend('admin/templates/index-template') ?>
<?= $this->section('content') ?>

<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Form</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/sibabad') ?>"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Produk</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Form Tambah Produk</h5>
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
                        <form class="mt-3" action="<?= base_url('sibabad/product/editData/') . $prod['id_product'] ?>" method="post">
                            <input name="id_product" type="hidden" value="<?= $prod['id_product'] ?>">

                            <div class="row mb-3">
                                <label for="pCode" class="col-sm-3 col-form-label">Kode</label>
                                <div class="col-sm-9">
                                    <input type="text" name="p_code" class="form-control" id="pCode" value="<?= $prod['p_code'] ?>">
                                    <?php if (session()->get('errors')) : ?>
                                        <?php $errors = session()->get('errors'); ?>
                                        <?php if (isset($errors['p_code'])) : ?>
                                            <div class="alert alert-danger text-center">
                                                <?= $errors['p_code'] ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label for="pName" class="col-sm-3 col-form-label">Nama Produk</label>
                                <div class="col-sm-9">
                                    <input type="text" name="p_name" class="form-control" id="pName" value="<?= $prod['p_name'] ?>">
                                    <?php if (session()->get('errors')) : ?>
                                        <?php $errors = session()->get('errors'); ?>
                                        <?php if (isset($errors['p_name'])) : ?>
                                            <div class="alert alert-danger text-center">
                                                <?= $errors['p_name'] ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="pUnitType" class="col-sm-3 col-form-label">Satuan</label>
                                <div class="col-sm-5">
                                    <select class="form-select" name="p_unit_type" id="pUnitType">
                                        
                                        <?php
                                        foreach ($units as $a): ?>
                                        <option value="<?= $a["u_name"] ?>" <?= $prod["p_unit_type"] == $a["u_name"]? "selected": null ?>>
                                            <?= $a["u_name"] ?>
                                        </option>
                                    <?php endforeach;?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="pPrice" class="col-sm-3 col-form-label">Harga (Rp.)</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="p_price" id="pPrice" placeholder="0" value="<?= rupiah($prod['p_price']) ?>">
                                    <?php if (session()->get('errors')) : ?>
                                        <?php $errors = session()->get('errors'); ?>
                                        <?php if (isset($errors['p_price'])) : ?>
                                            <div class="alert alert-danger text-center">
                                                <?= $errors['p_price'] ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" id="loadingContainer" class="btn btn-primary px-4" onclick="saveCoaData()">Simpan Data</button>
                                        <button type="reset" class="btn btn-light px-4">Bersihkan Form</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

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

<?= $this->endSection() ?>