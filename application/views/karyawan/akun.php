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
<body>
<?php $this->load->view('components/sidebar_all'); ?>
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
</body>
</html>