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
        <?php if (empty($date['tipe'])): ?>
            <div style="text-align: center;">
                <h3>Rekap Semua Transaksi</h3>
            </div>
            <div>
                <h5>Tanggal :
                    <?= $date['waktu_start'] ?> s/d <?= $date['waktu_end'] ?>
                </h5>
            </div>
        <?php else: ?>
            <div style="text-align: center;">
                <h3>Rekap Transaksi <?= $date['tipe'] ?></h3>
            </div>
            <div>
                <h5>Tanggal :
                    <?= $date['waktu_start'] ?> s/d <?= $date['waktu_end'] ?>
                </h5>
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
                    <th class="tg-0pky" style="border: 1px solid black;">Admin</th>
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
                            Total Pembelian / Purchase Order : Rp.
                            <?= rupiah($total_pembelian['total_po']) ?>
                            </br>
                            
                            Total Penjualan : Rp.
                            <?= rupiah($total_sale_retur['penjualan']) ?>
                            </br>
                            Total Penjualan Tunai : Rp.
                            <?= rupiah($total_sale_retur['penjualan_tunai']) ?>
                            </br>
                            Total Penjualan Non Tunai : Rp.
                            <?= rupiah($total_sale_retur['penjualan_non_tunai']) ?>
                            </br>
                            Total Retur Refund : Rp.
                            <?= rupiah($total_sale_retur['retur']) ?>
                            </br>
                            Total Kas Masuk : Rp.
                            <?= rupiah($total_kas['kas_masuk']) ?>
                            </br>
                            Total Kas Keluar : Rp.
                            <?= rupiah($total_kas['kas_keluar']) ?>
                            </br>
                            <strong style="font-size:15px">
                                Total Pendapatan : Rp.
                                <?= rupiah($total_income['total_income'] + $total_kas['kas_masuk'] - $total_kas['kas_keluar'] - $total_pembelian['total_po']) ?>
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