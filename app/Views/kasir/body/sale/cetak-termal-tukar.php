<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= get_nama_perusahaan() ?> | Cetak Struk</title>
    <style>
    html {
        font-family: "Verdana, Arial";
        color: #333;
    }

    .container {
        width: 190mm;
        font-size: 12px;
        padding: 5px 25px;
    }

    .title {
        text-align: center;
        font-size: 13px;
        padding-bottom: 5px;
        /* border-bottom: 1px dashed; */
    }

    .title h2,
    p {
        margin-bottom: 0;
        margin-top: 0;
    }

    .head {
        margin-top: 5px;
        margin-bottom: 10px;
        padding-bottom: 10px;
        /* border-bottom: 1px solid; */
    }

    .table {
        width: 100%;
        font-size: 11px;
    }

    .kiri {
        text-align: left;
    }

    .tengah {
        text-align: center;
    }

    .kanan {
        text-align: right;
    }

    .terimakasih {
        margin-top: 10px;
        padding-top: 10px;
        text-align: center;
    }

    @media print {
        @page {
            width: 210mm;
            margin: 0mm;
        }
    }
    </style>
</head>

<body onload="print()">
    <div class="container">
        <div class="head">
            <table class="table">
                <tr>
                    <td class="kiri" rowspan="4" width="60px"><img
                            src="<?= base_url('uploads/logo_perusahaan/' . get_logo()) ?>" width="50px"></td>
                    <td class="kiri">Bill To</td>
                    <td class="kiri"></td>
                    <td class="tengah" colspan="2" rowspan="2"
                        style="font-size:20px;font-weight:bold;text-align:center;vertical-align:middle">Tukar
                        Invoice
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td class="kiri"><?=$tukar[0]['pelanggan'];?></td>
                    <td class="kiri"><?= get_nama_perusahaan() ?></td>
                </tr>

                <tr>
                    <td class="kiri" rowspan="2" width="210px"><?= $tukar[0]['address'];?></td>
                    <td class="kiri" rowspan="2" width="210px"><?= get_alamat() ?></td>
                    <td class="tengah">Invoice Date</td>
                    <td class="tengah">Invoice No</td>
                </tr>
                <tr>
                    <td class="tengah"><?=date("d F Y", strtotime(esc($tukar[0]['tanggal'])))?></td>
                    <td class="tengah"><?=esc($tukar[0]['invoice']);?></td>
                </tr>

            </table>
        </div>

        <div class="transaksi">
            <table class="table">
                <tr>
                    <td colspan="8" style="border-bottom: 1.8px solid; "></td>
                </tr>
                <tr>
                    <td class="kiri">No.</td>
                    <td class="tengah">Product No</td>
                    <td class="tengah">Item Description</td>
                    <td class="tengah">Qty</td>
                    <td class="tengah">Unit Price</td>
                    <td class="tengah">Disc</td>
                    <td class="tengah">Amount</td>
                    <td class="tengah">Serial Number</td>
                </tr>
                <?php $diskon = 0;?>



                <?php $i=1;foreach (esc($tukar) as $data): ?>
                <?php $diskon = esc($data['diskon']);?>
                <tr>
                    <td class="kiri"><?= $i++ ;?></td>
                    <td class="tengah"> <?=strtoupper($data['p_code']);?></td>
                    <td class="tengah"><?=strtoupper($data['item']);?> <?=strtoupper($data['satuan']);?> <i></i></td>
                    <td class="tengah"><?=esc($data['jumlah']);?></td>
                    <td class="tengah"><?=rupiah(esc($data['harga']));?></td>
                    <td class="tengah"><?=esc($data['diskon_item']);?></td>
                    <td class="tengah"><?=rupiah(esc($data['subtotal']));?></td>
                    <td class="tengah"> </td>
                </tr>
                <?php endforeach;?>
                
                <tr>
                    <td colspan="8" style="border-bottom: 1.8px solid; "></td>
                </tr>
                
                <tr>
                    <td class="kiri" colspan="4" rowspan="2">DIAMBIL</td>
                    <td class="tengah">Salesman</td>
                    <td class="tengah">Terms</td>
                    <td class="kanan">Sub Total :</td>
                    <td class="kanan"><?=rupiah(esc($tukar[0]['total_harga']));?></td>
                </tr>
                <tr>
                    <td class="tengah">SMG - D - SMG</td>
                    <td class="tengah">C.O.D</td>
                    <td class="kanan">Discount :</td>
                    <td class="kanan"><?=esc($diskon);?></td>
                </tr>
                <tr>
                    <td class="kiri" colspan="5" rowspan="2">Catatan : </td>
                    <td class="tengah"></td>
                    <td class="kanan">Freight:</td>
                    <td class="kanan">0</td>
                </tr>
                <tr>
                    <td class="kanan" colspan="2"><b>Total Invoice :</b></td>
                    <td class="kanan"><b><?=rupiah(esc($tukar[0]['total_akhir']));?></b></td>
                </tr>
                <tr>
                    <td class="kiri">Disetujui,<br>Date <?=date("m/d/Y", strtotime(esc($tukar[0]['tanggal'])))?><br>Time <?=date("H:i:s", strtotime(esc($tukar[0]['tanggal'])))?><br></td>
                    <td class="tengah">Disiapkan,<br>Date<br></td>
                    <td class="tengah">Pengirim,<br>Date<br></td>
                    <td class="tengah">Penerima,<br>Date<br></td>
                    <td class="kiri"></td>
                    <td class="tengah" colspan="3"><b>Pembayaran ditransfer ke rekening<br><?= get_nama_perusahaan() ?> <?= get_no_rek() ?><br>
                 An. <?= get_an_rek() ?></b></td>
                </tr>
                <tr>
                    <td class="tengah" colspan="8" style="height:100px"></td>
                </tr>
                <tr>
                    <td class="kiri" colspan="8">*Transaksi dianggap sah apabila ditransfer ke rekening tercantum atau tunai.</td>
                </tr>

            </table>
        </div>

        <div class="terimakasih">
           
        </div>
    </div>
</body>

</html>