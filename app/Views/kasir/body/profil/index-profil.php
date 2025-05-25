<?= $this->extend('kasir/templates/sale-template') ?>
<?= $this->section('content') ?>

<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Profil</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Biodata</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="<?= get_foto_karyawan(session('id_user')) ?>" alt="Foto"
                                        class="rounded-circle p-1 bg-primary" width="110">
                                    <div class="mt-3">
                                        <h4>
                                            <?= get_nama_karyawan(session('id_user')) ?>
                                        </h4>
                                        <p class="text-muted font-size-sm">
                                            <?= get_alamat_karyawan(session('id_user')) ?>
                                            <br>
                                            <?= get_nohp_karyawan(session('id_user')) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="<?= base_url('kasir/profil/saveProfil') ?>" method="post"
                                    enctype="multipart/form-data">
                                    <?php if (session()->getFlashdata('success-userdetail')): ?>
                                        <div class="alert alert-success text-center">
                                            <?= session()->getFlashdata('success-userdetail') ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (session()->getFlashdata('update-userdetail')): ?>
                                        <div class="alert alert-success text-center">
                                            <?= session()->getFlashdata('update-userdetail') ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Nama Lengkap</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="nama" class="form-control" id="nama"
                                                placeholder="Nama Karyawan"
                                                value="<?= get_nama_karyawan(session('id_user')) ?>">
                                            <?php if (session()->get('errors')): ?>
                                                <?php $errors = session()->get('errors'); ?>
                                                <?php if (isset($errors['w_name'])): ?>
                                                    <div class="alert alert-danger text-center">
                                                        <?= $errors['w_name'] ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Nomor KTP</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input name="noktp" class="form-control" id="noktp" cols="30" rows="3"
                                                placeholder="Nomor KTP"
                                                value="<?= get_noktp_karyawan(session('id_user')) ?>"></input>
                                            <?php if (session()->get('errors')): ?>
                                                <?php $errors = session()->get('errors'); ?>
                                                <?php if (isset($errors['noktp'])): ?>
                                                    <div class="alert alert-danger text-center">
                                                        <?= $errors['noktp'] ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Alamat</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="alamat" class="form-control" id="alamat"
                                                placeholder="Alamat Karyawan"
                                                value="<?= get_alamat_karyawan(session('id_user')) ?>">
                                            <?php if (session()->get('errors')): ?>
                                                <?php $errors = session()->get('errors'); ?>
                                                <?php if (isset($errors['alamat'])): ?>
                                                    <div class="alert alert-danger text-center">
                                                        <?= $errors['alamat'] ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Nomor HP</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="nohp" class="form-control" id="nohp"
                                                placeholder="Nomor HP Karyawan"
                                                value="<?= get_nohp_karyawan(session('id_user')) ?>">
                                            <?php if (session()->get('errors')): ?>
                                                <?php $errors = session()->get('errors'); ?>
                                                <?php if (isset($errors['nohp'])): ?>
                                                    <div class="alert alert-danger text-center">
                                                        <?= $errors['nohp'] ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 for="foto" class="mb-0">Foto</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?php if ($prof['foto']): ?>
                                                <img src="<?= get_foto_karyawan(session('id_user')) ?>" alt="Foto Karyawan"
                                                    width="100" id="previewImage">
                                                <input type="file" name="foto" class="form-control" id="foto"
                                                    style="display: none;">
                                                <label for="foto" id="ubahFotoLabel">Ubah Foto</label>
                                            <?php else: ?>
                                                <input type="file" name="foto" class="form-control" id="foto">
                                            <?php endif; ?>
                                            <?php if (session()->get('errors')): ?>
                                                <?php $errors = session()->get('errors'); ?>
                                                <?php if (isset($errors['foto'])): ?>
                                                    <div class="alert alert-danger text-center">
                                                        <?= $errors['foto'] ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <button type="submit" class="btn btn-primary btn-sm">Simpan Data</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('previewImage').addEventListener('click', function () {
        document.getElementById('foto').click();
    });

    document.getElementById('ubahFotoLabel').addEventListener('click', function () {
        document.getElementById('foto').click();
    });

    document.getElementById('foto').addEventListener('change', function () {
        const file = this.files[0];
        const reader = new FileReader();

        reader.onload = function () {
            document.getElementById('previewImage').src = reader.result;
        }

        reader.readAsDataURL(file);
    });
</script>

<?= $this->endSection() ?>