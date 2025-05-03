<x-filament::page>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Security Metrics Card -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Metrik Keamanan</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-indigo-600 mb-1">{{ $encryptedMethodsCount }}</div>
                    <div class="text-sm text-gray-500">Metode Pembayaran Terenkripsi</div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-emerald-600 mb-1">{{ $enhancedEncryptedCount }}</div>
                    <div class="text-sm text-gray-500">Menggunakan PBKDF2</div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-violet-600 mb-1">{{ $dbSize }}</div>
                    <div class="text-sm text-gray-500">Ukuran Database</div>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Statistik Enkripsi Data</h3>

                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Total data terenkripsi</span>
                        <span class="font-medium">{{ $securityStats['totalEncrypted'] }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Dilindungi PBKDF2</span>
                        <span class="font-medium">{{ $securityStats['pbkdf2Protected'] }}</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Rata-rata kekuatan enkripsi</span>
                        <span class="font-medium text-emerald-600">{{ $securityStats['averageStrength'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Encryption Algorithms Card -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Algoritma Enkripsi</h2>

            <div class="divide-y divide-gray-200">
                @foreach($encryptionAlgorithms as $algorithm)
                    <div class="py-4 {{ $loop->first ? 'pt-0' : '' }}">
                        <div class="flex justify-between mb-1">
                            <h3 class="font-medium text-gray-900">{{ $algorithm['name'] }}</h3>
                            <span class="px-2 py-1 text-xs font-medium {{ $algorithm['strength'] === 'Sangat Tinggi' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }} rounded-full">
                                {{ $algorithm['strength'] }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mb-2">{{ $algorithm['description'] }}</p>
                        <div class="flex items-center text-xs text-gray-500">
                            <span class="mr-4">
                                <span class="font-medium text-gray-900">Ukuran Kunci:</span> {{ $algorithm['keySize'] }}
                            </span>
                            <span>
                                <span class="font-medium text-gray-900">Digunakan untuk:</span> {{ $algorithm['usedFor'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- PBKDF2 Explanation Card -->
    <div class="bg-white rounded-xl shadow p-6 mt-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">PBKDF2 + AES-256: Perlindungan Data Berlapis</h2>

        <div class="prose max-w-none">
            <p>ShopX mengimplementasikan perlindungan data sensitif menggunakan kombinasi PBKDF2 (Password-Based Key Derivation Function 2) dan AES-256 untuk mencapai tingkat keamanan tertinggi.</p>

            <h3>Bagaimana Cara Kerjanya?</h3>

            <div class="bg-gray-50 p-4 rounded-lg my-4 overflow-x-auto">
                <pre class="text-xs overflow-x-auto">
┌─────────────┐     ┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│ Data Sensitif│────►│  PBKDF2 Key │────►│  Enkripsi   │────►│ Data        │
│ (CVV, dll)   │     │  Derivation │     │  AES-256    │     │ Terenkripsi │
└─────────────┘     └─────────────┘     └─────────────┘     └─────────────┘
       ▲                   ▲                   ▲
       │                   │                   │
       │                   │                   │
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│ User Context │     │ Unique Salt │     │ APP_KEY     │
│ (user_id)    │     │ per Data    │     │ (Master Key)│
└─────────────┘     └─────────────┘     └─────────────┘</pre>
            </div>

            <h3>Keunggulan PBKDF2:</h3>

            <ul>
                <li><strong>Resistensi Brute Force:</strong> 10.000 iterasi hash membuat serangan brute force sangat sulit</li>
                <li><strong>Salt Unik:</strong> Setiap data menggunakan salt yang berbeda</li>
                <li><strong>Konteks Binding:</strong> Enkripsi terikat dengan konteks pengguna</li>
                <li><strong>Proteksi Kunci:</strong> Kunci enkripsi AES tidak pernah disimpan secara langsung</li>
                <li><strong>Metadata:</strong> Data terenkripsi menyimpan informasi tentang algoritma dan parameter yang digunakan</li>
            </ul>

            <p class="text-sm bg-indigo-50 p-3 rounded border-l-4 border-indigo-300">
                <strong class="text-indigo-800">Catatan Penting:</strong> Fitur ini diterapkan pada data yang sangat sensitif seperti CVV kartu kredit, dan memberikan layer keamanan tambahan di atas enkripsi AES-256 standar.
            </p>
        </div>
    </div>
</x-filament::page>
