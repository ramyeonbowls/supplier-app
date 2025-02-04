<template>
    <div class="">
        <nav class="relative flex items-center justify-between border-b-[0.5px] border-b-slate-100 px-5 pb-5 md:px-20">
            <img src="images/logo/logo.svg" alt="img-logo" class="w-24 md:w-40" />

            <div class="menu-icon md:hidden" @click="handleNavMobile">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="" class="size-6 stroke-svg-icon-color">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </div>

            <div id="nav-mobile" class="absolute left-0 top-0 hidden h-44 w-full translate-y-14 items-center justify-center bg-white drop-shadow-sm" @click="handleNavMobile">
                <ul class="flex w-full cursor-pointer flex-col gap-5 text-center text-sm text-slate-500">
                    <li class="hover:font-semibold hover:text-slate-700"><a href="#about">Tentang kami</a></li>
                    <hr />
                    <li class="hover:font-semibold hover:text-slate-700"><a href="#product">Produk</a></li>
                    <hr />
                    <li class="hover:font-semibold hover:text-slate-700"><a href="#contact">Kontak</a></li>
                </ul>
            </div>

            <ul class="hidden cursor-pointer gap-5 text-slate-500 md:flex">
                <li class="hover:font-semibold hover:text-slate-700"><a href="#about">Tentang kami</a></li>
                <li class="hover:font-semibold hover:text-slate-700"><a href="#product">Produk</a></li>
                <li class="hover:font-semibold hover:text-slate-700"><a href="#contact">Kontak</a></li>
            </ul>

            <a href="pendaftaran-client" class="hidden rounded-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-500 md:flex md:items-center md:gap-2"
                >Daftar Sekarang
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                </svg>
            </a>
        </nav>
        <main class="">
            <div class="banner mb-5 flex flex-col items-center gap-4 md:flex-row md:px-10">
                <img src="images/landing/public-library-visitors.png" alt="img-banner" class="w-[70%] md:hidden" />

                <div class="flex flex-col items-center justify-center gap-2 px-5 md:w-1/2">
                    <h1 class="text-center text-sm font-semibold uppercase text-slate-600 md:text-lg">inovasi perpustakaan masa depan</h1>
                    <p class="mb-5 text-center text-[0.6rem] text-slate-500 md:text-[1rem]">Platform perpustakaan digital yang bukan hanya menghadirkan ribuan buku ke ujung jari Anda, tetapi juga membuka peluang baru bagi perpustakaan dengan solusi perpustakaan hibrid kami. Dan sekarang, kami memiliki tawaran istimewa untuk Anda!</p>
                    <a href="#about" class="flex cursor-pointer items-center justify-center gap-2 rounded-full bg-blue-500 px-5 py-2 text-xs text-white hover:bg-blue-400">
                        <p>pelajari selengkapnya</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

                <img src="images/landing/public-library-visitors.png" alt="img-banner" class="hidden w-[70%] md:block md:w-1/2" />
            </div>

            <div id="about" class="relative flex h-[700px] items-center bg-blue-100 px-5 py-10 md:static md:h-[850px] md:px-10">
                <img src="images/landing/ebooks-collection-library.png" alt="img-ebook" class="md:w-3/4" />

                <div class="absolute top-0 flex w-full flex-col gap-3 md:static md:top-auto">
                    <h1 class="mb-5 mt-10 text-center text-sm md:text-[1rem] lg:text-[1.3rem]">Kenapa <span class="font-bold text-blue-500">GINESIA</span> ?</h1>

                    <div class="w-4/5 rounded-md bg-white p-3 text-xs">
                        <h2 class="mb-2 cursor-pointer font-semibold text-slate-600 md:text-base">Akses tanpa batas</h2>
                        <p class="text-[0.6rem] text-slate-500 md:text-base">Temukan ribuan buku dan materi pelajaran hanya dengan beberapa klik. GINESIA menawarkan kemudahan akses melalui website, tanpa perlu mengunduh aplikasi—cukup buka browser dan mulailah membaca!</p>
                    </div>

                    <div class="w-4/5 translate-x-9 rounded-md bg-white p-3 text-xs">
                        <h2 class="mb-2 cursor-pointer font-semibold text-slate-600 md:text-base">Tanpa download, tanpa ribet</h2>
                        <p class="text-[0.6rem] text-slate-500 md:text-base">GINESIA dapat diakses langsung dari browser Anda, menghilangkan kebutuhan untuk proses download dan instalasi. Nikmati pengalaman membaca yang cepat dan praktis!</p>
                    </div>

                    <div class="w-4/5 rounded-md bg-white p-3 text-xs">
                        <h2 class="mb-2 cursor-pointer font-semibold text-slate-600 md:text-base">Koleksi lengkap</h2>
                        <p class="text-[0.6rem] text-slate-500 md:text-base">Dari buku klasik hingga karya terbaru, dari fiksi hingga referensi akademik—semua ada di GINESIA. Dengan fitur pencarian yang mudah digunakan, menemukan buku favorit Anda menjadi sangat mudah.</p>
                    </div>

                    <div class="w-4/5 translate-x-9 rounded-md bg-white p-3 text-xs">
                        <h2 class="mb-2 cursor-pointer font-semibold text-slate-600 md:text-base">Pengalaman membaca interaktif</h2>
                        <p class="text-[0.6rem] text-slate-500 md:text-base">Nikmati antarmuka yang ramah pengguna, dengan fitur yang memungkinkan Anda menyesuaikan pengalaman membaca sesuai kebutuhan Anda.</p>
                    </div>

                    <div class="w-4/5 rounded-md bg-white p-3 text-xs">
                        <h2 class="mb-2 cursor-pointer font-semibold text-slate-600 md:text-base">Keamanan & Privasi</h2>
                        <p class="text-[0.6rem] text-slate-500 md:text-base">Kami menjaga data dan privasi Anda dengan serius. Bacalah dengan tenang, mengetahui bahwa informasi Anda aman bersama kami.</p>
                    </div>
                </div>
            </div>

            <div id="product" class="p-5 md:p-20">
                <h1 class="mb-5 text-center font-bold text-slate-600 md:text-base">Produk Kami</h1>

                <div class="">
                    <div class="mb-10 flex items-center justify-between gap-2">
                        <div class="w-[60%]">
                            <h1 class="mb-2 text-sm font-bold text-slate-600 md:text-base">Kerjasama Tanpa Beban:</h1>
                            <h2 class="mb-2 text-sm font-semibold text-blue-400 md:text-base">Perpustakaan Digital</h2>
                            <p class="text-[0.6rem] text-slate-500 md:text-base">Kami menawarkan kesempatan luar biasa untuk perpustakaan-perpustakaan di seluruh negeri untuk bergabung dengan GINESIA! Kami menyediakan aplikasi digital khusus untuk setiap perpustakaan <span class="font-semibold text-slate-600">gratis biaya maintenance, server, atau domain</span>. Perpustakaan Anda hanya perlu menambahkan koleksi, sementara kami mengurus aspek teknisnya!</p>
                        </div>

                        <img src="images/landing/ss-web-perpus.png" alt="img-web-perpus" class="w-1/3 md:w-1/4" />
                    </div>

                    <div class="flex flex-wrap items-center gap-2 md:flex-nowrap">
                        <img src="images/landing/ss-tugu-baca.png" alt="img-web-perpus" class="w-1/3" />

                        <div class="w-[60%]">
                            <h1 class="text-sm font-bold text-slate-600 md:text-base">Konsep Perpustakaan Hibrid:</h1>
                            <h2 class="mb-2 text-sm font-semibold text-blue-400 md:text-base">Solusi Terintegrasi untuk Literasi Modern!</h2>
                            <p class="flex flex-col gap-1 text-[0.6rem] text-slate-500 md:text-base">
                                Perkenalkan konsep perpustakaan hibrid yang menggabungkan buku cetak dan digital dalam satu ruangan. Dengan GINESIA, Anda dapat menciptakan ruang literasi sederhana atau tugu baca yang mudah diakses melalui barcode. Konsep inovatif ini memungkinkan pemustaka mengakses:
                                <span><b>Ebook</b>: Koleksi digital lengkap yang dapat diakses kapan saja.</span>
                                <span><b>Audiobook</b>: Buku dalam format audio untuk pengalaman mendengarkan yang nyaman.</span>
                                <span><b>Videobook</b>: Video yang menyajikan konten buku dengan cara yang interaktif dan menarik.</span>
                            </p>
                        </div>

                        <div class="">
                            <h2 class="mb-2 mt-5 text-sm font-semibold text-blue-400 md:text-base">Apa yang Kami Tawarkan untuk Perpustakaan Hibrid:</h2>
                            <ul class="flex flex-col gap-1 text-[0.6rem] text-slate-500 md:text-base">
                                <li><span class="font-semibold">Pengembangan produk inovasi di bidang literasi</span>, seperti: Tugu Baca Hybrid, Ginesia Literacy System, Ruang Baca Hybrid, dll</li>
                                <li><span class="font-semibold">Akses Mudah melalui Barcode</span>: Pemustaka dapat mengakses koleksi digital dengan memindai barcode.</li>
                                <li><span class="font-semibold">Koleksi Lengkap</span>: Ebook, audiobook, dan videobook tersedia dalam satu tempat.</li>
                                <li><span class="font-semibold">Fitur Tambahan</span> seperti Game Edukasi dan Kuis Pembelajaran</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex h-fit flex-col items-center gap-5 bg-blue-100 px-5 py-10">
                <h1 class="text-center text-sm font-bold text-slate-600 md:text-base">Pengembangan produk Platform <span class="text-blue-500">GINESIA</span></h1>
                <p class="text-center text-[0.6rem] text-slate-500 md:text-base">Selain Aplikasi Perpustakaan Digital Berbasis Website, kami juga mengembangkan produk-produk inovasi di bidang literasi, seperti</p>

                <div class="flex flex-col items-center justify-center gap-2 md:flex-row md:flex-wrap">
                    <div class="rounded-md bg-white p-5 md:h-48 md:w-1/3">
                        <h1 class="mb-2 text-sm font-semibold text-slate-600 md:text-base">Tugu Baca Hybrid</h1>
                        <p class="text-[0.6rem] text-slate-500 md:text-[0.8rem]">berupa kiosk touchscreen yang memungkinkanpengguna membaca konten literasi secara online maupun offline.Perangkat ini mempermudah akses ke e-book, audiobook, dankonten digital lainnya, sehingga cocok ditempatkan di area publikuntuk mendukung literasi masyarakat.</p>
                    </div>
                    <div class="rounded-md bg-white p-5 md:h-48 md:w-1/3">
                        <h1 class="mb-2 text-sm font-semibold text-slate-600 md:text-base">Ginesia Literacy System</h1>
                        <p class="text-[0.6rem] text-slate-500 md:text-[0.8rem]">berupa server GLS yang menyediakanberbagai konten digital, seperti e-book, audiobook, dan materiedukasi lainnya, untuk mendukung program literasi digital. Sistem inifleksibel dan dapat diterapkan di sekolah, perpustakaan keliling,maupun pusat belajar komunitas, dengan akses yang mudah kapansaja, bahkan tanpa koneksi internet.</p>
                    </div>
                    <div class="rounded-md bg-white p-5 md:h-48 md:w-1/3">
                        <h1 class="mb-2 text-sm font-semibold text-slate-600 md:text-base">Ruang Baca Hybrid</h1>
                        <p class="text-[0.6rem] text-slate-500 md:text-[0.8rem]">mengintegrasikan koleksi buku fisik dan kontendigital untuk memenuhi kebutuhan pembaca modern. Tempat inimenyediakan fasilitas membaca nyaman, baik untuk bahan cetakmaupun digital, serta dilengkapi perangkat elektronik untuk akseskoleksi virtual.</p>
                    </div>
                    <div class="rounded-md bg-white p-5 md:h-48 md:w-1/3">
                        <h1 class="mb-2 text-sm font-semibold text-slate-600 md:text-base">Internalisasi Sekolah</h1>
                        <p class="text-[0.6rem] text-slate-500 md:text-[0.8rem]">program yang menghadirkan jaringan Wi-Fi berkecepatan tinggi dan infrastruktur teknologi untuk mendukungpembelajaran berbasis digital. Program ini menawarkan dua opsikonektivitas, yaitu melalui ISP lokal atau satelit Starlink, yang dapatdisesuaikan dengan kondisi lingkungan sekolah, termasuk areaterpencil yang sulit dijangkau jaringan kabel.</p>
                    </div>
                </div>
            </div>

            <div class="relative flex min-h-40 flex-col items-center justify-center gap-5 bg-blue-500 p-10 text-white md:h-80 md:gap-10">
                <h1 class="text-center text-xl font-semibold md:text-2xl">Bangun Koleksi Digital Anda Bersama Kami !</h1>
                <a class="w-2/2 flex animate-bounce items-center justify-between gap-2 rounded-full bg-white px-5 py-3 text-xs text-black hover:bg-blue-100 hover:drop-shadow-lg" href="https://wa.me/+621226032731" target="_blank" rel="noopener noreferrer"
                    >Konsultasi Sekarang
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>

            <div id="contact" class="flex h-fit flex-col items-center justify-center p-5 text-slate-600 md:p-10">
                <img src="images/logo/logo.svg" alt="img-logo" class="w-24 md:w-40" />

                <div class="mt-5 w-1/2 md:flex md:gap-10">
                    <p class="mt-2 flex items-center gap-3 text-xs">
                        <img src="images/icons/email.png" alt="icon-email" class="w-5 rounded-full bg-slate-300 p-1" />
                        info@pustakadigital.id
                    </p>
                    <p class="mt-2 flex items-center gap-3 text-xs">
                        <img src="images/icons/phone-call.png" alt="icon-phone" class="w-5 rounded-full bg-slate-300 p-1" />
                        0812-2603-2731
                    </p>
                    <p class="mt-2 flex items-center gap-3 text-xs">
                        <img src="images/icons/maps-and-flags.png" alt="icon-maps" class="w-5 rounded-full bg-slate-300 p-1" />
                        Jl. Glondong Gg. Nakula, Bangunharjo, Sewon, Bantul, DI Yogyakarta 55188
                    </p>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
export default {
    components: {},

    data() {
        return {}
    },

    mounted() {},

    methods: {
        handleNavMobile() {
            const navLinks = document.getElementById('nav-mobile')
            if (navLinks.classList.contains('hidden')) {
                navLinks.classList.remove('hidden')
                navLinks.classList.add('flex')
            } else {
                navLinks.classList.remove('flex')
                navLinks.classList.add('hidden')
            }
        },
    },
}
</script>
