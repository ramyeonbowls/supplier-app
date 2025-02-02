<template>
    <div class="">
        <nav class="relative px-5 md:px-20 pb-5 flex justify-between items-center border-b-[0.5px] border-b-slate-100">
            <img src="images/logo/logo.svg" alt="img-logo" class="w-24 md:w-40">

            <div class="menu-icon md:hidden" @click="handleNavMobile">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="" class="size-6 stroke-svg-icon-color">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </div>

            <div id="nav-mobile" class="absolute top-0 left-0 w-full hidden items-center justify-center  h-44 bg-white translate-y-14 drop-shadow-sm" @click="handleNavMobile">
                <ul class="gap-5 text-slate-500 cursor-pointer flex flex-col text-center w-full text-sm">
                    <li class="hover:text-slate-700 hover:font-semibold"><a href="#about">Tentang kami</a></li>
                    <hr>
                    <li class="hover:text-slate-700 hover:font-semibold"><a href="#product">Produk</a></li>
                    <hr>
                    <li class="hover:text-slate-700 hover:font-semibold"><a href="#contact">Kontak</a></li>
                </ul>
            </div>

            <ul class="hidden gap-5 text-slate-500 cursor-pointer md:flex">
                <li class="hover:text-slate-700 hover:font-semibold"><a href="#about">Tentang kami</a></li>
                <li class="hover:text-slate-700 hover:font-semibold"><a href="#product">Produk</a></li>
                <li class="hover:text-slate-700 hover:font-semibold"><a href="#contact">Kontak</a></li>
            </ul>

            <a href="pendaftaran-client" class="bg-blue-600 hover:bg-blue-500 px-5 py-3 text-sm text-white font-semibold rounded-full hidden md:flex md:items-center md:gap-2">Daftar Sekarang
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                </svg>

            </a>
        </nav>
        <main class="">
            <div class="banner mb-5 flex flex-col items-center gap-4 md:flex-row md:px-10">
                
                <img src="images/landing/public-library-visitors.png" alt="img-banner" class="w-[70%] md:hidden">
                
                <div class="flex flex-col items-center justify-center gap-2 px-5 md:w-1/2">
                    <h1 class="text-sm uppercase text-center font-semibold text-slate-600 md:text-lg">inovasi perpustakaan masa depan</h1>
                    <p class="text-[0.6rem] text-center text-slate-500 mb-5 md:text-[1rem]">Platform perpustakaan digital yang bukan hanya menghadirkan ribuan buku ke ujung jari Anda, tetapi juga membuka peluang baru bagi perpustakaan dengan solusi perpustakaan hibrid kami. Dan sekarang, kami memiliki tawaran istimewa untuk Anda!</p>
                    <a href="#about" class="bg-blue-500 text-white text-xs  py-2 px-5 rounded-full flex gap-2 items-center justify-center cursor-pointer hover:bg-blue-400">
                        <p>pelajari selengkapnya</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>

                    </a>
                </div>

                <img src="images/landing/public-library-visitors.png" alt="img-banner" class="w-[70%] hidden md:block md:w-1/2">

            </div>

            <div id="about" class="relative bg-blue-100 px-5 py-10 h-[700px] md:h-[850px] flex items-center md:px-10 md:static">
                <img src="images/landing/ebooks-collection-library.png" alt="img-ebook" class="md:w-3/4">
                
                <div class="absolute top-0 w-full flex flex-col gap-3 md:static md:top-auto">
                    <h1 class="text-sm mt-10 mb-5 text-center md:text-[1rem] lg:text-[1.3rem]">Kenapa <span class="font-bold text-blue-500">GINESIA</span> ?</h1>

                    <div class="text-xs bg-white p-3 rounded-md w-4/5">
                        <h2 class="cursor-pointer mb-2 font-semibold text-slate-600 md:text-base">Akses tanpa batas</h2>
                        <p class="text-slate-500 text-[0.6rem] md:text-base">Temukan ribuan buku dan materi pelajaran hanya dengan beberapa klik. GINESIA menawarkan kemudahan akses melalui website, tanpa perlu mengunduh aplikasi—cukup buka browser dan mulailah membaca!</p>
                    </div>

                    <div class="text-xs bg-white p-3 rounded-md w-4/5 translate-x-9">
                        <h2 class="cursor-pointer mb-2 font-semibold text-slate-600 md:text-base">Tanpa download, tanpa ribet</h2>
                        <p class="text-slate-500 text-[0.6rem] md:text-base">GINESIA dapat diakses langsung dari browser Anda, menghilangkan kebutuhan untuk proses download dan instalasi. Nikmati pengalaman membaca yang cepat dan praktis!</p>
                    </div>

                     <div class="text-xs bg-white p-3 rounded-md w-4/5">
                        <h2 class="cursor-pointer mb-2 font-semibold text-slate-600 md:text-base">Koleksi lengkap</h2>
                        <p class="text-slate-500 text-[0.6rem] md:text-base">Dari buku klasik hingga karya terbaru, dari fiksi hingga referensi akademik—semua ada di GINESIA. Dengan fitur pencarian yang mudah digunakan, menemukan buku favorit Anda menjadi sangat mudah.</p>
                    </div>

                    <div class="text-xs bg-white p-3 rounded-md w-4/5 translate-x-9">
                        <h2  class="cursor-pointer mb-2 font-semibold text-slate-600 md:text-base">Pengalaman membaca interaktif</h2>
                        <p class="text-slate-500 text-[0.6rem] md:text-base">Nikmati antarmuka yang ramah pengguna, dengan fitur yang memungkinkan Anda menyesuaikan pengalaman membaca sesuai kebutuhan Anda.</p>
                    </div>

                    <div class="text-xs bg-white p-3 rounded-md w-4/5">
                        <h2 class="cursor-pointer mb-2 font-semibold text-slate-600 md:text-base">Keamanan & Privasi</h2>
                        <p class="text-slate-500 text-[0.6rem] md:text-base">Kami menjaga data dan privasi Anda dengan serius. Bacalah dengan tenang, mengetahui bahwa informasi Anda aman bersama kami.</p>
                    </div>
                </div>
            </div>

            <div id="product" class="p-5 md:p-20">
                <h1 class="text-center md:text-base mb-5 font-bold text-slate-600">Produk Kami</h1>

                <div class="">
                    <div class="flex items-center gap-2 mb-10 justify-between">
                        <div class="w-[60%]">
                            <h1 class="text-sm md:text-base text-slate-600 font-bold mb-2">Kerjasama Tanpa Beban:</h1>
                            <h2 class="text-sm md:text-base text-blue-400 font-semibold mb-2">Perpustakaan Digital</h2>
                            <p class="text-[0.6rem] text-slate-500 md:text-base">Kami menawarkan kesempatan luar biasa untuk perpustakaan-perpustakaan di seluruh negeri untuk bergabung dengan GINESIA! Kami menyediakan aplikasi digital khusus untuk setiap perpustakaan <span class="font-semibold text-slate-600">gratis biaya maintenance, server, atau domain</span>. Perpustakaan Anda hanya perlu menambahkan koleksi, sementara kami mengurus aspek teknisnya!</p>
                        </div>
    
                        <img src="images/landing/ss-web-perpus.png" alt="img-web-perpus" class="w-1/3 md:w-1/4">
                    </div>
    
                    <div class="flex items-center gap-2 flex-wrap md:flex-nowrap">
                        <img src="images/landing/ss-tugu-baca.png" alt="img-web-perpus" class="w-1/3">
                        
                        <div class="w-[60%]">
                            <h1 class="text-sm text-slate-600 font-bold md:text-base">Konsep Perpustakaan Hibrid:</h1>
                            <h2 class="text-sm text-blue-400 font-semibold mb-2 md:text-base">Solusi Terintegrasi untuk Literasi Modern!</h2>
                            <p class="text-[0.6rem] text-slate-500 flex flex-col gap-1 md:text-base">Perkenalkan konsep perpustakaan hibrid yang menggabungkan buku cetak dan digital dalam satu ruangan. Dengan GINESIA, Anda dapat menciptakan ruang literasi sederhana atau tugu baca yang mudah diakses melalui barcode. Konsep inovatif ini memungkinkan pemustaka mengakses:
                                <span><b>Ebook</b>: Koleksi digital lengkap yang dapat diakses kapan saja.</span>
                                <span><b>Audiobook</b>: Buku dalam format audio untuk pengalaman mendengarkan yang nyaman.</span>
                                <span><b>Videobook</b>: Video yang menyajikan konten buku dengan cara yang interaktif dan menarik.</span>
                            </p>
                        </div>

                        <div class="">
                            <h2 class="text-sm text-blue-400 font-semibold mb-2 mt-5 md:text-base">Apa yang Kami Tawarkan untuk Perpustakaan Hibrid:</h2>
                            <ul  class="text-[0.6rem] text-slate-500 flex flex-col gap-1 md:text-base">
                                <li><span class="font-semibold">Pengembangan produk inovasi di bidang literasi</span>, seperti: Tugu
                                    Baca Hybrid, Ginesia Literacy System, Ruang Baca Hybrid, dll</li>
                                <li><span class="font-semibold">Akses Mudah melalui Barcode</span>: Pemustaka dapat mengakses
                                    koleksi digital dengan memindai barcode.</li>
                                <li><span class="font-semibold">Koleksi Lengkap</span>: Ebook, audiobook, dan videobook tersedia
                                    dalam satu tempat.</li>
                                <li><span class="font-semibold">Fitur Tambahan</span> seperti Game Edukasi dan Kuis Pembelajaran</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="bg-blue-100 px-5 py-10 h-fit flex flex-col items-center gap-5">
                <h1 class="text-sm font-bold text-slate-600 text-center md:text-base">Pengembangan produk Platform <span class="text-blue-500">GINESIA</span></h1>
                <p class="text-center text-[0.6rem] text-slate-500 md:text-base">Selain Aplikasi Perpustakaan Digital Berbasis Website, kami juga mengembangkan produk-produk inovasi di bidang literasi, seperti</p>

                <div class="flex flex-col gap-2 md:flex-row md:flex-wrap items-center justify-center">
                    <div class="bg-white p-5 rounded-md md:w-1/3 md:h-48">
                        <h1 class="text-sm font-semibold text-slate-600 mb-2 md:text-base">Tugu Baca Hybrid</h1>
                        <p class="text-[0.6rem] text-slate-500 md:text-[0.8rem]">berupa kiosk touchscreen yang memungkinkanpengguna membaca konten literasi secara online maupun offline.Perangkat ini mempermudah akses ke e-book, audiobook, dankonten digital lainnya, sehingga cocok ditempatkan di area publikuntuk mendukung literasi masyarakat.</p>
                    </div>
                    <div class="bg-white p-5 rounded-md md:w-1/3 md:h-48">
                        <h1 class="text-sm font-semibold text-slate-600 mb-2 md:text-base">Ginesia Literacy System</h1>
                        <p class="text-[0.6rem] text-slate-500  md:text-[0.8rem]">berupa server GLS yang menyediakanberbagai konten digital, seperti e-book, audiobook, dan materiedukasi lainnya, untuk mendukung program literasi digital. Sistem inifleksibel dan dapat diterapkan di sekolah, perpustakaan keliling,maupun pusat belajar komunitas, dengan akses yang mudah kapansaja, bahkan tanpa koneksi internet.</p>
                    </div>
                    <div class="bg-white p-5 rounded-md md:w-1/3 md:h-48">
                        <h1 class="text-sm font-semibold text-slate-600 mb-2 md:text-base">Ruang Baca Hybrid</h1>
                        <p class="text-[0.6rem] text-slate-500 md:text-[0.8rem]">mengintegrasikan koleksi buku fisik dan kontendigital untuk memenuhi kebutuhan pembaca modern. Tempat inimenyediakan fasilitas membaca nyaman, baik untuk bahan cetakmaupun digital, serta dilengkapi perangkat elektronik untuk akseskoleksi virtual.</p>
                    </div>
                    <div class="bg-white p-5 rounded-md md:w-1/3 md:h-48">
                        <h1 class="text-sm font-semibold text-slate-600 mb-2 md:text-base">Internalisasi Sekolah</h1>
                        <p class="text-[0.6rem] text-slate-500 md:text-[0.8rem]">program yang menghadirkan jaringan Wi-Fi berkecepatan tinggi dan infrastruktur teknologi untuk mendukungpembelajaran berbasis digital. Program ini menawarkan dua opsikonektivitas, yaitu melalui ISP lokal atau satelit Starlink, yang dapatdisesuaikan dengan kondisi lingkungan sekolah, termasuk areaterpencil yang sulit dijangkau jaringan kabel.</p>
                    </div>
                </div>
            </div>

            <div class="relative bg-blue-500 min-h-40 text-white flex flex-col p-10 items-center justify-center gap-5 md:h-80 md:gap-10">
                <h1 class="text-center text-xl md:text-2xl font-semibold">Bangun Koleksi Digital Anda Bersama Kami !</h1>
                <a class="text-black bg-white rounded-full px-5 py-3 text-xs w-2/2 flex justify-between items-center gap-2 hover:drop-shadow-lg hover:bg-blue-100 animate-bounce" href="https://wa.me/+621226032731" target="_blank" rel="noopener noreferrer">Konsultasi Sekarang
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 30 30" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>

            <div id="contact" class="h-fit p-5 md:p-10 flex flex-col items-center justify-center text-slate-600">
                <img src="images/logo/logo.svg" alt="img-logo" class="w-24 md:w-40">

                <div class="w-1/2 mt-5 md:flex md:gap-10">
                    <p class="flex gap-3 mt-2 text-xs items-center">
                        <img src="images/icons/email.png" alt="icon-email" class="w-5 bg-slate-300 p-1 rounded-full">
                        info@pustakadigital.id
                    </p>
                    <p class="flex gap-3 mt-2 text-xs items-center">
                        <img src="images/icons/phone-call.png" alt="icon-phone" class="w-5  bg-slate-300 p-1 rounded-full">
                        0812-2603-2731
                    </p>
                    <p class="flex gap-3 mt-2 text-xs items-center">
                        <img src="images/icons/maps-and-flags.png" alt="icon-maps" class="w-5  bg-slate-300 p-1 rounded-full">
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
        handleNavMobile(){
            const navLinks = document.getElementById('nav-mobile')
            if(navLinks.classList.contains('hidden')){
                navLinks.classList.remove('hidden')
                navLinks.classList.add('flex')
            }else{
                navLinks.classList.remove('flex')
                navLinks.classList.add('hidden')
            }
        }
    },
}
</script>
