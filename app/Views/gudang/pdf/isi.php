<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estimate Document</title>
    <style>
        .no {
            width: 5%;
            /* Sesuaikan lebar sesuai kebutuhan */
        }

        .quantity {
            width: 15%;
            /* Sesuaikan lebar sesuai kebutuhan */
        }

        .satuan {
            width: 12%;
            /* Sesuaikan lebar sesuai kebutuhan */
        }

        .tg-0pky {
            width: 20%;
            /* Sesuaikan lebar sesuai kebutuhan */
        }

        .tanggal {
            width: 5%;
            /* Sesuaikan lebar sesuai kebutuhan */
        }

        .syarat {
            width: 91%;
        }

        .nosyarat {
            width: 4%;
        }

        .tab {
            padding-left: 2em;
            /* Menambahkan indentasi sebanyak 2 spasi */
        }

        .tab2 {
            padding-left: 3.35em;
            /* Menambahkan indentasi sebanyak 2 spasi */
        }

        .tab3 {
            padding-left: 3.35em;
            /* Menambahkan indentasi sebanyak 2 spasi */
        }

        .transparant {
            color: transparent;
        }
    </style>
</head>

<body>
    <header>
        <main>
            <table width="100%" style="font-size:10;">
                <thead>
                    <tr>
                        <td style="text-align: left; width:15%;">
                            <small>
                                <center>
                                    <!-- admin/pdf/isi.php -->
                                    <img src="http://localhost/internalssa/public/uploads/logo_perusahaan/<?= $supplier1["logo"] ?>"
                                        width="47%">
                                </center>
                            </small>
                        </td>
                        <td style="text-align: left; width: 30%;">
                            <span style="color: #1e81b0;"><b>
                                    <?= $supplier1["nama_perusahaan"] ?>
                                </b></span>
                            <br>
                            <span style="font-size: 10px;">
                                <?= $supplier1["alamat"] ?>
                                <br>
                                <?= $supplier1["kecamatan"] ?>
                                <br>
                                <?= $supplier1["email"] ?>
                            </span>
                        </td>
                        <td style="text-align: center; width: 30%;">
                            <span style="font-size: 20px;"><b>
                                    PURCHASING ORDER
                                </b>
                            </span>
                            </br>
                            <?= $supplier1["do_code"] ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left;"><small>
                                <!-- <?= $supplier1["s_name"] ?>,
                                <?= $supplier1["s_name"] ?>
                                <?= $supplier1["s_name"] ?> -->
                            </small></td>
                        <td style="text-align: left;"><small>

                            </small></td>
                        <td style="text-align: center;"><small>
                                <!-- <?= $supplier1["s_name"] ?> -->

                                <!-- <?= $supplier1["s_name"] ?> -->
                            </small></td>
                    </tr>
                    <tr>
                        <td></small></td>
                        <td style="text-align: left;"><small>
                                <!-- Kota Semarang, Jawa Tengah 50273 - Indonesia -->
                            </small></td>
                        <td style="text-align: left;"><small>
                                <!-- Jln. Sinar Kencana III no.947AB, kecamatan Tembalang 7AB, kecamatan Tembalang -->
                            </small></td>
                    </tr>
                    <tr>
                        <td style="text-align: left;"><small>
                                <!-- Purchasing Order:
                                <?= $supplier1["s_name"] ?> -->
                            </small></td>
                        <td style="text-align: left;"><small>
                                <!-- Email : perdana.teknosindo@gmail.com -->
                            </small></td>
                        <td style="text-align: left;"><small>
                                <!-- Purchasing Order:
                                <?= $supplier1["s_name"] ?> -->
                            </small></td>
                    </tr>
                </thead>
            </table>
        </main>
        <hr style="color:black; height:2px">
    </header>
    <!-- In the main section the table for the separate items is added. Also we add another table for the summary, so subtotal, tax and total amount. -->
    <main>
        <table width="55%" style="float: left; font-size:10;">
            <thead>
                <tr>
                    <td align="left"><small>
                            Kepada Yth.
                            </br>
                            <strong>
                                <?= $supplier1["s_name"] ?>
                            </strong>
                            </br>
                            <?= $supplier1["s_address"] ?>
                            </br>
                            <?= $supplier1["s_district"] ?>
                            <?= $supplier1["s_zip_code"] ?>,
                            <?= $supplier1["s_province"] ?>-
                            <?= $supplier1["s_nation"] ?>
                            </br>
                            <?= $supplier1["s_city"] ?>
                            </br>
                            Telp. 021 345678912
                            </br>
                            <strong><u>Bapak/Ibu
                                    <?= $supplier1["s_name"] ?>
                                </u>
                        </small>
                    </td>
                </tr>
            </thead>
        </table>
        <table width="45%"
            style="float: left; margin: 1; border-collapse: collapse; text-align: center; border: 1px solid black; font-size: 10px;">
            <thead style="background-color: #ccc;">
                <tr>
                    <th class="tanggal" style="border: 1px solid black; min-width: 25%; max-width: 25%;">TANGGAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tanggal" style="border: 1px solid black;">
                        <?= $supplier1["do_date"]; ?>
                    </td>
                </tr>
                <tr>
                    <td class="tanggal" style="background-color: #ccc; border: 1px solid black; font-weight: bold;">
                        BERDASARKAN PENAWARAN VENDOR NO.</td>
                </tr>
                <tr>
                    <td class="tanggal" style="border: 1px solid black;">1759-171778-00877</td>
                </tr>
                <tr>
                    <td class="tanggal" style="background-color: #ccc; border: 1px solid black; font-weight: bold;">NPWP
                        VENDOR</td>
                </tr>
                <tr>
                    <td class="tanggal" style="border: 1px solid black;">9752390179642</td>
                </tr>
            </tbody>
        </table>
        <aside style="clear: both; width: 100%; font-size:9;">
            <p>
                Dengan hormat,
                <br>
                Sehubungan dengan pengadaan barang / material dengan ini kami memesan barang / material sesuai schedule
                dengan rincian sebagai berikut :
            </p>
        </aside>
        <table width="100%" style="border-collapse: collapse;">
            <thead style="background-color: #ccc; font-size: 12px;">
                <tr>
                    <th class="no" style="border: 1px solid black;">No</th>
                    <th class="tg-0pky" style="border: 1px solid black;">Uraian Barang &amp; Keterangan</th>
                    <th class="quantity" style="border: 1px solid black;">Quantity</th>
                    <th class="satuan" style="border: 1px solid black;">Satuan</th>
                    <th class="tg-0pky" style="border: 1px solid black;">Harga Satuan</th>
                    <th class="tg-0pky" style="border: 1px solid black;">Jumlah</th>
                </tr>
            </thead>
            <tbody style="font-size: 12px;">
                <?php
                $rowCount = count($supplier);
                $subtotalDisplayed = false;

                // Menghapus koma jika ada
                $totalDop = str_replace(',', '', $totalDop);

                // Menggunakan number_format untuk memastikan ada dua digit desimal
                $totalDop = number_format($totalDop, 2, '.', '');

                // Menambahkan koma sebagai pemisah ribuan
                $totalDop = number_format($totalDop, 0, '', ',');

                // Menambahkan .00 di belakang nilai
                $totalDop .= '.00';

                // Menghapus koma jika ada
                $ppn = str_replace(',', '', $ppn);

                // Menggunakan number_format untuk memastikan ada dua digit desimal
                $ppn = number_format($ppn, 2, '.', '');

                // Menambahkan koma sebagai pemisah ribuan
                $ppn = number_format($ppn, 0, '', ',');

                // Menambahkan .00 di belakang nilai
                $ppn .= '.00';

                // Menghapus koma jika ada
                $total = str_replace(',', '', $total);

                // Menggunakan number_format untuk memastikan ada dua digit desimal
                $total = number_format($total, 2, '.', '');

                // Menambahkan koma sebagai pemisah ribuan
                $total = number_format($total, 0, '', ',');

                // Menambahkan .00 di belakang nilai
                $total .= '.00';
                $i = 1;
                ?>

                <?php foreach ($supplier as $index => $row): ?>
                    <tr>
                        <td class="no" style="border: 1px solid black; text-align: center;">
                            <?= $i++ ?>
                        </td>
                        <td class="tg-0pky" style="border: 1px solid black; text-align: center;">
                            <?= $row['p_name'] ?>
                        </td>
                        <td class="quantity" style="border: 1px solid black; text-align: center;">
                            <?= $row['dop_qty'] ?>
                        </td>
                        <td class="satuan" style="border: 1px solid black; text-align: center;">
                            <?= $row['p_unit_type'] ?>
                        </td>
                        <td class="tg-0pky" style="border: 1px solid black; text-align: center;">
                            Rp <?= $row['dop_price'] ?>
                        </td>
                        <td class="tg-0pky" style="border: 1px solid black; text-align: center;">
                            Rp
                            <?= $row['dop_total'] ?>
                        </td>
                    </tr>

                    <?php if ($index === $rowCount - 1 && !$subtotalDisplayed): ?>
                        <tr>
                            <td class="tg-0pky" colspan="4" style="border: 1px solid black;"></td>
                            <td class="tg-0pky" style="border: 1px solid black; text-align: center;"><b>Sub Total</b></td>
                            <td class="tg-0pky" style="border: 1px solid black; text-align: center;">
                                <b>Rp
                                    <?= $totalDop ?>
                                </b>
                            </td>
                        </tr>
                        <?php $subtotalDisplayed = true; ?>
                    <?php endif; ?>
                <?php endforeach; ?>

                <tr>
                    <td class="tg-0pky" colspan="4" style="border: 1px solid black;">Terbilang : </td>
                    <td class="tg-0pky" style="border: 1px solid black; text-align: center;"><b>PPN 11%</b></td>
                    <td class="tg-0pky" style="border: 1px solid black; text-align: center;">
                        <b>Rp
                            <?= $ppn ?>
                        </b>
                    </td>
                </tr>
                <tr>
                    <td class="tg-0pky" colspan="4" style="border: 1px solid black;"></td>
                    <td class="tg-0pky" style="border: 1px solid black; text-align: center;"><b>GRAND TOTAL</b></td>
                    <td class="tg-0pky" style="border: 1px solid black; text-align: center;">
                        <b>Rp
                            <?= $total ?>
                        </b>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
    <!-- Within the aside tag we will put the terms and conditions which shall be shown below the estimate table. -->
    <aside style="font-size:8">
        </br>
        <b><i>SYARAT DAN KETENTUAN :</i></b>
        <table width="100%">
            <thead>
                <tr>
                    <td class="nosyarat">1.)</td>
                    <td class="syarat">Barang yang dikirim harus memenuhi persyaratan/spesifikasi teknis sesuai dengan
                        pesanan kami, dalam keadaan baik dan baru.</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="nosyarat">2.)</td>
                    <td class="syarat">Material / barang yang tidak memenuhi persyaratan harus diganti tanpa biaya
                        tambahan</td>
                </tr>
                <tr>
                    <td class="nosyarat">3.)</td>
                    <td class="syarat">Penyimpangan terhadap hal-hal di atas dapat mengakibatkan pembatalan pesanan.
                    </td>
                </tr>
                <tr>
                    <td class="nosyarat">4.)</td>
                    <td class="syarat">Harga franco makasar <b><?= $supplier1["s_name"] ?>.</b></td>
                </tr>
                <tr>
                    <td class="nosyarat">5.)</td>
                    <td class="syarat">Pengiriman barang / material mengikuti jadwal yang ditentukan oleh <b>
                            <?= $supplier1["nama_perusahaan"] ?>
                        </b> dan harus disertai surat jalan asli.</td>
                </tr>
                <tr>
                    <td class="nosyarat">6.)</td>
                    <td class="syarat">Barang / material yang dibayar berdasarkan jumlah dan nilai Purchasing Order
                    </td>
                </tr>
                <tr>
                    <td class="nosyarat">7.)</td>
                    <td class="syarat">Cara Pembayaran :</b></td>
                </tr>
                <tr>
                    <td class="nosyarat"></td>
                    <td class="tab">a.) Dengan uang muka 30% dan 70% nya dibayar ketika panel siap kirim</td>
                </tr>
                <tr>
                    <td class="nosyarat"></td>
                    <td class="tab">b.) Cash Before Delivery (CBD) berdasarkan performa invoice dan kelengkapannya
                        diterima oleh
                    </td>
                </tr>
                <tr>
                    <td class="nosyarat"></td>
                    <td class="tab2"><b>
                            <?= $supplier1["nama_perusahaan"] ?>
                        </b> di transfer ke rekening : </td>
                </tr>
                <tr>
                    <td class="nosyarat"></td>
                    <td class="tab2">- Bank <span class="transparant">............................</span> : </td>
                </tr>
                <tr>
                    <td class="nosyarat"></td>
                    <td class="tab2">- No. Rekening <span class="transparant">.......Lu...</span> : </td>
                </tr>
                <tr>
                    <td class="nosyarat"></td>
                    <td class="tab2">- Atas Nama <span class="transparant">.............a....</span> : <b> <?= $supplier1["s_name"] ?></b></td>
                </tr>
                <tr>
                    <td class="nosyarat">8.)</td>
                    <td class="syarat">Kelengkapan tagihan / invoice / performa invoice diakui secara sah apabila
                        melampirkan dokumen sebagai berikut :</b></td>
                </tr>
                <tr>
                    <td class="nosyarat"></td>
                    <td class="tab">a.) Kwitansi bermaterai 10.000,-</td>
                </tr>
                <tr>
                    <td class="nosyarat"></td>
                    <td class="tab">b.) Invoice / detail tagihan.
                    </td>
                </tr>
                <tr>
                    <td class="nosyarat"></td>
                    <td class="tab">c.) Surat jalan asli.
                    </td>
                </tr>
                <tr>
                    <td class="nosyarat"></td>
                    <td class="tab">d.) Copy purchasing order (telah di tanda tangan lengkap).
                    </td>
                </tr>
                <tr>
                    <td class="nosyarat"></td>
                    <td class="tab">e.) Copy tagihan lengkap (poin "a" s/d "e") 1X
                    </td>
                </tr>
                <tr>
                    <td class="nosyarat">9.)</td>
                    <td class="syarat"> Alamat pengiriman dan Person In Contact (PIC) penerima barang di lokasi </b>
                    </td>
                </tr>
                <tr>
                    <td class="nosyarat"></td>
                    <td class="syarat"> Alamat pengiriman <span class="transparant">A</span> :</td>
                </tr>
                <tr>
                    <td class="nosyarat"></td>
                    <td class="syarat"> Nama Penerima <span class="transparant">...u...</span> :</td>
                </tr>
                <tr>
                    <td class="nosyarat"></td>
                    <td class="syarat"> Telepon <span class="transparant">..................C</span> : <?= $supplier1["s_pabx"]; ?></td>
                </tr>
            </tbody>
    </aside>
    <main>
        <?php
        $rowCountTable1 = 8; // Misalnya ada 8 baris di tabel pertama
        $rowCountTable2 = 8; // Misalnya ada 7 baris di tabel kedua
        ?>
        <!--<div class="page-break-before">-->
        <table width="50%" style="float: left; margin: 1; border-collapse: collapse; text-align: center; font-size:8">
            <thead>
                <tr>
                    <td class="tanggal" style="visibility: hidden;">aaaaa</td>
                </tr>
                <tr>
                    <td class="tanggal">Menyetujui,</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="tanggal"><?= $supplier1["s_name"] ?></th>
                </tr>
                <tr>
                    <td class="tanggal" style="visibility: hidden;">aaaaa</td>
                </tr>
                <tr>
                    <td class="tanggal" style="visibility: hidden;">aaaaa</td>
                </tr>
                <tr>
                    <td class="tanggal" style="font-size: 12px;">materai 10.000</td>
                </tr>
                <tr>
                    <td class="tanggal" style="visibility: hidden;">aaaaa</td>
                </tr>
                <tr>
                    <td class="tanggal" style="visibility: hidden;">aaaaa</td>
                </tr>
                <tr>
                    <th class="tanggal"><u><?= $supplier1["s_pic"] ?></u></th>
                </tr>
                <tr>
                    <td class="tanggal">Direktur</td>
                </tr>
            </tbody>
        </table>
        <table width="50%" style="float: left; margin: 1; border-collapse: collapse; text-align: center; font-size:8">
            <thead>
                <tr>
                    <td class="tanggal" style="visibility: hidden;">aaaaa</td>
                </tr>
                <tr>
                    <td class="tanggal">Dipesan oleh,</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tanggal"><b>
                            <?= $supplier1["nama_perusahaan"] ?>
                        </b></td>
                </tr>
                <tr>
                    <td class="tanggal" style="visibility: hidden;">aaaaa</td>
                </tr>
                <tr>
                    <td class="tanggal" style="visibility: hidden;">aaaaa</td>
                </tr>
                <tr>
                    <td class="tanggal" style="visibility: hidden;">aaaaa</td>
                </tr>
                <tr>
                    <td class="tanggal" style="visibility: hidden;">aaaaa</td>
                </tr>
                <tr>
                    <td class="tanggal" style="visibility: hidden;">aaaaa</td>
                </tr>
                <tr>
                    <td class="tanggal"><b><u>
                                <?= $supplier1["nama_lengkap"] ?>
                            </u></b></td>
                </tr>
                <tr>
                    <td class="tanggal">Direktur Utama</td>
                </tr>
            </tbody>
        </table>
        </div>

        <style>
            .page-break-before {
                page-break-before: always;
            }
        </style>
    </main>