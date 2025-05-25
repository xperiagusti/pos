<?= $this->extend('admin/templates/login-template') ?>
<?= $this->section('content') ?>

<div class="wrapper">
    <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col mx-auto">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="p-4">
                                <div class="mb-3 text-center">
                                    <img src="<?= base_url('assets/images/logo-icon.png') ?>" width="60" alt="" />
                                </div>
                                <div class="text-center mb-4">
                                    <h5 class="">Adydana Admin</h5>

                                    <?php if (session()->getFlashdata('failed')) : ?>
                                        <div class="alert alert-danger text-center">
                                            <?= session()->getFlashdata('failed') ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (session()->getFlashdata('unverif')) : ?>
                                        <div class="alert alert-danger text-center">
                                            <?= session()->getFlashdata('unverif') ?>
                                        </div>
                                    <?php endif; ?>

                                    <p class="mb-0">Login</p>
                                </div>
                                <div class="form-body">
                                    <form class="row g-3" action="<?= base_url('auth/login/ProcessGetIn') ?>" method="post">
                                        <div class="col-12">
                                            <label for="Email" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" id="Email" placeholder="jhon@example.com">
                                        </div>
                                        <div class="col-12">
                                            <label for="inputChoosePassword" class="form-label">Kata Sandi</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input type="password" name="password" class="form-control border-end-0" id="inputChoosePassword" placeholder="Masukkan kata sandi"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary">Sign in</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
</div>

<?= $this->endSection() ?>