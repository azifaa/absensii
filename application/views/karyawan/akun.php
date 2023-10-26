<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        .img-account-profile {
            height: 10rem;
        }
        .rounded-circle {
            border-radius: 50% !important;
        }
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
        }
        .card .card-header {
            font-weight: 500;
        }
        .card-header:first-child {
            border-radius: 0.35rem 0.35rem 0 0;
        }
        .card-header {
            padding: 1rem 1.35rem;
            margin-bottom: 0;
            background-color: rgba(33, 40, 50, 0.03);
            border-bottom: 1px solid rgba(33, 40, 50, 0.125);
        }
        .form-control,
        .dataTable-input {
            display: block;
            width: 100%;
            padding: 0.875rem 1.125rem;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1;
            color: #69707a;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #c5ccd6;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.35rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .nav-borders .nav-link.active {
            color: #0061f2;
            border-bottom-color: #0061f2;
        }
        .nav-borders .nav-link {
            color: #69707a;
            border-bottom-width: 0.125rem;
            border-bottom-style: solid;
            border-bottom-color: transparent;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            padding-left: 0;
            padding-right: 0;
            margin-left: 1rem;
            margin-right: 1rem;
        }
        .navbar {
            position: relative !important;
        }
        body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007BFF;
            color: #fff;
        }
        .form-control {
            border: 1px solid #ced4da;
        }
        .form-control:focus {
            border-color: #007BFF;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .btn {
            background-color: #007BFF;
            color: #fff;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <!-- Navbar content goes here -->
    </nav>
    <div class="d-flex align-items-center">
        <div class="container my-5 m-6">
            <div class="row">
                <div class="col-xl-3">
                    <!-- Profile picture card -->
                    <div class="card mb-2 mb-xl-7">
                        <div class="card-header">Profile Picture</div>
                        <div class="card-body text-center">
                            <?php if (isset($user)): ?>
                                <img class="img-account-profile rounded-circle mb-2"
                                    src="<?php echo base_url('images/karyawan/' . $user->image); ?>" alt="Profile Picture">
                            <?php endif; ?>
                            <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                            <form action="<?php echo base_url('karyawan/aksi_ubah_foto') ?>" method="post" class="row"
                                enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Default file input example</label>
                                    <input class="form-control" type="file" name="image" id="image" accept="image/*">
                                </div>
                                <div id="image-preview" style="display: none;">
                                    <img id="preview" style="max-width: 100px; max-height: 100px;">
                                </div>
                                <button class="btn btn-dark" type="submit">Upload new image</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <!-- Account details card -->
                    <div class="card mb-3">
                        <div class="card-header">Account Details</div>
                        <div class="card-body">
                            <form action="<?php echo base_url('karyawan/aksi_ubah_akun') ?>" method="post" class="row"
                                enctype="multipart/form-data">
                                <!-- Form Group (username) -->
                                <div class="mb-2">
                                    <label class="small mb-1" for="inputUsername">Username</label>
                                    <input type="text" class="form-control" value="<?php echo $user->username ?>"
                                        id="username" name="username">
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                    <input type="text" value="<?php echo $user->email ?>" class="form-control"
                                        id="email" name="email">
                                </div>
                                <!-- Form Row -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (first name) -->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputFirstName">First name</label>
                                        <input type="text" class="form-control" value="<?php echo $user->nama_depan ?>"
                                            id="nama_depan" name="nama_depan">
                                    </div>
                                    <!-- Form Group (last name) -->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputLastName">Last name</label>
                                        <input type text" class="form-control"
                                            value="<?php echo $user->nama_belakang ?>" id="nama_belakang"
                                            name="nama_belakang">
                                    </div>
                                </div>
                                <h5>Ubah Password</h5>
                                <hr>
                                <div class="mb-3 col-md-12">
                                    <label for="password_lama" class="form-label">Password Lama</label>
                                    <input type="password" class="form-control" id="password_lama" name="password_lama">
                                    <div class="text-danger">
                                        <?php
                                        echo $this->session->flashdata('error_password_lama');
                                        ?>
                                    </div>
                                </div>
                                <!-- Form Row -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (organization name) -->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputOrgName">Password Baru</label>
                                        <input type="text" class="form-control" id="password_baru" name="password_baru">
                                    </div>
                                    <!-- Form Group (location) -->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputLocation">Konfirmasi Password</label>
                                        <input type="text" class="form-control" id="konfirmasi_password"
                                            name="konfirmasi_password">
                                    </div>
                                </div>
                                <!-- Save changes button -->
                                <button class="btn btn-dark" type="submit">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
// Memanggil fungsi ini saat gambar dipilih
document.getElementById("image").addEventListener("change", function () {
    var file = this.files[0];
    if (file) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var imagePreview = document.getElementById("image-preview");
            var preview = document.getElementById("preview");

            imagePreview.style.display = "block";
            preview.src = e.target.result;
        };

        reader.readAsDataURL(file);
    }
});
</script>
</body>
</html>
