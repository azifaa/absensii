<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Bulanan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

</head>

<body>
    <div class="relative min-h-screen md:flex" data-dev-hint="container">
        <?php $this->load->view('components/sidebar_admin') ?>
        <main id="content" class="max-h-screen overflow-y-auto flex-1 p-6 lg:px-8">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 px-2 md:grid-cols-3 rounded-t-lg py-2.5 bg-stone-700 text-white text-xl">
                    <div class="flex justify-center mb-2 md:justify-start md:pl-6">
                        REKAP BULANAN
                    </div>
                    <form action="<?= base_url('admin/rekap_bulanan'); ?>" method="post">
                        <div class="text-center">
                            <div class="text-center"
                                style="display: flex; justify-content: space-between; align-items: center;">
                                <div style="position: relative;">
                                <a href="<?php echo base_url('Admin/export_rekap_bulanan'); ?>"
                                    class="py-1 float-end bg-sky-400
                text-white bg-sky-500 hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center w-[250px] md:w-[250px] mt-2 md:mt-0">
                                    Export Data
                                </a>
                                </div>
                                <select class="form-control" id="bulan" name="bulan"
                                    style="width: 150px; color: black;">
                                    <option>Pilih Bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="overflow-x-auto w-full px-4 bg-white rounded-b-lg shadow">
                    <table class="my-4 w-full divide-y divide-gray-300 text-center">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-xs text-gray-500">NO</th>
                                <th class="px-3 py-2 text-xs text-gray-500">NAMA KARYAWAN</th>
                                <th class="px-3 py-2 text-xs text-gray-500">
                                    KEGIATAN
                                </th>
                                <th class="px-3 py-2 text-xs text-gray-500">TANGGAL</th>
                                <th class="px-3 py-2 text-xs text-gray-500">JAM MASUK</th>
                                <th class="px-3 py-2 text-xs text-gray-500">JAM PULANG</th>
                                <th class="px-3 py-2 text-xs text-gray-500">KETERANGAN IZIN</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-300">
                            <?php $no = 0;
                            foreach ($absensi as $rekap):
                                $no++ ?>
                                <tr class="whitespace-nowrap">
                                    <td class="px-3 py-4 text-sm text-gray-500">
                                        <?php echo $no ?>
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-500 uppercase">
                                        <?php echo tampil_nama_karawan_byid($rekap->id_karyawan) ?>
                                    </td>
                                    <td class="px-3 py-4">
                                        <div class="text-sm text-gray-900">
                                            <?php echo $rekap->kegiatan ?>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4">
                                        <div class="text-sm text-gray-900">
                                            <?php echo $rekap->date ?>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4">
                                        <div class="text-sm text-gray-900">
                                            <?php if ($rekap->jam_masuk == null) {
                                                echo '-';
                                            } else {
                                                echo $rekap->jam_masuk;
                                            } ?>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4">
                                        <div class="text-sm text-gray-900">
                                            <?php if ($rekap->jam_pulang == null) {
                                                echo '-';
                                            } else {
                                                echo $rekap->jam_pulang;
                                            } ?>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4">
                                        <div class="text-sm text-gray-900">
                                            <?php echo $rekap->keterangan_izin ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Add an event listener for the "change" event on the select element
            var selectElement = document.getElementById('bulan');
            var formElement = selectElement.form; // Get the parent form

            selectElement.addEventListener('change', function () {
                formElement.submit(); // Submit the form when the select element changes
            });
        });
    </script>

</body>

</html>