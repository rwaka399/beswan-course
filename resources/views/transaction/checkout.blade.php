<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - {{ $package->lesson_package_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center py-12 px-4">

    <div class="w-full max-w-xl bg-white shadow-2xl rounded-3xl p-10">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-6">
            Checkout: <span class="text-blue-600">{{ $package->lesson_package_name }}</span>
        </h1>

        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 mb-6">
            <p class="text-lg text-gray-700 mb-2">
                <strong>Harga:</strong> 
                <span class="text-green-600 font-semibold">
                    Rp {{ number_format($package->lesson_package_price, 0, ',', '.') }}
                </span>
            </p>
            <p class="text-lg text-gray-700 mb-2">
                <strong>Durasi:</strong> 
                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                    {{ $package->lesson_duration }} Minggu
                </span>
            </p>
            <p class="text-lg text-gray-700">
                <strong>Deskripsi:</strong> 
                <span class="text-gray-600">
                    {{ $package->lesson_package_description ?? 'Paket ini menawarkan pembelajaran bahasa Inggris yang interaktif dan terjangkau.' }}
                </span>
            </p>
        </div>

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <form id="payment-form" method="POST" action="{{ route('transaction.create') }}" novalidate class="space-y-6">
            @csrf
            <input type="hidden" name="lesson_package_id" value="{{ $package->lesson_package_id }}">

            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" id="email"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ auth()->user()->email ?? '' }}" required>
                <p class="text-sm text-gray-500 mt-1">Email akan digunakan untuk notifikasi pembayaran.</p>
                @error('email')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-8">
                <a href="{{ route('home') }}" class="text-gray-600 hover:underline text-sm">
                    ← Kembali ke Daftar Paket
                </a>

                <button type="submit" id="pay-button"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                    Bayar Sekarang
                </button>
            </div>
        </form>
    </div>

    <script>
        const paymentForm = document.getElementById('payment-form');
        const payButton = document.getElementById('pay-button');

        paymentForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const emailInput = document.getElementById('email');
            if (!emailInput.value || !emailInput.checkValidity()) {
                alert('Harap masukkan email yang valid.');
                return;
            }

            payButton.disabled = true;
            payButton.textContent = 'Memproses...';

            const formData = new FormData(paymentForm);

            try {
                const response = await fetch(paymentForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                });

                const result = await response.json();

                if (result.invoice_url) {
                    window.location.href = result.invoice_url;
                } else {
                    alert(result.message + (result.error ? ': ' + result.error : ''));
                }
            } catch (error) {
                alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
                console.error('Fetch error:', error);
            } finally {
                payButton.disabled = false;
                payButton.textContent = 'Bayar Sekarang';
            }
        });
    </script>

</body>
</html>