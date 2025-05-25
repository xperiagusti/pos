<?= $this->extend('gudang/templates/index-template') ?>
<?= $this->section('content') ?>

<style>
    td.actions {
        width: 100px;
        /* Sesuaikan lebar sesuai kebutuhan Anda */
        text-align: center;
        /* Pusatkan isi sel */
    }

    /* Atur lebar sel aksi untuk baris kedua */
    td.actions:nth-child(2) {
        width: auto;
        /* Reset lebar untuk baris kedua */
    }
</style>

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
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success text-center">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('update')): ?>
                            <div class="alert alert-success text-center">
                                <?= session()->getFlashdata('update') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('success-delete')): ?>
                            <div class="alert alert-success text-center">
                                <?= session()->getFlashdata('success-delete') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('error-delete')): ?>
                            <div class="alert alert-danger text-center">
                                <?= session()->getFlashdata('error-delete') ?>
                            </div>
                        <?php endif; ?>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered " style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Tanggal Pembelian</th>
                                        <th scope="col" class="text-center">Kode Pembelian</th>
                                        <th scope="col" class="text-center">Nama Produk</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($dapat as $product): ?>
                                        <tr data-source="modal">
                                            <td class="text-center">
                                                <?= $i++ ?>
                                            <td class="text-center">
                                                <?= $product['do_date'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $product['do_code'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $product['p_name'] ?>
                                            </td class="text-center">
                                            <td class="text-center">
                                                <?= $product['p_unit_type'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $product['dop_qty'] ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= base_url('sibabad3/recieve_order/editRO/') . $product['id_do'] ?>"
                                                    type="button" class="btn btn-primary btn-sm">
                                                    <span class="bx bx-pencil"></span>
                                                </a>
                                                <button data-id_do="<?= $product['id_do'] ?>" type="button"
                                                    class="btn btn-danger btn-sm btnDelete"><span
                                                        class="bx bx-trash"></span></button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
    $(document).ready(function () {
        // Event delegation untuk tombol "Simpan Jurnal"
        $(document).on('click', '#saveButton', function () {
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
    document.addEventListener("DOMContentLoaded", function () {
        const filterButton = document.getElementById("filterButton");
        const filterOptions = document.getElementById("filterOptions");

        filterButton.addEventListener("click", function () {
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

    function updateTable(searchResults) {
        const tableBody = $('.tableBuyReport');
        tableBody.empty();

        let previousDate = null;
        let previousCode = null;

        searchResults.forEach(result => {
            const {
                do_date,
                do_code,
                p_name,
                // dop_qty,
                // p_price,
                // dop_total,
                id_do
            } = result;

            if (do_date !== previousDate || do_code !== previousCode) {
                // Open new row
                const row = `
                <tr>
                    <td>${do_date}</td>
                    <td>${do_code}</td>
                    <td>${p_name}</td>
                    <td class="actions">
                        <a href="editDO/${id_do}" class="btn btn-primary btn-sm"><span class="bx bx-pencil"></span></a>
                        <button type="button" id="btnDeleteProduct" data-id_do="${id_do}" class="btn btn-danger btn-sm"><span class="bx bx-trash"></span></button>
                    </td>
                </tr>
            `;

                tableBody.append(row);

                previousDate = do_date;
                previousCode = do_code;
            } else {
                // Continue existing row
                const row = `
                <tr>
                    <td></td>
                    <td></td>
                    <td>${p_name}</td>
                    <td>${dop_qty}</td>
                    <td class="actions">
                        <a href="editDO/${id_do}" class="btn btn-primary btn-sm"><span class="bx bx-pencil"></span></a>
                        <button id="btnDeleteProduct" type="button" data-id_do="${id_do}" class="btn btn-danger btn-sm"><span class="bx bx-trash"></span></button>
                    </td>
                </tr>
            `;

                tableBody.append(row);
            }
        });
    }

    $('#searchInput').on('input', searchJournal);

    function handleDateRange(selectedDates, dateStr, instance) {
        dateRange = selectedDates;
        console.log("Selected Dates:", dateRange); // Tambahkan ini
        searchJournal(); // Panggil searchJournal setiap kali rentang tanggal berubah
    }

    // Fungsi untuk mengubah format tanggal ke "Y-m-d"
    function formatDate(date) {
        // Konversi tanggal ke format "Y-m-d" di sini
        return date.split(' ')[0];
    }

    $("#dateRange").on('change', function () {
        dateRange = this.value;
        console.log("Selected Date Range:", dateRange);
    });

    $("#dateRange").flatpickr({
        mode: "range",
        altInput: true,
        altFormat: "Y-m-d",
        dateFormat: "Y-m-d",
        onChange: handleDateRange
    });

    updateTable(reportLogOrder);
</script>


<script>
    $(document).ready(function () {
        $(document).on('click', '.btnDelete', function () {
            const IdDO = $(this).data('id_do');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data Penerimaan yang dihapus akan kembali ke Data Pembelian dengan status Proses!',
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
                        url: `<?= base_url('sibabad3/recieve_order/deleteRO/') ?>${IdDO}`,
                        method: 'DELETE',
                        dataType: 'json',
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Terhapus!',
                                    text: 'Data berhasil dihapus.',
                                    icon: 'success'
                                }).then(() => {
                                    // Redirect or perform any other action after deletion
                                    window.location.href =
                                        '<?= base_url('sibabad3/recieve_order/index') ?>';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat menghapus data.',
                                    icon: 'error'
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error deleting recieve order data:', status,
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