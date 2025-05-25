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
                        <li class="breadcrumb-item active" aria-current="page">Produk</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Form Edit Stok Product</h5>
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
                        <form class="mt-3"
                            action="<?= base_url('sibabad/stock-product/editData/') . $prod['id_s_product'] ?>"
                            method="post">
                            <input name="id_s_product" type="hidden" value="<?= $prod['id_s_product'] ?>">
                            <input name="id_product" type="hidden" id="id_product" value="<?= $prod['id_product'] ?>">

                            <div class="row mb-3">
                                <label for="pCode" class="col-sm-2 col-form-label">Nama Produk</label>
                                <div class="col-sm-4">
                                    <input type="text" name="p_name" class="form-control" id="pCode"
                                        value="<?= $prod['p_name'] ?>" readonly>
                                </div>

                                <label for="pName" class="col-sm-2 col-form-label">Jumlah</label>
                                <div class="col-sm-4">
                                    <input type="text" name="s_stock" class="form-control" id="s_stock"
                                        value="<?= $prod['s_stock'] ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="pName" class="col-sm-2 col-form-label">Barcode</label>
                                <div class="col-sm-4">
                                    <input type="text" name="s_barcode" class="form-control" id="s_barcode"
                                        value="<?= $prod['s_barcode'] ?>">
                                    <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['s_barcode'])) : ?>
                                    <div class="alert alert-danger text-center">
                                        <?= $errors['s_barcode'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <label for="dateOrder" class="col-sm-2 col-form-label">Tgl Expired</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="s_date_expired" name="s_date_expired"
                                        value="<?= $prod['s_date_expired'] ?>">
                                    <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['s_date_expired'])) : ?>
                                    <div class="alert alert-danger text-center">
                                        <?= $errors['s_date_expired'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>



                            <!-- <div class="row mb-3">
                                <label for="pPrice" class="col-sm-2 col-form-label">Atur Harga Jual</label>

                                <div class="col-sm-4">
                                    <select name="" id="shippingOption" class="form-select col-sm-3"
                                        onchange="toggleAturharga()">
                                        <option value="0" selected>Persen %</option>
                                        <option value="1">Nominal</option>
                                    </select>
                                </div>

                                <label for="pPrice" class="col-sm-2 col-form-label">Harga Beli (Rp.)</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="dop_price" id="dop_price"
                                        placeholder="0">
                                </div>
                            </div> -->

                            <div class="row mb-3">
                                <!-- <div class="col-sm-2">
                                    <div id="tpersen" style="display: block;">
                                        <label for="pName" class="col-form-label">Keuntungan %</label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div id="persen" style="display: block;">
                                        <input type="number" class="form-control" id="nilai_persen"
                                            oninput="harga_jual_persen()">
                                    </div>
                                </div> -->

                                <div class="col-sm-2">
                                    <div id="tpersen" style="display: block;">
                                        <label for="pName" class="col-form-label">Satuan</label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div id="persen" style="display: block;">
                                        <input type="text" class="form-control" id="p_unit_type" value="<?= $prod['p_unit_type'] ?>" readonly>
                                    </div>
                                </div>


                                <label for="pPrice" class="col-sm-2 col-form-label">Harga Jual (Rp.)</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="s_price" id="s_price_persen"
                                        value="<?= $prod['s_price'] ?>" placeholder="0">
                                    <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['s_price'])) : ?>
                                    <div class="alert alert-danger text-center">
                                        <?= $errors['s_price'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            
                            <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const selectProduct = document.querySelector('#id_product');
                                const id_product = selectProduct.value; // Ambil nilai id_product
                                getDataFromServer(id_product);
                                function clearForm() {
                                    document.querySelector('#dop_price').value = '';
                                }
                                function getDataFromServer(id_product) {
                                    const xhr = new XMLHttpRequest();
                                    xhr.open('GET', `getHargaJual/${id_product}`);
                                    xhr.onload = function () {
                                        if (xhr.status === 200) {
                                            const data = JSON.parse(xhr.responseText);
                                            if (data.dop_price !== undefined && data.dop_price !== null) {
                                            document.querySelector('#dop_price').value = parseInt(data.dop_price);
                                        } else {
                                            clearForm();
                                        }
                                        } else {
                                            clearForm();
                                        }
                                    };
                                    xhr.send();
                                }
                            });
                            </script>

                            <div class="row mb-3">
                                <label for="pName" class="col-sm-2 col-form-label">Qty Grosir</label>
                                <div class="col-sm-4">
                                    <input type="number" name="s_qty_grosir" class="form-control" id="s_qty_grosir"  value="<?= $prod['s_qty_grosir'] ?>">
                                    <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['s_qty_grosir'])) : ?>
                                    <div class="alert alert-danger text-center">
                                        <?= $errors['s_qty_grosir'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <label for="dateOrder" class="col-sm-2 col-form-label">Harga Grosir (Rp.)</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="s_price_grosir" name="s_price_grosir" placeholder="0"  value="<?= $prod['s_price_grosir'] ?>">
                                    <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['s_price_grosir'])) : ?>
                                    <div class="alert alert-danger text-center">
                                        <?= $errors['s_price_grosir'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="pName" class="col-sm-2 col-form-label">Qty Khusus</label>
                                <div class="col-sm-4">
                                    <input type="number" name="s_qty_khusus" class="form-control" id="s_qty_khusus"  value="<?= $prod['s_qty_khusus'] ?>">
                                    <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['s_qty_khusus'])) : ?>
                                    <div class="alert alert-danger text-center">
                                        <?= $errors['s_qty_khusus'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <label for="dateOrder" class="col-sm-2 col-form-label">Harga Khusus (Rp.)</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="s_price_khusus" name="s_price_khusus" placeholder="0"  value="<?= $prod['s_price_khusus'] ?>">
                                    <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['s_price_khusus'])) : ?>
                                    <div class="alert alert-danger text-center">
                                        <?= $errors['s_price_khusus'] ?>
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
    var barcode = '';
    var interval;
    document.addEventListener('keydown', function (evt) {
        if (interval)
            clearInterval(interval);
        if (evt.code == 'Enter') {
            if (barcode)
                handleBarcode(barcode);
            barcode = '';
            return;
        }
        if (evt.key != 'Shift')
            barcode += evt.key;
        interval = setInterval(() => barcode = '', 20);
    });

    function handleBarcode(scanned_barcode) {
        barcode = scanned_barcode; 
        $('#barcode').val(barcode); 
    }
</script>

<script>
function clearHargaJual() {
        document.querySelector('#s_price_persen').value = '';
        document.querySelector('#nilai_persen').value = '';
}

function toggleAturharga() {
    var selectElement = document.getElementById("shippingOption");
    var persen = document.getElementById("persen");
    var tpersen = document.getElementById("tpersen");

    if (selectElement.value === "1") {
        persen.style.display = "none";
        tpersen.style.display = "none";
        clearHargaJual();
    } else {
        persen.style.display = "block";
        tpersen.style.display = "block";
    }
}

function harga_jual_persen() {

    var dop_price = parseFloat(document.getElementById("dop_price").value);
    var nilai_persen = parseFloat(document.getElementById("nilai_persen").value);
    var s_price_persen = (dop_price * (nilai_persen / 100)) + dop_price;
    document.querySelector('#s_price_persen').value = parseInt(s_price_persen);
}
</script>


<?= $this->endSection() ?>