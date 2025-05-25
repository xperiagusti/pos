<?= $this->extend('Admin/templates/sale-template') ?>
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
                        <li class="breadcrumb-item active" aria-current="page">Retur Tukar</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6 col-sm-12">
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
                <br>
                <div class="card">
                    <div class="card-body p-4">

                        <h5 class="mb-4">Form Retur Tukar</h5>
                        <form class="mt-3" action="<?= base_url('sibabad/tukar') ?>" method="post">
                            <div class="row mb-3">
                                <label for="codeOrder" class="col-sm-4 col-form-label">Kode Invoice</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="search" value="<?= $search; ?>">
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" value="Apply" class="btn btn-info btn-sm"><span
                                            class="bx bx-search-alt"></span> Cari</button>
                                </div>
                            </div>

                        </form>

                        <?php if ($transaksi !== null && isset($transaksi[0])): ?>
                        <div class="row mb-3">
                            <label for="dateOrder" class="col-sm-4 col-form-label">Tanggal dan Waktu</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="<?=date("d F Y H:i", strtotime(esc($transaksi[0]['tanggal'])))?>" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="codeOrder" class="col-sm-4 col-form-label">Jenis Pembayaran</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?=esc($transaksi[0]['jenis']);?>"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="codeOrder" class="col-sm-4 col-form-label">Tipe Transaksi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?=esc($transaksi[0]['tipe']);?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="codeOrder" class="col-sm-4 col-form-label">Pelanggan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?=esc($transaksi[0]['pelanggan']);?>"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="codeOrder" class="col-sm-4 col-form-label">Kasir</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?=esc($transaksi[0]['kasir']);?>"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="codeOrder" class="col-sm-4 col-form-label">IP Address</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?=esc($transaksi[0]['ip_address']);?>"
                                    readonly>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
        <?php if ($transaksi !== null && isset($transaksi[0])): ?>
        <div class="row">
            <div class="col-xl-12 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                        
                            <form id="tukarForm">
                                <table class="table mb-0 table-borderless mt-3">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Produk</th>
                                            <th scope="col">Satuan</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Jumlah</th>
                                            <th scope="col" style="width:300px">Satuan & Jumlah Tukar</th>
                                        </tr>

                                    </thead>
                                    <tbody class="text-center">
                                       
                                        <?php $i=1; $j=0;
                                    foreach ($transaksi as $data) : ?>
                                        <tr>
                                            <!-- Isi kolom-kolom produk yang ditambahkan melalui modal -->
                                            <td><?= $i++ ?></td>
                                            <td><?=esc($data['item']);?></td>
                                            <td><?=esc($data['namaproduk']);?></td>
                                            <td><?=rupiah(esc($data['harga']));?></td>
                                            <td><?=esc($data['jumlah']);?></td>
                                            <td>
                                                <div class="input-group">
                                                        <input type="hidden" name="harga_jual[]"
                                                        value="<?=($data['harga']);?>"> 
                                                        <input type="hidden" name="level_1[]"
                                                        value="<?=($data['level_1']);?>">
                                                        <input type="hidden" name="level_2[]"
                                                        value="<?=($data['level_2']);?>">
                                                        <input type="hidden" name="level_3[]"
                                                        value="<?=($data['level_3']);?>">
                                                        <input type="hidden" id="unitTypes[<?= $j++ ?>]" name="satuan_level[]"
                                                        value="<?=($data['level']);?>">


                                                        <input type="hidden" name="invoice" value="<?= $search; ?>">
                                                        <input type="hidden" name="id_customer" value="<?=esc($data['id_customer']);?>">
                                                        <input type="hidden" name="harga_item_retur[]">
                                                        <input type="hidden" name="nama_item[]" value="<?=esc($data['item']);?>">
                                                        <input type="hidden" name="barcode[]" value="<?=esc($data['s_barcode']);?>">
                                                        <input type="hidden" name="id_s_product[]" value="<?=esc($data['id_s_product']);?>">
                                                        <input type="hidden" name="level_1_plus[]">
                                                        <input type="hidden" name="level_2_plus[]">
                                                        <input type="hidden" name="level_3_plus[]">
                                                        
                                                    <select class="form-control col-sm-6" name="satuan_retur[]"
                                                        width="10px">
                                                        <option value="">Pilih...</option>

                                                    </select>
                                                    <input type="number" class="form-control col-sm-6"
                                                        name="qty_retur[]" value="0">
                                                </div>
                                            </td>

                                            
                                            <input type="hidden" class="form-control" name="subtotal_item_retur[]"
                                                    placeholder="0" readonly>
                                        </tr>

                                        <?php endforeach; ?>
                                            <input type="hidden" class="form-control"
                                                    name="subtotal_retur" placeholder="0" readonly>
                                            <input type="hidden" class="form-control" name="total_retur"
                                                    placeholder="0" readonly>
                                            <input type="hidden" class="form-control" name="total_item"
                                                    placeholder="0" readonly>
                                        
                                       
                                    </tbody>
                                 
                                </table>
                                 
                                </table>
                                
                                <div class="d-flex justify-content-center mt-3">
                                    <button type="button" id="submitTukar" class="btn btn-primary" style="margin-left: 10px;">Simpan Data Tukar</button>
                                </div>
                               
                            </form>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
