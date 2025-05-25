<?= $this->extend('admin/templates/index-template') ?>
<?= $this->section('content') ?>

<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Karyawan</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/sibabad') ?>"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Data Karyawan</li>
                    </ol>
                </nav>
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
                                        <th>Nama Karyawan</th>
                                        <th>Nomor KTP</th>
                                        <th>Alamat</th>
                                        <th>Nomor HP</th>
                                        <th>Shift</th>
                                        <th>Role</th>
                                        <th>Foto</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1; foreach ($karyawan as $w):
                                        ?>
                                        <tr>
                                            <td class="text-center">
                                                <?= $i++ ?>
                                            </td>
                                            <td>
                                                <?= $w['nama'] ?>
                                            </td>
                                            <td>
                                                <?= $w['noktp'] ?>
                                            </td>
                                            <td>
                                                <?= $w['alamat'] ?>
                                            </td>
                                            <td>
                                                <?= $w['nohp'] ?>
                                            </td>
                                            <td>
                                                <?= $w['nama_shift'] ?>
                                            </td>
                                            <td> 
                                                <?= $w['role'] ?>
                                            </td>
                                            <td class="text-center">
                                                <img src="<?= base_url('uploads/foto_karyawan/') . $w['foto'] ?>"
                                                    alt="Foto Karyawan" width="100">
                                            </td>
                                            <td class="text-center">
                                                <!-- Edit -->
                                                <a href="<?= base_url('sibabad/karyawan/editView/') . $w['id_karyawan'] ?>"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="bx bx-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th style="width: 20px;">No</th>
                                        <th>Nama Karyawan</th>
                                        <th>Nomor KTP</th>
                                        <th>Alamat</th>
                                        <th>Nomor HP</th>
                                        <th>Shift</th>
                                        <th>Foto</th>
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