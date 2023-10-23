<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Sesuaikan dengan path file CSS Anda -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php $this->load->view('components/sidebar_karyawan'); ?>
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
        </div>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="fs-6 text-center p-3 bg-dark text-white">Total Masuk</p>
                            <p class="fs-1 text-center text-dark">10</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="fs-6 text-center p-3 bg-dark text-white">Total Izin</p>
                            <p class="fs-1 text-center text-dark">6</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="fs-6 text-center p-3 bg-dark text-white">Total Keseluruhan</p>
                            <p class="fs-1 text-center text-dark">16</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="overview shadow p-3 bg-body rounded">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Karyawan</th>
                            <th scope="col">Kegiatan</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Jam Masuk</th>
                            <th scope="col">Jam Pulang</th>
                            <th scope="col">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($absensi as $row): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td> <?php echo tampil_nama_karawan_byid($row->id_karyawan) ?></td>
                                <td><?php echo $row->kegiatan; ?></td>
                                <td><?php echo $row->date; ?></td>
                                <td><?php echo $row->jam_masuk; ?></td>
                                <td><span id="jam-pulang-<?php echo $i; ?>"><?php echo $row->jam_pulang; ?></span></td>
                                <td>
                                    <?php if (!empty($row->keterangan_izin)): ?>
                                        Izin
                                    <?php else: ?>
                                        Masuk
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>
