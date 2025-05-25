<?= $this->extend('admin/templates/index-template') ?>
<?= $this->section('content') ?>

<div class="page-wrapper">
    <div class="page-content">
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
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Supplier</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('/symamin') ?>"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Data Supplier</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">Form Supplier</h5>
                <form class="row g-3" action="<?= base_url('sibabad/supplier/saveData') ?>" method="post" enctype="multipart/form-data">
                    <input name="id_supplier" type="hidden" value="<?= $sups['id_supplier'] ?>">
                    <div class="col-md-4">
                        <label for="clientName" class="form-label">Nama Supplier</label>
                        <input type="text" name="s_name" class="form-control" id="clientName" placeholder="Nama Supplier" value="<?= $sups['s_name'] ?>">
                        <?php if (session()->get('errors')) : ?>
                            <?php $errors = session()->get('errors'); ?>
                            <?php if (isset($errors['s_name'])) : ?>
                                <div class="alert alert-danger text-center">
                                    <?= $errors['s_name'] ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <label for="clientPABX" class="form-label">PABX</label>
                        <input type="text" name="s_pabx" class="form-control" id="clientPABX" placeholder="(024) - 7621681" value="<?= $sups['s_pabx'] ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="clientEmail" class="form-label">Email</label>
                        <input type="email" name="s_email" class="form-control" id="clientEmail" placeholder="alamat@mail.com" value="<?= $sups['s_email'] ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="picName" class="form-label">Nama PIC</label>
                        <input type="text" name="s_pic" class="form-control" id="picName" placeholder="Nama PIC" value="<?= $sups['s_pic'] ?>">
                        <?php if (session()->get('errors')) : ?>
                            <?php $errors = session()->get('errors'); ?>
                            <?php if (isset($errors['s_pic'])) : ?>
                                <div class="alert alert-danger text-center">
                                    <?= $errors['s_pic'] ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <label for="picContact" class="form-label">Kontak PIC</label>
                        <input type="text" name="s_pic_contact" class="form-control" id="picContact" placeholder="Kontak PIC" value="<?= $sups['s_pic_contact'] ?>">
                        <?php if (session()->get('errors')) : ?>
                            <?php $errors = session()->get('errors'); ?>
                            <?php if (isset($errors['s_pic_contact'])) : ?>
                                <div class="alert alert-danger text-center">
                                    <?= $errors['s_pic_contact'] ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <label for="clientType" class="form-label">Jenis Supplier</label>
                        <select name="s_type" id="clientType" class="form-select">
                            <option value="--" selected disabled><?= $sups['s_type'] ?></option>
                            <option value="Badan Usaha">Badan Usaha</option>
                            <option value="Perorangan">Perorangan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="clientNation" class="form-label">Negara</label>
                        <select id="clientNation" name="s_nation" class="form-select">
                            <option selected disabled><?= $sups['s_nation'] ?></option>
                            <option value="Indonesia">Indonesia</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="clientProvince" class="form-label">Provinsi</label>
                        <select id="clientProvince" name="s_province" class="form-select">
                            <option selected disabled><?= $sups['s_province'] ?></option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="clientCity" class="form-label">Kota</label>
                        <select id="clientCity" name="s_city" class="form-select">
                            <option selected disabled><?= $sups['s_city'] ?></option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="clientDistrict" class="form-label">Kecamatan</label>
                        <select id="clientDistrict" name="s_district" class="form-select">
                            <option selected disabled><?= $sups['s_district'] ?></option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="clientSubDistrict" class="form-label">Kelurahan</label>
                        <select id="clientSubDistrict" name="s_subdistrict" class="form-select">
                            <option selected disabled><?= $sups['s_subdistrict'] ?></option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="clientAddress" class="form-label">Alamat Perusahaan (Lengkap RT RW)</label>
                        <input type="text" name="s_address" class="form-control" id="clientAddress" placeholder="Alamat Supplier (Lengkap RT RW)" value="<?= $sups['s_address'] ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="clientZipCode" class="form-label">Kode Pos</label>
                        <input type="text" name="s_zip_code" class="form-control" id="clientZipCode" placeholder="Kode Pos" value="<?= $sups['s_zip_code'] ?>">
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="submit" class="btn btn-primary px-4">Simpan Data</button>
                            <button type="reset" class="btn btn-light px-4">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="col">
    <?php if (!empty($cust)) : ?>
        <div class="modal fade" id="modalHapus<?= $cust['id_customer'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin menghapus data ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <a type="button" class="btn btn-primary" href="<?= base_url('symamin/pelanggan/delete/') . $cust['id_customer'] ?>">Hapus Data</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        const inputNPWP = $('#clientNPWP');

        inputNPWP.on('input', function() {
            const inputValue = $(this).val().replace(/\D/g, ''); // Hanya menyimpan angka, menghapus karakter non-digit

            // Batasi jumlah karakter yang dapat dimasukkan (maksimal 20 karakter)
            const limitedValue = inputValue.substr(0, 20);

            // Format NPWP sesuai placeholder
            const formattedNPWP = formatNPWP(limitedValue);

            // Update nilai input
            $(this).val(formattedNPWP);
        });
    });

    function formatNPWP(npwp) {
        // Memformat sesuai placeholder
        let formatted = npwp.replace(/^(\d{0,2})?(\d{0,3})?(\d{0,3})?(\d{0,1})?(\d{0,3})?(\d{0,3})?(\d{0,2})?/, function(
            match,
            p1,
            p2,
            p3,
            p4,
            p5,
            p6,
            p7
        ) {
            let result = '';
            if (p1) result += p1;
            if (p2) result += '.' + p2;
            if (p3) result += '.' + p3;
            if (p4) result += '.' + p4;
            if (p5) result += '-' + p5;
            if (p6) {
                // Hapus spasi setelah 5 digit angka ke-6
                const p6WithoutSpaces = p6.replace(/\s/g, '');
                result += '.' + p6WithoutSpaces.slice(0, 3) + '.' + p6WithoutSpaces.slice(3, 6);
            }
            // Hapus titik di paling belakang jika ada
            result = result.replace(/\.$/, '');
            return result;
        });

        return formatted;
    }
