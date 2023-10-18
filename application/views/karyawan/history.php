<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>History</title>
</head>

<body>
    <?php $this->load->view('components/sidebar_karyawan'); ?>
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
        </div>
        <div class="dash-content mx-auto">
            <div class="overview shadow p-1 mb-3 bg-body rounded ">
                <div class="title ">
                    <span class="text ">History Absensi</span>
                </div>
            </div>
            <div class="overview shadow p-1 mb-3     bg-body rounded">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Kegiatan</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Jam Masuk</th>
                            <th scope="col">Jam Pulang</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Pulang</th>
                            <th scope="col text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($absensi as $row): ?>
                            <tr>
                                <td><span class="number">
                                        <?php echo $i; ?>
                                    </span></td>
                                <td>
                                    <?php echo $row['kegiatan']; ?>
                                </td>
                                <td>
                                    <?php echo $row['date']; ?>
                                </td>
                                <td>
                                    <?php echo $row['jam_masuk']; ?>
                                </td>
                                <td>
                                    <span id="jam-pulang-<?php echo $i; ?>">
                                        <?php echo $row['jam_pulang']; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($row['keterangan_izin'])): ?>
                                        <p>Izin</p>
                                    <?php else: ?>
                                        <p>Masuk</p>
                                    <?php endif; ?>
                                </td>
                                <td>
                                <!-- <?php if (!empty($row['keterangan_izin'])): ?>
                                    <?php else: ?> -->
                                        <a href="javascript:setHomeTime(<?php echo $i; ?>);" class="btn btn-success <?php echo !empty(
                                               $row['keterangan_izin']
                                               )
                                               ? 'disabled'
                                               : ''; ?>">
                                            <i class="fa-solid fa-house"></i>
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                <td>
                                    <a href="<?php echo base_url('karyawan/ubah_absen/') .
                                        $row['id']; ?>" type="button" class="btn btn-primary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <!-- HAPUS -->
                                    <button onClick="hapus(<?php echo $row['id']; ?>)" type="button"
                                        class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>

                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <script>
        function hapus(id) {
            swal.fire({
                title: 'Yakin untuk menghapus data ini?',
                text: "Data ini akan terhapus permanen",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Dihapus',
                        showConfirmButton: false,
                        timer: 1500,

                    }).then(function () {
                        window.location.href = "<?php echo base_url('karyawan/hapus_karyawan/') ?>" + id;
                    });
                }
            });
        }
    </script>
</body>
<script>
    function setHomeTime(row) {
        var jamPulangElement = document.getElementById('jam-pulang-' + row);
        var pulangButton = document.getElementById('pulangBtn-' + row);

        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();
        var formattedTime = (hours < 10 ? "0" : "") + hours + ":" + (minutes < 10 ? "0" : "") + minutes + ":" + (
            seconds < 10 ? "0" : "") + seconds;

        jamPulangElement.textContent = formattedTime;

        // Simpan waktu di localStorage
        localStorage.setItem('jamPulang-' + row, formattedTime);

        // Nonaktifkan tombol home setelah ditekan
        var homeButton = document.querySelector('a[href="javascript:setHomeTime(' + row + ');"]');
        homeButton.classList.add('disabled');

        // Nonaktifkan tombol "Pulang" setelah tombol "Home" ditekan
        pulangButton.classList.add('disabled');
        pulangButton.onclick = null;
    }

    // Cek apakah waktu tersimpan di localStorage saat halaman dimuat
    window.addEventListener('load', function () {
        var rows = document.querySelectorAll('[id^=jam-pulang-]');

        rows.forEach(function (jamPulangElement) {
            var row = jamPulangElement.getAttribute('id').replace('jam-pulang-', '');
            var storedTime = localStorage.getItem('jamPulang-' + row);

            if (storedTime) {
                jamPulangElement.textContent = storedTime;

                // Nonaktifkan tombol "Pulang" jika tombol "Home" sudah ditekan
                var pulangButton = document.getElementById('pulangBtn-' + row);
                pulangButton.classList.add('disabled');
                pulangButton.onclick = null;

                // Nonaktifkan tombol "Home" jika tombol "Home" sudah ditekan
                var homeButton = document.querySelector('a[href="javascript:setHomeTime(' + row +
                    ');"]');
                homeButton.classList.add('disabled');
                homeButton.onclick = null;
            }
        });
    });
</script>

</html>