var unitTypes = <?= json_encode($unitTypes) ?>;


for (var i = 0; i < <?= count($transaksi) ?>; i++) {
    var level = document.getElementById('unitTypes[' + i + ']').value;
    var options = generateOptions(level);
    document.querySelectorAll('select[name="satuan_retur[]"]')[i].innerHTML = options;
}

//Opsi Satuan    
function generateOptions(level) {
    var options = '<option value="">Pilih Satuan</option>';
    for (var i = 0; i < unitTypes.length; i++) {
        var unitType = unitTypes[i];
        if (unitType.level == 3 && level <= 3) {
            options += '<option value="' + unitType.level + '">' + unitType.u_name + '</option>';
        } else if (unitType.level == 2 && level <= 2) {
            options += '<option value="' + unitType.level + '">' + unitType.u_name + '</option>';
        } else if (unitType.level == 1 && level == 1) {
            options += '<option value="' + unitType.level + '">' + unitType.u_name + '</option>';
        }
    }
    return options;
}


var satuanReturInputs = document.querySelectorAll('select[name="satuan_retur[]"]');
var qtyReturInputs = document.querySelectorAll('input[name="qty_retur[]"]');
var subtotalItemInputs = document.querySelectorAll('input[name="subtotal_item_retur[]"]');
var hargaItemRetur = document.querySelectorAll('input[name="harga_item_retur[]"]');
var hargaInputs = document.querySelectorAll('input[name="harga_jual[]"]');
var level_1Inputs = document.querySelectorAll('input[name="level_1[]"]');
var level_2Inputs = document.querySelectorAll('input[name="level_2[]"]');
var level_3Inputs = document.querySelectorAll('input[name="level_3[]"]');
var level_1_plus = document.querySelectorAll('input[name="level_1_plus[]"]');
var level_2_plus = document.querySelectorAll('input[name="level_2_plus[]"]');
var level_3_plus = document.querySelectorAll('input[name="level_3_plus[]"]');
var satuanLevelInputs = document.querySelectorAll('input[name="satuan_level[]"]');

satuanReturInputs.forEach(function(select, i) {
    select.addEventListener('change', function() {
        calculateSubtotal(i);
    });
    
    qtyReturInputs[i].addEventListener('change', function() {
        calculateSubtotal(i);
    });
});

