<?= $this->extend('admin/templates/index-template') ?>
<?= $this->section('content') ?>


<style>
select.form-select option {
    height: 10px;
}
</style>

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
                        <li class="breadcrumb-item active" aria-current="page">Stock Produk</li>
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
                                <p class="mb-0 text-secondary">Hampir Expired</p>
                                <h4 class="my-1"><?= get_stok_expired() ?></h4>
                            </div>
                            <div class="text-warning ms-auto font-35"><i class='bx bx-calendar-exclamation'></i>
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
                                <p class="mb-0 text-secondary">Expired</p>
                                <h4 class="my-1"><?= get_stok_expired2() ?></h4>
                            </div>
                            <div class="text-danger ms-auto font-35"><i class='bx bx-calendar-x'></i>
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
                                <p class="mb-0 text-secondary">Hampir Habis</p>
                                <h4 class="my-1"> <?= get_stok_habis2() ?></h4>
                            </div>
                            <div class="text-warning ms-auto font-35"><i class='bx bx-pyramid'></i>
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
                                <p class="mb-0 text-secondary">Habis</p>
                                <h4 class="my-1"> <?= get_stok_habis() ?></h4>
                            </div>
                            <div class="text-danger ms-auto font-35"><i class='bx bx-cube'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
       
        <div class="row">
            <div class="col-xl-12 col-sm-12">
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
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <a href="<?= base_url('sibabad/stock-product/tambah') ?>"
                                class="btn btn-primary px-4">Tambah
                                Data</a>
                            <button type="button" class="btn btn-success" data-bs-target="#konversiModal"
                                data-bs-toggle="modal" style="margin-left: 10px;">Konversi Satuan</button>
                        </div>
                        <br>

                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered " style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Barcode</th>
                                        <th>Nama Produk</th>
                                        <th>Satuan</th>
                                        <th>Jumlah Stock</th>
                                        <th>Harga Jual</th>
                                        <th>Qty Grosir</th>
                                        <th>Harga Grosir</th>
                                        <th>Qty Khusus</th>
                                        <th>Harga Khusus</th>
                                        <th>Tanggal Expired</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1;
                                    foreach ($stock as $st) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i++ ?></td>
                                        <td class="text-center"><?= $st['s_barcode'] ?></td>
                                        <td><?= $st['p_name'] ?>
                                        <?php 
                                                if ($st['s_stock'] == '0') {
                                                    echo ' <p class="mb-0 font-13 text-danger"><span class="badge bg-danger">Habis</span></p>';
                                                }
                                                else if ($st['s_stock'] > 0 && $st['s_stock'] <= 50)
                                                {
                                                    echo '<p class="mb-0 font-13 text-warning"><span class="badge bg-warning">Hampir Habis</span></p>';
                                                }
                                                ?></td>
                                        <td class="text-center"><?= $st['p_unit_type'] ?></td>
                                        <td class="text-center">
                                            <?= $st['s_stock'] ?>
                                        </td>
                                        <td class="text-center"><?= rupiah($st['s_price']) ?></td>
                                        <td class="text-center"><?= $st['s_qty_grosir'] ?></td>
                                        <td class="text-center"><?= rupiah($st['s_price_grosir']) ?></td>
                                        <td class="text-center"><?= $st['s_qty_khusus'] ?></td>
                                        <td class="text-center"><?= rupiah($st['s_price_khusus']) ?></td>
                                        <?php if($st['s_date_expired'] == '0000-00-00') : ?>
                                        <td class="text-center"></td>
                                        <?php else : ?>
                                        <td class="text-center"><?= date("d F Y", strtotime($st['s_date_expired'])) ?>
                                        <?php 
                                                $kgb_yad = $st['s_date_expired'];
                                                $awal = date_create($kgb_yad);
                                                $akhir = date_create(); 
                                               

                                                $diff = date_diff($awal, $akhir);
                                                $tahun = $diff->y;
                                                $bulan = $diff->m;
                                                $hari = $diff->d;
                                                if ($st['s_date_expired'] < date("Y-m-d")) {
                                                    echo ' <p class="mb-0 font-13 text-danger"><span class="badge bg-danger">EXP</span></p>';
                                                } else if ($st['s_date_expired'] < date("Y-m-d", strtotime('+1 months'))) {
                                                    echo ' <p class="mb-0 font-13 text-danger"><span class="badge bg-warning">Hampir EXP</span> ' . $bulan . ' bulan ' . $hari . ' hari</p>';
                                                }
                                               
                                              
                                                ?>
                                        </td>
                                        <?php endif; ?>

                                        <td class="text-center">
                                            <a href="<?= base_url('sibabad/stock-product/editProduct/') . $st['id_s_product'] ?>"
                                                type="button" class="btn btn-primary btn-sm">
                                                <span class="bx bx-pencil"></span>
                                            </a>
                                            <a href="<?= base_url('sibabad/pdf/cetakBarcode/') . $st['s_barcode'] ?>"
                                             target="_blank" type="button" class="btn btn-info btn-sm">
                                                <span class="bx bx-barcode"></span>
                                            </a>
                                            <button data-id_product="<?= $st['id_s_product'] ?>" type="button"
                                                class="btn btn-danger btn-sm btnDelete"><span
                                                    class="bx bx-trash"></span></button>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot class="text-center">
                                    <tr>
                                    <th>No</th>
                                        <th>Barcode</th>
                                        <th>Nama Produk</th>
                                        <th>Satuan</th>
                                        <th>Jumlah Stock</th>
                                        <th>Harga Jual</th>
                                        <th>Qty Grosir</th>
                                        <th>Harga Grosir</th>
                                        <th>Qty Khusus</th>
                                        <th>Harga Khusus</th>
                                        <th>Tanggal Expired</th>
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


