<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
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
            border: 1px solid #504099;
            background-color: #3b82f6;
            text-align: center;
            line-height: 2rem;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="relative min-h-screen md:flex" data-dev-hint="container">
    <?php $this->load->view('components/sidebar_admin'); ?>
    <main id="content" class="max-h-screen overflow-y-auto flex-1 p-6 lg:px-8">
        <div class="container mx-auto">
            <div class="grid gap-6 mb-2 mt-2 md:grid-cols-2">
                <div class="py-2 bg-white">
                    <p class="text-md text-center font-medium">
                        TOTAL KARYAWAN
                    </p>
                    <div class="text-3xl text-center text-black-700 font-semibold mb-2">
                        <span class="fa-stack fa-xs">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa-solid fa-person fa-stack-1x fa-inverse"></i>
                        </span>
                        <?php echo $karyawan; ?> Orang
                    </div>
                </div>
                <div class="py-2 bg-white">
                    <p class="text-md text-center font-medium">
                        TOTAL ABSEN
                    </p>
                    <div class="text-3xl text-center text-black-700 font-semibold mb-2">
                        <span class="fa-stack fa-xs">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa-solid fa-book fa-stack-1x fa-inverse"></i>
                        </span>
                        <?php echo $absen; ?> Kali
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 px-2 md:grid-cols-3 rounded-t-lg py-2.5 bg-stone-700 text-white text-xl">
                <div class="flex justify-center mb-2 md:justify-start md:pl-6">
                    REKAP KESELURUHAN
                </div>
                <div class="flex flex-wrap justify-center col-span-2 gap-2 md:justify-end">
              <a
              href="<?php echo base_url('Admin/export_rekap'); ?>"
                class="py-1 float-end bg-sky-400
          text-white bg-sky-500 hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center w-[250px] md:w-[250px]"
              >
                Export Data
              </a>
            </div>
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
                            <th class="px-3 py-2 text-xs text-gray-500">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-300">
                        <?php $no = 0;foreach ($data_keseluruhan  as $row): $no++?>
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
                            <td class="px-3 py-4">
                      <div class="text-sm text-gray-900 uppercase">
                      <?php echo $row->status?>
                      </div>
                    </td>
                        </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
                <div class="rounded-b-lg border-t border-gray-200 px-4 py-2">
            <?php echo $links; ?>
                </div>
          </div>
        </div>
      </main>
    </div>

</body>
</html>