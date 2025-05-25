<?= $this->extend('admin/templates/index-template') ?>
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
                        <li class="breadcrumb-item"><a href="<?= base_url('/sibabad') ?>"><i
                                    class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Penerimaan Barang</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-start mb-3">
                            <a href="" class="btn btn-warning" data-bs-target="#buyReport" data-bs-toggle="modal">Tambah
                                Laporan Penerimaan</a>
                        </div>
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
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered " style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <!-- <th>Tanggal Pembelian</th>
                                        <th>Kode Pembelian</th> -->
                                        <th>Supplier</th>
                                        <!-- <th>Status</th> -->
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center tableSupplier">
                                    <?php $i=1; foreach ($recieveOrder as $prod) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $prod['s_name'] ?></td>
                                        <!-- <td><span class="badge  bg-success">Selesai</span></td> -->

                                        <td>
                                            <a href="<?= base_url('sibabad/recieve_order/detailRO/') . $prod['id_supplier'] ?>"
                                                type="button" class="btn btn-primary btn-sm">
                                                <span class="bx bx-pencil"></span>
                                            </a>
                                            <!-- <button data-id_do="<?= $prod['id_supplier'] ?>" type="button"
                                                class="btn btn-danger btn-sm btnDelete"><span
                                                    class="bx bx-trash"></span></button> -->
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                                <tfoot class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <!-- <th>Tanggal Pembelian</th>
                                        <th>Kode Pembelian</th> -->
                                        <th>Supplier</th>
                                        <!-- <th>Status</th> -->
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


