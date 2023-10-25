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
                        <div class="btn-group" style="margin-top: 5px;">
                            <button type="submit" class="btn btn-info text-white"
                                style="margin-top: 10px;">Filter</button>
                        </div>

                        <a href="<?php echo base_url('Admin/export_rekap_harian'); ?>"
                            class="py-1 float-end bg-sky-400
          text-white bg-sky-500 hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center w-[250px] md:w-[250px]">
                            Export Data
                        </a>
                    </div>
                </div>

                <table class="my-4 w-full divide-y divide-gray-300 text-center">
                <thead class="bg-gray-50">
                        <tr>
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>KEGIATAN</th>
                            <th>TANGGAL</th>
                            <th>JAM MASUK</th>
                            <th>JAM PULANG</th>
                            <th>KETERANGAN IZIN</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-300">
                        <?php
                        $perhari = $this->m_model->getPerhariData(); // Mengambil data perhari dari model atau sumber data lain
                        $no = 0;
                        foreach ($perhari as $rekap):
                            $no++;
                            ?>
                            <tr class="whitespace-nowrap">
                                <td class="px-3 py-4 text-sm text-gray-500">
                                    <?php echo $no ?>
                                </td>
                                <td class="px-3 py-4">
                                <?= tampil_nama_karawan_byid($rekap->id_karyawan) ?>

                                </td>
                                <td class="px-3 py-4">
                                    <div>
                                    <?php echo $rekap->kegiatan; ?>
                                    </div>
                                </td>
                                <td class="px-3 py-4">
                                    <div>
                                        <?php echo $rekap->date; ?>
                                    </div>
                                </td>
                                <td class="px-3 py-4">
                                    <div>
                                        <?php echo $rekap->jam_masuk; ?>
                                    </div>
                                </td>
                                <td class="px-3 py-4">
                                    <div>
                                        <?php echo $rekap->jam_pulang; ?>
                                    </div>
                                </td>
                                <td class="px-3 py-4">
                                    <div>
                                        <?php echo $rekap->keterangan_izin; ?>
                                    </div>
                                </td>
                                <td class="px-3 py-4">
                                    <div>
                                        <?php echo $rekap->status; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <!-- HAPUS -->
            <script>
                function hapus(id) {
                    Swal.fire({
                        title: 'Apakah Kamu Ingin Menghapusnya?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?php echo base_url('admin/hapus_karyawan/') ?>" + id;
                        }
                    });
                }
            </script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <!-- LOGOUT -->
            <script>
                function confirmLogout() {
                    Swal.fire({
                        title: 'Yakin mau Logout?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Logout',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?php echo base_url('/auth') ?>";
                        }
                    });
                }
            </script>
</body>

</html>