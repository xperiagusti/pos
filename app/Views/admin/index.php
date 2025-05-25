<?= $this->extend('admin/templates/index-template') ?>
<?= $this->section('content') ?>

<div class="page-wrapper">
    <div class="page-content">
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Penjualan Hari Ini</p>
                                <h4 class="my-1">Rp. <?= rupiah($p_hari['total_penjualan']) ?></h4>

                            </div>
                            <div class="widgets-icons bg-light-success text-success ms-auto"><i class='bx bx-money'></i>
                            </div>
                        </div>
                        <div id="chart1"></div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Penjualan Minggu Ini</p>
                                <h4 class="my-1">Rp. <?= rupiah($p_minggu['total_penjualan'])?></h4>

                            </div>
                            <div class="widgets-icons bg-light-warning text-warning ms-auto"><i class='bx bx-money'></i>
                            </div>
                        </div>
                        <div id="chart2"></div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Penjualan Bulan Ini</p>
                                <h4 class="my-1">Rp. <?= rupiah($p_bulan['total_penjualan']) ?></h4>

                            </div>
                            <div class="widgets-icons bg-light-danger text-danger ms-auto"><i class='bx bx-money'></i>
                            </div>
                        </div>
                        <div id="chart3"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3">
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Users</p>
                                <h4 class="my-1"><?= $users ?></h4>
                            </div>
                            <div class="text-primary ms-auto font-35"><i class='bx bxs-group'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Suppliers</p>
                                <h4 class="my-1"><?= $suppliers ?></h4>
                            </div>
                            <div class="text-danger ms-auto font-35"><i class='bx bxs-group'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Customers</p>
                                <h4 class="my-1"><?= $customers ?></h4>
                            </div>
                            <div class="text-warning ms-auto font-35"><i class='bx bxs-group'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3">
            <div class="col">
                <div class="card radius-10 bg-primary bg-gradient">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Total Purchase Orders</p>
                                <h4 class="my-1 text-white">Rp. <?= rupiah($total_po['total_po']) ?></h4>
                            </div>
                            <div class="text-white ms-auto font-35"><i class='bx bx-wallet'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 bg-danger bg-gradient">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Total Pendapatan</p>
                                <h4 class="my-1 text-white">Rp.<?= rupiah($total_income['total_income'] + $total_kas['kas_masuk'] - $total_kas['kas_keluar']) ?></h4>
                            </div>
                            <div class="text-white ms-auto font-35"><i class='bx bx-dollar'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 bg-warning bg-gradient">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-dark">Total Penjualan</p>
                                <h4 class="text-dark my-1">Rp. <?= rupiah($total_sale_retur['penjualan']) ?></h4>
                            </div>
                            <div class="text-dark ms-auto font-35"><i class='bx bx-cart'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col">
                <div class="card radius-10 bg-info bg-gradient">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Total Product in Stock</p>
                                <h4 class="my-1 text-white"><?= $stock ?></h4>
                            </div>
                            <div class="text-white ms-auto font-35"><i class='bx bx-package'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 bg-secondary bg-gradient">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Total Transaksi</p>
                                <h4 class="my-1 text-white"><?= $sales ?></h4>
                            </div>
                            <div class="text-white ms-auto font-35"><i class='bx bx-basket'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 bg-success bg-gradient">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Total Retur Refund</p>
                                <h4 class="my-1 text-white">Rp. <?= rupiah($total_sale_retur['retur']) ?></h4>
                            </div>
                            <div class="text-white ms-auto font-35"><i class='bx bx-donate-heart'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>



        <!--end row-->
        <div class="row row-cols-1 row-cols-xl-1">

            <div class="col d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-header border-bottom-0">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="mb-1">Produk Terlaris</h5>
                                <p class="mb-0 font-13 text-secondary"><i class='bx bxs-calendar'></i>Dalam 30 hari
                                    terakhir</p>
                            </div>
                            <div class="dropdown ms-auto">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                                    <i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:;">Action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="product-list p-3 mb-3">
                        <?php $i=5; foreach ($produkTerlaris as $pt) : ?>
                        <div class="row border mx-0 mb-3 py-2 radius-10 cursor-pointer">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center">
                                    <div class="ms-2">
                                        <h6 class="mb-1"><?= $pt['p_name'] ?></h6>
                                        <p class="mb-0"><?= $pt['p_unit_type'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" style="text-align:right">
                                <h6 class="mb-1">Rp. <?= rupiah($pt['s_price']) ?></h6>
                                <p class="mb-0"><?= $pt['jumlah_item_terjual'] ?> Terjual</p>
                            </div>

                        </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->


    </div>
</div>

<?= $this->endSection() ?>