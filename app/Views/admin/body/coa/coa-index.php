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
                        <li class="breadcrumb-item active" aria-current="page">Chart of Account</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Chart Of Account</h5>
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
                                <label for="CoaName" class="col-sm-3 col-form-label">Nama Akun</label>
                                <div class="col-sm-9">
                                    <input type="text" name="coa_name" class="form-control" id="CoaName" placeholder="Nama akun COA">
                                    <?php if (session()->get('errors')) : ?>
                                        <?php $errors = session()->get('errors'); ?>
                                        <?php if (isset($errors['coa_name'])) : ?>
                                            <div class="alert alert-danger text-center">
                                                <?= $errors['coa_name'] ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="CoaCode" class="col-sm-3 col-form-label">Kode Akun</label>
                                <div class="col-sm-9">
                                    <input type="text" name="coa_code" class="form-control" id="CoaCode" placeholder="Kode COA">
                                    <?php if (session()->get('errors')) : ?>
                                        <?php $errors = session()->get('errors'); ?>
                                        <?php if (isset($errors['coa_code'])) : ?>
                                            <div class="alert alert-danger text-center">
                                                <?= $errors['coa_code'] ?>
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
            <div class="col-xl-8">
                <h6 class="mb-0 text-uppercase text-center">Data COA</h6>
                <hr />
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($coaGet as $coa) : ?>
                                        <tr>
                                            <td><?= $coa['coa_code'] ?></td>
                                            <td><?= $coa['coa_name'] ?></td>
                                            <td>
                                                <!-- Edit -->
                                                <button type="button" class="btn btn-primary btn-sm">
                                                    <i class="bx bx-pencil" onclick="editCoa('<?= $coa['coa_name'] ?>', '<?= $coa['coa_code'] ?>')"></i>
                                                </button>
                                                <!-- Delete -->
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCOA<?= $coa['id_coa'] ?>">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Hapus -->
                                        <div class="modal fade" id="deleteCOA<?= $coa['id_coa'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                        <a href="<?= base_url('sibabad/coa/deleteCoaData/') . $coa['id_coa'] ?>" type="button" class="btn btn-success">Hapus</a>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function validateForm() {
        var coaName = document.getElementById('CoaName').value;
        var coaCode = document.getElementById('CoaCode').value;

        // Memeriksa apakah kedua input kosong
        if (coaName === '' || coaCode === '') {
            // Menampilkan pesan menggunakan SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Kolom tidak boleh kosong.'
            });
            return false; // Mencegah pengiriman formulir
        }

        return true; // Mengizinkan pengiriman formulir
    }
</script>

<script>
    function editCoa(coaName, coaCode) {
        document.getElementById('CoaName').value = coaName;
        document.getElementById('CoaCode').value = coaCode;
    }
</script>

<?= $this->endSection() ?>