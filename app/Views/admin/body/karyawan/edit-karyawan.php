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
            <div class="col-xl-6 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Form Karyawan</h5>
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
                        <?php if (session()->getFlashdata('update')): ?>
                            <div class="alert alert-success text-center">
                                <?= session()->getFlashdata('update') ?>
                            </div>
                        <?php endif; ?>

                        <form class="row g-3 mt-3"
                            action="<?= base_url('sibabad/karyawan/editData/') . $karyawan['id_karyawan'] ?>"
                            method="post" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <label for="nama" class="col-sm-3 col-form-label">Nama Karyawan</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nama" class="form-control" id="nama"
                                        placeholder="Nama Karyawan" value="<?= $karyawan['nama'] ?>">
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
                                <label for="noktp" class="col-sm-3 col-form-label">Nomor KTP</label>
                                <div class="col-sm-9">
                                    <input name="noktp" class="form-control" id="noktp" cols="30" rows="3"
                                        placeholder="Nomor KTP" value="<?= $karyawan['noktp'] ?>"></input>
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
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <input type="text" name="alamat" class="form-control" id="alamat"
                                        placeholder="Alamat Karyawan" value="<?= $karyawan['alamat'] ?>">
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
                                <label for="nohp" class="col-sm-3 col-form-label">Nomor HP</label>
                                <div class="col-sm-9">
                                    <input type="text" name="nohp" class="form-control" id="nohp"
                                        placeholder="Nomor HP Karyawan" value="<?= $karyawan['nohp'] ?>">
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
                                <label for="jam_selesai" class="col-sm-3 col-form-label">Shift</label>
                                <div class="col-sm-9">
                                    <div class="position-relative">
                                        <select name="jam_selesai" class="form-control">
                                            <option value="">Ubah shift disini...</option>
                                            <?php foreach ($shift as $s): ?>
                                                <?php $selected = ($s['jam_selesai'] == $s['jam_selesai']) ? 'selected' : ''; ?>
                                                <option value="<?= $s['jam_selesai']; ?>"><?= $s['nama']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="position-absolute top-50 end-0 translate-middle-y">
                                            &#9660;
                                        </span>
                                    </div>
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
                            <div class="row mb-3">
                                <label for="foto" class="col-sm-3 col-form-label">Foto</label>
                                <div class="col-sm-9">
                                    <?php if ($karyawan['foto']): ?>
                                        <img src="<?= base_url('uploads/foto_karyawan/') . $karyawan['foto'] ?>"
                                            alt="Foto Karyawan" width="100" id="previewImage">
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