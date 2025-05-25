<?= $this->extend('gudang/templates/index-template') ?>
<?= $this->section('content') ?>

<style>
    td.merged-cell {
        border-top: none !important;
        border-bottom: none !important;
        padding: 0 !important;
    }

    td.merged-cell>a,
    td.merged-cell>button {
        margin-right: 5px;
    }

    td.merged-cell>a:last-child,
    td.merged-cell>button:last-child {
        margin-right: 0;
    }
</style>

<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Form</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/sibabad3') ?>"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Pembelian Langsung</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Form Pemb. Langsung</h5>
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

                        <form class="mt-3" action="<?= base_url('sibabad3/coa/saveCoaData') ?>" method="post" onsubmit="return validateForm()">
                            <div class="row mb-3">
                                <label for="dateOrder" class="col-sm-4 col-form-label">Tgl Pembelian</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="dateOrder" value="<?= $getRO[0]->do_date ?? '' ?>" readonly> 
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="codeOrder" class="col-sm-4 col-form-label">Kode Pembelian</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="codeOrder" placeholder="KODE.001/PEMB/XXX" value="<?= $getRO[0]->do_code ?? '' ?>" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="paymentMethod" class="col-sm-4 col-form-label">Metode Bayar</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="paymentMethod" value="<?= $getRO[0]->coa_name ?? '' ?>" readonly> 
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="supplierOrder" class="col-sm-4 col-form-label">Supplier</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="supplierOrder" value="<?= $getRO[0]->s_name ?? '' ?>" readonly> 
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="statusOrder" class="col-sm-4 col-form-label">Status</label>
                                <div class="col-sm-8">
                                    <select name="" id="statusOrder" class="form-select">
                                        <option value="1" <?= ($getRO[0]->do_status == '1') ? 'selected' : ''; ?>>Selesai</option>
                                        <!-- <option value="2" <?= ($getRO[0]->do_status == '2') ? 'selected' : ''; ?>>Gagal</option> -->
                                    </select>
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
                        <div class="row">
                            <form action="<?= base_url('sibabad3/recieve_order/updateData/') . $getRO[0]->id_do ?>" method="post">
                                <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['id_product'])) : ?>
                                        <div class="alert alert-danger text-center">
                                            <?= $errors['id_product'] ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['ro_product_keep'])) : ?>
                                        <div class="alert alert-danger text-center mt-2">
                                            <?= $errors['ro_product_keep'] ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['ro_product_return'])) : ?>
                                        <div class="alert alert-danger text-center mt-2">
                                            <?= $errors['ro_product_return'] ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary" style="margin-left: 10px;">Update Data Penerimaan</button>
                                </div>
                                <div class="table-responsive">
                                <table class="table mb-0 table-striped mt-3 receiveProduct">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col" style="display: none;">ID Produk</th>
                                            <th scope="col">Nama Produk</th>
                                            <th scope="col">Satuan</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Jumlah Produk Simpan</th>
                                            <th scope="col">Jumlah Produk Return</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($getRO as $product) : ?>
                                            <tr data-source="modal" >
                                                <!-- Isi kolom-kolom produk yang ditambahkan melalui modal -->
                                                <td style="display: none;"><input type="hidden" name="id_do_product[]" value="<?= $product->id_do_products ?>"></td>
                                                <td><?= $product->p_name ?><input type="hidden" name="id_product[]" value="<?= $product->id_product ?>"></td>
                                                <td><?= $product->p_unit_type ?></td>
                                                <td><?= $product->dop_qty ?></td>
                                                <td ><input type="text" class="form-control" name="ro_product_keep[]" style="width:100px;" value="<?= $product->ro_product_keep ?>"></td>
                                                <td ><input type="text" class="form-control" name="ro_product_return[]" style="width:100px;" value="<?= $product->ro_product_return ?>"></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>




<script>
    $(document).ready(function() {
        $('#statusOrder').on('change', function() {
            var statusOrder = $(this).val();
            $('#hiddenDOStatus').val(statusOrder);
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Event delegation untuk tombol "Simpan Jurnal"
        $(document).on('click', '#saveButton', function() {
            // Dapatkan nilai dari kedua input
            var dopQty = $('#DOPQty').val();
            var dopPrice = $('#DOPPrice').val();

            // Periksa apakah kedua input kosong
            if (dopQty.trim() === '' || dopPrice.trim() === '') {
                // Tampilkan SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Kuantiti dan Harga produk tidak boleh kosong!'
                });
            } else {
                // Jika tidak kosong, lanjutkan dengan proses penyimpanan atau tindakan lainnya
                // ...
            }
        });
    });
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

<script>
    const roProductKeepInputs = document.querySelectorAll('input[name="ro_product_keep[]"]');
    const roProductReturnInputs = document.querySelectorAll('input[name="ro_product_return[]"]');
    const dopQty = <?= $product->dop_qty ?>;
    
    // Menambahkan event listener untuk form submit
    document.querySelector('form').addEventListener('submit', function(event) {
        // Lakukan perulangan untuk memeriksa setiap baris produk
        for (let i = 0; i < roProductKeepInputs.length; i++) {
            const roProductKeep = parseInt(roProductKeepInputs[i].value);
            const roProductReturn = parseInt(roProductReturnInputs[i].value);
            
            // Periksa apakah jumlah ro_product_return dan ro_product_keep tidak sama dengan dop_qty
            if (roProductKeep + roProductReturn !== dopQty) {
                event.preventDefault(); // Mencegah pengiriman formulir
                
                // Tampilkan pesan error
                alert('Jumlah RO Product Keep dan RO Product Return harus sama dengan ' + dopQty);
                return;
            }
        }
    });
</script>




<?= $this->endSection() ?>