<!-- Modal Satuan -->
<div class="modal fade" id="konversiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Konversi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="card">
                        <div class="card-body p-4">
                            <form action="">
                                <input type="hidden" name="id_c_unit" id="id_c_unit">
                                <div class="row mb-3">
                                    <label for="uName" class="col-sm-3 col-form-label">Barcode</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="s_barcode" class="form-control" id="s_barcode">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="uName" class="col-sm-3 col-form-label">Level 1</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="level_1" class="form-control" id="level_1" value="1"
                                            readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="uName" class="col-sm-3 col-form-label">Level 2</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="level_2" class="form-control" id="level_2">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="uName" class="col-sm-3 col-form-label">Level 3</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="level_3" class="form-control" id="level_3">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <button type="button" class="btn btn-primary btnSave">Simpan Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table id="tabel_konversi" class="table table-striped table-bordered "
                                    style="width:100%">
                                    <thead class="text-center">
                                        <tr>
                                            <th scope="col">Barcode</th>
                                            <th scope="col">Level 1</th>
                                            <th scope="col">Level 2</th>
                                            <th scope="col">Level 3</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php foreach ($convert as $converts) : ?>
                                        <tr>
                                            <td>
                                                <?= $converts['s_barcode'] ?>
                                            </td>
                                            <td>
                                                <?= $converts['level_1'] ?>
                                            </td>
                                            <td>
                                                <?= $converts['level_2'] ?>
                                            </td>
                                            <td>
                                                <?= $converts['level_3'] ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm btnEditKonversi"
                                                    data-s_barcode="<?= $converts['s_barcode'] ?>"
                                                    data-level_1="<?= $converts['level_1'] ?>"
                                                    data-level_2="<?= $converts['level_2'] ?>"
                                                    data-level_3="<?= $converts['level_3'] ?>"
                                                    data-id_c_unit="<?= $converts['id_c_unit'] ?>">
                                                    <span class="bx bx-pencil"></span>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm btnDeleteKonversi"
                                                    data-id_c_unit="<?= $converts['id_c_unit'] ?>">
                                                    <span class="bx bx-trash"></span>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
jQuery(document).ready(function($) {
    $('#tabel_konversi').DataTable({
        "lengthMenu": [
            [5, 10, 20],
            [5, 10, 20]
        ]
    });
});
</script>

$(...).DataTable is not a function

