<?= $this->extend('admin/templates/index-template') ?>
<?= $this->section('content') ?>

<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Shift</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/sibabad') ?>"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Data Shift</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Form Shift</h5>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success text-center">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('success-delete')): ?>
                            <div class="alert alert-success text-center">
                                <?= session()->getFlashdata('success-delete') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('info')): ?>
                            <div class="alert alert-success text-center">
                                <?= session()->getFlashdata('info') ?>
                            </div>
                        <?php endif; ?>

                        <form class="row g-3 mt-3" action="<?= base_url('sibabad/shift/saveData') ?>" method="post">
                            <div class="row mb-3">
                                <label for="nama" class="col-sm-3 col-form-label">Nama Shift</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama" class="form-control" id="nama"
                                        placeholder="Masukkan Nama Shift">
                                    <?php if (session()->get('errors')): ?>
                                        <?php $errors = session()->get('errors'); ?>
                                        <?php if (isset($errors['nama'])): ?>
                                            <div class="alert alert-danger text-center">
                                                <?= $errors['nama'] ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="jam_mulai" class="col-sm-3 col-form-label">Jam Mulai Shift</label>
                                <div class="col-sm-9">
                                    <input type="time" name="jam_mulai" class="form-control" id="jam_mulai"
                                        placeholder="Masukkan Jam Mulai Shift">
                                    <?php if (session()->get('errors')): ?>
                                        <?php $errors = session()->get('errors'); ?>
                                        <?php if (isset($errors['jam_mulai'])): ?>
                                            <div class="alert alert-danger text-center">
                                                <?= $errors['jam_mulai'] ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="jam_selesai" class="col-sm-3 col-form-label">Jam Selesai Shift</label>
                                <div class="col-sm-9">
                                    <input type="time" name="jam_selesai" class="form-control" id="jam_selesai"
                                        placeholder="Masukkan Jam Selesai Shift">
                                    <?php if (session()->get('errors')): ?>
                                        <?php $errors = session()->get('errors'); ?>
                                        <?php if (isset($errors['jam_selesai'])): ?>
                                            <div class="alert alert-danger text-center">
                                                <?= $errors['jam_selesai'] ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" id="loadingContainer" class="btn btn-primary px-4"
                                            onclick="saveCoaData()">Simpan Data</button>
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
                                        <th style="width: 20px;">No</th>
                                        <th>Nama Shift</th>
                                        <th>Jam Mulai Shift</th>
                                        <th>Jam Selesai Shift</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($shift as $w): ?>
                                        <tr>
                                            <td class="text-center">
                                                <?= $i++ ?>
                                            </td>
                                            <td>
                                                <?= $w['nama'] ?>
                                            </td>
                                            <td>
                                                <?= $w['jam_mulai'] ?>
                                            </td>
                                            <td>
                                                <?= $w['jam_selesai'] ?>
                                            </td>
                                            <td class="text-center">
                                                <!-- Edit -->
                                                <a href="<?= base_url('sibabad/shift/editView/') . $w['id_shift'] ?>"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="bx bx-pencil"></i>
                                                </a>
                                                <!-- Delete -->
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#deleteShift<?= $w['id_shift'] ?>">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Hapus -->
                                        <div class="modal fade" id="deleteShift<?= $w['id_shift'] ?>" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda ingin menghapus daftar akun ini ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="<?= base_url('sibabad/shift/deleteShiftData/') . $w['id_shift'] ?>"
                                                            type="button" class="btn btn-success">Hapus</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width: 20px;">No</th>
                                        <th>Nama Shift</th>
                                        <th>Jam Mulai Shift</th>
                                        <th>Jam Selesai Shift</th>
                                        <th class="text-center">Aksi</th>
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