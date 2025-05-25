<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JournalDetailModel;
use App\Models\JournalModel;
use App\Models\JournalTypeInModel;

class JournalController extends BaseController
{
    protected $journalIn;
    protected $journalModel;
    protected $journalDetailModel;

    public function __construct()
    {
        $this->journalIn = new JournalTypeInModel();
        $this->journalModel = new JournalModel();
        $this->journalDetailModel = new JournalDetailModel();
    }

    public function inputTransaction()
    {
        $data['title'] = "SiBabad - Pencatatan Jurnal Transaksi";
        return view('admin/body/journal/journal-index', $data);
    }

    public function editTransaction($idJournal)
    {
        $data['title'] = "SiBabad - Edit Jurnal";
        $journalData = $this->journalModel->find($idJournal);

        $journalDetailData = $this->journalDetailModel->where('id_journal', $idJournal)->findAll();

        $data['journal'] = $journalData;
        $data['journalDetails'] = $journalDetailData;
        return view('admin/body/journal/journal-edit', $data);
    }

    public function addJournalIn()
    {
        $jtName = $this->request->getVar('jt_name');
        $userId = session('id_user');

        date_default_timezone_set('Asia/Jakarta');

        // Periksa apakah nama jurnal sudah ada di database
        $existingJournal = $this->journalIn->where('jt_name', $jtName)->first();

        if ($existingJournal) {
            // Jika nama jurnal sudah ada, kirim respons error
            $response = [
                'status' => 'error',
                'message' => ['jt_name' => 'Nama jurnal tidak boleh sama. Silakan ganti nama jurnal.']
            ];
        } else {
            // Jika nama jurnal belum ada, simpan data
            $dataSave = [
                'jt_name' => $jtName,
                'id_user' => $userId,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->journalIn->insert($dataSave);

            $response = [
                'status' => 'success',
                'message' => 'Data berhasil disimpan.'
            ];
        }

        // Mengirim respons dalam bentuk JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    public function getTypeIn()
    {
        $typeInData = $this->journalIn->findAll();
        return $this->response->setJSON($typeInData);
    }

    public function saveJournal()
    {
        $jDate = $this->request->getVar('journal_date');
        $jName = $this->request->getVar('journal_name');
        $jAccount = $this->request->getVar('jd_account');
        $jDebit = $this->request->getVar('jd_debit');
        $jCredit = $this->request->getVar('jd_credit');
        $userId = session('id_user');
        date_default_timezone_set('Asia/Jakarta');
        $validation = \Config\Services::validation();

        $validationRules =
            [
                'journal_date' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tanggal tidak boleh kosong.'
                    ],
                ],
                'journal_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Keterangan transaksi tidak boleh kosong.'
                    ],
                ],
            ];
        $validation->setRules($validationRules);
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        } else {
            $saveJournal = [
                'journal_date' => $jDate,
                'journal_name' => $jName
            ];
            $this->journalModel->insert($saveJournal);
            $getID = $this->journalModel->getInsertID();

            $detailJournal = []; // Initialize an empty array

            for ($i = 0; $i < count($jAccount); $i++) {
                $detailJournal[] = [
                    'id_journal' => $getID,
                    'jd_account' => $jAccount[$i],
                    'jd_debit' => $jDebit[$i],
                    'jd_credit' => $jCredit[$i],
                    'created_at' => date('Y:m:d H:i:s'),
                    'updated_at' => date('Y:m:d H:i:s')
                ];
            }

            $this->journalDetailModel->insertBatch($detailJournal);
            session()->setFlashdata('success', 'Transaksi jurnal berhasil disimpan');

            return redirect()->to('sibabad/journal/input-transaction');
        }
    }

    public function updateJournal($idJournal)
    {
        $jDate = $this->request->getVar('journal_date');
        $jName = $this->request->getVar('journal_name');
        $jAccount = $this->request->getVar('jd_account');
        $jDebit = $this->request->getVar('jd_debit');
        $jCredit = $this->request->getVar('jd_credit');
        $userId = session('id_user');
        date_default_timezone_set('Asia/Jakarta');
        $validation = \Config\Services::validation();

        $validationRules = [
            'journal_date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal tidak boleh kosong.'
                ],
            ],
            'journal_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keterangan transaksi tidak boleh kosong.'
                ],
            ],
        ];
        $validation->setRules($validationRules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Find journal by ID
        $existingJournal = $this->journalModel->find($idJournal);

        if ($existingJournal) {
            // If journal exists, update the details
            $this->journalModel->update($idJournal, [
                'journal_date' => $jDate,
                'journal_name' => $jName
            ]);

            $detailJournal = [];

            for ($i = 0; $i < count($jAccount); $i++) {
                $account = $jAccount[$i];
                $debit = $jDebit[$i];
                $credit = $jCredit[$i];

                // Check if the same record already exists
                $existingRecord = $this->journalDetailModel
                    ->where('id_journal', $idJournal)
                    ->where('jd_account', $account)
                    ->where('jd_debit', $debit)
                    ->where('jd_credit', $credit)
                    ->first();

                if (!$existingRecord) {
                    // Add the record to the detailJournal array
                    $detailJournal[] = [
                        'id_journal' => $idJournal,
                        'jd_account' => $account,
                        'jd_debit' => $debit,
                        'jd_credit' => $credit,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
            }

            // Insert the new records if there are any
            if (!empty($detailJournal)) {
                $this->journalDetailModel->insertBatch($detailJournal);
            }

            session()->setFlashdata('success', 'Transaksi jurnal berhasil diperbarui');
        }

        return redirect()->to('sibabad/journal/reports');
    }

    public function getReports()
    {
        $data['title'] = "SiBabad - Lihat Laporan Jurnal Umum";
        $journals = $this->journalDetailModel->getJournalDetailsWithJournal();

        $rowspanData = [];
        foreach ($journals as $index => &$journal) {
            if (!isset($rowspanData[$journal['journal_date']])) {
                $rowspanData[$journal['journal_date']] = [
                    'rowspan_date' => 0,
                    'rowspan_date_index' => $index,
                ];
            }
            if (!isset($rowspanData[$journal['journal_name']])) {
                $rowspanData[$journal['journal_name']] = [
                    'rowspan_name' => 0,
                    'rowspan_name_index' => $index,
                ];
            }

            $rowspanData[$journal['journal_date']]['rowspan_date']++;
            $rowspanData[$journal['journal_name']]['rowspan_name']++;
        }

        foreach ($journals as $index => &$journal) {
            $journal['rowspan_date'] = $rowspanData[$journal['journal_date']]['rowspan_date'];
            $journal['rowspan_date_index'] = $rowspanData[$journal['journal_date']]['rowspan_date_index'];
            $journal['rowspan_name'] = $rowspanData[$journal['journal_name']]['rowspan_name'];
            $journal['rowspan_name_index'] = $rowspanData[$journal['journal_name']]['rowspan_name_index'];
        }

        $data['journals'] = $journals;
        $data['journalsJson'] = json_encode($journals);

        return view('admin/body/journal/journal-report', $data);
    }

    public function deleteDetailJournal($idDetailJournal)
    {
        $detailData = $this->journalDetailModel->find($idDetailJournal);

        if ($detailData) {
            $this->journalDetailModel->delete($idDetailJournal);
            $response['status'] = 'success';
            $response['message'] = 'Data has been deleted successfully.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Data not found.';
        }

        return json_encode($response);
    }

    public function deleteJournal($idJournal)
    {
        $detailData = $this->journalModel->find($idJournal);

        if ($detailData) {
            $this->journalDetailModel->delete($idJournal);
            $response['status'] = 'success';
            $response['message'] = 'Data has been deleted successfully.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Data not found.';
        }

        return json_encode($response);
    }

    public function searchJournal()
    {
        $searchTerm = $this->request->getVar('search');
        $searchResults = $this->journalDetailModel->searchByTerm($searchTerm);
        return $this->response->setJSON($searchResults);
    }
}