function calculateSubtotal(i) {
    var harga = parseFloat(hargaInputs[i].value);
    var qtySelect = parseInt(satuanReturInputs[i].value);
    var qty = parseInt(qtyReturInputs[i].value);
    var level_1 = parseFloat(level_1Inputs[i].value);
    var level_2 = parseFloat(level_2Inputs[i].value);
    var level_3 = parseFloat(level_3Inputs[i].value);
    var satuanLevel = parseInt(satuanLevelInputs[i].value);

    var alltot;
    var harga_item_retur;
    var level1_plus;
    var level2_plus;
    var level3_plus;

    if (satuanLevel === 1) {
        if (qtySelect === 1) {
            harga_item_retur = harga;
            alltot = harga * qty;

            level1_plus = qty;
            level2_plus = qty * level_2;
            level3_plus =  qty * level_3;

        } else if (qtySelect === 2) {
            harga_item_retur = harga / (level_2 / level_1);
            alltot = harga / (level_2 / level_1) * qty;

            level1_plus = qty / level_2;
            level2_plus = qty * (level_3 / level_2 );
            level3_plus =  qty;

        } else if (qtySelect === 3) {
            harga_item_retur = harga / (level_3 / level_1);
            alltot = harga / (level_3 / level_1) * qty;

            level1_plus = qty / level_3 ;
            level2_plus = qty / level_2;
            level3_plus =  qty;
        }
    } else if (satuanLevel === 2) {
        if (qtySelect === 2) {
            harga_item_retur = harga;
            alltot = harga * qty;

            level1_plus = qty / level_2;
            level2_plus = qty * (level_3 / level_2 );
            level3_plus =  qty;

        } else if (qtySelect === 3) {
            harga_item_retur = harga / (level_3 / level_2);
            alltot = harga / (level_3 / level_2) * qty;

            level1_plus = qty / level_3 ;
            level2_plus = qty / level_2;
            level3_plus =  qty;
        }
    } else if (satuanLevel === 3) {
        if (qtySelect === 3) {
            harga_item_retur = harga;
            alltot = harga * qty;

            level1_plus = qty / level_3 ;
            level2_plus = qty / level_2;
            level3_plus =  qty;
        }
    }

    subtotalItemInputs[i].value = parseInt(alltot);
    hargaItemRetur[i].value = parseInt(harga_item_retur);
    level_1_plus[i].value = parseFloat(level1_plus);
    level_2_plus[i].value = parseFloat(level2_plus);
    level_3_plus[i].value = parseFloat(level3_plus);

    calculateTotal();
}

function calculateTotal() {
    var subtotalItemInputs = document.querySelectorAll('input[name="subtotal_item_retur[]"]');
    var qtyReturInputs = document.querySelectorAll('input[name="qty_retur[]"]');
    var total = 0;
    var total_item = 0;

    for (var i = 0; i < subtotalItemInputs.length; i++) {
        var subtotalValue = parseFloat(subtotalItemInputs[i].value) || 0;
        total += subtotalValue;
    }

    for (var i = 0; i < qtyReturInputs.length; i++) {
        var itemtotalValue = parseInt(qtyReturInputs[i].value) || 0;
        total_item += itemtotalValue;
    }

    // Set the total value in the subtotal_retur input
    var subtotalReturInput = document.querySelector('input[name="subtotal_retur"]');
    var totalReturInput = document.querySelector('input[name="total_retur"]');
    var totalItemInput = document.querySelector('input[name="total_item"]');

    if (subtotalReturInput) {
        subtotalReturInput.value = total;
        totalReturInput.value = total;
        totalItemInput.value = total_item;
    }
}

// Call calculateTotal initially to set the initial total value
calculateTotal();


</script>

<script>
$('#submitTukar').on('click', function () {

    let formData = $('#tukarForm').serializeArray();
    $.ajax({
        url: '<?= base_url('sibabad/tukar/saveData') ?>',
        type: 'post',
        dataType: 'json',
        data: formData,
        success: function (response) {
            if (response.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: `${response.pesan}`,
                    showConfirmButton: false,
                    timer: 1500,
                }).then((res) => {
                    window.open(`<?= base_url('sibabad/tukar/cetakTransaksi/') ?>${response.invoice}`);
                    window.location.href = '<?= base_url('sibabad/tukar') ?>';
                });
            } else {
                toastr.error(response.pesan);
            }
        },
        error: function () {
            toastr.error('An error occurred during the request.');
        }
    });
});
</script>


<?= $this->endSection() ?>