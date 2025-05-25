<?= $this->extend('admin/templates/index-template') ?>
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
                                    <img src="<?= base_url('uploads/logo_perusahaan/' . $kea['logo']) ?>" alt="Admin"
                                        class="rounded-circle p-1 bg-primary" width="110">
                                    <div class="mt-3">
                                        <h4>
                                            <?= $prof['nama_perusahaan']; ?>
                                        </h4>
                                        <p class="text-muted font-size-sm">
                                            <?= $prof['alamat'] ?>,
                                            <?= $prof['kecamatan'] ?>,
                                            <?= $prof['provinsi'] ?>
                                        </p>
                                        <!-- <button class="btn btn-primary">Follow</button>
                                        <button class="btn btn-outline-primary">Message</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="<?= base_url('admin/profil/userProfil') ?>" method="post">
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
                                            <input type="text" name="nama_lengkap" class="form-control"
                                                value="<?= isset($user['nama_lengkap']) ? $user['nama_lengkap'] : '' ?>">
                                            <?php if (session()->get('errors')): ?>
                                                <?php $errors = session()->get('errors'); ?>
                                                <?php if (isset($errors['nama_lengkap'])): ?>
                                                    <div class="alert alert-danger text-center">
                                                        <?= $errors['nama_lengkap'] ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="email" class="form-control"
                                                value="<?= isset($user['email']) ? $user['email'] : '' ?>">
                                            <?php if (session()->get('errors')): ?>
                                                <?php $errors = session()->get('errors'); ?>
                                                <?php if (isset($errors['email'])): ?>
                                                    <div class="alert alert-danger text-center">
                                                        <?= $errors['email'] ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Kontak</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="kontak" class="form-control"
                                                value="<?= isset($user['kontak']) ? $user['kontak'] : '' ?>">
                                            <?php if (session()->get('errors')): ?>
                                                <?php $errors = session()->get('errors'); ?>
                                                <?php if (isset($errors['kontak'])): ?>
                                                    <div class="alert alert-danger text-center">
                                                        <?= $errors['kontak'] ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Alamat Lengkap</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="alamat_lengkap" class="form-control"
                                                value="<?= isset($user['alamat_lengkap']) ? $user['alamat_lengkap'] : '' ?>">
                                            <?php if (session()->get('errors')): ?>
                                                <?php $errors = session()->get('errors'); ?>
                                                <?php if (isset($errors['alamat_lengkap'])): ?>
                                                    <div class="alert alert-danger text-center">
                                                        <?= $errors['alamat_lengkap'] ?>
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-primary" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#primaryprofil" role="tab"
                                            aria-selected="true">
                                            <div class="d-flex align-items-center">
                                                <div class="tab-icon"><i class='bx bx-microphone font-18 me-1'></i>
                                                </div>
                                                <div class="tab-title">Profil</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#primaryhome" role="tab"
                                            aria-selected="false">
                                            <div class="d-flex align-items-center">
                                                <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                                </div>
                                                <div class="tab-title">Logo</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab"
                                            aria-selected="false">
                                            <div class="d-flex align-items-center">
                                                <div class="tab-icon"><i class='bx bx-user-pin font-18 me-1'></i>
                                                </div>
                                                <div class="tab-title">Pembayaran</div>
                                            </div>
                                        </a>
                                    </li>
                                    
                                </ul>
                                <div class="tab-content py-3">
                                    <div class="tab-pane fade show active" id="primaryprofil" role="tabpanel">
                                        <?php if (session()->getFlashdata('success')): ?>
                                            <div class="alert alert-success text-center">
                                                <?= session()->getFlashdata('success') ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (session()->getFlashdata('failed')): ?>
                                            <div class="alert alert-success text-center">
                                                <?= session()->getFlashdata('failed') ?>
                                            </div>
                                        <?php endif; ?>
                                        <form action="<?= base_url('admin/profil/saveProfil') ?>" method="post"
                                            enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <label for="nama_perusahaan" class="col-sm-3 col-form-label">Nama
                                                    Perusahaan</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="nama_perusahaan" class="form-control"
                                                        id="nama_perusahaan"
                                                        placeholder="Masukkan nama perusahaan disini..."
                                                        value="<?= isset($prof['nama_perusahaan']) ? $prof['nama_perusahaan'] : '' ?>">
                                                    <?php if (session()->get('errors')): ?>
                                                        <?php $errors = session()->get('errors'); ?>
                                                        <?php if (isset($errors['nama_perusahaan'])): ?>
                                                            <div class="alert alert-danger text-center">
                                                                <?= $errors['nama_perusahaan'] ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="alamat" class="form-control" id="alamat"
                                                        placeholder="Masukkan alamat disini..."
                                                        value="<?= isset($prof['alamat']) ? $prof['alamat'] : '' ?>">
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
                                                <label for="kecamatan" class="col-sm-3 col-form-label">Kecamatan</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="kecamatan" class="form-control"
                                                        id="kecamatan" placeholder="Masukkan kecamatan disini..."
                                                        value="<?= isset($prof['kecamatan']) ? $prof['kecamatan'] : '' ?>">
                                                    <?php if (session()->get('errors')): ?>
                                                        <?php $errors = session()->get('errors'); ?>
                                                        <?php if (isset($errors['kecamatan'])): ?>
                                                            <div class="alert alert-danger text-center">
                                                                <?= $errors['kecamatan'] ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="provinsi" class="col-sm-3 col-form-label">Provinsi</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="provinsi" class="form-control"
                                                        id="provinsi" placeholder="Masukkan provinsi disini..."
                                                        value="<?= isset($prof['provinsi']) ? $prof['provinsi'] : '' ?>">
                                                    <?php if (session()->get('errors')): ?>
                                                        <?php $errors = session()->get('errors'); ?>
                                                        <?php if (isset($errors['provinsi'])): ?>
                                                            <div class="alert alert-danger text-center">
                                                                <?= $errors['provinsi'] ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="kode_pos" class="col-sm-3 col-form-label">Kode Pos</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="kode_pos" class="form-control"
                                                        id="kode_pos" placeholder="Masukkan kode pos disini..."
                                                        value="<?= isset($prof['kode_pos']) ? $prof['kode_pos'] : '' ?>">
                                                    <?php if (session()->get('errors')): ?>
                                                        <?php $errors = session()->get('errors'); ?>
                                                        <?php if (isset($errors['kode_pos'])): ?>
                                                            <div class="alert alert-danger text-center">
                                                                <?= $errors['kode_pos'] ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="negara" class="col-sm-3 col-form-label">Negara</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="negara" class="form-control" id="negara"
                                                        placeholder="Masukkan negara disini..."
                                                        value="<?= isset($prof['negara']) ? $prof['negara'] : '' ?>">
                                                    <?php if (session()->get('errors')): ?>
                                                        <?php $errors = session()->get('errors'); ?>
                                                        <?php if (isset($errors['negara'])): ?>
                                                            <div class="alert alert-danger text-center">
                                                                <?= $errors['negara'] ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="email" class="form-control" id="email"
                                                        placeholder="Masukkan email disini..."
                                                        value="<?= isset($prof['email']) ? $prof['email'] : '' ?>">
                                                    <?php if (session()->get('errors')): ?>
                                                        <?php $errors = session()->get('errors'); ?>
                                                        <?php if (isset($errors['email'])): ?>
                                                            <div class="alert alert-danger text-center">
                                                                <?= $errors['email'] ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 col-form-label"></label>
                                                <div class="col-sm-9">
                                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                                        <button type="submit" class="btn btn-primary px-4"
                                                            id="submitButton" onclick="submitForm()">Simpan</button>
                                                        <button type="reset" class="btn btn-light px-4">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div id="loadingSpinner" class="spinner-border text-primary d-none"></div>
                                    </div>
                                    <div class="tab-pane fade" id="primaryhome" role="tabpanel">
                                        <?php if (session()->getFlashdata('success')): ?>
                                            <div class="alert alert-success text-center">
                                                <?= session()->getFlashdata('success') ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (session()->getFlashdata('failed')): ?>
                                            <div class="alert alert-success text-center">
                                                <?= session()->getFlashdata('failed') ?>
                                            </div>
                                        <?php endif; ?>
                                        <form action="<?= base_url('admin/profil/keahlianProfil') ?>" method="post"
                                            enctype="multipart/form-data">
                                            
                                            <div class="row mb-3">
                                                <label for="logo" class="col-sm-3 col-form-label">Logo</label>
                                                <div class="col-sm-9">
                                                    <input type="file" name="logo" class="form-control" id="logo" required>
                                                    <?php if (empty($_FILES['logo']['name']) && isset($kea['logo']) && !empty($kea['logo'])): ?>
                                                        <input type="hidden" name="existing_logo"
                                                            value="<?= $kea['logo'] ?>">
                                                    <?php endif; ?>
                                                    <?php if (session()->get('errors')): ?>
                                                        <?php $errors = session()->get('errors'); ?>
                                                        <?php if (isset($errors['logo'])): ?>
                                                            <div class="alert alert-danger text-center">
                                                                <?= $errors['logo'] ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <label class="col-sm-3 col-form-label"></label>
                                                <div class="col-sm-9">
                                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                                        <button type="submit" class="btn btn-primary px-4"
                                                            id="submitButton" onclick="submitForm()">Simpan</button>
                                                        <button type="reset" class="btn btn-light px-4">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div id="loadingSpinner" class="spinner-border text-primary d-none"></div>
                                    </div>
                                   
                                    <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
                                        <?php if (session()->getFlashdata('bio-success')): ?>
                                            <div class="alert alert-success text-center">
                                                <?= session()->getFlashdata('bio-success') ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (session()->getFlashdata('bio-update')): ?>
                                            <div class="alert alert-success text-center">
                                                <?= session()->getFlashdata('bio-update') ?>
                                            </div>
                                        <?php endif; ?>
                                        <form action="<?= base_url('admin/profil/biodataProfil') ?>" method="post"
                                            enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <label for="biodata" class="col-sm-3 col-form-label">Nama Bank dan No Rekening
                                                    </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="biodata" class="form-control" id="biodata"
                                                        placeholder="Masukkan nama bank dan no rekening disini..." value="<?= isset($bio['biodata']) ? $bio['biodata'] : '' ?>"
                                                        >
                                                    <?php if (session()->get('errors')): ?>
                                                        <?php $errors = session()->get('errors'); ?>
                                                        <?php if (isset($errors['biodata'])): ?>
                                                            <div class="alert alert-danger text-center">
                                                                <?= $errors['biodata'] ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="footer" class="col-sm-3 col-form-label">Atas Nama Akun Rekening 
                                                    </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="footer" class="form-control" id="footer"
                                                        placeholder="Masukkan nama pemilik akun rekening..."
                                                        value="<?= isset($bio['footer']) ? $bio['footer'] : '' ?>">
                                                    <?php if (session()->get('errors')): ?>
                                                        <?php $errors = session()->get('errors'); ?>
                                                        <?php if (isset($errors['footer'])): ?>
                                                            <div class="alert alert-danger text-center">
                                                                <?= $errors['footer'] ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label class="col-sm-3 col-form-label"></label>
                                                <div class="col-sm-9">
                                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                                        <button type="submit"
                                                            class="btn btn-primary px-4">Simpan</button>
                                                        <button type="reset" class="btn btn-light px-4">Reset</button>
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
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>