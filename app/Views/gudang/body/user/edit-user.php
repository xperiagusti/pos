<?= $this->extend('admin/templates/index-template') ?>
<?= $this->section('content') ?>

<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">User</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/sibabad') ?>"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Data User</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Form User</h5>

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

                        <form class="row g-3 mt-3" action="<?= base_url('sibabad/user/editData/') . $user['id_user'] ?>"
                            method="post">
                            <div class="col-md-8">
                                <label for="Username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" id="Username"
                                    placeholder="username" value="<?= $user['username'] ?>">
                                <?php if (session()->get('errors')): ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['username'])): ?>
                                        <div class="alert alert-danger text-center">
                                            <?= $errors['username'] ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <label for="Email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="Email" placeholder="Email"
                                    value="<?= $user['email'] ?>">
                                <?php if (session()->get('errors')): ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['email'])): ?>
                                        <div class="alert alert-danger text-center">
                                            <?= $errors['email'] ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <label for="Password" class="form-label">Kata Sandi</label>
                                <input type="password" name="password" class="form-control" id="Password"
                                    placeholder="Kata Sandi" value="<?= $user['password'] ?>">
                                <?php if (session()->get('errors')): ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['password'])): ?>
                                        <div class="alert alert-danger text-center">
                                            <?= $errors['password'] ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" class="form-control">
                                    <option value="">Pilih...</option>
                                    <option value="Administrator" <?php if ($user['role'] == "Administrator")
                                        echo 'selected="selected"'; ?>>Administrator</option>
                                    <option value="Kasir" <?php if ($user['role'] == "Kasir")
                                        echo 'selected="selected"'; ?>>Kasir</option>
                                </select>
                                <?php if (session()->get('errors')): ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['role'])): ?>
                                        <div class="alert alert-danger text-center">
                                            <?= $errors['role'] ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <label for="is_verified" class="form-label">Status Verifikasi</label>
                                <select name="is_verified" class="form-control">
                                    <option value="">Pilih...</option>
                                    <option value="1" <?php if ($user['is_verified'] == "1")
                                        echo 'selected="selected"'; ?>>Terverifikasi</option>
                                    <option value="0" <?php if ($user['is_verified'] == "0")
                                        echo 'selected="selected"'; ?>>Tidak Terverifikasi</option>
                                </select>
                                <?php if (session()->get('errors')): ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['is_verified'])): ?> <!-- Perubahan disini -->
                                        <div class="alert alert-danger text-center">
                                            <?= $errors['is_verified'] ?> <!-- Perubahan disini -->
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">Ubah Data</button>
                                    <button type="reset" class="btn btn-light px-4">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>