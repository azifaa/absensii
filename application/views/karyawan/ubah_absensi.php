<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Izin Karyawan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/your/custom.css">
</head>
<body>
    <?php $this->load->view('components/sidebar_all'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">Ubah Absensi</h1>
                        <form action="<?= base_url('karyawan/ubah_absensi/' . $absen_id); ?>" method="post">
                            <div class="mb-3">
                                <label for="kegiatan" class="form-label">Kegiatan:</label>
                                <input type="text" class="form-control" id="kegiatan" name="kegiatan" value="<?= $absensi->kegiatan; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="jam_masuk" class="form-label">Jam Masuk:</label>
                                <input type="text" class="form-control" id="jam_masuk" name="jam_masuk" value="<?= $absensi->jam_masuk; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="path/to/your/custom.js"></script>
</body>
</html>