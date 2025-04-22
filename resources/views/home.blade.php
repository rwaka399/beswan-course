<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body>

    <!-- Hero Section dengan Navbar di atas gambar -->
    <header class="relative h-[600px] bg-cover bg-center overflow-hidden"
        style="background-image: url('/storage/beswan.jpg');">
        <!-- Navbar -->
        <nav class="relative z-10 flex justify-center pt-6">
            <div
                class="bg-white bg-opacity-90 shadow-lg rounded-xl px-8 py-3 flex items-center justify-between w-[90%] max-w-7xl">
                <!-- Logo -->
                <div class="font-bold text-xl text-gray-800">Home</div>

                <!-- Nav Links -->
                <ul class="flex gap-6 text-gray-700 font-medium">
                    <li><a href="#" class="hover:text-blue-500">Pages</a></li>
                    <li><a href="#" class="hover:text-blue-500">Sections</a></li>
                    <li><a href="#" class="hover:text-blue-500">Paket</a></li>
                    <li><a href="#" class="hover:text-blue-500">Contact</a></li>
                </ul>

                <!-- Auth Buttons -->
                <!-- Auth Buttons -->
                @guest
                    <div class="flex gap-2">
                        <a href="{{ route('login') }}"
                            class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                            Register
                        </a>
                    </div>
                @endguest

                @auth
                    <div x-data="{ open: false }" class="relative">
                        <!-- Tombol avatar -->
                        <button @click="open = !open" class="focus:outline-none">
                            <img src="{{ Auth::user()->profile_picture ?? '/storage/default-avatar.png' }}" alt="Profile"
                                class="w-10 h-10 rounded-full object-cover border border-gray-300">
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-50">
                            <a href="{{ route('profile-index')}}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100 hover:text-red-600">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth


            </div>
        </nav>

        <!-- Hero Text -->
        <div class="absolute inset-0 z-0 flex flex-col items-center justify-center text-white text-center">
            <h1 class="text-4xl font-bold drop-shadow-lg">BESWAN COURSE</h1>
            <p class="text-lg mt-2 drop-shadow-md">Tempat Les Bahasa Inggris dengan Kualitas Terbaik</p>
        </div>
    </header>
    <!-- Section Konten Bawah -->
    <section class="relative -mt-16 z-20">
        <div
            class="bg-white max-w-[1400px] mx-auto rounded-xl shadow-lg p-10 grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
            <div>
                <h2 class="text-3xl font-bold">1000+</h2>
                <p class="font-semibold mt-2">Lulusan</p>
                <p class="text-sm text-gray-500 mt-1">Siswa yang sukses menguasai bahasa Inggris</p>
            </div>
            <div>
                <h2 class="text-3xl font-bold">10+</h2>
                <p class="font-semibold mt-2">Tahun Pengalaman</p>
                <p class="text-sm text-gray-500 mt-1">Pengajar bersertifikat</p>
            </div>
            <div>
                <h2 class="text-3xl font-bold">95%</h2>
                <p class="font-semibold mt-2">Kefasihan</p>
                <p class="text-sm text-gray-500 mt-1">Siswa percaya diri berbicara dalam 3 bulan</p>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-gray-800">Keuntungan Mengikuti Kursus Kami</h2>
            <p class="mt-4 text-lg text-gray-600">Kami menawarkan berbagai manfaat yang akan membantu Anda menguasai
                bahasa dengan cara yang efektif dan menyenangkan.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mt-10">
                <div class="p-6 bg-gray-50 rounded-xl shadow-lg">
                    <img src="/path/to/benefit1.jpg" alt="Benefit 1" class="w-24 h-24 mx-auto">
                    <h3 class="text-2xl font-semibold text-gray-800 mt-6">Pengajaran yang Profesional</h3>
                    <p class="mt-4 text-gray-600">Guru-guru kami berpengalaman dalam mengajar bahasa dan berkomitmen
                        untuk membantu Anda mencapai tujuan belajar dengan cara yang menyenangkan.</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-xl shadow-lg">
                    <img src="/path/to/benefit2.jpg" alt="Benefit 2" class="w-24 h-24 mx-auto">
                    <h3 class="text-2xl font-semibold text-gray-800 mt-6">Kelas Interaktif</h3>
                    <p class="mt-4 text-gray-600">Kami menyediakan kelas yang interaktif dengan berbagai media
                        pembelajaran agar Anda bisa belajar dengan cara yang lebih menarik dan tidak membosankan.</p>
                </div>
                <div class="p-6 bg-gray-50 rounded-xl shadow-lg">
                    <img src="/path/to/benefit3.jpg" alt="Benefit 3" class="w-24 h-24 mx-auto">
                    <h3 class="text-2xl font-semibold text-gray-800 mt-6">Pariwisata</h3>
                    <p class="mt-4 text-gray-600">Dengan adanya jadwal yang padat dapat membuat siswa pusing, dengan
                        adanya kelas pariwisata yang dilakukan tiap bulan sekali akan menghilangkan pusing siswa</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto text-center">
            <h3 class="text-3xl font-semibold text-gray-800">Tim Pengajar Kami</h3>
            <p class="mt-4 text-lg text-gray-600">Tim pengajar kami terdiri dari para profesional yang berpengalaman
                dalam bidang pengajaran bahasa. Berikut adalah dua di antaranya:</p>

            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-10">
                <!-- Card Pengajar 1 -->
                <div class="bg-gray-50 rounded-xl shadow-md p-6 text-center">
                    <img class="w-32 h-32 rounded-full mx-auto" src="https://randomuser.me/api/portraits/men/1.jpg"
                        alt="Pengajar 1">
                    <h4 class="mt-4 text-xl font-semibold text-gray-800">Mr. Hadi</h4>
                    <p class="mt-2 text-gray-600">Pengajar Bahasa Inggris</p>
                    <p class="mt-4 text-gray-500">Budi memiliki pengalaman lebih dari 10 tahun dalam mengajar Bahasa
                        Inggris dan telah membantu banyak siswa mencapai tujuan mereka dalam ujian internasional.</p>
                </div>

                <!-- Card Pengajar 2 -->
                <div class="bg-gray-50 rounded-xl shadow-md p-6 text-center">
                    <img class="w-32 h-32 rounded-full mx-auto" src="https://randomuser.me/api/portraits/women/2.jpg"
                        alt="Pengajar 2">
                    <h4 class="mt-4 text-xl font-semibold text-gray-800">Mrs. Nina</h4>
                    <p class="mt-2 text-gray-600">Pengajar Bahasa Inggris</p>
                    <p class="mt-4 text-gray-500">Siti adalah pengajar Bahasa Inggris yang berlisensi dan berpengalaman
                        dalam mengajar Bahasa Jepang untuk pemula hingga tingkat lanjutan.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-100 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h2 class="text-4xl font-semibol text-gray-900 sm:text-5xl">Paket Pembelajaran</h2>
                <p class="mt-4 text-lg text-gray-600">Pilih paket yang sesuai dengan kebutuhan belajar Anda</p>
            </div>

            <!-- Packages Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                @forelse ($lessonPackages as $package)
                    <div
                        class="bg-white shadow-lg rounded-xl p-8 text-center transform transition duration-300 hover:shadow-xl hover:-translate-y-1">
                        <!-- Icon -->
                        <div class="flex justify-center mb-4">
                            <svg class="h-12 w-12 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 006 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3-.512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>

                        <!-- Package Name -->
                        <h3 class="text-2xl font-bold text-gray-900">{{ $package->lesson_package_name }}</h3>

                        <!-- Description -->
                        <p class="mt-3 text-gray-600 text-sm">
                            {{ $package->lesson_package_description ?? 'Belajar dengan paket ini untuk pengalaman terbaik!' }}
                        </p>

                        <!-- Duration -->
                        <p class="mt-4 text-gray-700">
                            Durasi:
                            <span class="font-semibold">
                                {{ $package->lesson_duration == 4 ? '1 bulan' : $package->lesson_duration . ' minggu' }}
                            </span>
                        </p>

                        <!-- Price -->
                        <p class="mt-4 text-2xl font-bold text-gray-900">Rp
                            {{ number_format($package->lesson_package_price, 0, ',', '.') }}</p>

                        <!-- Button -->
                        <a href="{{ route('checkout', $package->lesson_package_id) }}"
                            class="inline-block mt-6 px-6 py-3 bg-blue-600 text-white font-semibold rounded-full hover:bg-blue-700 transition duration-200">
                            Daftar Sekarang
                        </a>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-10">
                        <p class="text-gray-600 text-lg">Belum ada paket pembelajaran yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl font-bold text-gray-800 text-left">Pertanyaan yang Sering Diajukan</h2>
            <p class="mt-4 text-lg text-gray-600 text-left">Berikut beberapa pertanyaan yang sering diajukan oleh siswa
                kami. Jika Anda punya pertanyaan lain, jangan ragu untuk menghubungi kami.</p>
            <div class="mt-10 space-y-6">
                <div class="bg-gray-50 rounded-xl p-6 shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Apa saja kursus bahasa yang tersedia?</h3>
                    <p class="mt-4 text-gray-600">Kami menyediakan kursus Bahasa Inggris, Bahasa Jepang, Bahasa
                        Prancis,
                        dan beberapa bahasa lainnya. Anda bisa memilih kursus sesuai dengan kebutuhan dan minat.</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-6 shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Berapa lama durasi setiap kursus?</h3>
                    <p class="mt-4 text-gray-600">Durasi setiap kursus berbeda, tergantung pada jenis kursus yang Anda
                        pilih. Biasanya kursus berlangsung selama satu bulan dengan pertemuan 2-3 kali seminggu.</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-6 shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Apakah ada kelas online?</h3>
                    <p class="mt-4 text-gray-600">Ya, kami menyediakan kelas online untuk semua kursus yang kami
                        tawarkan. Anda bisa mengikuti kelas dari mana saja dengan koneksi internet yang stabil.</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-6 shadow-md">
                    <h3 class="text-xl font-semibold text-gray-800">Bagaimana cara mendaftar?</h3>
                    <p class="mt-4 text-gray-600">Anda dapat mendaftar secara online melalui halaman pendaftaran di
                        website kami, atau datang langsung ke lokasi kami.</p>
                </div>
            </div>
        </div>
    </section>



    <section class="py-16 bg-indigo-600 text-white text-center">
        <h2 class="text-4xl font-bold">Siap untuk Mulai Belajar?</h2>
        <p class="mt-4 text-lg">Bergabunglah dengan kursus kami dan kuasai bahasa impian Anda. Daftar sekarang dan
            mulailah perjalanan belajar Anda!</p>
        <a href="/daftar"
            class="mt-6 inline-block bg-yellow-500 text-gray-800 py-3 px-8 rounded-full font-semibold hover:bg-yellow-400 transition duration-300">Daftar
            Sekarang</a>
    </section>




    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


</body>

</html>
