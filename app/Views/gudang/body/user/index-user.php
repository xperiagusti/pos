<?= $this->extend('admin/templates/index-template') ?>
<?= $this->section('content') ?>

<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Pengguna</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/adeemin') ?>"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Buat Baru</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4 text-center">Buat Pengguna Baru</h5>
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success text-center">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>
                        <form class="row g-3" action="<?= base_url('sibabad/user/saveData') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="col-md-8">
                                <label for="Username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" id="Username"
                                    placeholder="username">
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
                                <input type="email" name="email" class="form-control" id="Email" placeholder="Email">
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
                                    placeholder="Kata Sandi">
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
                                    <option value="Administrator">Administrator</option>
                                    <option value="Kasir">Kasir</option>
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
                                    <option value="1">Terverifikasi</option>
                                    <option value="0">Tidak Terverifikasi</option>
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
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                                    <button type="reset" class="btn btn-light px-4">Reset</button>
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
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status Verifikasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($user as $w): ?>
                                        <tr>
                                            <td class="text-center">
                                                <?= $i++ ?>
                                            </td>
                                            <td>
                                                <?php if ($w['role'] == 'Kasir'): ?>
                                                    <?= $w['nama_karyawan']; ?>
                                                <?php elseif ($w['role'] == 'Administrator'): ?>
                                                    <?= $w['nama_user']; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= $w['username'] ?>
                                            </td>
                                            <td>
                                                <?= $w['email'] ?>
                                            </td>
                                            <td>
                                                <?= $w['role'] ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($w['is_verified'] == 1) {
                                                    echo "Terverifikasi";
                                                } else {
                                                    echo "Belum Terverifikasi";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <!-- Edit -->
                                                <a href="<?= base_url('sibabad/user/editView/') . $w['id_user'] ?>"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="bx bx-pencil"></i>
                                                </a>
                                                <!-- Delete -->
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#deleteUser<?= $w['id_user'] ?>">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Hapus -->
                                        <div class="modal fade" id="deleteUser<?= $w['id_user'] ?>" tabindex="-1"
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
                                                        <a href="<?= base_url('sibabad/user/deleteUserData/') . $w['id_user'] ?>"
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
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status Verifikasi</th>
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