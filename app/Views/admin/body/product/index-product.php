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
                        <h5 class="mb-4">Form Tambah Produk</h5>
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
                        <form class="mt-3" action="<?= base_url('sibabad/product/saveData') ?>" method="post"
                            onsubmit="return validateForm()">

                            <div class="row mb-3">
                                <label for="pName" class="col-sm-3 col-form-label">Nama Produk</label>
                                <div class="col-sm-9">
                                    <input type="text" name="p_name" class="form-control" id="pName">
                                    <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['p_name'])) : ?>
                                    <div class="alert alert-danger text-center">
                                        <?= $errors['p_name'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="pUnitType" class="col-sm-3 col-form-label">Satuan</label>
                                <div class="col-sm-5">
                                    <select class="form-select" name="p_unit_type" id="pUnitType">
                                        <option value="pcs" selected disabled>--Pilih--</option>
                                        <?php foreach ($units as $unit) : ?>
                                        <option value="<?= $unit['u_name'] ?>"><?= $unit['u_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['p_unit_type'])) : ?>
                                    <div class="alert alert-danger text-center">
                                        <?= $errors['p_unit_type'] ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="col-sm-3">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#unitModal">
                                        Tambah Satuan
                                    </button>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="pPrice" class="col-sm-3 col-form-label">Harga Beli (Rp.)</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="p_price" id="pPrice" placeholder="0">
                                    <?php if (session()->get('errors')) : ?>
                                    <?php $errors = session()->get('errors'); ?>
                                    <?php if (isset($errors['p_price'])) : ?>
                                    <div class="alert alert-danger text-center">
                                        <?= $errors['p_price'] ?>
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

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered " style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama Produk</th>
                                        <th>Satuan</th>
                                        <th>Harga Beli</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center tableSupplier">
                                    <?php $i=1; 
                                    foreach ($prods as $prod) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $prod['p_code'] ?></td>
                                        <td><?= $prod['p_name'] ?></td>
                                        <td><?= $prod['p_unit_type'] ?></td>
                                        <td><?= rupiah($prod['p_price']) ?></td>
                                        <td>
                                            <a href="<?= base_url('sibabad/product/editProduct/') . $prod['id_product'] ?>"
                                                type="button" class="btn btn-primary btn-sm">
                                                <span class="bx bx-pencil"></span>
                                            </a>
                                            <button data-id_product="<?= $prod['id_product'] ?>" type="button"
                                                class="btn btn-danger btn-sm btnDelete"><span
                                                    class="bx bx-trash"></span></button>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama Produk</th>
                                        <th>Satuan</th>
                                        <th>Harga Beli</th>
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
<div class="modal fade" id="unitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Satuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="card">
                        <div class="card-body p-4">
                            <form action="">
                                <input type="hidden" name="id_unit_type" id="hiddenIDUnit">
                                <div class="row mb-3">
                                    <label for="uName" class="col-sm-3 col-form-label">Nama Satuan</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="u_name" class="form-control" id="uName"
                                            placeholder="Ex: Pcs/Unit/Kg">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="uName" class="col-sm-3 col-form-label">Level</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="level" class="form-control" id="level" min="1" max="3"
                                            placeholder="1 / 2 / 3" value="1">
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
                            <table class="table mb-0 table-striped mt-3 receiveProduct">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">Nama Satuan</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php foreach ($units as $unit) : ?>
                                    <tr>
                                        <td>
                                            <?= $unit['u_name'] ?>
                                        </td>
                                        <td>
                                            <?= $unit['level'] ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm btnEditUnit"
                                                data-name="<?= $unit['u_name'] ?>"  data-level="<?= $unit['level'] ?>"
                                                data-id="<?= $unit['id_unit_type'] ?>">
                                                <span class="bx bx-pencil"></span>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm btnDeleteUnit"
                                                data-id_unit_type="<?= $unit['id_unit_type'] ?>">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                    url: `<?= base_url('sibabad/product/deleteProduct/') ?>${productId}`,
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
                                    '<?= base_url('sibabad/product/add-new') ?>';
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
        var uName = $('#uName').val().trim();
        var level = $('#level').val();
        var idUnit = $('#hiddenIDUnit').val();

        if (uName !== '') {
            $.ajax({
                url: '<?= base_url('sibabad/product/saveUnitType') ?>', // URL untuk POST
                method: 'POST',
                data: {
                    u_name: uName,
                    level: level,
                    id_unit_type: idUnit
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

                        window.location.href = '<?= base_url('sibabad/product/add-new') ?>'
                    } else if (data.status === 'error') {
                        if (data.message.u_name && data.message.u_name[0] ===
                            'Nama satuan tidak boleh sama.') {
                            // Tampilkan notifikasi bahwa tidak boleh ada nama jurnal yang sama
                            Swal.fire({
                                icon: 'error',
                                title: 'Data gagal disimpan',
                                text: 'Tidak boleh ada nama satuan yang sama.',
                            });

                            $('#uName').val('');
                        } else {
                            // Tampilkan pesan error umum jika ada error lain
                            Swal.fire({
                                icon: 'error',
                                title: 'Data gagal disimpan',
                                text: 'Tidak boleh ada nama satuan yang sama.',
                            });
                            $('#uName').val('');
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
var pPrice = document.getElementById('pPrice');
pPrice.addEventListener('keyup', function(e) {
    this.value = formatRupiah(this.value);
});

function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/g);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
</script>

<script>
$(document).ready(function() {
    $('.btnEditUnit').on('click', function() {
        var dataName = $(this).data('name');
        var idUnit = $(this).data('id');
        var level = $(this).data('level');

        $('#uName').val(dataName);
        $('#level').val(level);
        $('#hiddenIDUnit').val(idUnit);
    });
});
</script>

<script>
$(document).ready(function() {
    $(document).on('click', '.btnDeleteUnit', function() {
        const unitId = $(this).data('id_unit_type');

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
                    url: `<?= base_url('sibabad/product/deleteUnitType/') ?>${unitId}`,
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
                                    '<?= base_url('sibabad/product/add-new') ?>';
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