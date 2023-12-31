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

                    <span class="text ">Absensi Karyawan</span>

                </div>
            </div>
            <?php echo $this->session->flashdata('message'); ?>
            <form action="<?php echo base_url('Karyawan/save_absensi') ?>" method="post" enctype="multipart/form-data">
                <div class="overview shadow-lg p-4 mb-3 bg-body rounded">
                    <div class="wrapper d-flex flex-column">

                        <textarea id="kegiatan" name="kegiatan" placeholder="  Kegiatan..." required></textarea>
                    </div>
                    <br>
                    <button type="submit" class=" btn btn-sm btn-dark text-white mb-3">Absensi</button>
                </div>
        </div>
        </form>
    </section>
</body>
</html>