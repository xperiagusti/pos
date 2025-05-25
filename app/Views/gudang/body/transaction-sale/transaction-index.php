<?= $this->extend('admin/templates/index-template') ?>
<?= $this->section('content') ?>


<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Form</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/sibabad') ?>"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Invoice Penjualan</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-4 row-cols-xl-4">
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Transaksi</p>
                                <h6 class="my-1"><?= $total_transaction ?></h6>
                            </div>
                            <div class="text-secondary ms-auto font-35"><i class='bx bx-basket'></i>
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
                                <p class="mb-0 text-secondary">Income</p>
                                <h6 class="my-1">Rp. <?= rupiah($total_income['total_income']) ?></h6>
                            </div>
                            <div class="text-primary ms-auto font-35"><i class='bx bx-dollar'></i>
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
                                <p class="mb-0 text-secondary">Total Penjualan</p>
                                <h6 class="my-1">Rp. <?= rupiah($total_sale_retur['penjualan']) ?></h6>
                            </div>
                            <div class="text-warning ms-auto font-35"><i class='bx bx-cart'></i>
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
                                <p class="mb-0 text-secondary">Penjualan Tunai</p>
                                <h6 class="my-1">Rp. <?= rupiah($total_sale_retur['penjualan_tunai']) ?></h6>
                            </div>
                            <div class="text-success ms-auto font-35"><i class='bx bx-money'></i>
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
                                <p class="mb-0 text-secondary">Penjualan Non Tunai</p>
                                <h6 class="my-1">Rp. <?= rupiah($total_sale_retur['penjualan_non_tunai']) ?></h6>
                            </div>
                            <div class="text-info ms-auto font-35"><i class='bx bx-scan'></i>
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
                                <p class="mb-0 text-secondary">Total Retur</p>
                                <h6 class="my-1">Rp. <?= rupiah($total_sale_retur['retur']) ?></h6>
                            </div>
                            <div class="text-danger ms-auto font-35"><i class='bx bx-donate-heart'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="row">
            <div class="col-xl-12 col-sm-12">
                <div class="card" id="filterOptions" style="display: none;">
                    <div class="card-body">
                        <form class="mt-3" action="<?= base_url('sibabad/transaction-sale/index') ?>" method="post">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="journalDateFrom" class="col-form-label">Tanggal Transaksi
                                            Dari</label>
                                        <input type="date" id="journalDateFrom" name="waktu_start" class="form-control"
                                            value="<?= $date['waktu_start']; ?>">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label for="journalDateUntil" class="col-form-label">Tanggal Transaksi
                                            Sampai</label>
                                        <input type="date" id="journalDateUntil" name="waktu_end" class="form-control"
                                            value="<?= $date['waktu_end']; ?>">
                                    </div>
                                </div>
                                <div class="col-xl-12 ">
                                    <div class="text-center">
                                        <button type="submit" value="Apply" class="btn btn-info btn-sm"><span
                                                class="bx bx-search-alt"></span></button>
                                        <a href="<?= base_url('sibabad/transaction-sale/index') ?>" type="submit"
                                            class="btn btn-secondary btn-sm">
                                            <span class="bx bx-refresh"></span>
                                        </a>

                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                                <button id="filterButton" class="btn btn-dark btn-sm">
                                <span class="bx bx-filter-alt"></span>
                            </button>
                        </div><br>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered " style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Invoice</th>
                                        <th>Tanggal</th>
                                        <th>Total Akhir</th>
                                        <th>Jenis</th>
                                        <th>Kasir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center tableSupplier">
                                    <?php  $i= 1;
                                 foreach ($transaksi as $st) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $st['invoice'] ?></td>
                                        <td><?= date("d F Y H:i", strtotime($st['created_at'])) ?></td>
                                        <td><?= rupiah($st['final_price']) ?></td>
                                        <td>
                                            <?= $st['tipe'] ?> |
                                            <?= $st['jenis'] ?>
                                        </td>
                                        <td><?= $st['username'] ?><td>
                                                <a href="<?= base_url('sibabad/transaction-sale/detailTransaksi/') . $st['id_sale'] ?>"
                                                    type="button" class="btn btn-primary btn-sm">
                                                    <span class="bx bx-detail"></span>
                                                </a>
                                                <a href="<?= base_url('sibabad/transaction-sale/cetakTransaksi/') . $st['id_sale'] ?>"
                                                    type="button" class="btn btn-warning btn-sm">
                                                    <span class="bx bx-printer"></span>
                                                </a>

                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Invoice</th>
                                        <th>Tanggal</th>
                                        <th>Total Akhir</th>
                                        <th>Jenis</th>
                                        <th>Kasir</th>
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



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Hapus Produk -->


<script>
function rupiah(nominal) {
    let number_string = nominal.toString(), // convert nominal ke string
        sisa = number_string.length % 3, // cek jumlah digit bukan kelipatan 3
        rupiah = number_string.substr(0, sisa),
        ribuan = number_string.substr(sisa).match(/\d{3}/g)
    if (ribuan) {
        let separator = sisa ? '.' : ''
        rupiah += separator + ribuan.join('.')
    }
    return rupiah
}


</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const filterButton = document.getElementById("filterButton");
        const filterOptions = document.getElementById("filterOptions");

        filterButton.addEventListener("click", function() {
            if (filterOptions.style.display === "none" || filterOptions.style.display === "") {
                // Jika elemen belum ditampilkan, tampilkan mereka
                filterOptions.style.display = "block";
            } else {
                // Jika elemen sudah ditampilkan, sembunyikan mereka
                filterOptions.style.display = "none";
            }
        });
    });
</script>





<?= $this->endSection() ?>