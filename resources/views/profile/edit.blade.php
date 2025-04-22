@extends('profile.layout')

@section('title', 'Edit Profil')

@section('content')
    <!-- Breadcrumb -->
    <div class="sticky top-12 inset-x-0 z-10 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center py-3">
            <ol class="flex items-center whitespace-nowrap">
                <li class="flex items-center text-base text-gray-800">
                    <a href="{{ route('profile-index') }}" class="hover:text-blue-600 font-medium">Profile</a>
                    <svg class="shrink-0 mx-3 overflow-visible size-3 text-gray-400" width="16" height="16"
                        viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </li>
                <li class="text-base font-semibold text-gray-800 truncate" aria-current="page">
                    Edit Profile
                </li>
            </ol>
        </div>
    </div>

    <!-- Form Edit Profile -->
    <div class="max-w-4xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
        <div class="w-full bg-white rounded-3xl shadow-xl p-8 space-y-6">
            <!-- Header -->
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21a8 8 0 0116 0H4z" />
                </svg>
                <h2 class="mt-3 text-2xl font-bold text-gray-800">Edit Profile</h2>
                <p class="text-sm text-gray-500">Perbarui informasi pribadi Anda</p>
            </div>

            <!-- Flash Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative transition-opacity duration-300"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative transition-opacity duration-300"
                    role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Error Validasi -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative transition-opacity duration-300"
                    role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('profile-update') }}" method="POST" class="space-y-4" aria-label="Edit profile form">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800"
                        placeholder="Masukkan nama lengkap" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800"
                        placeholder="Masukkan alamat email" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="relative">
                    <label for="password" class="block text-sm font-semibold text-gray-700">Kata Sandi Baru</label>
                    <div class="mt-2 relative">
                        <input type="password" name="password" id="password"
                            class="block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 pr-10 text-gray-800"
                            placeholder="Masukkan kata sandi baru">
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700"
                            aria-label="Toggle password visibility">
                            <svg id="eyeIconPassword" class="h-5 w-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <small class="text-gray-500">Kosongkan jika tidak ingin mengubah kata sandi</small>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone_number" class="block text-sm font-semibold text-gray-700">Nomor Telepon</label>
                    <input type="text" name="phone_number" id="phone_number"
                        value="{{ old('phone_number', auth()->user()->phone_number) }}"
                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800"
                        placeholder="+628123456789">
                    @error('phone_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Province, City, Kecamatan -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Province -->
                    <div>
                        <label for="province" class="block text-sm font-semibold text-gray-700">Provinsi</label>
                        <select name="province" id="province"
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800">
                            <option value="" disabled selected>P Josephineilih Provinsi</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province['nama'] }}"
                                    {{ old('province', auth()->user()->province) == $province['nama'] ? 'selected' : '' }}
                                    data-id="{{ $province['id'] }}">
                                    {{ $province['nama'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('province')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-semibold text-gray-700">Kota / Kabupaten</label>
                        <select name="city" id="city"
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800">
                            <option value="" disabled selected>Pilih Kota</option>
                        </select>
                        @error('city')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kecamatan -->
                    <div>
                        <label for="kecamatan" class="block text-sm font-semibold text-gray-700">Kecamatan</label>
                        <select name="kecamatan" id="kecamatan"
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800">
                            <option value="" disabled selected>Pilih Kecamatan</option>
                        </select>
                        @error('kecamatan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                    <textarea name="address" id="address" rows="3"
                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800 resize-none">{{ old('address', auth()->user()->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('profile-index') }}"
                        class="w-1/2 bg-gray-200 text-gray-700 font-semibold py-3 px-4 rounded-xl hover:bg-gray-300 transition duration-200 text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="w-1/2 bg-blue-600 text-white font-semibold py-3 px-4 rounded-xl hover:bg-blue-700 transition duration-200">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Flash Message auto disappear
            const flashes = document.querySelectorAll('[role="alert"]');
            flashes.forEach(el => {
                setTimeout(() => {
                    el.classList.add('opacity-0');
                    setTimeout(() => el.remove(), 300);
                }, 3000);
            });

            // Logika untuk dropdown provinsi, kota, dan kecamatan
            const provinceSelect = document.getElementById('province');
            const citySelect = document.getElementById('city');
            const districtSelect = document.getElementById('kecamatan');

            provinceSelect.addEventListener('change', function() {
                const provinceId = this.options[this.selectedIndex].dataset.id;
                if (!provinceId) return;

                fetch(`https://ibnux.github.io/data-indonesia/kota/${provinceId}.json`)
                    .then(response => {
                        if (!response.ok) throw new Error('Gagal memuat data kota');
                        return response.json();
                    })
                    .then(data => {
                        citySelect.innerHTML = '<option value="" disabled selected>Pilih Kota</option>';
                        districtSelect.innerHTML =
                            '<option value="" disabled selected>Pilih Kecamatan</option>';
                        data.forEach(city => {
                            const option = new Option(city.nama, city.nama);
                            option.dataset.id = city.id;
                            citySelect.add(option);
                        });
                        if ("{{ old('city', auth()->user()->city) }}") {
                            citySelect.value = "{{ old('city', auth()->user()->city) }}";
                            citySelect.dispatchEvent(new Event('change'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal memuat data kota. Silakan coba lagi.');
                        citySelect.innerHTML =
                            '<option value="" disabled selected>Error: Tidak dapat memuat kota</option>';
                    });
            });

            citySelect.addEventListener('change', function() {
                const cityId = this.options[this.selectedIndex].dataset.id;
                if (!cityId) return;

                fetch(`https://ibnux.github.io/data-indonesia/kecamatan/${cityId}.json`)
                    .then(response => {
                        if (!response.ok) throw new Error('Gagal memuat data kecamatan');
                        return response.json();
                    })
                    .then(data => {
                        districtSelect.innerHTML =
                            '<option value="" disabled selected>Pilih Kecamatan</option>';
                        data.forEach(district => {
                            const option = new Option(district.nama, district.nama);
                            districtSelect.add(option);
                        });
                        if ("{{ old('kecamatan', auth()->user()->kecamatan) }}") {
                            districtSelect.value = "{{ old('kecamatan', auth()->user()->kecamatan) }}";
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal memuat data kecamatan. Silakan coba lagi.');
                        districtSelect.innerHTML =
                            '<option value="" disabled selected>Error: Tidak dapat memuat kecamatan</option>';
                    });
            });

            // Trigger province change if there's an old value or user data
            if ("{{ old('province', auth()->user()->province) }}") {
                provinceSelect.value = "{{ old('province', auth()->user()->province) }}";
                provinceSelect.dispatchEvent(new Event('change'));
            }

            // Logika untuk toggle visibility password
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const eyeIconPassword = document.getElementById('eyeIconPassword');

            togglePassword.addEventListener('click', function() {
                const isPasswordVisible = passwordInput.type === 'text';
                passwordInput.type = isPasswordVisible ? 'password' : 'text';
                eyeIconPassword.innerHTML = isPasswordVisible ?
                    `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />` :
                    `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
            });
        });
    </script>
@endsection