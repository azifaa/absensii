<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Karyawan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    .pagination {
      display: flex;
      justify-content: center;
      gap: 1rem;
    }

    .pagination a,
    .pagination strong {
      display: block;
      width: 2rem;
      height: 2rem;
      text-align: center;
      line-height: 2rem;
      border: 1px solid #ccc;
      background-color: #fff;
      border-radius: 4px;
      color: #333;
    }

    .pagination a:hover,
    .pagination strong {
      display: block;
      width: 2rem;
      height: 2rem;
      border: 1px solid #f9fafb;
      /* Ganti dengan warna sesuai kebutuhan Anda */
      background-color: #f9fafb;
      /* Ganti dengan warna sesuai kebutuhan Anda */
      text-align: center;
      line-height: 2rem;
      color: #fff;
    }
  </style>
</head>

<body>
  <div class="relative min-h-screen md:flex" data-dev-hint="container">
    <?php $this->load->view('components/sidebar_admin') ?>
    <main id="content" class="max-h-screen overflow-y-auto flex-1 p-6 lg:px-8">
      <div class="container mx-auto">
        <div class="grid grid-cols-1 px-2 md:grid-cols-3 rounded-t-lg py-2.5 bg-stone-700 text-white text-xl">
          <div class="flex justify-center mb-2 md:justify-start md:pl-6">
            DATA KARYAWAN
          </div>
          <div class="flex flex-wrap justify-center col-span-2 gap-2 md:justify-end">
            <a href="<?php echo base_url('Admin/exportToExcel'); ?>"
              class="py-1 float-end bg-sky-400
          text-white bg-sky-500 hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center w-[250px] md:w-[250px]">
              Export Data
            </a>
          </div>
        </div>
        <div class="overflow-x-auto w-full px-4 bg-white rounded-b-lg shadow">
          <table class="my-4 w-full divide-y divide-gray-300 text-center">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-3 py-2 text-xs text-gray-500">NO</th>
                <th class="px-3 py-2 text-xs text-gray-500">
                  NAMA KARYAWAN
                </th>
                <th class="px-3 py-2 text-xs text-gray-500">USERNAME</th>
                <!-- <th class="px-3 py-2 text-xs text-gray-500">AKSI</th> -->
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-300">
              <?php $no = 0;
              foreach ($karyawan as $row):
                $no++ ?>
                <tr class="whitespace-nowrap">
                  <td class="px-3 py-4 text-sm text-gray-500">
                    <?php echo $no ?>
                  </td>
                  <td class="px-3 py-4">
                    <div class="text-sm text-gray-900">
                      <?php echo $row->nama_depan . ' ' . $row->nama_belakang ?>
                    </div>
                  </td>
                  <td class="px-3 py-4">
                    <div class="text-sm text-gray-900">
                      <?php echo $row->username ?>
                    </div>
                  </td>
                  <td>
                    <!-- HAPUS -->
                    <!-- <button onClick="hapus(<?php echo $row->id ?>)" class="btn btn-sm btn-danger mx-1"><i
                        class="fa-solid fa-trash"></i></button> -->
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
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
            window.location.href = "<?php echo base_url('admin/hapus_data_karyawan/') ?>" + id;
          });
        }
      });
    }
  </script>

</body>

</html>