<div class="wrapper">
    <!--sidebar wrapper -->
    <div class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div>
                <img src="<?= base_url('uploads/logo_perusahaan/' . get_logo()) ?>" class=" logo-icon" alt="logo icon">
            </div>
            <div>
                <h4 class="logo-text"><?= get_nama_perusahaan() ?></h4>
            </div>
            <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
            </div>
        </div>
        <!--navigation-->
        <ul class="metismenu" id="menu">
            <li>
                <a href="<?= base_url('sibabad2') ?>">
                    <div class="parent-icon"><i class='bx bx-cart'></i>
                    </div>
                    <div class="menu-title">Kasir</div>
                </a>
            </li>
            <!-- <li class="menu-label">Data Pembelian</li>
            <li>
                <a href="<?= base_url('sibabad2/product/add-new') ?>">
                    <div class="parent-icon"><i class='bx bx-arrow-to-right'></i>
                    </div>
                    <div class="menu-title">Data Produk</div>
                </a>
            </li> -->
            <!-- <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-arrow-to-right'></i>
                    </div>
                    <div class="menu-title">Rekap Pembelian</div>
                </a>
                <ul>
                    <li><a href="<?= base_url('/sibabad2/direct_order/index') ?>"><i
                                class='bx bx-radio-circle'></i>Pembelian Langsung</a>
                    </li>
                    <li><a href="<?= base_url('/sibabad2/recieve_order/index') ?>"><i
                                class='bx bx-radio-circle'></i>Penerimaan Barang</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="<?= base_url('sibabad2/stock-product/index') ?>">
                    <div class="parent-icon"><i class='bx bx-package'></i>
                    </div>
                    <div class="menu-title">Stok Produk</div>
                </a>
            </li>
            <li class="menu-label">Data Penjualan</li>
            <li>
                <a href="<?= base_url('sibabad2/transaction-sale/index') ?>">
                    <div class="parent-icon"><i class='bx bx-receipt'></i>
                    </div>
                    <div class="menu-title">Invoice Penjualan</div>
                </a>
            </li> -->
        </ul>
        <!--end navigation-->
    </div>