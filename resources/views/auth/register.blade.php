<!doctype html>
<html>
<head>
    <title>Register</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-3xl bg-white rounded-3xl shadow-xl p-8 space-y-6">
        <div class="text-center">
            <svg class="mx-auto h-12 w-12 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21a8 8 0 0116 0H4z" />
            </svg>
            <h2 class="mt-3 text-2xl font-bold text-gray-800">Create Account</h2>
            <p class="text-sm text-gray-500">Sign up to get started</p>
        </div>

        <!-- Notifikasi Success -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative transition-opacity duration-300" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Notifikasi Error -->
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative transition-opacity duration-300" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Error Validasi -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative transition-opacity duration-300" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}" class="space-y-4" aria-label="Register form">
            @csrf
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700">Full Name</label>
                <input id="name" name="name" type="text" required autofocus
                       class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800"
                       value="{{ old('name') }}" placeholder="Enter your full name">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700">Email address</label>
                <input id="email" name="email" type="email" required
                       class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800"
                       value="{{ old('email') }}" placeholder="Enter your email">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="relative">
                <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                <input id="password" name="password" type="password" required
                       class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 pr-10 text-gray-800"
                       placeholder="Enter your password" aria-describedby="password-error">
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3 mt-6 text-gray-500 hover:text-gray-700" aria-label="Toggle password visibility">
                    <svg id="eyeIconPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
                @error('password')
                    <p id="password-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="relative">
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 pr-10 text-gray-800"
                       placeholder="Confirm your password" aria-describedby="password-confirmation-error">
                <button type="button" id="togglePasswordConfirmation" class="absolute inset-y-0 right-0 flex items-center pr-3 mt-6 text-gray-500 hover:text-gray-700" aria-label="Toggle confirm password visibility">
                    <svg id="eyeIconPasswordConfirmation" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
                @error('password_confirmation')
                    <p id="password-confirmation-error" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="phone_number" class="block text-sm font-semibold text-gray-700">Phone Number</label>
                <input id="phone_number" name="phone_number" type="text" required
                       class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800"
                       placeholder="+628123456789" value="{{ old('phone_number') }}">
                @error('phone_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="province" class="block text-sm font-semibold text-gray-700">Provinsi</label>
                    <select id="province" name="province" required
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800">
                        <option value="" disabled selected>Pilih Provinsi</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province['nama'] }}" data-id="{{ $province['id'] }}"
                                    {{ old('province') == $province['nama'] ? 'selected' : '' }}>
                                {{ $province['nama'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('province')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="city" class="block text-sm font-semibold text-gray-700">Kota / Kabupaten</label>
                    <select id="city" name="city" required
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800">
                        <option value="" disabled selected>Pilih Kota</option>
                    </select>
                    @error('city')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="kecamatan" class="block text-sm font-semibold text-gray-700">Kecamatan</label>
                    <select id="kecamatan" name="kecamatan" required
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800">
                        <option value="" disabled selected>Pilih Kecamatan</option>
                    </select>
                    @error('kecamatan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="address" class="block text-sm font-semibold text-gray-700">Full Address</label>
                <textarea id="address" name="address" rows="3" required
                          class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent py-2 px-3 text-gray-800 resize-none">{{ old('address') }}</textarea>
                @error('address')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <button type="submit"
                        class="w-full bg-blue-600 text-white font-semibold py-3 px-4 rounded-xl hover:bg-blue-700 transition duration-200">
                    Register
                </button>
            </div>
        </form>
        <p class="text-center text-sm text-gray-500">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login here</a>
        </p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                        districtSelect.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';
                        data.forEach(city => {
                            const option = new Option(city.nama, city.nama);
                            option.dataset.id = city.id;
                            citySelect.add(option);
                        });
                        if ("{{ old('city') }}") {
                            citySelect.value = "{{ old('city') }}";
                            citySelect.dispatchEvent(new Event('change'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal memuat data kota. Silakan coba lagi.');
                        citySelect.innerHTML = '<option value="" disabled selected>Error: Tidak dapat memuat kota</option>';
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
                        districtSelect.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';
                        data.forEach(district => {
                            const option = new Option(district.nama, district.nama);
                            districtSelect.add(option);
                        });
                        if ("{{ old('kecamatan') }}") {
                            districtSelect.value = "{{ old('kecamatan') }}";
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal memuat data kecamatan. Silakan coba lagi.');
                        districtSelect.innerHTML = '<option value="" disabled selected>Error: Tidak dapat memuat kecamatan</option>';
                    });
            });

            if ("{{ old('province') }}") {
                provinceSelect.value = "{{ old('province') }}";
                provinceSelect.dispatchEvent(new Event('change'));
            }

            // Logika untuk toggle visibility password dan confirm password
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const eyeIconPassword = document.getElementById('eyeIconPassword');

            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
            const eyeIconPasswordConfirmation = document.getElementById('eyeIconPasswordConfirmation');

            togglePassword.addEventListener('click', function () {
                const isPasswordVisible = passwordInput.type === 'text';
                passwordInput.type = isPasswordVisible ? 'password' : 'text';
                eyeIconPassword.innerHTML = isPasswordVisible
                    ? `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`
                    : `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
            });

            togglePasswordConfirmation.addEventListener('click', function () {
                const isPasswordVisible = passwordConfirmationInput.type === 'text';
                passwordConfirmationInput.type = isPasswordVisible ? 'password' : 'text';
                eyeIconPasswordConfirmation.innerHTML = isPasswordVisible
                    ? `<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`
                    : `<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;
            });
        });
    </script>
</body>
</html>