</script>

<script>
    $(document).ready(function() {
        // Fungsi untuk mengisi select box dengan data provinsi
        function populateSelectBox(data) {
            var select = document.getElementById("clientProvince");
            if (data.length > 0) {
                data.forEach(function(province) {
                    var option = document.createElement("option");
                    option.value = province.name; // Menggunakan nama provinsi sebagai value
                    option.text = province.name;
                    option.dataset.provinceId = province.id; // Menyimpan provinsi_id sebagai data atribut
                    select.appendChild(option);
                });
            } else {
                var option = document.createElement("option");
                option.disabled = true;
                option.text = "Tidak ada data provinsi";
                select.appendChild(option);
            }
        }

        // Mengambil data provinsi dari API menggunakan fetch API
        fetch('https://api.goapi.id/v1/regional/provinsi', {
                method: 'GET',
                headers: {
                    'accept': 'application/json',
                    'X-API-KEY': 'xx9LHWjIklZ5jxmmcD1lLp6Twpk0Ys'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Memproses data provinsi dari "data" pada respons JSON
                var provinsi = data.data;
                populateSelectBox(provinsi);
            })
            .catch(error => {
                console.error("Error retrieving provinsi data:", error);
            });
    });

    $(document).ready(function() {
        function populateCitySelectBox(select, data) {
            select.empty();
            select.append(new Option("Pilih Kota", ""));
            $.each(data, function(index, city) {
                var option = new Option(city.name, city.name); // Use 'city.name' as the option text
                option.setAttribute("data-city-id", city.id); // Set a custom attribute to store the city ID
                select.append(option);
            });
        }

        function fetchCitiesByProvince(provinceId) {
            $.ajax({
                url: "https://api.goapi.id/v1/regional/kota",
                method: "GET",
                headers: {
                    'accept': 'application/json',
                    'X-API-KEY': 'xx9LHWjIklZ5jxmmcD1lLp6Twpk0Ys'
                },
                dataType: "json",
                data: {
                    provinsi_id: provinceId
                },
                success: function(data) {
                    var select = $("#clientCity");
                    populateCitySelectBox(select, data.data); // Panggil fungsi yang sesuai
                },
                error: function(xhr, status, error) {
                    console.error("Error retrieving city data:", error);
                }
            });
        }

        $("#clientProvince").change(function() {
            var selectedProvinceId = $(this).find(":selected").data("provinceId");
            if (selectedProvinceId) {
                fetchCitiesByProvince(selectedProvinceId);
            } else {
                var select = $("#clientCity");
                populateSelectBox(select, []);
            }
        });

    });

    $(document).ready(function() {
        function populateDistrictSelectBox(select, data) {
            select.empty();
            select.append(new Option("Pilih Kecamatan", ""));
            $.each(data, function(index, district) {
                var option = new Option(district.name, district.name); // Use 'district.name' as the option text
                option.setAttribute("data-district-id", district.id); // Set a custom attribute to store the district ID
                select.append(option);
            });
        }

        function fetchDistrictByCity(cityId) {
            $.ajax({
                url: "https://api.goapi.id/v1/regional/kecamatan",
                method: "GET",
                headers: {
                    'accept': 'application/json',
                    'X-API-KEY': 'xx9LHWjIklZ5jxmmcD1lLp6Twpk0Ys'
                },
                dataType: "json",
                data: {
                    kota_id: cityId
                },
                success: function(data) {
                    var select = $("#clientDistrict");
                    populateDistrictSelectBox(select, data.data); // Panggil fungsi yang sesuai
                },
                error: function(xhr, status, error) {
                    console.error("Error retrieving district data:", error);
                }
            });
        }

        $("#clientCity").change(function() {
            var selectedCityId = $(this).find(":selected").data("cityId");
            if (selectedCityId) {
                fetchDistrictByCity(selectedCityId);
            } else {
                var select = $("#clientDistrict");
                populateSelectBox(select, []);
            }
        });
    });

    $(document).ready(function() {
        function populateSelectBox(select, data) {
            select.empty();
            select.append(new Option("Pilih Kelurahan", ""));
            $.each(data, function(index, subdistrict) {
                var option = new Option(subdistrict.name, subdistrict.name); // Use 'subdistrict.name' as the option text
                option.setAttribute("data-subdistrict-name", subdistrict.name); // Set a custom attribute to store the subdistrict name
                select.append(option);
            });
        }

        function fetchSubDistrictByDistrict(districtId) {
            $.ajax({
                url: "https://api.goapi.id/v1/regional/kelurahan",
                method: "GET",
                headers: {
                    'accept': 'application/json',
                    'X-API-KEY': 'xx9LHWjIklZ5jxmmcD1lLp6Twpk0Ys'
                },
                dataType: "json",
                data: {
                    kecamatan_id: districtId
                },
                success: function(data) {
                    var select = $("#clientSubDistrict");
                    populateSelectBox(select, data.data);
                },
                error: function(xhr, status, error) {
                    console.error("Error retrieving subdistrict data:", error);
                }
            });
        }

        $("#clientDistrict").change(function() {
            var selectedDistrictName = $(this).find(":selected").data("districtId"); // Get the selected district ID
            if (selectedDistrictName) {
                fetchSubDistrictByDistrict(selectedDistrictName); // Fetch data berdasarkan district ID
            } else {
                var select = $("#clientSubDistrict");
                populateSelectBox(select, []);
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Fetch data from the server and populate the table
        $.ajax({
            url: '<?= site_url('sibabad/supplier/getDataSupplier') ?>',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                updateTable(data);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching supplier data:', status, error);
            }
        });
    });

    function updateTable(data) {
        const tbody = $('.tableSupplier');
        tbody.empty();

        data.forEach(item => {
            const row = `
            <tr data-supplier='${JSON.stringify(item)}'>
                <td>${item.s_name}</td>
                <td>${item.s_pabx}</td>
                <td>${item.s_pic}</td>
                <td>${item.s_pic_contact}</td>
                <td>${item.s_address}</td>
                <td>
    <a href="<?= base_url('sibabad/supplier/editData/') ?>${item.id_supplier}" class="btn btn-primary btn-sm"><span class="bx bx-pencil"></span></a>
</td>
            </tr>
        `;
            tbody.append(row);
        });
    }
</script>

<?= $this->endSection() ?>