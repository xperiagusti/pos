<?= $this->extend('gudang/templates/index-template') ?>
<?= $this->section('content') ?>

<div class="page-wrapper">
    <div class="page-content">

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
                                <!-- <h6 class="mb-1">Rp. <?= rupiah($pt['s_price']) ?></h6> -->
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