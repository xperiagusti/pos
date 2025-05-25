<?= $this->extend('gudang/templates/index-template') ?>
<?= $this->section('content') ?>

<div class="page-wrapper">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Form</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/sibabad3') ?>"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Stock</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Form Tambah Stock Produk</h5>
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
                      
                            <div class="row mb-3">
                                <label for="pCode" class="col-sm-2 col-form-label">Nama Produk</label>
                                <div class="col-sm-4">
                                    <select class="form-select" name="id_do_product" id="id_do_product">
                                        <option value="" selected disabled>--Pilih--</option>
                                        <?php foreach ($product as $p) : ?>

                                        <option value="<?= $p['id_do_products'] ?>"> <?= $p['do_code'] ?> |
                                            <?= $p['p_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['id_do_products'])) : ?>
                                    <div class="alert alert-danger text-center">
                                        <?= $errors['id_do_products'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <label for="pPrice" class="col-sm-2 col-form-label">Rata2 Harga Beli (Rp.)</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="dop_price" id="dop_price"
                                        placeholder="0" oninput="harga_jual_lvl1();harga_jual_lvl2();harga_jual_lvl3()">
                                </div>


                            </div>

                            <div class="row mb-3">
                                <label for="pName" class="col-sm-2 col-form-label">Barcode</label>
                                <div class="col-sm-4">
                                    <input type="text" name="barcode" class="form-control" id="barcode">
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
                                    <input type="date" class="form-control" id="date_expired" name="date_expired">
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
                    </div>
                </div>

            </div>
            <div class="col-xl-12 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                        <form action="<?= base_url('sibabad3/stock-product/saveData') ?>" method="post">
                            <input type="hidden" name="id_do_products" class="form-control" id="id_do_products">
                            <input type="hidden" name="s_barcode" class="form-control" id="s_barcode">
                            <input type="hidden" name="id_product[]" id="id_product">
                            <input type="hidden" name="p_name" class="form-control" id="p_name">
                            <input type="hidden" name="s_date_expired" class="form-control" id="s_date_expired">
                            <table class="table mb-0 table-striped mt-3 receiveProduct">
                                <thead>
                                    <tr>
                                        <th class="tg-0pky"></th>
                                        <th class="tg-0lax">Level 1</th>
                                        <th class="tg-0lax">Level 2</th>
                                        <th class="tg-0lax">Level 3</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="tg-0lax">Satuan</td>
                                        <td class="tg-0lax"><input type="text" name="p_unit_type[]" class="form-control"
                                                id="p_unit_type" readonly>
                                        </td>
                                        <td class="tg-0lax"><select class="form-select" name="p_unit_type[]"
                                                id="pUnitType">
                                                <option value="pcs" selected disabled>--Pilih--</option>
                                                <?php foreach ($units_level2 as $unit) : ?>
                                                <option value="<?= $unit['u_name'] ?>"><?= $unit['u_name'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td class="tg-0lax"><select class="form-select" name="p_unit_type[]"
                                                id="pUnitType">
                                                <option value="pcs" selected disabled>--Pilih--</option>
                                                <?php foreach ($units_level3 as $unit) : ?>
                                                <option value="<?= $unit['u_name'] ?>"><?= $unit['u_name'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tg-0lax">% Keuntungan</td>
                                        <td class="tg-0lax"><input type="text" name="persen_1" class="form-control"
                                                id="persen_1" oninput="harga_jual_lvl1()"></td>
                                        <td class="tg-0lax"><input type="text" name="persen_2" class="form-control"
                                                id="persen_2" oninput="harga_jual_lvl2()"></td>
                                        <td class="tg-0lax"><input type="text" name="persen_3" class="form-control"
                                                id="persen_3" oninput="harga_jual_lvl3()"></td>
                                    </tr>
                                    <tr>
                                        <td class="tg-0lax">Harga Jual (Rp)<br></td>
                                        <td class="tg-0lax"><input type="text" class="form-control" name="s_price[]"
                                                id="s_price_1" placeholder="0"></td>
                                        <td class="tg-0lax"><input type="text" class="form-control" name="s_price[]"
                                                id="s_price_2" placeholder="0"></td>
                                        <td class="tg-0lax"><input type="text" class="form-control" name="s_price[]"
                                                id="s_price_3" placeholder="0"></td>
                                    </tr>
                                    <tr>
                                        <td class="tg-0lax">Qty Grosir<br></td>
                                        <td class="tg-0lax"><input type="number" name="s_qty_grosir[]"
                                                class="form-control" id="s_qty_grosir" placeholder="0"></td>
                                        <td class="tg-0lax"><input type="number" name="s_qty_grosir[]"
                                                class="form-control" id="s_qty_grosir" placeholder="0"></td>
                                        <td class="tg-0lax"><input type="number" name="s_qty_grosir[]"
                                                class="form-control" id="s_qty_grosir" placeholder="0"></td>
                                    </tr>
                                    <tr>
                                        <td class="tg-0lax">Harga Grosir (Rp)</td>
                                        <td class="tg-0lax"><input type="text" class="form-control"
                                                id="s_price_grosir" name="s_price_grosir[]" placeholder="0"></td>
                                        <td class="tg-0lax"><input type="text" class="form-control"
                                                id="s_price_grosir" name="s_price_grosir[]" placeholder="0"></td>
                                        <td class="tg-0lax"><input type="text" class="form-control"
                                                id="s_price_grosir" name="s_price_grosir[]" placeholder="0"></td>
                                    </tr>
                                    <tr>
                                        <td class="tg-0lax">Qty Khusus <br></td>
                                        <td class="tg-0lax"><input type="number" name="s_qty_khusus[]"
                                                class="form-control" id="s_qty_khusus" placeholder="0"></td>
                                        <td class="tg-0lax"><input type="number" name="s_qty_khusus[]"
                                                class="form-control" id="s_qty_khusus" placeholder="0"></td>
                                        <td class="tg-0lax"><input type="number" name="s_qty_khusus[]"
                                                class="form-control" id="s_qty_khusus" placeholder="0"></td>
                                    </tr>
                                    <tr>
                                        <td class="tg-0lax">Harga Khusus (Rp)</td>
                                        <td class="tg-0lax"><input type="text" class="form-control" id="s_price_khusus"
                                                name="s_price_khusus[]" placeholder="0"></td>
                                        <td class="tg-0lax"><input type="text" class="form-control" id="s_price_khusus"
                                                name="s_price_khusus[]" placeholder="0"></td>
                                        <td class="tg-0lax"><input type="text" class="form-control" id="s_price_khusus"
                                                name="s_price_khusus[]" placeholder="0"></td>
                                    </tr>
                                    <tr>
                                        <td class="tg-0lax">Jumlah Stok</td>
                                        <td class="tg-0lax"><input type="text" name="s_stock[]" class="form-control"
                                                id="s_stock" placeholder="0"></td>
                                        <td class="tg-0lax"><input type="text" name="s_stock[]" class="form-control"
                                                id="s_stock2" placeholder="0"></td>
                                        <td class="tg-0lax"><input type="text" name="s_stock[]" class="form-control"
                                                id="s_stock3" placeholder="0"></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row mt-3">
                                <label class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-8">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" id="loadingContainer" class="btn btn-primary px-4">Simpan
                                            Data</button>
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
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
        $(document).ready(function() {
            $('#barcode').on('change', function() {
                var barcode1 = $(this).val();
                $('#s_barcode').val(barcode1);
            });
        });
</script>
<script>
        $(document).ready(function() {
            $('#date_expired').on('change', function() {
                var date_expired = $(this).val();
                $('#s_date_expired').val(date_expired);
            });
        });
</script>
<script>
        $(document).ready(function() {
            $('#id_do_product').on('change', function() {
                var id_do_product = $(this).val();
                $('#id_do_products').val(id_do_product);
            });
        });
</script>

<script>
const selectProduct = document.querySelector('#id_do_product');
selectProduct.addEventListener('change', handleProduct);

function handleProduct() {
    const idDOP = this.value;
    if (idDOP === '') {
    } else {
        getDataFromServer(idDOP);
    }
}

function clearForm() {
    document.querySelector('#s_stock').value = '';
    document.querySelector('#dop_price').value = '';
}

function getDataFromServer(idDOP) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `getProductDetail/${idDOP}`);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            document.querySelector('#s_stock').value = data.s_stock;
            document.querySelector('#p_unit_type').value = data.p_unit_type;
            document.querySelector('#p_name').value = data.p_name;
            document.querySelector('#dop_price').value = parseInt(data.dop_price);
            document.querySelector('#id_product').value = data.id_product;
        } else {
            clearForm();
        }
    };
    xhr.send();
}
</script>


