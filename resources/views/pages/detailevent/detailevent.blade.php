<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event - Reservasi Tiket</title>
    
    <!-- Tailwind CSS dari CDN (sementara) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        purple: {
                            900: '#1a103d',
                            800: '#2d1b69',
                            700: '#3d2a7a',
                            600: '#5a3d9a',
                            500: '#7c5ac2',
                            400: '#9f7aea',
                            300: '#b794f4',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(to bottom, #1f2937, #6b21a8, #000000);
        }
        
        .backdrop-custom {
            background: rgba(31, 41, 55, 0.7);
            backdrop-filter: blur(20px);
        }
        
        .hover-glow:hover {
            box-shadow: 0 0 20px rgba(139, 92, 246, 0.5);
        }
    </style>
</head>
<body class="min-h-screen gradient-bg text-white">

    <!-- Container Utama -->
    <div class="max-w-4xl mx-auto p-4 sm:p-6 backdrop-custom rounded-2xl shadow-xl border border-purple-500/40 mt-10 mb-10">

        {{-- Banner Event --}}
        <div class="relative overflow-hidden rounded-xl shadow-lg mb-8">
            <img src="https://source.unsplash.com/1200x400/?concert,lights" 
                 alt="Concert Banner" 
                 class="w-full h-64 sm:h-80 object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/20"></div>
            <div class="absolute bottom-6 left-6">
                <h1 class="text-3xl sm:text-4xl font-bold text-purple-300 drop-shadow-lg">
                    {{ $event->nama_event ?? 'Konser Musik Spektakuler' }}
                </h1>
                <p class="text-lg text-gray-200 mt-2">
                    {{ $event->deskripsi ?? 'Pengalaman musik yang tak terlupakan dengan artis ternama' }}
                </p>
            </div>
        </div>

        {{-- Informasi Event --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            {{-- Jadwal --}}
            <div class="bg-black/40 border border-purple-400/30 p-5 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-purple-300 mb-3 flex items-center">
                    <span class="mr-2">📅</span> Jadwal Event
                </h2>
                <div class="space-y-2">
                    <p class="flex items-center">
                        <span class="w-6">🗓</span>
                        <span class="ml-2">{{ $event->tanggal ?? '18 Agustus 2025' }}</span>
                    </p>
                    <p class="flex items-center">
                        <span class="w-6">⏰</span>
                        <span class="ml-2">{{ $event->waktu ?? '20:00 WIB' }}</span>
                    </p>
                    <p class="flex items-center mt-3">
                        <span class="w-6">📍</span>
                        <span class="ml-2 text-gray-300">Stadion Utama Sumatera Utara</span>
                    </p>
                </div>
            </div>

            {{-- Tiket --}}
            <div class="bg-black/40 border border-purple-400/30 p-5 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-purple-300 mb-3 flex items-center">
                    <span class="mr-2">🎟</span> Informasi Tiket
                </h2>
                <div class="space-y-3">
                    <p class="flex justify-between items-center">
                        <span>Harga:</span>
                        <span class="text-green-400 font-bold">Rp {{ number_format($event->harga ?? 250000, 0, ',', '.') }}</span>
                    </p>
                    <p class="flex justify-between items-center">
                        <span>Status:</span>
                        <span class="text-yellow-300 font-medium">{{ $event->status ?? 'Tersedia' }}</span>
                    </p>
                    <p class="flex justify-between items-center">
                        <span>Kuota:</span>
                        <span class="text-blue-300">{{ $event->kuota ?? '1000' }} kursi</span>
                    </p>
                </div>
                
                <button class="mt-6 w-full py-3 bg-purple-600 hover:bg-purple-700 rounded-xl font-semibold 
                              transition-all duration-300 shadow-md hover-glow transform hover:scale-105"
                        onclick="pesanTiket()">
                    🎵 Pesan Tiket Sekarang
                </button>
            </div>
        </div>

        {{-- Deskripsi Detail --}}
        <div class="bg-black/40 border border-purple-400/30 p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-semibold text-purple-300 mb-4 flex items-center">
                <span class="mr-2">ℹ️</span> Informasi Tambahan
            </h2>
            <ul class="space-y-3 text-gray-300">
                <li class="flex items-start">
                    <span class="text-green-400 mr-2">✓</span>
                    <span>Anak-anak di bawah 3 tahun masuk gratis (tanpa kursi)</span>
                </li>
                <li class="flex items-start">
                    <span class="text-red-400 mr-2">✗</span>
                    <span>Tiket tidak dapat dikembalikan atau refund</span>
                </li>
                <li class="flex items-start">
                    <span class="text-yellow-400 mr-2">⚠️</span>
                    <span>Setiap ID hanya bisa membeli maksimal 4 tiket</span>
                </li>
                <li class="flex items-start">
                    <span class="text-blue-400 mr-2">⏰</span>
                    <span>Pintu dibuka 2 jam sebelum acara dimulai</span>
                </li>
                <li class="flex items-start">
                    <span class="text-purple-400 mr-2">🎵</span>
                    <span>Dilarang membawa makanan dan minuman dari luar</span>
                </li>
            </ul>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-8 text-center">
            <a href="#" 
               class="inline-flex items-center px-6 py-3 border border-purple-400/30 text-purple-300 
                      rounded-xl hover:bg-purple-400/10 transition-all duration-300">
                ← Kembali ke Halaman Utama
            </a>
        </div>

    </div>

    <script>
        function pesanTiket() {
            alert('Fitur pemesanan tiket akan segera tersedia!');
            // window.location.href = '/pesan-tiket'; // Redirect ke halaman pemesanan
        }
        
        // Animasi hover untuk tombol
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>

</body>
</html>