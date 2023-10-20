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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Dashboard</title>
</head>
<body>
<?php $this->load->view('components/sidebar_karyawan'); ?>
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
        </div>
        <div class="dash-content mx-auto">
            <div class="overview shadow-lg p-1 mb-3 bg-body rounded">
                <div class="d-flex">

                    <div class="card  rounded " style="width: 16rem;height:11rem; margin-left:20px;">
                        <p class=" fs-6 text-white text-center p-3 bg-dark">Total <br> Masuk</p>

                        <p class=" fs-1 text-dark text-center">10</p>
                    </div>
                    <div class="card  rounded " style="width: 16rem;height:11rem; margin-left:20px;">
                        <p class=" fs-6 text-white text-center p-3 bg-dark">Total <br> Izin</p>

                        <p class=" fs-1 text-dark text-center">6</p>
                    </div>
                    <div class="card  rounded" style="width: 16rem;height:11rem; margin-left:20px;">
                        <p class=" fs-6 text-white text-center p-3 bg-dark">Total
                            <br>Keseluruhan
                        </p>
                        <p class=" fs-1 text-dark text-center">16</p>
                    </div>
                </div>
            </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>