<script>
 function harga_jual_lvl1() {
    var persen_1 = parseFloat(document.getElementById("persen_1").value) || 0;
    var dop_price = parseFloat(document.getElementById("dop_price").value) || 0;
    var harga_jual = (dop_price * (persen_1 / 100)) + dop_price;
    document.querySelector('#s_price_1').value = parseInt(harga_jual);
}

function harga_jual_lvl2() {
    var persen_2 = parseFloat(document.getElementById("persen_2").value) || 0;
    var dop_price = parseFloat(document.getElementById("dop_price").value) || 0;
    var level_2 = parseFloat(document.getElementById("level_2").value) || 0;
    var harga_jual = ((dop_price * (persen_2 / 100)) + dop_price) / level_2;
    document.querySelector('#s_price_2').value = parseInt(harga_jual);
}

function harga_jual_lvl3() {
    var persen_3 = parseFloat(document.getElementById("persen_3").value) || 0;
    var dop_price = parseFloat(document.getElementById("dop_price").value)|| 0;
    var level_3 = parseFloat(document.getElementById("level_3").value) || 0;
    var harga_jual = ((dop_price * (persen_3 / 100)) + dop_price) / level_3;
    document.querySelector('#s_price_3').value = parseInt(harga_jual);
}


function jumlah_stok_lvl2() {
    var satuan_level2 = document.getElementById("level_2").value;
    var s_stock = document.getElementById("s_stock").value;
    var s_stock_2 = satuan_level2 * s_stock;
    document.querySelector('#s_stock2').value = s_stock_2;
}

function jumlah_stok_lvl3() {
    var satuan_level3 = document.getElementById("level_3").value;
    var s_stock = document.getElementById("s_stock").value;
    var s_stock_3 = satuan_level3 * s_stock;
    document.querySelector('#s_stock3').value = s_stock_3;
}
</script>




<?= $this->endSection() ?>