<!--  Modal Lap. Pembelian -->
<div class="modal fade" id="buyReport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Riwayat Pembelian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-end">
                            <button id="filterButton" class="btn btn-dark btn-sm">
                                <span class="bx bx-filter-alt"></span>
                            </button>
                        </div>
                        <form method="get" id="filterForm">
                            <table id="tableData" class="table table-striped table-bordered mt-2" style="width:100%">
                                <div id="filterOptions" style="display: none;">
                                    <div class="justify-content-end">
                                        <div class="row mb-3">
                                            <label for="dateFrom" class="col-sm-3 col-form-label">Filter Tanggal</label>
                                            <div class="col-sm-6">
                                                <input type="date" class="form-control" id="dateFrom">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="dateTo" class="col-sm-3 col-form-label">Filter Tanggal</label>
                                            <div class="col-sm-6">
                                                <input type="date" class="form-control" id="dateTo">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="searchInput" class="col-sm-3 col-form-label">Cari Data</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" id="searchInput">
                                            </div>
                                            <div class="col-sm-3">
                                                <button id="refreshData" class="btn btn-primary btn-sm">Refresh
                                                    Data</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <thead class="text-center">
                                    <tr>
                                        <th>Tgl Pesanan</th>
                                        <th>Kode PO</th>
                                        <th>Supplier</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center tableBuyReport" id="tableBody">
                                    <?php
                                    $previousDoDate = null;
                                    $previousDoCode = null;
                                    $mergedRow = false;

                                    foreach ($logOrder as $log) {
                                        if ($log->do_date === $previousDoDate && $log->do_code === $previousDoCode) {
                                            // Jika do_date dan do_code sama dengan data sebelumnya, maka gabungkan baris
                                            echo '<tr>';
                                            echo '<td></td>'; // Tambahkan sel kosong untuk do_date
                                            echo '<td></td>'; // Tambahkan sel kosong untuk do_code
                                            echo '<td>' . $log->s_name  . '</td>';
                                            echo '<td>';
                                            echo '<a href="' . base_url('sibabad/recieve_order/tambahRO/') . $log->id_do . '" class="btn btn-primary btn-sm">';
                                            echo '<span class="bx bx-list-plus"></span>';
                                            echo '</a>';
                                            echo '</td>';
                                            echo '</tr>';
                                            $mergedRow = true;
                                        } else {
                                            // Jika do_date atau do_code berbeda dengan data sebelumnya, tampilkan baris biasa
                                            if ($mergedRow) {
                                                echo '</tr>';
                                                $mergedRow = false;
                                            }
                                            echo '<tr>';
                                            echo '<td>' . $log->do_date . '</td>';
                                            echo '<td>' . $log->do_code . '</td>';
                                            echo '<td>' . $log->s_name . '</td>';
                                            echo '<td>';
                                            echo '<a href="' . base_url('sibabad/recieve_order/tambahRO/') . $log->id_do . '" class="btn btn-primary btn-sm">';
                                            echo '<span class="bx bx-list-plus"></span>';
                                            echo '</a>';
                                            echo '</td>';
                                            echo '</tr>';
                                            $previousDoDate = $log->do_date;
                                            $previousDoCode = $log->do_code;
                                        }
                                    }

                                    // Tutup baris terakhir jika tergabung
                                    if ($mergedRow) {
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                                <tfoot class="text-center">
                                    <tr>
                                        <th>Tgl Pesanan</th>
                                        <th>Kode PO</th>
                                        <th>Supplier</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </form>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
const reportLogOrder = <?= $reportOrderJson ?>;
let dateRange = null;

function searchJournal() {
    const searchInput = $('#searchInput').val().toLowerCase();
    let filteredResults = reportLogOrder;

    if (dateRange) {
        const [startDate, endDate] = dateRange.map(date => formatDate(date));
        filteredResults = filteredResults.filter(result => {
            const doDate = formatDate(result.do_date);
            return doDate >= startDate && doDate <= endDate;
        });
    }

    filteredResults = filteredResults.filter(result => {
        return (
            result.do_date.toLowerCase().includes(searchInput) ||
            result.do_code.toLowerCase().includes(searchInput) ||
            result.p_name.toLowerCase().includes(searchInput) ||
            // result.dop_qty.toLowerCase().includes(searchInput) ||
            // result.p_price.toLowerCase().includes(searchInput) ||
            // result.dop_total.toLowerCase().includes(searchInput)
        );
    });

    updateTable(filteredResults);
}

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
                        <button type="button" id="btnDeleteProduct" data-id_do="${id_supplier}" class="btn btn-danger btn-sm"><span class="bx bx-trash"></span></button>
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
                        <button id="btnDeleteProduct" type="button" data-id_do="${id_supplier}" class="btn btn-danger btn-sm"><span class="bx bx-trash"></span></button>
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

$("#dateRange").on('change', function() {
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
// Mendefinisikan variabel data JSON yang sudah ada
let reportDateOrder = <?= $reportOrderJson ?>;

// Fungsi untuk memfilter data berdasarkan tanggal
function filterDataByDate(startDate, endDate, jsonData) {
    return jsonData.filter(item => {
        const itemDate = new Date(item.do_date);
        return itemDate >= startDate && itemDate <= endDate;
    });
}

// Fungsi untuk menampilkan data yang sesuai ke dalam tabel
function updateTableBasedOnDate() {
    const dateFromInput = new Date(document.getElementById('dateFrom').value);
    const dateToInput = new Date(document.getElementById('dateTo').value);

    if (!dateFromInput || !dateToInput) {
        alert('Mohon masukkan tanggal yang valid.');
        return;
    }

    const filteredData = filterDataByDate(dateFromInput, dateToInput, reportDateOrder);
    updateTable(filteredData);
}

// Event listener untuk memanggil fungsi di atas saat tanggal 'dateTo' berubah
document.getElementById('dateTo').addEventListener('change', updateTableBasedOnDate);

// Event listener untuk memastikan 'dateTo' selalu lebih besar dari atau sama dengan 'dateFrom'
document.getElementById('dateFrom').addEventListener('change', function() {
    const dateFromInput = new Date(this.value);
    const dateToInput = new Date(document.getElementById('dateTo').value);

    if (dateToInput < dateFromInput) {
        alert('Tanggal "dateTo" harus lebih besar dari atau sama dengan tanggal "dateFrom".');
        document.getElementById('dateTo').value = this
        .value; // Atur tanggal 'dateTo' ke 'dateFrom' jika tidak valid
    }
});

// Event listener untuk memastikan 'dateTo' tidak kurang dari 'dateFrom'
document.getElementById('dateTo').addEventListener('change', function() {
    const dateFromInput = new Date(document.getElementById('dateFrom').value);
    const dateToInput = new Date(this.value);

    if (dateToInput < dateFromInput) {
        alert('Tanggal "dateTo" harus lebih besar dari atau sama dengan tanggal "dateFrom".');
        this.value = dateFromInput
    .toLocaleDateString(); // Atur tanggal 'dateTo' ke tanggal 'dateFrom' jika tidak valid
    }
});

// Event listener untuk tombol "Refresh Data"
document.getElementById('refreshData').addEventListener('click', function() {
    // Kembalikan data ke data asli
    reportDateOrder = <?= $reportOrderJson ?>;
    // Perbarui tabel dengan data asli
    updateTable(reportDateOrder);

    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    document.getElementById('searchInput').value = '';
});

// Fungsi untuk menginisialisasi tabel pada awal halaman dimuat
function initializeTable() {
    updateTable(reportDateOrder);
}

// Panggil fungsi inisialisasi tabel saat halaman dimuat
window.addEventListener('DOMContentLoaded', initializeTable);
</script>

<script>
$(document).ready(function() {
    $(document).on('click', '.btnDelete', function() {
        const IdDO = $(this).data('id_supplier');

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
                    url: `<?= base_url('sibabad/recieve_order/deleteRO/') ?>${IdDO}`,
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
                                    '<?= base_url('sibabad/recieve_order/index') ?>';
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