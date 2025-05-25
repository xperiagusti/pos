<div class="wrapper">
    <!--sidebar wrapper -->
    <div class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div>
                <img src="<?= base_url('uploads/logo_perusahaan/' . get_logo()) ?>" class="logo-icon" alt="logo icon">
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
                <a href="<?= base_url('/sibabad') ?>">
                    <div class="parent-icon"><i class='bx bx-home-alt'></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            <li>
                <a href="<?= base_url('sibabad/sale/index') ?>">
                    <div class="parent-icon"><i class='bx bx-cart'></i>
                    </div>
                    <div class="menu-title">Kasir</div>
                </a>
            </li>
            <li class="menu-label">Data Pembelian</li>
            <li>
                <a href="<?= base_url('sibabad/product/add-new') ?>">
                    <div class="parent-icon"><i class='bx bx-arrow-to-right'></i>
                    </div>
                    <div class="menu-title">Data Produk</div>
                </a>
            </li>
            
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-arrow-to-right'></i>
                    </div>
                    <div class="menu-title">Rekap Pembelian</div>
                </a>
                <ul>
                    <li><a href="<?= base_url('/sibabad/direct_order/index') ?>"><i class='bx bx-radio-circle'></i>Pembelian Langsung</a>
                    </li>
                    <li><a href="<?= base_url('/sibabad/recieve_order/index') ?>"><i class='bx bx-radio-circle'></i>Penerimaan Barang</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="<?= base_url('sibabad/stock-product/index') ?>">
                    <div class="parent-icon"><i class='bx bx-package'></i>
                    </div>
                    <div class="menu-title">Stok Produk</div>
                </a>
            </li>
            <li class="menu-label">Data Transaksi</li>
            <li>
                <a href="<?= base_url('sibabad/transaction-sale/index') ?>">
                    <div class="parent-icon"><i class='bx bx-receipt'></i>
                    </div>
                    <div class="menu-title">Rekap Transaksi</div>
                </a>
            </li>
            <!-- <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-file'></i>
                    </div>
                    <div class="menu-title">Pemb. Prosedural</div>
                </a>
                <ul>
                    <li><a href="<?= base_url('/sibabad/journal/input-transaction') ?>"><i class='bx bx-radio-circle'></i>Purchase Order (PO)</a>
                    </li>
                </ul>
                <ul>
                    <li><a href="<?= base_url('/sibabad/journal/input-transaction') ?>"><i class='bx bx-radio-circle'></i>Upload Proforma Invoice</a>
                    </li>
                </ul>
                <ul>
                    <li><a href="<?= base_url('/sibabad/journal/input-transaction') ?>"><i class='bx bx-radio-circle'></i>Pengajuan Transfer</a>
                    </li>
                </ul>
                <ul>
                    <li><a href="<?= base_url('/sibabad/journal/input-transaction') ?>"><i class='bx bx-radio-circle'></i>Rekap Transfer Pembelian</a>
                    </li>
                </ul>
                <ul>
                    <li><a href="<?= base_url('/sibabad/journal/input-transaction') ?>"><i class='bx bx-radio-circle'></i>Tracking Pesanan</a>
                    </li>
                </ul>
                <ul>
                    <li><a href="<?= base_url('/sibabad/journal/input-transaction') ?>"><i class='bx bx-radio-circle'></i>Pendataan Barang Datang</a>
                    </li>
                </ul>
            </li> -->
            <!-- <li class="menu-label">Finance Reports</li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-message-square-check'></i>
                    </div>
                    <div class="menu-title">Transaksi</div>
                </a>
                <ul>
                    <li> <a href="<?= base_url('/sibabad/reports/daily') ?>"><i class='bx bx-radio-circle'></i>Transaksi Harian</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="<?= base_url('/sibabad/coa/index') ?>">
                    <div class="parent-icon"><i class='bx bx-bar-chart-alt-2'></i>
                    </div>
                    <div class="menu-title">Chart Of Account (COA)</div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-file'></i>
                    </div>
                    <div class="menu-title">Jurnal Umum</div>
                </a>
                <ul>
                    <li> <a href="<?= base_url('/sibabad/journal/input-transaction') ?>"><i class='bx bx-radio-circle'></i>Tambah Data</a>
                    </li>
                    <li> <a href="<?= base_url('/sibabad/journal/reports') ?>"><i class='bx bx-radio-circle'></i>Lihat Laporan</a>
                    </li>
                </ul>
            </li> -->
            <li class="menu-label">Data</li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-user-plus'></i>
                    </div>
                    <div class="menu-title">Supplier</div>
                </a>
                <ul>
                    <li> <a href="<?= base_url('sibabad/supplier/index') ?>"><i class='bx bx-radio-circle'></i>Tambah Data</a>
                    </li>
                </ul>
            </li>
            <!-- <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-user-plus'></i>
                    </div>
                    <div class="menu-title">Gudang</div>
                </a>
                <ul>
                    <li> <a href="<?= base_url('sibabad/warehouse/index') ?>"><i class='bx bx-radio-circle'></i>Tambah
                            Data</a>
                    </li>
                </ul>
            </li> -->
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-user-plus'></i>
                    </div>
                    <div class="menu-title">Manage Karyawan</div>
                </a>
                <ul>
                    <li> <a href="<?= base_url('sibabad/karyawan/index') ?>"><i class='bx bx-radio-circle'></i>
                            Data Karyawan</a>
                    </li>
                    <li> <a href="<?= base_url('sibabad/shift/index') ?>"><i class='bx bx-radio-circle'></i>Tambah Data
                            Shift</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-user-plus'></i>
                    </div>
                    <div class="menu-title">User</div>
                </a>
                <ul>
                    <li> <a href="<?= base_url('sibabad/user/index') ?>"><i class='bx bx-radio-circle'></i>Tambah
                            Data</a>
                    </li>
                </ul>
            </li>
            <!-- <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class='bx bx-user-plus'></i>
                    </div>
                    <div class="menu-title">Gudang</div>
                </a>
                <ul>
                    <li> <a href="<?= base_url('sibabad/warehouse/index') ?>"><i class='bx bx-radio-circle'></i>Tambah Data</a>
                    </li>
                </ul>
            </li> -->
        </ul>
        <!--end navigation-->
    </div>