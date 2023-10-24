<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Harian</title>
    <!-- Perbarui URL CSS Font Awesome dan Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
</head>

<body>
    <div class="relative min-h-screen md:flex" data-dev-hint="container">
        <?php $this->load->view('components/sidebar_admin') ?>
        <main id="content" class="max-h-screen overflow-y-auto flex-1 p-6 lg:px-8">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 px-2 md:grid-cols-3 rounded-t-lg py-2.5 bg-stone-700 text-white text-xl">
                    <div class="flex justify-center mb-2 md:justify-start md:pl-6">
                        REKAP HARIAN
                        <form action="<?= base_url('admin/rekap_harian'); ?>" method="post">
                    </div>
                    <div class="flex flex-wrap justify-center col-span-2 gap-2 md:justify-end">
                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                            value="<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : ''; ?>"
                            style="width: 150px; margin: 0 auto;">
                    </div>
                    <br>
                    <div class="btn-group" style="margin-top: 5px;">
                        <button type="submit" class="btn btn-info text-black" style="margin-top: 10px;">Filter</button>

                        <a href="<?php echo base_url('Admin/export_rekap_harian'); ?>"
                            class="py-1 float-end bg-sky-400
          text-white bg-sky-500 hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center w-[250px] md:w-[250px]">
                            Export Data
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto w-full px-4 bg-white rounded-b-lg shadow">
                    <!-- Tampilkan data yang sesuai berdasarkan filter tanggal di sini -->
                    <table class="my-4 w-full divide-y divide-gray-300 text-center">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Kegiatan</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Jam Masuk</th>
                                <th scope="col">Jam Pulang</th>
                                <th scope="col">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-300">
                            <?php $no = 0;
                            foreach ($data_harian as $row):
                                $no++ ?>
                                <tr>
                                    <td>
                                        <?= $no; ?>
                                    </td>
                                    <td>
                                        <?php echo nama_karyawan($rekap->id_karyawan) ?>
                                    </td>
                                    <td>
                                        <?= convDate($rekap->date); ?>
                                    </td>
                                    <td>
                                        <?= $rekap->kegiatan; ?>
                                    </td>
                                    <td>
                                        <?= $rekap->jam_masuk; ?>
                                    </td>
                                    <td>
                                        <?= $rekap->jam_pulang; ?>
                                    </td>
                                    <td>
                                        <?= $rekap->keterangan_izin; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var selectElement = document.getElementById('tanggal');
            var selectedDateElement = document.getElementById('selected-date');

            // Fungsi untuk menampilkan tanggal yang dipilih
            function displaySelectedDate() {
                var selectedOption = selectElement.options[selectElement.selectedIndex];
                selectedDateElement.textContent = selectedOption ? selectedOption.text : '';
            }

            // Panggil fungsi displaySelectedDate saat halaman dimuat
            displaySelectedDate();

            selectElement.addEventListener('change', function () {
                // Jika pemilihan tanggal berubah, panggil fungsi displaySelectedDate
                displaySelectedDate();
                selectElement.form.submit();
            });
        });
    </script>

</body>

</html>