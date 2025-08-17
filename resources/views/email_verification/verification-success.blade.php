<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email Berhasil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center min-h-screen px-4 py-12">
        <div class="w-full max-w-md p-8 space-y-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg text-center">
            <div class="flex justify-center">
                @if (session('status'))
                <div class="w-20 h-20 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-green-500 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                @else
                <div class="w-20 h-20 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-red-500 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                @endif
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
            </h1>
            @if (session('status'))
            <p class="text-gray-600 dark:text-gray-300 text-base">
                Alamat email Anda telah berhasil diverifikasi. Terima kasih telah bergabung dengan kami. Sekarang Anda dapat masuk ke akun Anda.
            </p>
            @else
            <p class="text-gray-600 dark:text-gray-300 text-base">
                Tidak ada akun yang diverifikasi.
            </p>
            @endif
            @if (session('status'))
            <div>
                <a href="#" class="inline-block w-full px-5 py-3 mt-4 text-base font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800 transition-transform transform hover:scale-105">
                    Lanjutkan ke Aplikasi
                </a>
            </div>
            @endif
        </div>
    </div>
</body>
</html>
