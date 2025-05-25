<?= $this->extend('admin/templates/index-template') ?>
<?= $this->section('content') ?>

<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Gudang</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/sibabad') ?>"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Data Gudang</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Form Gudang</h5>

                        <?php if (session()->getFlashdata('success')) : ?>
                            <div class="alert alert-success text-center">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('success-delete')) : ?>
                            <div class="alert alert-success text-center">
                                <?= session()->getFlashdata('success-delete') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('info')) : ?>
                            <div class="alert alert-success text-center">
                                <?= session()->getFlashdata('info') ?>
                            </div>
                        <?php endif; ?>

                        <form class="row g-3 mt-3" action="<?= base_url('sibabad/warehouse/saveData') ?>" method="post">
                            <div class="row mb-3">
                                <label for="wName" class="col-sm-3 col-form-label">Nama Gudang</label>
                                <div class="col-sm-9">
                                    <input type="text" name="w_name" class="form-control" id="wName" placeholder="Nama Gudang">
                                    <?php if (session()->get('errors')) : ?>
                                        <?php $errors = session()->get('errors'); ?>
                                        <?php if (isset($errors['w_name'])) : ?>
                                            <div class="alert alert-danger text-center">
                                                <?= $errors['w_name'] ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="wAddress" class="col-sm-3 col-form-label">Alamat Gudang</label>
                                <div class="col-sm-9">
                                    <textarea name="w_address" class="form-control" id="wAddress" cols="30" rows="3" placeholder="Alamat lengkap gudang"></textarea>
                                    <?php if (session()->get('errors')) : ?>
                                        <?php $errors = session()->get('errors'); ?>
                                        <?php if (isset($errors['w_address'])) : ?>
                                            <div class="alert alert-danger text-center">
                                                <?= $errors['w_address'] ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="wPIC" class="col-sm-3 col-form-label">Nama PIC</label>
                                <div class="col-sm-9">
                                    <input type="text" name="w_pic" class="form-control" id="wPIC" placeholder="Nama PIC/ Penanggung Jawab">
                                    <?php if (session()->get('errors')) : ?>
                                        <?php $errors = session()->get('errors'); ?>
                                        <?php if (isset($errors['w_pic'])) : ?>
                                            <div class="alert alert-danger text-center">
                                                <?= $errors['w_pic'] ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="wContact" class="col-sm-3 col-form-label">Kontak PIC</label>
                                <div class="col-sm-9">
                                    <input type="text" name="w_pic_contact" class="form-control" id="wContact" placeholder="Kontak PIC/ Penanggung Jawab">
                                    <?php if (session()->get('errors')) : ?>
                                        <?php $errors = session()->get('errors'); ?>
                                        <?php if (isset($errors['w_pic_contact'])) : ?>
                                            <div class="alert alert-danger text-center">
                                                <?= $errors['w_pic_contact'] ?>
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

        <div class="row">
            <div class="col-xl-12 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Gudang</th>
                                        <th>Nama PIC</th>
                                        <th>Kontak</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($warehouse as $w) : ?>
                                        <tr>
                                            <td><?= $w['w_name'] ?></td>
                                            <td><?= $w['w_pic'] ?></td>
                                            <td><?= $w['w_pic_contact'] ?></td>
                                            <td>
                                                <!-- Edit -->
                                                <a href="<?= base_url('sibabad/warehouse/editView/') . $w['id_warehouse'] ?>" class="btn btn-primary btn-sm">
                                                    <i class="bx bx-pencil"></i>
                                                </a>
                                                <!-- Delete -->
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteWarehouse<?= $w['id_warehouse'] ?>">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Hapus -->
                                        <div class="modal fade" id="deleteWarehouse<?= $w['id_warehouse'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda ingin menghapus daftar akun ini ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="<?= base_url('sibabad/warehouse/deleteWarehouseData/') . $w['id_warehouse'] ?>" type="button" class="btn btn-success">Hapus</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Kode Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Aksi</th>
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

<?= $this->endSection() ?>