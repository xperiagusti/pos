<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Rekap Transaksi</title>
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

    <!-- In the main section the table for the separate items is added. Also we add another table for the summary, so subtotal, tax and total amount. -->
    <main>
        <?php if (empty($filter)): ?>
            <div style="text-align: center;">
                <h3>Rekap Transaksi Harian</h3>
            </div>
            <div>
                <h5>Tanggal :
                    <?= date('Y-m-d') ?>
                </h5>
            </div>
        <?php elseif ($filter == '1'): ?>
            <?php
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            ?>
            <div style="text-align: center;">
                <h3>Rekap Transaksi Kemarin</h3>
            </div>
            <div>
                <h5>Tanggal :
                    <?= $yesterday ?>
                </h5>
            </div>
        <?php elseif ($filter == '2'): ?>
            <?php
            $today = date('Y-m-d');
            $sevendays = date('Y-m-d', strtotime('-7 day'));
            ?>
            <div style="text-align: center;">
                <h3>Rekap Transaksi 7 Hari Terakhir</h3>
            </div>
            <div>
                <h5>Tanggal :
                    <?= $sevendays ?> s/d
                    <?= $today ?>
                </h5>
            </div>
        <?php elseif ($filter == '3'): ?>
            <?php
            $today = date('Y-m-d');
            $thirtydays = date('Y-m-d', strtotime('-30 day'));
            ?>
            <div style="text-align: center;">
                <h3>Rekap Transaksi 30 Hari Terakhir</h3>
            </div>
            <div>
                <h5>Tanggal :
                    <?= $thirtydays ?> s/d
                    <?= $today ?>
                </h5>
            </div>
        <?php elseif ($filter == '4'): ?>
            <?php
            $firstDayOfMonth = date('Y-m-01');
            $lastDayOfMonth = date('Y-m-t');
            ?>
            <div style="text-align: center;">
                <h3>Rekap Transaksi Bulan Ini</h3>
            </div>
            <div>
                <h5>Tanggal :
                    <?= $firstDayOfMonth ?> s/d
                    <?= $lastDayOfMonth ?>
                </h5>
            </div>
        <?php elseif ($filter == '5'): ?>
            <?php
            $firstDayOfLastMonth = date('Y-m-01', strtotime('first day of last month'));
            $lastDayOfLastMonth = date('Y-m-t', strtotime('last day of last month'));
            ?>
            <div style="text-align: center;">
                <h3>Rekap Transaksi Bulan Lalu</h3>
            </div>
            <div>
                <h5>Tanggal :
                    <?= $firstDayOfLastMonth ?> s/d
                    <?= $lastDayOfLastMonth ?>
                </h5>
            </div>
        <?php elseif ($filter == '6'): ?>
            <div style="text-align: center;">
                <h3>Rekap Transaksi Seluruhnya</h3>
            </div>

        <?php endif; ?>




        <table width="100%" style="border-collapse: collapse;">
            <thead style="background-color: #ccc; font-size: 12px;">
                <tr>
                    <th class="no" style="border: 1px solid black;">No</th>
                    <th class="tg-0pky" style="border: 1px solid black;">Kode</th>
                    <th class="quantity" style="border: 1px solid black;">Tanggal</th>
                    <th class="satuan" style="border: 1px solid black;">Total</th>
                    <th class="tg-0pky" style="border: 1px solid black;">Tipe</th>
                    <th class="tg-0pky" style="border: 1px solid black;">Kasir</th>
                </tr>
            </thead>
            <tbody style="font-size: 12px;">
                <?php
                $i = 1;
                ?>

                <?php foreach ($transaksi as $row): ?>
                    <tr>
                        <td class="no" style="border: 1px solid black; text-align: center;">
                            <?= $i++ ?>
                        </td>
                        <td class="tg-0pky" style="border: 1px solid black; text-align: center;">
                            <?= $row['kode'] ?>
                        </td>
                        <td class="tg-0pky" style="border: 1px solid black; text-align: center;">
                            <?= $row['created_at'] ?>
                        </td>
                        <td class="quantity" style="border: 1px solid black; text-align: center;">
                            <?= rupiah($row['nilai']) ?>
                        </td>
                        <td class="satuan" style="border: 1px solid black; text-align: center;">
                            <?= $row['tipe'] ?>
                        </td>
                        <td class="tg-0pky" style="border: 1px solid black; text-align: center;">
                            <?= $row['kasir'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

        <table width="55%" style="float: left; font-size:10;">

            <thead>
                <tr>
                    <td align="left"><small>
                            </br>
                            Total Penjualan : Rp.
                            <?= rupiah($rincianPenjualan['penjualan']) ?>
                            </br>
                            Total Penjualan Tunai : Rp.
                            <?= rupiah($rincianPenjualan['penjualan_tunai']) ?>
                            </br>
                            Total Penjualan Non Tunai : Rp.
                            <?= rupiah($rincianPenjualan['penjualan_non_tunai']) ?>
                            </br>
                            Total Retur Refund : Rp.
                            <?= rupiah($rincianPenjualan['retur']) ?>
                            </br>
                            Total Kas Masuk : Rp.
                            <?= rupiah($rincianKas['kas_masuk']) ?>
                            </br>
                            Total Kas Keluar : Rp.
                            <?= rupiah($rincianKas['kas_keluar']) ?>
                            </br>
                            <strong style="font-size:15px">
                                Total Transaksi : Rp.
                                <?= rupiah(($rincianPenjualan['penjualan'] + $rincianKas['kas_masuk']) - ($rincianPenjualan['retur'] + $rincianKas['kas_keluar'])) ?>
                            </strong>
                        </small>
                    </td>
                </tr>
            </thead>
        </table>

    </main>
    <!-- Within the aside tag we will put the terms and conditions which shall be shown below the estimate table. -->

    </div>

    <style>
        .page-break-before {
            page-break-before: always;
        }
    </style>
    </main>