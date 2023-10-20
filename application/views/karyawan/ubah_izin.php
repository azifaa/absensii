<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Ubah Izin</title>
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
                    <span class="text ">Update Izin Karyawan</span>
                </div>
            </div>
            <?php echo $this->session->flashdata('message'); ?>
            <?php foreach ($izin as $row):  $izin= $row->keterangan_izin;?>
            <form action="<?php echo base_url('Karyawan/aksi_ubah_izin') ?>" method="post"
                enctype="multipart/form-data">
                <div class="overview shadow-lg p-4 mb-3 bg-body rounded">
                    <input type="hidden" id="id" name="id" value="<?php echo $row->id ?>">

                    <div class="wrapper d-flex flex-column">

                        <textarea id="izin" name="izin" placeholder="  Izin karena..."
                            required><?php echo $izin; ?></textarea>
                    </div>
                    <br>
                    <button type="submit" class=" btn btn-sm btn-dark text-white mb-3">Izin</button>
                </div>
        </div>
        </form>
        <?php endforeach ?>
    </section>
</body>
</html>