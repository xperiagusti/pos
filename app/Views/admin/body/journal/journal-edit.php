<?= $this->extend('admin/templates/index-template') ?>
<?= $this->section('content') ?>

<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Form</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/sibabad') ?>"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Pencatatan Jurnal Transaksi</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Jurnal Transaksi</h5>
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
                        <form class="mt-3" action="<?= base_url('sibabad/coa/saveCoaData') ?>" method="post" onsubmit="return validateForm()">
                            <div class="row mb-3">
                                <label for="journalDate" class="col-sm-3 col-form-label">Tanggal Transaksi</label>
                                <div class="col-sm-9">
                                    <input type="date" id="journalDate" class="form-control" name="journal_date" value="<?= $journal['journal_date'] ?>">
                                    <?php if (session()->get('errors')) : ?>
                                        <?php $errors = session()->get('errors'); ?>
                                        <?php if (isset($errors['journal_date'])) : ?>
                                            <div class="alert alert-danger text-center">
                                                <?= $errors['journal_date'] ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="journalName" class="col-sm-3 col-form-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="journal_name" id="journalName" cols="30" rows="2" placeholder="Masukkan keterangan transaksi. Contoh: Pembelian barang dari PT.XXX"><?= $journal['journal_name'] ?></textarea>
                                    <?php if (session()->get('errors')) : ?>
                                        <?php $errors = session()->get('errors'); ?>
                                        <?php if (isset($errors['journal_name'])) : ?>
                                            <div class="alert alert-danger text-center">
                                                <?= $errors['journal_name'] ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Display None Pemasukkan -->
                            <div id="inFunding">
                                <div class="row mb-3">
                                    <label for="sourceFunding" class="col-sm-3 col-form-label">Tipe Jurnal (Pemasukkan)</label>
                                    <div class="col-sm-6">
                                        <select name="jd_account" class="form-select" id="sourceFunding">
                                            <option value="" selected disabled>--Pilih--</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addJournalIncome">Tambah</button>
                                        <!-- Modal Journal Income -->
                                        <div class="modal fade" id="addJournalIncome" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Jurnal</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <form id="formJournalIn" method="post">
                                                                <label for="journalInName" class="col-sm-3 col-form-label">Nama Jurnal</label>
                                                                <div class="col-sm-6">
                                                                    <input type="text" class="form-control" name="jt_name" id="journalInName" placeholder="Contoh: Bank/Kas/Modal">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" id="saveButton" class="btn btn-success">Simpan Data</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="jdDebit" class="col-sm-3 col-form-label">Debit</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="jd_debit" id="jdDebit" placeholder="0">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="jdCredit" class="col-sm-3 col-form-label">Kredit</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="jd_credit" id="jdCredit" placeholder="0">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <div class="d-md-flex d-grid align-items-center gap-3">
                                            <button type="button" id="inputTable" class="btn btn-primary px-4" onclick="saveCoaData()">Input Tabel</button>
                                            <button type="reset" class="btn btn-light px-4">Bersihkan Form</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Style Display Pengeluaran -->
                            <div id="outFunding" style="display: none;">
                                <h1>Test</h1>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row">
                            <form action="<?= base_url('sibabad/journal/updateJournal/') . $journal['id_journal'] ?>" method="post">
                                <input type="hidden" name="journal_date" id="hiddenJournalDate" value="<?= $journal['journal_date'] ?>">
                                <input type="hidden" name="journal_name" id="hiddenJournalName" value="<?= $journal['journal_name'] ?>">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan Data</button>
                                </div>
                                <table class="table mb-0 table-striped mt-3">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nama Jurnal</th>
                                            <th scope="col">Debit</th>
                                            <th scope="col">Kredit</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        <?php foreach ($journalDetails as $journalDetail) : ?>
                                            <tr>
                                                <td>
                                                    <?= $journalDetail['jd_account'] ?>
                                                    <input type="hidden" name="jd_account[]" value="<?= $journalDetail['jd_account'] ?>">
                                                </td>
                                                <td>
                                                    <?= $journalDetail['jd_debit'] ?>
                                                    <input type="hidden" name="jd_debit[]" value="<?= $journalDetail['jd_debit'] ?>">
                                                </td>
                                                <td>
                                                    <?= $journalDetail['jd_credit'] ?>
                                                    <input type="hidden" name="jd_credit[]" value="<?= $journalDetail['jd_credit'] ?>">
                                                </td>
                                                <td>
                                                    <i class="bx bx-trash" onclick="showDeleteConfirmation(this, <?= $journalDetail['id_journal_detail'] ?>)"></i>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
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

