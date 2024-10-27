@php
    $html = "
        <style>
            @page {
                margin: 3rem 4rem;
            }
            body {
                font-family: 'Georgia', 'Times New Roman', Times, sans-serif;
            }
            .border-0 {border: 0}
            .text-left{text-align:left!important}
            .text-center{text-align:center!important}
            .text-right{text-align:right!important}

            .font-w50{font-weight:10!important}
            .font-w600{font-weight:600!important}
            .font-w700{font-weight:700!important}
            .font-size-base{font-size:1rem!important}
            .font-size-lg{font-size:1.25rem!important}
            .font-size-sm{font-size:.875rem!important}
            .font-size-xs{font-size: .715rem!important}
            .font-size-xxs{font-size: .675rem!important}
            .font-size-xxxs{font-size: .500rem!important}

            .mt-2{margin-top:.5rem!important}
            .mb-2{margin-bottom:.5rem!important}
            .my-2{margin-top:.5rem!important}
            .my-2{margin-bottom:.5rem!important}
            .my-3{margin-top:1rem!important}
            .my-3{margin-bottom:1rem!important}
            .mx-3{margin-left:1rem!important}
            .mx-3{margin-right:1rem!important}

            .table {border-collapse: collapse}
            .table td,.table th{padding:.25rem;align-items: center;vertical-align:top;border-top:0px solid #000000;text-align: center;}
            .table thead th{vertical-align:bottom;border-bottom:0px solid #000000}
            .table tbody+tbody{border-top:0px solid #222222}
            .table tbody td{border-bottom:0px solid #222222}
            .table tfoot th{border:none}
            .table-sm td,.table-sm th{padding:.25rem}
            .table-bordered{border:1px solid #000000}
            .table-bordered td,.table-bordered th{border:1px solid #000000}
            .table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}
            .table-borderless tbody+tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{border:0}

            .page_break{ page-break-before: always}

            .line-text {
                display: flex;
                align-items: center;
                text-align: center;
                margin: 20px 0;
            }

            .line-text::before,
            .line-text::after {
                content: '';
                flex: 1;
                border-bottom: 2px solid black; /* Ketebalan dan warna garis */
                margin: 0 10px; /* Jarak antara teks dan garis */
            }

            footer {
                position: fixed;
                bottom: -120px;
                left: 0px;
                right: 0px;
                height: 110px;
            }
        </style>
    ";

    use Carbon\Carbon;
    Carbon::setLocale('id');
    $tanggal = Carbon::create($results->profile[0]->created_at);
    $namaHari = $tanggal->isoFormat('dddd');
    $formatTanggal = $tanggal->isoFormat('D MMMM YYYY');

    if ($results->profile[0]->type == '1' || $results->profile[0]->type == '3') {
        $html .="
            <div class='font-size-xxs font-w50 text-center'><h2>PERJANJIAN SUPPLIER PRODUK DIGITAL</h2></div>
            <div class='font-size-sm font-w50'>Pada hari ini, " .$namaHari .", tanggal ". $formatTanggal .", kami yang bertanda tangan di bawah ini:</div>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;padding: .5rem;'>
                <tr>
                    <td colspan='2' style='vertical-align: top;'><b>Pihak Pertama :</b></td>
                </tr>
                <tr>
                    <td style='text-align: center; width: 5%;'>&#8226;</td>
                    <td style='vertical-align: top; text-align: left;'><b>Nama:</b> PT. GINESIA DIGITAL INDONESIA</td>
                </tr>
                <tr>
                    <td style='text-align: center; width: 5%;'>&#8226;</td>
                    <td style='vertical-align: top; text-align: left;'><b>Alamat:</b> Jl. Glondong, Gg. Nakula, Pandeyan, Bangunharjo, Kec. Sewon, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55188</td>
                </tr>
                <tr>
                    <td style='text-align: center; width: 5%;'>&#8226;</td>
                    <td style='vertical-align: top; text-align: left;'><b>Diwakili Oleh:</b> Irfan Hilmi, Direktur</td>
                </tr>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;padding: 1rem;'>
                <tr>
                    <td colspan='2' style='vertical-align: top;'><b>Pihak Kedua :</b></td>
                </tr>
                <tr>
                    <td style='text-align: center; width: 5%;'>&#8226;</td>
                    <td style='vertical-align: top; text-align: left;'><b>Nama:</b> ".$results->profile[0]->name ."</td>
                </tr>
                <tr>
                    <td style='text-align: center; width: 5%;'>&#8226;</td>
                    <td style='vertical-align: top; text-align: left;'><b>Alamat:</b> ". $results->profile[0]->address ."</td>
                </tr>
                <tr>
                    <td style='text-align: center; width: 5%;'>&#8226;</td>
                    <td style='vertical-align: top; text-align: left;'><b>Diwakili Oleh:</b> " .$results->profile[0]->director ."</td>
                </tr>
            </table>
            <div class='font-size-sm font-w50'>Kedua belah pihak sepakat untuk mengadakan Perjanjian Penjualan Produk Digital secara bersama dengan ketentuan sebagai berikut:</div>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th colspan='2' class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 1 DEFINISI</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>1.</td>
                        <td style='vertical-align: top;width: 95%;'><b>Produk Digital</b> adalah produk yang disuplai oleh Pihak Kedua kepada Pihak Pertama dalam bentuk ebook, ebook interaktif, audiobook, videobook, atau video tutorial.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>2.</td>
                        <td style='vertical-align: top;width: 95%;'>Produk yang dimaksud dalam ayat 1 ditulis atau disampaikan oleh penulis yang memiliki hubungan kerja dengan Pihak Kedua.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>3.</td>
                        <td style='vertical-align: top;width: 95%;'><b>Platform</b> adalah suatu sistem yang mengintegrasikan perangkat keras dan perangkat lunak dalam satu kesatuan arsitektur teknologi.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>4.</td>
                        <td style='vertical-align: top;width: 95%;'><b>Perpustakaan Digital</b> adalah koleksi produk digital yang dimiliki oleh lembaga atau individu.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>5.</td>
                        <td style='vertical-align: top;width: 95%;'><b>Platform Perpustakaan Digital</b> yang dikembangkan dapat diakses secara online menggunakan internet dan atau secara offline menggunakan jaringan IP lokal, yang sudah diamankan dengan sistem enkripsi dan restriksi konten digital pada platform.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th colspan='2' class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 2 PARA PIHAK</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>1.</td>
                        <td style='vertical-align: top;width: 95%;'>Pihak Pertama adalah perusahaan pengembang platform digital berbasis web, terdaftar di Bantul dengan Akta Notaris Dhani Satria Wijaya, S.H., M.Kn, No. 58, tanggal 27 September 2024.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>2.</td>
                        <td style='vertical-align: top;width: 95%;'>Pihak Kedua adalah perusahaan yang berbadan hukum atau badan usaha yang bergerak di bidang penerbitan buku.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>3.</td>
                        <td style='vertical-align: top;width: 95%;'>Pihak Pertama dan Pihak Kedua kemudian disebut sebagai Para Pihak.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th colspan='2' class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 3 BENTUK KERJA SAMA</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>1.</td>
                        <td style='vertical-align: top;width: 95%;'>Pihak Kedua memberikan hak kepada Pihak Pertama untuk menjual produk digital Pihak Kedua dan atau produk digital pihak ketiga yang ditunjuk.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>2.</td>
                        <td style='vertical-align: top;width: 95%;'>Hak distribusi untuk produk pihak ketiga akan dinyatakan dalam surat penunjukan atau kerjasama antara kedua belah pihak yang diberikan kepada Pihak Pertama.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>3.</td>
                        <td style='vertical-align: top;width: 95%;'>Ruang lingkup perjanjian ini mencakup penjualan produk digital ke seluruh jaringan pemasaran Pihak Pertama.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>4.</td>
                        <td style='vertical-align: top;width: 95%;'>Pihak Kedua tetap berhak menunjuk pihak lain untuk menjual produk digitalnya.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>5.</td>
                        <td style='vertical-align: top;width: 95%;'>Detail produk akan dicantumkan dalam file metadata yang dikirimkan Pihak Kedua kepada Pihak Pertama bersama dengan file produk digital yang telah dienkripsi.</td>
                    </tr>
                </tbody>
            </table>
            <div class='page_break'></div>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 4 KONSEP DASAR</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 100%;'>Para pihak sepakat bahwa platform yang dimaksud dalam perjanjian ini mencakup perpustakaan untuk lembaga atau individu.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th colspan='2' class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 5 MATERI PRODUK</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan='2'>Pihak Kedua menjamin bahwa Produk Digital yang dikirimkan kepada Pihak Pertama,</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>1.</td>
                        <td style='vertical-align: top;width: 95%;'>Tidak melanggar hak cipta dan tidak mengandung unsur SARA yang dapat menimbulkan perselisihan.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>2.</td>
                        <td style='vertical-align: top;width: 95%;'>Tidak mengandung penghinaan atau fitnah terhadap pihak lain..</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>3.</td>
                        <td style='vertical-align: top;width: 95%;'>Bebas dari plagiasi.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>4.</td>
                        <td style='vertical-align: top;width: 95%;'>Telah memperoleh izin dari semua kontributor yang namanya tercantum dalam produk yang dipublikasikan.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>5.</td>
                        <td style='vertical-align: top;width: 95%;'>Telah mendapatkan izin dari pemilik hak kekayaan intelektual terkait.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>6.</td>
                        <td style='vertical-align: top;width: 95%;'>Tidak memuat logo atau desain milik pihak ketiga tanpa izin.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 6 HARGA JUAL</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 100%;'>Pihak Kedua menetapkan harga jual produk digital yang dijual melalui platform Pihak Pertama.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th colspan='2' class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 7 KOMISI PENJUALAN</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>1.</td>
                        <td style='vertical-align: top;width: 95%;'>Secara umum, komisi penjualan dalam perjanjian ini sebagai berikut:</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>&nbsp;</td>
                        <td style='vertical-align: top;width: 95%;'>a.	Pihak Pertama (Pemilik Platform) 30%<br>b.	Pihak Kedua (Penerbit/Supplier) 40%<br>c.	Para Pihak yang Menjual (Distributor) 30%.</td>
                    <tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>2.</td>
                        <td style='vertical-align: top;width: 95%;'>Terkait dengan komisi penjualan pada ayat 1 di atas, dalam kondisi tertentu, Pihak Pertama dan Pihak Kedua dapat bernegosiasi sesuai kesepakatan bersama, dengan dibuatkan surat persetujuan oleh Pihak Kedua.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>3.</td>
                        <td style='vertical-align: top;width: 95%;'>Pembayaran untuk produk yang terjual pada bulan ke-N akan dilakukan pada bulan N+1.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>4.</td>
                        <td style='vertical-align: top;width: 95%;'>Pihak Kedua dapat mengubah harga jual dengan persetujuan Pihak Pertama, dan perubahan dapat dilakukan maksimal sekali dalam setahun.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 8 PENJUALAN</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 100%;'>Pihak Pertama diizinkan untuk menyerahkan file produk yang telah terenkripsi kepada pembeli untuk diakses secara offline di satu komputer/server sesuai jumlah produk yang terbeli, guna kepentingan pengadaan barang dan jasa.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 9 DATA PENDUKUNG</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 100%;'>Pihak Kedua wajib mengisi metadata buku secara lengkap.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 10 PENOLAKAN PIHAK PERTAMA</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 100%;'>Pihak Pertama berhak menyeleksi produk digital Pihak Kedua, dan jika ditemukan pelanggaran sesuai pada Pasal 5 maka Pihak Pertama dapat menonaktifkan produk digital tersebut, dengan memberitahukan kepada Pihak Kedua.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 11 PAJAK</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 100%;'>Pengenaan pajak atas produk mengikuti peraturan perpajakan yang berlaku.</td>
                    </tr>
                </tbody>
            </table>
            <div class='page_break'></div>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th colspan='2' class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 12 PENGHENTIAN HAK EDAR BUKU KARENA PENETAPAN PEMERINTAH</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>1.</td>
                        <td style='vertical-align: top;width: 95%;'>Jika pemerintah mengeluarkan peraturan yang berdampak pada perjanjian ini, maka kedua belah pihak saling membebaskan tanggung jawab atas dampak peraturan tersebut.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>2.</td>
                        <td style='vertical-align: top;width: 95%;'>Produk yang ditarik dari platform tidak akan dilaporkan dalam laporan penjualan setelah pengumuman larangan.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th colspan='2' class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 13 PENGHENTIAN PEREDARAN PRODUK DIGITAL</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>1.</td>
                        <td style='vertical-align: top;width: 95%;'>Pihak Pertama berhak menghentikan sementara peredaran produk digital yang mendapat keberatan dari pihak ketiga.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>2.</td>
                        <td style='vertical-align: top;width: 95%;'>Pihak Pertama akan memberi waktu 45 hari kepada Pihak Kedua untuk penyelesaian masalah dengan pihak ketiga.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th colspan='2' class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 14 KUASA UNTUK MEMBERIKAN DUKUNGAN</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>1.</td>
                        <td style='vertical-align: top;width: 95%;'>Pihak Kedua memberikan kuasa kepada Pihak Pertama untuk menandatangani surat dukungan untuk pihak ketiga yang bertindak sebagai distributor jika diperlukan.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>2.</td>
                        <td style='vertical-align: top;width: 95%;'>Surat dukungan akan ditulis menggunakan kertas berkop Pihak Pertama dan dilampiri salinan surat kuasa dari Pihak Kedua.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 15 FORCE MAJEURE</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 100%;'>Para pihak tidak bertanggung jawab atas keterlambatan akibat kejadian luar biasa, seperti bencana alam atau perubahan peraturan pemerintah. Jika <i>force majeure</i> berlangsung lebih dari 30 hari, masing-masing pihak dapat mengakhiri perjanjian ini dengan pemberitahuan tertulis.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 16 PENANDATANGAN PERJANJIAN</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 100%;'>Penandatangan perjanjian adalah pemilik perusahaan atau yang mewakili dengan dilampirkannya surat kuasa dari pemilik perusahaan.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th colspan='2' class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 17 MASA BERLAKU PERJANJIAN</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>1.</td>
                        <td style='vertical-align: top;width: 95%;'>Perjanjian ini berlaku selama 5 tahun sejak ditandatangani.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>2.</td>
                        <td style='vertical-align: top;width: 95%;'>Perjanjian akan otomatis diperpanjang jika Pihak Kedua tidak mengajukan penghentian 1 bulan sebelum berakhir.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th colspan='2' class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 18 PENGAKHIRAN PERJANJIAN</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>1.</td>
                        <td style='vertical-align: top;width: 95%;'>Perjanjian dapat diakhiri jika salah satu pihak melakukan wanprestasi atau melanggar ketentuan hukum.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>2.</td>
                        <td style='vertical-align: top;width: 95%;'>Jika ada perubahan kepemilikan perusahaan Pihak Kedua maka akan dilakukan perjanjian ulang, dan secara otomatis mengakhiri perjanjian yang lama.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th colspan='2' class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 19 JUMLAH RANGKAP PERJANJIAN</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>1.</td>
                        <td style='vertical-align: top;width: 95%;'>Perjanjian ini dibuat secara elektronik dan diakui sah meskipun tanpa tanda tangan basah.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>2.</td>
                        <td style='vertical-align: top;width: 95%;'>Para Pihak dapat mendownload surat perjanjian ini pada dashboard Para Pihak.</td>
                    </tr>
                </tbody>
            </table>
            <div class='page_break'></div>
            <table class='table-sm table font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 20 PENYELESAIAN PERSELISIHAN</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 100%;text-align: left;'>Setiap perselisihan akan diselesaikan melalui musyawarah untuk mufakat.</td>
                    </tr>
                </tbody>
            </table>";

            if ($results->profile[0]->type == '3') {
                $html .= "<div class='page_break'></div>";
            }
    }

    if ($results->profile[0]->type == '2' || $results->profile[0]->type == '3') {
        $html .="
            <div class='font-size-xxs font-w50 text-center'><h2>PERJANJIAN DISTRIBUTOR PRODUK DIGITAL</h2></div>
            <div class='font-size-sm font-w50'>Pada hari ini, " .$namaHari .", tanggal ". $formatTanggal .", kami yang bertanda tangan di bawah ini:</div>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;padding: .5rem;'>
                <tr>
                    <td colspan='2' style='vertical-align: top;'><b>Pihak Pertama :</b></td>
                </tr>
                <tr>
                    <td style='text-align: center; width: 5%;'>&#8226;</td>
                    <td style='vertical-align: top; text-align: left;'><b>Nama:</b> PT. GINESIA DIGITAL INDONESIA</td>
                </tr>
                <tr>
                    <td style='text-align: center; width: 5%;'>&#8226;</td>
                    <td style='vertical-align: top; text-align: left;'><b>Alamat:</b> Jl. Glondong, Gg. Nakula, Pandeyan, Bangunharjo, Kec. Sewon, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55188</td>
                </tr>
                <tr>
                    <td style='text-align: center; width: 5%;'>&#8226;</td>
                    <td style='vertical-align: top; text-align: left;'><b>Diwakili Oleh:</b> Irfan Hilmi, Direktur</td>
                </tr>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;padding: 1rem;'>
                <tr>
                    <td colspan='2' style='vertical-align: top;'><b>Pihak Kedua :</b></td>
                </tr>
                <tr>
                    <td style='text-align: center; width: 5%;'>&#8226;</td>
                    <td style='vertical-align: top; text-align: left;'><b>Nama:</b> ".$results->profile[0]->name ."</td>
                </tr>
                <tr>
                    <td style='text-align: center; width: 5%;'>&#8226;</td>
                    <td style='vertical-align: top; text-align: left;'><b>Alamat:</b> ". $results->profile[0]->address ."</td>
                </tr>
                <tr>
                    <td style='text-align: center; width: 5%;'>&#8226;</td>
                    <td style='vertical-align: top; text-align: left;'><b>Diwakili Oleh:</b> " .$results->profile[0]->director ."</td>
                </tr>
            </table>
            <div class='font-size-sm font-w50'>Kedua belah pihak sepakat untuk mengadakan Perjanjian Penjualan Produk Digital Pihak Kedua di platform milik Pihak Pertama dengan ketentuan sebagai berikut:</div>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th colspan='2' class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 1 DEFINISI</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>1.</td>
                        <td style='vertical-align: top;width: 95%;'><b>Konten Digital</b> adalah produk digital yang diproduksi oleh Pihak Pertama dalam bentuk ebook, video, audio, atau format digital lainnya yang relevan</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>2.</td>
                        <td style='vertical-align: top;width: 95%;'><b>Platform</b> adalah sistem perangkat keras dan perangkat lunak yang digunakan oleh Pihak Pertama untuk mendistribusikan konten digital.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th colspan='2' class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 2 PARA PIHAK</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>1.</td>
                        <td style='vertical-align: top;width: 95%;'>Pihak Pertama adalah perusahaan pengembang platform digital berbasis web, terdaftar di Bantul dengan Akta Notaris Dhani Satria Wijaya, S.H., M.Kn, No. 58, tanggal 27 September 2024.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>2.</td>
                        <td style='vertical-align: top;width: 95%;'>Pihak Kedua adalah perusahaan yang berbadan hukum atau badan usaha yang bergerak sebagai marketing dan distributor buku.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>3.</td>
                        <td style='vertical-align: top;width: 95%;'>Pihak Pertama dan Pihak Kedua selanjutnya disebut sebagai Para Pihak.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th colspan='2' class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 3 HAK DISTRIBUSI</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>1.</td>
                        <td style='vertical-align: top;width: 95%;'>Pihak Pertama memberikan hak kepada Pihak Kedua untuk menjual konten digital yang disuplai oleh Pihak Pertama melalui saluran distribusi yang dimiliki oleh Pihak Kedua.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>2.</td>
                        <td style='vertical-align: top;width: 95%;'>Pasar utama untuk konten digital ini mencakup perpustakaan sekolah, kampus, desa/kelurahan, kota/kabupaten, provinsi, dan semua lembaga yang memiliki perpustakaan.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>3.</td>
                        <td style='vertical-align: top;width: 95%;'>Harga konten digital akan ditentukan oleh penerbit sebagai supplier pada saat mengupload konten, dan Pihak Kedua tidak berhak untuk mengubah harga tersebut.</td>
                    </tr>
                </tbody>
            </table>
            <div class='page_break'></div>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th colspan='2' class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 4 PEMBAYARAN DAN MARGIN</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>1.</td>
                        <td style='vertical-align: top;width: 95%;'>Pembayaran untuk setiap penjualan konten digital akan diterima oleh Pihak Kedua dari pembeli.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>2.</td>
                        <td style='vertical-align: top;width: 95%;'>Pihak Kedua akan menerima margin sebesar 30% dari keseluruhan total harga buku yang terbeli yang disubmit oleh penerbit di platform milik Pihak Pertama.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>3.</td>
                        <td style='vertical-align: top;width: 95%;'>Pihak Kedua berkewajiban untuk membayarkan margin 70% dari keseluruhan total harga buku yang terbeli kepada Pihak Pertama.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>4.</td>
                        <td style='vertical-align: top;width: 95%;'>Bila ada kesepakatan lain di luar peraturan pembayaran dan margin pada Pasal ini maka akan diatur kemudian hari sesuai kesepakatan Para Pihak.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 5 KEWAJIBAN DISTRIBUTOR</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 100%;'>Pihak Kedua wajib mempromosikan dan menjual buku digital Platform Ginesia dengan cara yang profesional dan etis, khususnya kepada target pasar yang telah ditentukan.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 6 TANGGUNG JAWAB</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 100%;'>Pihak Kedua bertanggung jawab penuh atas kegiatan distribusi dan pemasaran konten digital. Pihak Pertama tidak akan bertanggung jawab atas segala bentuk kerugian yang mungkin timbul akibat tindakan atau kelalaian Pihak Kedua.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th colspan='2' class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 7 MASA BERLAKU PERJANJIAN</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>1.</td>
                        <td style='vertical-align: top;width: 95%;'>Perjanjian ini berlaku selama 5 (lima) tahun sejak ditandatangani.</td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;width: 5%;'>2.</td>
                        <td style='vertical-align: top;width: 95%;'>Perjanjian dapat diperpanjang atas kesepakatan kedua belah pihak.</td>
                    </tr>
                </tbody>
            </table>
            <table class='table-sm table font-size-sm' cellspacing='0' style='width: 100%;'>
                <thead>
                    <tr>
                        <th class='font-size-xxs font-w50' style='vertical-align: bottom; text-align: left;'><h2>PASAL 8 PENYELESAIAN PERSELISIHAN</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style='vertical-align: top;width: 100%;text-align: left;'>Apabila terjadi perselisihan mengenai penafsiran atau pelaksanaan perjanjian ini, para pihak sepakat untuk menyelesaikannya melalui musyawarah untuk mufakat.</td>
                    </tr>
                </tbody>
            </table>";
    }

    use Endroid\QrCode\QrCode;
    use Endroid\QrCode\Writer\PngWriter;

    $qrCode = QrCode::create(env('APP_URL') . '/signature?id=' . $results->profile[0]->id)->setSize(100); // Size in pixels
    $qrCodes = QrCode::create(env('APP_URL') . '/signature?id=')->setSize(100); // Size in pixels

    $writer = new PngWriter();
    $qrCodeImage = $writer->write($qrCode);
    $qrCodeBase64 = base64_encode($qrCodeImage->getString());

    $qrCodeImages = $writer->write($qrCodes);
    $qrCodeBase64s = base64_encode($qrCodeImages->getString());

    $html .=
        "<table class='table-sm font-size-sm' cellspacing='0' style='width: 100%; margin-top: 1rem!important'>
            <thead>
                <tr>
                    <td colspan='3' class='font-size-sm' style='vertical-align: bottom; text-align: left;'>Demikian perjanjian ini dibuat dan disetujui secara elektronik di Bantul.</div>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan='3' style='vertical-align: top;width: 100%;'>&nbsp;</td>
                </tr>
                <tr>
                    <td class='text-center'>Pihak Pertama</td>
                    <td class='text-center'></td>
                    <td class='text-center'>Pihak Kedua</td>
                </tr>
                <tr>
                    <td class='text-center' ><img src='data:image/png;base64,". $qrCodeBase64s ."' alt='QR Code'></td>
                    <td class='text-center'></td>
                    <td class='text-center'><img src='data:image/png;base64,". $qrCodeBase64 ."' alt='QR Code'></td>
                </tr>
                <tr>
                    <td class='text-center'><b>Irfan Hilmi</b></td>
                    <td class='text-center'></td>
                    <td class='text-center'><b>". $results->profile[0]->director ."</b></td>
                </tr>
            </tbody>
        </table>";

    $html .= "
        <div class='page_break'></div>
        <div class='font-size-xxs font-w50 text-center'><h2>PROFIL PERUSAHAAN</h2></div>
        <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
            <tr>
                <td style='text-align: left; width: 20%;'><b>Nama Perusahaan</b></td>
                <td style='text-align: left; width: 5%;'>:</td>
                <td style='text-align: left;'>PT. GINESIA DIGITAL INDONESIA</td>
            </tr>
            <tr>
                <td style='text-align: left; width: 20%;'><b>Nama Direktur</b></td>
                <td style='text-align: left; width: 5%;'>:</td>
                <td style='text-align: left;'>Irfan Hilmi</td>
            </tr>
            <tr>
                <td style='text-align: left; width: 20%;'><b>Notaris</b></td>
                <td style='text-align: left; width: 5%;'>:</td>
                <td style='text-align: left;'>Dhani Satria Wijaya, S.H., M.Kn</td>
            </tr>
            <tr>
                <td style='text-align: left; width: 20%;'><b>Nomor Akta Notaris</b></td>
                <td style='text-align: left; width: 5%;'>:</td>
                <td style='text-align: left;'>58</td>
            </tr>
            <tr>
                <td style='text-align: left; width: 20%;'><b>Tanggal Berdiri</b></td>
                <td style='text-align: left; width: 5%;'>:</td>
                <td style='text-align: left;'>27 September 2024</td>
            </tr>
            <tr>
                <td style='text-align: left; width: 20%;'><b>SK Kemenkumham</b></td>
                <td style='text-align: left; width: 5%;'>:</td>
                <td style='text-align: left;'>AHU-0076238.AH.01.01.TAHUN 2024</td>
            </tr>
            <tr>
                <td style='text-align: left; width: 20%;'><b>NIB</b></td>
                <td style='text-align: left; width: 5%;'>:</td>
                <td style='text-align: left;'>3009240091751</td>
            </tr>
            <tr>
                <td style='text-align: left; width: 20%;'><b>NPWP</b></td>
                <td style='text-align: left; width: 5%;'>:</td>
                <td style='text-align: left;'>27.866.704.3-543.000</td>
            </tr>
            <tr>
                <td style='text-align: left; width: 20%;'><b>Alamat</b></td>
                <td style='text-align: left; width: 5%;'>:</td>
                <td style='text-align: left;'>Jl. Glondong, Gg. Nakula, Pandeyan, Bangunharjo, Kec. Sewon, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55188</td>
            </tr>
            <tr>
                <td style='text-align: left; width: 20%;'><b>No. HP</b></td>
                <td style='text-align: left; width: 5%;'>:</td>
                <td style='text-align: left;'>0812 2603 2731 / 0896 7193 4993</td>
            </tr>
            <tr>
                <td style='text-align: left; width: 20%;'><b>Website</b></td>
                <td style='text-align: left; width: 5%;'>:</td>
                <td style='text-align: left;'>www.pustakadigital.id</td>
            </tr>
            <tr>
                <td style='text-align: left; width: 20%;'><b>Email</b></td>
                <td style='text-align: left; width: 5%;'>:</td>
                <td style='text-align: left;'>info@pustakadigital.id</td>
            </tr>
        </table>";

        if ($results->profile[0]->type == '1' || $results->profile[0]->type == '3') {
            $html .= "
                <div class='page_break'></div>
                <div class='font-size-xxs font-w50 text-center'><h2>SURAT AKSES HAK JUAL BUKU ELEKTRONIK</h2></div>
                <div class='font-size-sm font-w50'>Sesuai dengan Surat Perjanjian Penjualan tertanggal ". $formatTanggal .", Kode Suplier ". $results->profile[0]->id .", yang bertanda tangan di bawah ini:</div>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <div class='font-size-sm font-w50'>Nama Badan : ". $results->profile[0]->name ."</div>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <div class='font-size-sm font-w50'>Alamat : ". $results->profile[0]->address ."</div>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <div class='font-size-sm font-w50'>Dengan ini memberikan akses hak jual kepada :</div>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <div class='font-size-sm font-w50'>Nama Badan : PT. GINESIA DIGITAL INDONESIA</div>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <div class='font-size-sm font-w50'>Alamat : Jl. Glondong, Gg. Nakula, Pandeyan, Bangunharjo, Kec. Sewon, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55188</div>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <div class='font-size-sm font-w50'>Sebagai pihak yang memiliki hak untuk menjual produk digital (buku elektronik) melalui platform milik PT. GINESIA DIGITAL INDONESIA.</div>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <div class='font-size-sm font-w50'>Demikian Surat Akses Hak Jual ini dibuat untuk digunakan sebagaimana mestinya.</div>
                <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%; margin-top: 1rem!important'>
                    <thead>
                        <tr>
                            <td colspan='3' class='font-size-sm' style='vertical-align: bottom; text-align: left;'>Tanggal : ". $formatTanggal ."</div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan='3' style='vertical-align: top;width: 100%;'>&nbsp;</td>
                        </tr>
                        <tr>
                            <td class='text-center' style='vertical-align: top;width: 45%;'>PT. GINESIA DIGITAL INDONESIA</td>
                            <td class='text-center' style='vertical-align: top;width: 5%;'></td>
                            <td class='text-center' style='vertical-align: top;width: 45%;'>". $results->profile[0]->name ."</td>
                        </tr>
                        <tr>
                            <td class='text-center' style='vertical-align: top;width: 45%;'><img src='data:image/png;base64,". $qrCodeBase64s ."' alt='QR Code'></td>
                            <td class='text-center' style='vertical-align: top;width: 5%;'></td>
                            <td class='text-center' style='vertical-align: top;width: 45%;'><img src='data:image/png;base64,". $qrCodeBase64 ."' alt='QR Code'></td>
                        </tr>
                        <tr>
                            <td class='text-center' style='vertical-align: top;width: 45%;'><b>Irfan Hilmi</b></td>
                            <td class='text-center' style='vertical-align: top;width: 5%;'></td>
                            <td class='text-center' style='vertical-align: top;width: 45%;'><b>". $results->profile[0]->director ."</b></td>
                        </tr>
                    </tbody>
                </table>";
        }

        if ($results->profile[0]->type == '1' || $results->profile[0]->type == '3') {
            $html .= "
                <div class='page_break'></div>
                <div class='font-size-xxs font-w50 text-center'><h2>SURAT KUASA</h2></div>
                <div class='font-size-sm font-w50'>Sesuai dengan Surat Perjanjian Penjualan tertanggal ". $formatTanggal .", Kode Suplier ". $results->profile[0]->id .", yang bertanda tangan di bawah ini:</div>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <div class='font-size-sm font-w50'>Nama Badan : ". $results->profile[0]->name ."</div>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <div class='font-size-sm font-w50'>Alamat : ". $results->profile[0]->address ."</div>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <div class='font-size-sm font-w50'>Dengan ini memberikan kuasa kepada :</div>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <div class='font-size-sm font-w50'>Nama Badan : PT. GINESIA DIGITAL INDONESIA</div>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <div class='font-size-sm font-w50'>Alamat : Jl. Glondong, Gg. Nakula, Pandeyan, Bangunharjo, Kec. Sewon, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55188</div>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <div class='font-size-sm font-w50'>Untuk menandatangani Surat Dukungan kepada Pihak Ketiga sehubungan dengan syarat pengadaan buku di sebuah instansi, untuk seluruh buku kami yang diupload pada platform milik PT. GINESIA DIGITAL INDONESIA.</div>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <div class='font-size-sm font-w50'>Demikian surat kuasa ini dibuat untuk dapat digunakan sebagaimana mestinya.</div>
                <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%; margin-top: 1rem!important'>
                    <thead>
                        <tr>
                            <td colspan='3' class='font-size-sm' style='vertical-align: bottom; text-align: left;'>". $results->profile[0]->regency_name .", ". $formatTanggal ."</div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan='3' style='vertical-align: bottom;width: 100%; text-align: left;'>Hormat Kami,</td>
                        </tr>
                        <tr>
                            <td style='vertical-align: top;width: 45%;'><img src='data:image/png;base64,". $qrCodeBase64 ."' alt='QR Code'></td>
                        </tr>
                        <tr>
                            <td style='vertical-align: top;width: 45%;'>". $results->profile[0]->director ."</td>
                        </tr> 
                        <tr>
                            <td style='vertical-align: top;width: 45%;'>". $results->profile[0]->position ."</td>
                        </tr>
                        <tr>
                            <td style='vertical-align: top;width: 45%;'>". $results->profile[0]->name ."</td>
                        </tr>
                    </tbody>
                </table>";
        }

        if ($results->profile[0]->type == '1' || $results->profile[0]->type == '3') {
            $html .= "
                <div class='page_break'></div>
                <div class='font-size-xxs font-w50 text-center'><h2>SURAT PERNYATAAN IMPRINT</h2></div>
                <div class='font-size-sm font-w50'>Yang bertanda tangan dibawah ini, saya :</div>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                    <tr>
                        <td style='text-align: left; width: 15%;'>Nama</td>
                        <td style='text-align: left; width: 5%;'>:</td>
                        <td style='text-align: left;'>". $results->profile[0]->director ."</td>
                    </tr>
                    <tr>
                        <td style='text-align: left; width: 15%;'>Jabatan</td>
                        <td style='text-align: left; width: 5%;'>:</td>
                        <td style='text-align: left;'>". $results->profile[0]->position ."</td>
                    </tr>
                    <tr>
                        <td style='text-align: left; width: 15%;'>Perusahaan</td>
                        <td style='text-align: left; width: 5%;'>:</td>
                        <td style='text-align: left;'>". $results->profile[0]->name ."</td>
                    </tr>
                    <tr>
                        <td style='text-align: left; width: 15%;'>Alamat</td>
                        <td style='text-align: left; width: 5%;'>:</td>
                        <td style='text-align: left;'>". $results->profile[0]->address ."</td>
                    </tr>
                    <tr>
                        <td style='text-align: left; width: 15%;'>No. Telp/WA</td>
                        <td style='text-align: left; width: 5%;'>:</td>
                        <td style='text-align: left;'>". $results->profile[0]->handphone_director ."</td>
                    </tr>
                </table>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <div class='font-size-sm font-w50'>Dengan ini menerangkan bahwa nama-nama penerbit di bawah ini adalah benar merupakan imprint dari supplier ". $results->profile[0]->name ."., yang menerbitkan buku baik cetak maupun digital, yakni sebagai berikut :</div>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>";
                foreach ($results->imprint as $i => $value) {
                    $html .=
                        "<tr>
                            <td style='text-align: left; width: 5%;'>". $i + 1 .".</td>
                            <td style='text-align: left;'>". $value->name ."</td>
                        </tr>";
                }
                $html .=" 
                </table>
                <div class='font-size-sm font-w50'>&nbsp;</div>
                <div class='font-size-sm font-w50'>Demikian surat keterangan ini kami buat dengan penuh kesadaraan dan rasa tanggung jawab agar dapat dipergunakan sebagaimana mestinya.</div>
                <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%; margin-top: 1rem!important'>
                    <thead>
                        <tr>
                            <td colspan='3' class='font-size-sm' style='vertical-align: bottom; text-align: left;'>". $results->profile[0]->regency_name .", ". $formatTanggal ."</div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan='3' style='vertical-align: bottom;width: 100%; text-align: left;'>Hormat Kami,</td>
                        </tr>
                        <tr>
                            <td style='vertical-align: top;width: 45%;'><img src='data:image/png;base64,". $qrCodeBase64 ."' alt='QR Code'></td>
                        </tr>
                        <tr>
                            <td style='vertical-align: top;width: 45%;'>". $results->profile[0]->director ."</td>
                        </tr> 
                        <tr>
                            <td style='vertical-align: top;width: 45%;'>". $results->profile[0]->position ."</td>
                        </tr>
                    </tbody>
                </table>";
            }

        $html .= "
            <div class='page_break'></div>
            <div class='font-size-xxs font-w50 text-center'><h2>PENDAFTARAN SUPPLIER DAN ATAU DISTRIBUTOR GINESIA</h2></div>
            <div class='font-size-sm font-w50'>Yang bertanda tangan dibawah ini, saya :</div>
            <div class='font-size-sm font-w50'>&nbsp;</div>
            <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%;'>
                <tr>
                    <td style='text-align: left; width: 20%;'>Nama Perusahaan</td>
                    <td style='text-align: left; width: 2%;'>:</td>
                    <td colspan='4' style='text-align: left;'>". $results->profile[0]->name ."</td>
                </tr>
                <tr>
                    <td style='text-align: left; width: 20%;'>Alamat Perusahaan</td>
                    <td style='text-align: left; width: 2%;'>:</td>
                    <td colspan='4' style='text-align: left;'>". $results->profile[0]->address ."</td>
                </tr>
                <tr>
                    <td style='text-align: left; width: 20%;'>Kab./Kota</td>
                    <td style='text-align: left; width: 2%;'>:</td>
                    <td style='text-align: left;'>".$results->profile[0]->regency_name ."</td>
                    <td style='text-align: left; width: 10%;'>Kode Pos</td>
                    <td style='text-align: left; width: 2%;'>:</td>
                    <td style='text-align: left; width: 15%;'>". $results->profile[0]->postal_code ."</td>
                </tr>
                <tr>
                    <td style='text-align: left; width: 20%;'>Nomor Telepon</td>
                    <td style='text-align: left; width: 2%;'>:</td>
                    <td style='text-align: left;'>".$results->profile[0]->handphone ."</td>
                    <td style='text-align: left; width: 10%;'>No. WA</td>
                    <td style='text-align: left; width: 2%;'>:</td>
                    <td style='text-align: left; width: 15%;'>". $results->profile[0]->handphone ."</td>
                </tr>
                <tr>
                    <td style='text-align: left; width: 20%;'>Email</td>
                    <td style='text-align: left; width: 2%;'>:</td>
                    <td colspan='4' style='text-align: left;'>". $results->profile[0]->email ."</td>
                </tr>
                <tr>
                    <td style='text-align: left; width: 20%;'>Nama Pimpinan</td>
                    <td style='text-align: left; width: 2%;'>:</td>
                    <td style='text-align: left;'>".$results->profile[0]->director ."</td>
                    <td style='text-align: left; width: 10%;'>No. HP</td>
                    <td style='text-align: left; width: 2%;'>:</td>
                    <td style='text-align: left; width: 15%;'>". $results->profile[0]->handphone_director ."</td>
                </tr>
                <tr>
                    <td style='text-align: left; width: 20%;'>Jabatan Pimpinan</td>
                    <td style='text-align: left; width: 2%;'>:</td>
                    <td colspan='4' style='text-align: left;'>". $results->profile[0]->position ."</td>
                </tr>
                <tr>
                    <td style='text-align: left; width: 20%;'>Nama PIC</td>
                    <td style='text-align: left; width: 2%;'>:</td>
                    <td style='text-align: left;'>".$results->profile[0]->pic ."</td>
                    <td style='text-align: left; width: 10%;'>No. HP</td>
                    <td style='text-align: left; width: 2%;'>:</td>
                    <td style='text-align: left; width: 15%;'>". $results->profile[0]->handphone_pic ."</td>
                </tr>
                <tr>
                    <td style='text-align: left; width: 20%;'>Bentuk Perusahaan</td>
                    <td style='text-align: left; width: 2%;'>:</td>
                    <td colspan='4' style='text-align: left;'>PT</td>
                </tr>
                <tr>
                    <td style='text-align: left; width: 20%;'>Bertindak Sebagai</td>
                    <td style='text-align: left; width: 2%;'>:</td>
                    <td colspan='4' style='text-align: left;'>";
                        if ($results->profile[0]->type == '1') {
                            $html .= "Supplier/<s>Distributor</s>/<s>Keduanya</s>";
                        } elseif ($results->profile[0]->type == '2') {
                            $html .= "<s>Supplier</s>/Distributor/<s>Keduanya</s>";
                        } else {
                            $html .= "<s>Supplier</s>/<s>Distributor</s>/Keduanya";
                        }
                    $html .= "</td>
                </tr>
                <tr>
                    <td style='vertical-align: top; text-align: left; width: 20%;'>Nama Imprint<br>(<span class='font-size-xxs'>jika memiliki imprint</span>)</td>
                    <td style='vertical-align: top; text-align: left; width: 2%;'>:</td>
                    <td colspan='4' style='vertical-align: top; text-align: left;'>";
                    foreach ($results->imprint as $i => $value) {
                        $html .= '' . $i + 1 . '. ' . $value->name . '<br>';
                    }
                    $html .= "</td>
                </tr>
                <tr>
                    <td style='vertical-align: top; text-align: left; width: 20%;'>Nama Penerbit<br>(<span class='font-size-xxs'>jika ada penerbit yang memberikan kuasa jual melalui Pihak Kedua</span>)</td>
                    <td style='vertical-align: top; text-align: left; width: 2%;'>:</td>
                    <td colspan='4' style='vertical-align: top; text-align: left;'>";
                    foreach ($results->kuasa as $i => $value) {
                        $html .= '' . $i + 1 . '. ' . $value->name . '<br>';
                    }
                    $html .= "</td>
                </tr>
                <tr>
                    <td style='vertical-align: top; text-align: left; width: 20%;'>Kategori Terbitan</td>
                    <td style='vertical-align: top; text-align: left; width: 2%;'>:</td>
                    <td colspan='4' style='vertical-align: top; text-align: left;'>";
                    foreach ($results->category as $i => $value) {
                        $html .= '' . $i + 1 . '. ' . $value->name . '<br>';
                    }
                    $html .= "</td>
                </tr>";

        foreach ($results->account as $i => $value) {
            $html .="
                    <tr>
                        <td colspan='6' style='vertical-align: top; text-align: left; width: 20%;'>REKENING ". $i + 1 ."</td>
                    </tr>
                    <tr>
                        <td style='text-align: left; width: 20%;'>NPWP</td>
                        <td style='text-align: left; width: 2%;'>:</td>
                        <td colspan='4' style='text-align: left;'>". $value->npwp ."</td>
                    </tr>
                    <tr>
                        <td style='text-align: left; width: 20%;'>Nomor Rekening</td>
                        <td style='text-align: left; width: 2%;'>:</td>
                        <td colspan='4' style='text-align: left;'>". $value->account_bank ."</td>
                    </tr>
                    <tr>
                        <td style='text-align: left; width: 20%;'>Nama Bank</td>
                        <td style='text-align: left; width: 2%;'>:</td>
                        <td colspan='4' style='text-align: left;'>". $value->bank ."</td>
                    </tr>
                    <tr>
                        <td style='text-align: left; width: 20%;'>Nama di Rekening</td>
                        <td style='text-align: left; width: 2%;'>:</td>
                        <td colspan='4' style='text-align: left;'>". $value->account_name ."</td>
                    </tr>
                    <tr>
                        <td style='text-align: left; width: 20%;'>Kota Bank</td>
                        <td style='text-align: left; width: 2%;'>:</td>
                        <td colspan='4' style='text-align: left;'>". $value->bank_city ."</td>
                    </tr>";
        }

    $html .= "
        </table>
        <div class='page_break'></div>
        <div class='font-size-sm font-w50'>Saya dengan ini menyatakan bahwa seluruh data yang telah diisi adalah benar dan akurat. Apabila terdapat perubahan, saya akan mengisi ulang formulir ini untuk memperbarui informasi yang diperlukan. Saya bertanggung jawab sepenuhnya atas kebenaran data ini, dan saya memahami bahwa dokumen ini akan secara otomatis dilengkapi dengan tanda tangan elektronik sebagai bentuk persetujuan saya.</div>
        <table class='table-sm font-size-sm' cellspacing='0' style='width: 100%; margin-top: 1rem!important'>
            <thead>
                <tr>
                    <td colspan='3' class='font-size-sm' style='vertical-align: bottom; text-align: left;'>". $results->profile[0]->regency_name .", ". $formatTanggal ."</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan='3' style='vertical-align: bottom;width: 100%; text-align: left;'>Hormat Kami,</td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 45%;'><img src='data:image/png;base64,". $qrCodeBase64 ."' alt='QR Code'></td>
                </tr>
                <tr>
                    <td style='vertical-align: top;width: 45%;'>". $results->profile[0]->director ."</td>
                </tr> 
                <tr>
                    <td style='vertical-align: top;width: 45%;'>". $results->profile[0]->position ."</td>
                </tr>
            </tbody>
        </table>
    ";

    use Dompdf\Dompdf;

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    $canvas = $dompdf->getCanvas();
    $width = $canvas->get_width();
    $height = $canvas->get_height();

    // Parameters
    $x = $width - 60; // Adjusted for right alignment (60px margin from the right edge)
    $y = $height - 33; // Adjusted for bottom alignment (33px margin from the bottom edge)
    $text = '{PAGE_NUM} of {PAGE_COUNT}';
    $font = $dompdf->getFontMetrics()->get_font('Times', 'normal');
    $size = 8;
    $color = [0, 0, 0];
    $word_space = 0.0;
    $char_space = 0.0;
    $angle = 0.0;

    // Add page number to bottom-right corner
    $canvas->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);

    // Parameters for name on the left
    $x_left = 30; // Adjusted for left alignment (30px margin from the left edge)
    $name_text = now()->format('d M Y H:i:s'); // Replace with the desired name

    // Add name to bottom-left corner
    $canvas->page_text($x_left, $y, $name_text, $font, $size, $color, $word_space, $char_space, $angle);

    // Output the generated PDF to Browser
    $dompdf->stream('Agreement Letter', ['Attachment' => false]);
    exit(0);
@endphp
