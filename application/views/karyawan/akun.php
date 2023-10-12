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

    <title>Profile Account</title>
</head>
<style>
    /* ===== Google Font Import - Poppins ===== */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    :root {
        /* ===== Colors ===== */
        --primary-color: #0E4BF1;
        --panel-color: #FFF;
        --text-color: #000;
        --black-light-color: #707070;
        --border-color: #e6e5e5;
        --toggle-color: #DDD;
        --box1-color: #4DA3FF;
        --box2-color: #FFE6AC;
        --box3-color: #E7D1FC;
        --title-icon-color: #fff;

        /* ====== Transition ====== */
        --tran-05: all 0.5s ease;
        --tran-03: all 0.3s ease;
        --tran-03: all 0.2s ease;
    }

    body {
        min-height: 100vh;
        background-color: var(--primary-color);
    }

    body.dark {
        --primary-color: #3A3B3C;
        --panel-color: #242526;
        --text-color: #CCC;
        --black-light-color: #CCC;
        --border-color: #4D4C4C;
        --toggle-color: #FFF;
        --box1-color: #3A3B3C;
        --box2-color: #3A3B3C;
        --box3-color: #3A3B3C;
        --title-icon-color: #CCC;
    }

    /* === Custom Scroll Bar CSS === */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #0b3cc1;
    }

    body.dark::-webkit-scrollbar-thumb:hover,
    body.dark .activity-data::-webkit-scrollbar-thumb:hover {
        background: #3A3B3C;
    }

    nav {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 250px;
        padding: 10px 14px;
        background-color: var(--panel-color);
        border-right: 1px solid var(--border-color);
        transition: var(--tran-05);
    }

    nav.close {
        width: 73px;
    }

    nav .logo-name {
        display: flex;
        align-items: center;
    }

    nav .logo-image {
        display: flex;
        justify-content: center;
        min-width: 45px;
    }

    nav .logo-image img {
        width: 40px;
        object-fit: cover;
        border-radius: 50%;
    }

    nav .logo-name .logo_name {
        font-size: 22px;
        font-weight: 600;
        color: var(--text-color);
        margin-left: 14px;
        transition: var(--tran-05);
    }

    nav.close .logo_name {
        opacity: 0;
        pointer-events: none;
    }

    nav .menu-items {
        margin-top: 40px;
        height: calc(100% - 90px);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .menu-items li {
        list-style: none;
    }

    .menu-items li a {
        display: flex;
        align-items: center;
        height: 50px;
        text-decoration: none;
        position: relative;
    }

    .nav-links li a:hover:before {
        content: "";
        position: absolute;
        left: -7px;
        height: 5px;
        width: 5px;
        border-radius: 50%;
        background-color: var(--primary-color);
    }

    body.dark li a:hover:before {
        background-color: var(--text-color);
    }

    .menu-items li a i {
        font-size: 24px;
        min-width: 45px;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--black-light-color);
    }

    .menu-items li a .link-name {
        font-size: 18px;
        font-weight: 400;
        color: var(--black-light-color);
        transition: var(--tran-05);
    }

    nav.close li a .link-name {
        opacity: 0;
        pointer-events: none;
    }

    .nav-links li a:hover i,
    .nav-links li a:hover .link-name {
        color: var(--primary-color);
    }

    body.dark .nav-links li a:hover i,
    body.dark .nav-links li a:hover .link-name {
        color: var(--text-color);
    }

    .menu-items .logout-mode {
        padding-top: 10px;
        border-top: 1px solid var(--border-color);
    }

    .menu-items .mode {
        display: flex;
        align-items: center;
        white-space: nowrap;
    }

    .menu-items .mode-toggle {
        position: absolute;
        right: 14px;
        height: 50px;
        min-width: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .mode-toggle .switch {
        position: relative;
        display: inline-block;
        height: 22px;
        width: 40px;
        border-radius: 25px;
        background-color: var(--toggle-color);
    }

    .switch:before {
        content: "";
        position: absolute;
        left: 5px;
        top: 50%;
        transform: translateY(-50%);
        height: 15px;
        width: 15px;
        background-color: var(--panel-color);
        border-radius: 50%;
        transition: var(--tran-03);
    }

    body.dark .switch:before {
        left: 20px;
    }

    .dashboard {
        position: relative;
        left: 250px;
        background-color: var(--panel-color);
        min-height: 100vh;
        width: calc(100% - 250px);
        padding: 10px 14px;
        transition: var(--tran-05);
    }

    nav.close~.dashboard {
        left: 73px;
        width: calc(100% - 73px);
    }

    .dashboard .top {
        position: fixed;
        top: 0;
        left: 250px;
        display: flex;
        width: calc(100% - 250px);
        justify-content: space-between;
        align-items: center;
        padding: 10px 14px;
        background-color: var(--panel-color);
        transition: var(--tran-05);
        z-index: 10;
    }

    nav.close~.dashboard .top {
        left: 73px;
        width: calc(100% - 73px);
    }

    .dashboard .top .sidebar-toggle {
        font-size: 26px;
        color: var(--text-color);
        cursor: pointer;
    }

    .dashboard .top .search-box {
        position: relative;
        height: 45px;
        max-width: 600px;
        width: 100%;
        margin: 0 30px;
    }



    .top img {
        width: 40px;
        border-radius: 50%;
    }

    .dashboard .dash-content {
        padding-top: 50px;
    }

    .dash-content .title {
        display: flex;
        align-items: center;
        margin: 60px 0 30px 0;
    }

    .dash-content .title i {
        position: relative;
        height: 35px;
        width: 35px;
        background-color: var(--primary-color);
        border-radius: 6px;
        color: var(--title-icon-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .dash-content .title .text {
        font-size: 24px;
        font-weight: 500;
        color: dark;
        margin-left: 10px;
    }

    .dash-content .boxes {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .dash-content .boxes .box {
        display: flex;
        flex-direction: column;
        align-items: center;
        border-radius: 12px;
        width: calc(100% / 3 - 15px);
        padding: 15px 20px;
        background-color: var(--box1-color);
        transition: var(--tran-05);
    }

    .boxes .box i {
        font-size: 35px;
        color: var(--text-color);
    }

    .boxes .box .text {
        white-space: nowrap;
        font-size: 18px;
        font-weight: 500;
        color: var(--text-color);
    }

    .boxes .box .number {
        font-size: 40px;
        font-weight: 500;
        color: var(--text-color);
    }

    .boxes .box.box2 {
        background-color: var(--box2-color);
    }

    .boxes .box.box3 {
        background-color: var(--box3-color);
    }

    .dash-content .activity .activity-data {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .activity .activity-data {
        display: flex;
    }

    .activity-data .data {
        display: flex;
        flex-direction: column;
        margin: 0 15px;
    }

    .activity-data .data-title {
        font-size: 20px;
        font-weight: 500;
        color: var(--text-color);
    }

    .activity-data .data .data-list {
        font-size: 18px;
        font-weight: 400;
        margin-top: 20px;
        white-space: nowrap;
        color: var(--text-color);
    }

    @media (max-width: 1000px) {
        nav {
            width: 73px;
        }

        nav.close {
            width: 250px;
        }

        nav .logo_name {
            opacity: 0;
            pointer-events: none;
        }

        nav.close .logo_name {
            opacity: 1;
            pointer-events: auto;
        }

        nav li a .link-name {
            opacity: 0;
            pointer-events: none;
        }

        nav.close li a .link-name {
            opacity: 1;
            pointer-events: auto;
        }

        nav~.dashboard {
            left: 73px;
            width: calc(100% - 73px);
        }

        nav.close~.dashboard {
            left: 250px;
            width: calc(100% - 250px);
        }

        nav~.dashboard .top {
            left: 73px;
            width: calc(100% - 73px);
        }

        nav.close~.dashboard .top {
            left: 250px;
            width: calc(100% - 250px);
        }

        .activity .activity-data {
            overflow-X: scroll;
        }
    }

    @media (max-width: 780px) {
        .dash-content .boxes .box {
            width: calc(100% / 2 - 15px);
            margin-top: 15px;
        }
    }

    @media (max-width: 560px) {
        .dash-content .boxes .box {
            width: 100%;
        }
    }

    @media (max-width: 400px) {
        nav {
            width: 0px;
        }

        nav.close {
            width: 73px;
        }

        nav .logo_name {
            opacity: 0;
            pointer-events: none;
        }

        nav.close .logo_name {
            opacity: 0;
            pointer-events: none;
        }

        nav li a .link-name {
            opacity: 0;
            pointer-events: none;
        }

        nav.close li a .link-name {
            opacity: 0;
            pointer-events: none;
        }

        nav~.dashboard {
            left: 0;
            width: 100%;
        }

        nav.close~.dashboard {
            left: 73px;
            width: calc(100% - 73px);
        }

        nav~.dashboard .top {
            left: 0;
            width: 100%;
        }

        nav.close~.dashboard .top {
            left: 0;
            width: 100%;
        }
    }
</style>

<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
            <img src="images/logo.png" alt="">
            </div>

            <span class="logo_name">Karyawan</span>
        </div>


        <div class="menu-items">
            <ul class="nav-links" style="padding-left:16px;">
                <li><a href="<?php echo base_url('karyawan/index') ?>">
                        <i class="fa-solid fa-house"></i>
                        <span class="link-name">Dashboard</span>
                    </a></li>

                <li><a href="<?php echo base_url('karyawan/history') ?>">
                        <i class="fa-solid fa-clock-rotate-left"></i>

                        <span class="link-name">History Absensi</span>
                    </a></li>
                <li><a href="<?php echo base_url('karyawan/absensi') ?>">
                <i class="fa-regular fa-calendar-days"></i>
                        <span class="link-name">Absensi</span>
                    </a></li>
                <li><a href="<?php echo base_url('karyawan/izin') ?>">
                        <i class="fa-solid fa-i"></i>
                        <span class="link-name">Izin</span>
                    </a></li>

                <li><a href="<?php echo base_url('karyawan/akun') ?>">
                        <i class="fa-solid fa-circle-user"></i>
                        <span class="link-name">Edit Profil</span>
                    </a></li>
                <hr>
                <li class="logout-mode  ">

                <li>

                    <span id="clock" name="date" class="text-white link-name"> </span>

                </li>
                <li>
                    <span id="clock2" name="date2" class="text-dark link-name"> </span>
                </li>

                <li><button class="btn btn-lg p-4.5rem  " onclick="logout(id)">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span class="link-name">Keluar</span>
                    </button>

                </li>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>


        </div>

        <div class="dash-content">

            <div class="overview shadow-lg p-1 mb-3 bg-body rounded">
                <div class="title ">

                    <span class="text ">Profile Account</span>

                </div>
            </div>
            <div class="overview shadow-lg p-1 mb-3 bg-body rounded">

                <?php $no = 0;
                foreach ($user as $row):
                    $no++ ?>


                    <div class="  w-100 m-auto p-3 ">

                        <br>
                        <div>
                            <?php $this->session->flashdata('message') ?>
                        </div>
                        <div class="row d-flex">
                            <center>
                                <button class="border border-0 btn btn-link" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <?php if (!empty($row->foto)): ?>
                                        <img class="rounded-circle" height="150" width="150"
                                            src="<?php echo base64_decode($row->foto); ?>">
                                    <?php else: ?>
                                        <img class="rounded-circle" height="150" width="150"
                                            src="https://slabsoft.com/wp-content/uploads/2022/05/pp-wa-kosong-default.jpg" />
                                    <?php endif; ?>
                                </button>
                            </center>
                            <br>
                            <br>
                            <form method="post" action="<?php echo base_url('admin/aksi_ubah_password') ?>"
                                enctype="multipart/form_data">
                                <input name="id_siswa" type="hidden" value="<?php echo $row->id ?>">
                                <div class="d-flex flex-row ">

                                    <div class="p-2 col-6">
                                        <label for="" class="form-label fs-5 ">Email </label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                                            value="<?php echo $row->email ?>">
                                    </div>
                                    <div class="p-2 col-6">
                                        <label for="" class="form-label fs-5">Username </label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            placeholder="Username" value="<?php echo $row->username ?>">
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="d-flex flex-row ">
                                    <div class="p-2 col-6 >
                    <label for=" nama="" class="form-label fs-5">Password Baru </label>
                                        <input type="text" class="form-control" id="password_baru" name="password_baru"
                                            placeholder="Password Baru" value=>
                                    </div>
                                    <div class="p-2 col-6 >
                    <label for=" nama="" class="form-label fs-5"> Konfirmasi </label>
                                        <input type="text" class="form-control" id="password_konfirmasi"
                                            name="password_konfirmasi" placeholder="Konfirmasi Paswword" value=>
                                    </div>
                                </div>
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Foto Profile</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="container w-75 m p-3">
                                                <form method="post"
                                                    action="<?php echo base_url('karyawan/upload_image'); ?>"
                                                    enctype="multipart/form-data" class="row">
                                                    <div class="mb-3 col-12">
                                                        <label for="nama" class="form-label">Foto:</label>
                                                        <input type="hidden" class="form-control" id="id" name="id"
                                                            value="<?php echo $this->session->userdata('id'); ?>">
                                                        <input type="hidden" name="base64_image" id="base64_image">
                                                        <input class="form-control" type="file" name="userfile"
                                                            id="userfile" accept="image/*">
                                                    </div>
                                                    <div class="col-12 text-end">
                                                        <input type="submit" class="btn btn-sm btn-primary px-3"
                                                            name="submit" value="Ubah Foto"></input>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-danger"
                                                    href="<?php echo base_url('karyawan/hapus_image'); ?>">Hapus
                                                    Foto</a>
                                            </div>

                                        </div>

                                    </div>







                                </div>
                                <div class="flex justify-content-between">

                                    <div>
                                        <button type="submit" class="btn btn-sm btn-dark" name=" submit">Confirm</button>
                                    </div>
                                </div>

                            </form>
                        <?php endforeach ?>
                    </div>
    </section>

    <script src="script.js"></script>
    <script>
        const body = document.querySelector("body"),
            modeToggle = body.querySelector(".mode-toggle");
        sidebar = body.querySelector("nav");
        sidebarToggle = body.querySelector(".sidebar-toggle");

        let getMode = localStorage.getItem("mode");
        if (getMode && getMode === "dark") {
            body.classList.toggle("dark");
        }

        let getStatus = localStorage.getItem("status");
        if (getStatus && getStatus === "close") {
            sidebar.classList.toggle("close");
        }

        modeToggle.addEventListener("click", () => {
            body.classList.toggle("dark");
            if (body.classList.contains("dark")) {
                localStorage.setItem("mode", "dark");
            } else {
                localStorage.setItem("mode", "light");
            }
        });

        sidebarToggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");
            if (sidebar.classList.contains("close")) {
                localStorage.setItem("status", "close");
            } else {
                localStorage.setItem("status", "open");
            }
        })
    </script>
</body>
<script>
    function logout(id) {
        swal.fire({
            title: ' Yakin Ingin Log Out',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Log Out'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Log Out',
                    showConfirmButton: false,
                    timer: 1500,

                }).then(function () {
                    window.location.href = "<?php echo base_url('auth/logout/') ?>" + id;
                });
            }
        });
    }
</script>

</html>