<script>
    $(document).ready(function() {
        $('#saveButton').click(function() {
            var jtName = $('#journalInName').val(); // Ambil nilai dari input

            // Memeriksa apakah input tidak kosong
            if (jtName !== '') {
                $.ajax({
                    url: '<?= base_url('sibabad/journal/postTypeIn') ?>', // URL untuk POST
                    method: 'POST',
                    data: {
                        jt_name: jtName
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
                            // Atur ulang form
                            $('#journalInName').val(''); // Reset nilai input
                        } else if (data.status === 'error') {
                            if (data.message.jt_name && data.message.jt_name[0] === 'Nama jurnal tidak boleh sama.') {
                                // Tampilkan notifikasi bahwa tidak boleh ada nama jurnal yang sama
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Data gagal disimpan',
                                    text: 'Tidak boleh ada nama jurnal yang sama. Silakan ganti nama jurnal.',
                                });
                            } else {
                                // Tampilkan pesan error umum jika ada error lain
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Data gagal disimpan',
                                    text: 'Tidak boleh ada nama jurnal yang sama. Silakan ganti nama jurnal.',
                                });
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
        // Panggil fungsi untuk mengambil data tipe pemasukkan
        fetchTypeIn();

        function fetchTypeIn() {
            $.ajax({
                url: '<?= site_url('sibabad/journal/getTypeIn') ?>', // URL ke controller
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#sourceFunding').empty();

                    // Tambahkan opsi baru ke dalam select dropdown
                    $('#sourceFunding').append('<option value="" selected disabled>--Pilih--</option>');
                    $.each(data, function(index, value) {
                        $('#sourceFunding').append('<option value="' + value.jt_name + '">' + value.jt_name + '</option>');
                    });
                },
                error: function() {
                    console.log('Terjadi kesalahan saat mengambil data.');
                }
            });
        }

    });
</script>

<script>
    var jdDebit = document.getElementById('jdDebit');
    jdDebit.addEventListener('keyup', function(e) {
        this.value = formatRupiah(this.value);
    });

    var jdCredit = document.getElementById('jdCredit');
    jdCredit.addEventListener('keyup', function(e) {
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
    document.getElementById("inputTable").addEventListener("click", function() {
        var account = document.getElementById("sourceFunding").value;
        var debit = document.getElementById("jdDebit").value;
        var credit = document.getElementById("jdCredit").value;

        if (account && (debit || credit)) {
            var tableBody = document.getElementById("tableBody");
            var newRow = tableBody.insertRow();

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4); // New cell for hidden input

            cell1.innerHTML = account;
            cell2.innerHTML = debit;
            cell3.innerHTML = credit;
            cell4.innerHTML = '<i class="bx bx-trash" onclick="deleteRow(this)"></i>';

            // Create hidden inputs and set their values
            var hiddenAccountInput = document.createElement("input");
            hiddenAccountInput.type = "hidden";
            hiddenAccountInput.name = "jd_account[]";
            hiddenAccountInput.value = account;
            cell5.appendChild(hiddenAccountInput);

            var hiddenDebitInput = document.createElement("input");
            hiddenDebitInput.type = "hidden";
            hiddenDebitInput.name = "jd_debit[]";
            hiddenDebitInput.value = debit;
            cell5.appendChild(hiddenDebitInput);

            var hiddenCreditInput = document.createElement("input");
            hiddenCreditInput.type = "hidden";
            hiddenCreditInput.name = "jd_credit[]";
            hiddenCreditInput.value = credit;
            cell5.appendChild(hiddenCreditInput);

            // Reset input fields
            document.getElementById("sourceFunding").value = "";
            document.getElementById("jdDebit").value = "";
            document.getElementById("jdCredit").value = "";
        }
    });

    function deleteRow(icon) {
        var row = icon.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>

<script>
    document.getElementById("journalDate").addEventListener("input", function() {
        var journalDateValue = this.value;
        document.getElementById("hiddenJournalDate").value = journalDateValue;
    });

    document.getElementById("journalName").addEventListener("input", function() {
        var journalNameValue = this.value;
        document.getElementById("hiddenJournalName").value = journalNameValue;
    });
</script>

<script>
    function showDeleteConfirmation(icon, journalDetailId) {
        Swal.fire({
            title: 'Konfirmasi Hapus?',
            text: 'Apakah anda yakin menghapus data ini ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, perform the delete operation
                deleteRow(icon, journalDetailId);
            }
        });
    }

    function deleteRow(icon, journalDetailId) {
        // Perform the delete operation using AJAX or other methods
        // Example using AJAX:
        $.ajax({
            url: '<?= base_url('sibabad/journal/deleteDetailJournal/') ?>' + journalDetailId,
            type: 'DELETE',
            success: function(response) {
                // Handle success
                $(icon).closest('tr').remove();
            },
            error: function(xhr, status, error) {
                // Handle error
            }
        });

        // For now, let's just remove the row directly
        $(icon).closest('tr').remove();
    }
</script>

<?= $this->endSection() ?>