<!-- Hapus Produk -->
<script>
$(document).ready(function() {
    $(document).on('click', '.btnDelete', function() {
        const productId = $(this).data('id_product');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Anda tidak dapat mengembalikan data yang dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform the delete action using AJAX
                $.ajax({
                    url: `<?= base_url('sibabad/stock-product/deleteStock/') ?>${productId}`,
                    method: 'DELETE',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: 'Data berhasil dihapus.',
                                icon: 'success'
                            }).then(() => {
                                // Redirect or perform any other action after deletion
                                window.location.href =
                                    '<?= base_url('sibabad/stock-product/index') ?>';
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting product data:', status,
                            error);
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menghapus data.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});
</script>

<!-- Tambah Satuan -->
<script>
$(document).ready(function() {
    $('.btnSave').on('click', function() {
        var s_barcode = $('#s_barcode').val();
        var level_1 = $('#level_1').val();
        var level_2 = $('#level_2').val();
        var level_3 = $('#level_3').val();
        var id_c_unit = $('#id_c_unit').val();

        if (s_barcode !== '') {
            $.ajax({
                url: '<?= base_url('sibabad/konversi/saveKonversi') ?>', // URL untuk POST
                method: 'POST',
                data: {
                    s_barcode: s_barcode,
                    level_1: level_1,
                    level_2: level_2,
                    level_3: level_3,
                    id_c_unit: id_c_unit
                }, // Data yang akan dikirim
                dataType: 'json',
                success: function(data) {
                    // Tangani respons dari server jika diperlukan
                    if (data.status === 'success') {
                        // Tampilkan notifikasi sukses dengan SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil disimpan',
                            text: data.message,
                        });

                        window.location.href = '<?= base_url('sibabad/stock-product/index') ?>'
                    } else if (data.status === 'error') {
                        if (data.message.s_barcode && data.message.s_barcode[0] ===
                            'Nomer Barcode tidak boleh sama.') {
                            // Tampilkan notifikasi bahwa tidak boleh ada nama jurnal yang sama
                            Swal.fire({
                                icon: 'error',
                                title: 'Data gagal disimpan',
                                text: 'Tidak boleh ada barcode yang sama.',
                            });

                            $('#s_barcode').val('');
                            $('#level_1').val('');
                            $('#level_2').val('');
                            $('#level_3').val('');
                        } else {
                            // Tampilkan pesan error umum jika ada error lain
                            Swal.fire({
                                icon: 'error',
                                title: 'Data gagal disimpan',
                                text: 'Tidak boleh ada nama barcode yang sama.',
                            });
                            $('#s_barcode').val('');
                            $('#level_1').val('');
                            $('#level_2').val('');
                            $('#level_3').val('');
                        }
                    }
                },
                error: function() {
                    console.log('Terjadi kesalahan saat mengirim data.');
                }
            });
        } else {
            // Tampilkan notifikasi data tidak boleh kosong dengan SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Data tidak boleh kosong',
                text: 'Mohon isi semua kolom.',
            });
        }

    });
});
</script>

<script>
$(document).ready(function() {
    $('.btnEditKonversi').on('click', function() {
        var s_barcode = $(this).data('s_barcode');
        var level_1 = $(this).data('level_1');
        var level_2 = $(this).data('level_2');
        var level_3 = $(this).data('level_3');
        var id_c_unit = $(this).data('id_c_unit');

        $('#s_barcode').val(s_barcode);
        $('#level_1').val(level_1);
        $('#level_2').val(level_2);
        $('#level_3').val(level_3);
        $('#id_c_unit').val(id_c_unit);
    });
});
</script>

<script>
$(document).ready(function() {
    $(document).on('click', '.btnDeleteKonversi', function() {
        const id_c_unit = $(this).data('id_c_unit');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Anda tidak dapat mengembalikan data yang dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform the delete action using AJAX
                $.ajax({
                    url: `<?= base_url('sibabad/konversi/deleteKonversi/') ?>${id_c_unit}`,
                    method: 'DELETE',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: 'Data berhasil dihapus.',
                                icon: 'success'
                            }).then(() => {
                                // Redirect or perform any other action after deletion
                                window.location.href =
                                    '<?= base_url('sibabad/stock-product/index') ?>';
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting product data:', status,
                            error);
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menghapus data.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});
</script>




<?= $this->endSection() ?>