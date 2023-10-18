<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Harian</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
</head>

<body>
<div class="relative min-h-screen md:flex" data-dev-hint="container">
    <?php $this->load->view('components/sidebar_admin')?>
    <main id="content" class="max-h-screen overflow-y-auto flex-1 p-6 lg:px-8">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 px-2 md:grid-cols-3 rounded-t-lg py-2.5 bg-stone-700 text-white text-xl">
                <div class="flex justify-center mb-2 md:justify-start md:pl-6">
                    REKAP HARIAN
                </div>
                <form action="<?php echo base_url('admin/rekap_harian') ?>" method="post">
                <div class="flex flex-wrap justify-center col-span-2 gap-2 md:justify-end md:mr-[-20em]">
                    <!-- Add the "id" attribute to the input element -->
                    <input type="date" id="tanggal" name="tanggal" class="text-black rounded-md border p-2">
                </div>
                </form>
                <a
              href="<?php echo base_url('Admin/export_rekap_harian'); ?>"
                class=" md:ml-[-4em] 
          text-white bg-sky-500 hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 pt-3  text-center w-[250px] md:w-[250px] mt-2 md:mt-0"
              >
                Export Data
              </a>
            </div>
            <div class="overflow-x-auto w-full px-4 bg-white rounded-b-lg shadow">
                <table class="my-4 w-full divide-y divide-gray-300 text-center">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-xs text-gray-500">NO</th>
                            <th class="px-3 py-2 text-xs text-gray-500">NAMA KARYAWAN</th>
                            <th class="px-3 py-2 text-xs text-gray-500">
                                KEGIATAN
                            </th>
                            <th class="px-3 py-2 text-xs text-gray-500">TANGGAL</th>
                            <th class="px-3 py-2 text-xs text-gray-500">JAM MASUK</th>
                            <th class="px-3 py-2 text-xs text-gray-500">JAM PULANG</th>
                            <th class="px-3 py-2 text-xs text-gray-500">KETERANGAN IZIN</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-300">
                        <?php $no = 0;foreach ($data_harian  as $row): $no++?>
                        <tr class="whitespace-nowrap">
                            <td class="px-3 py-4 text-sm text-gray-500"><?php echo $no ?></td>
                            <td class="px-3 py-4 text-sm text-gray-500 uppercase"><?php echo tampil_nama_karawan_byid($row->id_karyawan) ?></td>
                            <td class="px-3 py-4">
                                <div class="text-sm text-gray-900">
                                    <?php echo $row->kegiatan ?>
                                </div>
                            </td>
                            <td class="px-3 py-4">
                                <div class="text-sm text-gray-900">
                                    <?php echo $row->date ?>
                                </div>
                            </td>
                            <td class="px-3 py-4">
                                <div class="text-sm text-gray-900">
                                    <?php if ($row->jam_masuk == null) {
                                        echo '-';
                                    } else {
                                        echo $row->jam_masuk;
                                    }?>
                                </div>
                            </td>
                            <td class="px-3 py-4">
                                <div class="text-sm text-gray-900">
                                    <?php if ($row->jam_pulang == null) {
                                        echo '-';
                                    } else {
                                        echo $row->jam_pulang;
                                    }?>
                                </div>
                            </td>
                            <td class="px-3 py-4">
                                <div class="text-sm text-gray-900">
                                    <?php echo $row->keterangan_izin ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<script>
 document.addEventListener("DOMContentLoaded", function() {
    // Add an event listener for the "change" event on the select element
    var selectElement = document.getElementById('tanggal');
    var formElement = selectElement.form; // Get the parent form

    selectElement.addEventListener('change', function() {
        formElement.submit(); // Submit the form when the select element changes
    });
});
</script>

</body>

</html>