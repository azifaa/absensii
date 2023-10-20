<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Absensi</title>
</head>
<body>
    <?php $this->load->view('components/sidebar_karyawan'); ?>
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
        </div>
        <div class="dash-content">
            
            <div class="overview shadow-lg p-1 mb-3 bg-body rounded">
                <div class="title ">
                    <span class="text ">Update Absensi Karyawan</span>
                </div>
            </div>
            <?php echo $this->session->flashdata('message'); ?>
          
                <form action="<?php echo base_url('Karyawan/aksi_ubah_absen') ?>" method="post" enctype="multipart/form-data">
                    <div class="overview shadow-lg p-4 mb-3 bg-body rounded">
            <input type="hidden" name="id" value="<?php echo $absensi->id ?>">
            <div class="wrapper d-flex flex-column">
                <textarea id="kegiatan" name="kegiatan" placeholder="Kegiatan..." required><?php echo $absensi->kegiatan; ?></textarea>
            </div>
            <br>
            <button type="submit" class="btn btn-sm btn-dark text-white mb-3">Absensi</button>
        </div>
    </form>

    </section>
    
</body>
</html>