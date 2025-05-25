<?= $this->extend('gudang/templates/index-template') ?>
<?= $this->section('content') ?>

<style>
    td {
        vertical-align: middle;
    }
</style>

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
                        <li class="breadcrumb-item active" aria-current="page">Lap. Jurnal Umum</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
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

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="journalDateFrom" class="col-form-label">Tanggal Transaksi Dari</label>
                                    <input type="date" id="journalDateFrom" class="form-control">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="journalDateUntil" class="col-form-label">Tanggal Transaksi Sampai</label>
                                    <input type="date" id="journalDateUntil" class="form-control">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="searchInput" class="col-form-label">Kolom Pencarian</label>
                                    <input type="text" name="search" id="searchInput" class="form-control" placeholder="Cari transaksi disini..." oninput="searchJournal()">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label for="chooseExport" class="col-form-label">Ekspor Jurnal</label>
                                    <select class="form-select" id="chooseExport">
                                        <option value="" selected disabled>--</option>
                                        <option id="chooseExcel">Excel</option>
                                        <option id="choosePDF">PDF</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="d-flex justify-content-end">
                                <div id="btnPDF" style="display: none;">
                                    <button type="button" class="btn btn-primary">Cetak PDF</button>
                                    <button type="button" class="btn btn-warning" style="margin-left: 5px;">Download PDF</button>
                                </div>
                                <div id="btnEXCEL" style="display: none;">
                                    <button type="button" class="btn btn-primary">Cetak Excel</button>
                                    <button type="button" class="btn btn-warning" style="margin-left: 5px;">Download Excel</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mt-3">
                            <table id="journalTable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Nama Jurnal</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="journalTableBody">
                                    <?php
                                    $mergedJournals = [];
                                    foreach ($journals as $index => $journal) {
                                        $journalId = $journal['id_journal'];
                                        if (!isset($mergedJournals[$journalId])) {
                                            $mergedJournals[$journalId] = [
                                                'journal_date' => $journal['journal_date'],
                                                'journal_name' => $journal['journal_name'],
                                                'actions' => [],
                                            ];
                                        }

                                        $mergedJournals[$journalId]['actions'][] = [
                                            'jd_account' => $journal['jd_account'],
                                            'jd_debit' => $journal['jd_debit'],
                                            'jd_credit' => $journal['jd_credit'],
                                        ];
                                    }

                                    foreach ($mergedJournals as $journalId => $mergedJournal) {
                                    ?>
                                        <tr>
                                            <td rowspan="<?= count($mergedJournal['actions']) ?>"><?= $mergedJournal['journal_date'] ?></td>
                                            <td rowspan="<?= count($mergedJournal['actions']) ?>"><?= $mergedJournal['journal_name'] ?></td>
                                            <?php foreach ($mergedJournal['actions'] as $actionIndex => $action) { ?>
                                                <?php if ($actionIndex > 0) {
                                                    echo '<tr>';
                                                } ?>
                                                <td><?= $action['jd_account'] ?></td>
                                                <td><?= $action['jd_debit'] ?></td>
                                                <td><?= $action['jd_credit'] ?></td>
                                                <?php if ($actionIndex === 0) { ?>
                                                    <td rowspan="<?= count($mergedJournal['actions']) ?>">
                                                        <a href="<?= base_url('sibabad/journal/edit-transaction/') . $journalId ?>" class="btn btn-primary btn-sm"><span class="bx bx-pencil"></span></a>
                                                        <button class="btn btn-danger btn-sm" onclick="showDeleteConfirmation(this, <?= $journalId ?>)"><span class="bx bx-trash"></span></button>
                                                    </td>
                                                <?php } ?>
                                                <?php if ($actionIndex > 0) {
                                                    echo '</tr>';
                                                } ?>
                                            <?php } ?>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Nama Jurnal</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<script>
    function showDeleteConfirmation(icon, journalId) {
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
                deleteRow(icon, journalId);
            }
        });
    }

    function deleteRow(icon, journalId) {
        // Perform the delete operation using AJAX or other methods
        // Example using AJAX:
        $.ajax({
            url: '<?= base_url('sibabad/journal/deleteJournal/') ?>' + journalId,
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

<script>
    const journalsData = <?= $journalsJson ?>;

    function searchJournal() {
        const searchInput = $('#searchInput').val().toLowerCase();

        const filteredResults = journalsData.filter(result => {
            return (
                result.journal_date.toLowerCase().includes(searchInput) ||
                result.journal_name.toLowerCase().includes(searchInput) ||
                result.jd_account.toLowerCase().includes(searchInput) ||
                result.jd_debit.toLowerCase().includes(searchInput) ||
                result.jd_credit.toLowerCase().includes(searchInput)
            );
        });

        updateTable(filteredResults);
    }

    function updateTable(searchResults) {
        const tableBody = $('#journalTableBody');
        tableBody.empty(); // Clear existing table rows

        let previousDate = null;
        let previousName = null;

        searchResults.forEach(result => {
            const {
                journal_date,
                journal_name,
                jd_account,
                jd_debit,
                jd_credit,
                id_journal
            } = result;

            if (journal_date !== previousDate || journal_name !== previousName) {
                // Close previous row if needed
                if (previousDate !== null) {
                    closeRow(tableBody);
                }

                // Open new row
                const row = `
                <tr>
                    <td>${journal_date}</td>
                    <td>${journal_name}</td>
                    <td>${jd_account}</td>
                    <td>${jd_debit}</td>
                    <td>${jd_credit}</td>
                    <td rowspan="3">
                        <a href="your_base_url/sibabad/journal/edit-transaction/${id_journal}" class="btn btn-primary btn-sm"><span class="bx bx-pencil"></span></a>
                        <button class="btn btn-danger btn-sm" onclick="showDeleteConfirmation(this, ${id_journal})"><span class="bx bx-trash"></span></button>
                    </td>
                </tr>
            `;

                tableBody.append(row);
            } else {
                // Continue existing row
                const row = `
                <tr>
                    <td></td>
                    <td></td>
                    <td>${jd_account}</td>
                    <td>${jd_debit}</td>
                    <td>${jd_credit}</td>
                </tr>
            `;

                tableBody.append(row);
            }

            previousDate = journal_date;
            previousName = journal_name;
        });

        // Close last row if needed
        if (previousDate !== null) {
            closeRow(tableBody);
        }
    }

    function closeRow(tableBody) {
        const row = `
        <tr>
            <td colspan="2"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    `;

        tableBody.append(row);
    }


    function closeRow(tableBody) {
        const row = `
        <tr>
            <td colspan="2"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    `;

        tableBody.append(row);
    }
</script>

<script>
    document.getElementById("chooseExport").addEventListener("change", function() {
        var selectedOption = this.value;
        var btnPDF = document.getElementById("btnPDF");
        var btnEXCEL = document.getElementById("btnEXCEL");

        if (selectedOption === "PDF") {
            btnPDF.style.display = "block";
            btnEXCEL.style.display = "none";
        } else if (selectedOption === "Excel") {
            btnPDF.style.display = "none";
            btnEXCEL.style.display = "block";
        } else {
            btnPDF.style.display = "none";
            btnEXCEL.style.display = "none";
        }
    });
</script>

<?= $this->endSection() ?>