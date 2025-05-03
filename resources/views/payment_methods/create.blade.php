<x-layouts.main>
    <x-slot name="title">Tambah Metode Pembayaran</x-slot>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Tambah Metode Pembayaran</h1>

                <!-- Errors Display -->
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Ada {{ count($errors) }} kesalahan pada formulir Anda:
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('payment-methods.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Basic Information -->
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h2>

                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama metode pembayaran</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="contoh: Kartu Utama Saya" value="{{ old('name') }}" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Tipe Pembayaran</label>
                                <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Pilih tipe pembayaran</option>
                                    <option value="credit_card" {{ old('type') == 'credit_card' ? 'selected' : '' }}>Kartu Kredit</option>
                                    <option value="debit_card" {{ old('type') == 'debit_card' ? 'selected' : '' }}>Kartu Debit</option>
                                    <option value="bank_transfer" {{ old('type') == 'bank_transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Credit/Debit Card Details (conditional) -->
                    <div id="card-details" class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden p-6 hidden">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Detail Kartu</h2>

                        <div class="space-y-4">
                            <div>
                                <label for="card_holder" class="block text-sm font-medium text-gray-700">Nama Pemegang Kartu</label>
                                <input type="text" name="card_holder" id="card_holder" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Nama pada kartu" value="{{ old('card_holder') }}">
                                @error('card_holder')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="card_number" class="block text-sm font-medium text-gray-700">Nomor Kartu</label>
                                <input type="text" name="card_number" id="card_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="1234 5678 9012 3456" value="{{ old('card_number') }}" maxlength="19">
                                @error('card_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-1">
                                    <label for="expiry_month" class="block text-sm font-medium text-gray-700">Bulan Kadaluarsa</label>
                                    <input type="text" name="expiry_month" id="expiry_month" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="MM" value="{{ old('expiry_month') }}" maxlength="2">
                                    @error('expiry_month')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-1">
                                    <label for="expiry_year" class="block text-sm font-medium text-gray-700">Tahun Kadaluarsa</label>
                                    <input type="text" name="expiry_year" id="expiry_year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="YY" value="{{ old('expiry_year') }}" maxlength="2">
                                    @error('expiry_year')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-1">
                                    <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                                    <input type="text" name="cvv" id="cvv" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="123" value="{{ old('cvv') }}" maxlength="4">
                                    <div class="mt-1 text-xs text-gray-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Dienkripsi dengan AES-256
                                    </div>
                                    @error('cvv')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Enhanced Security for CVV (PBKDF2 + AES-256) -->
                            <div class="mt-4 border-t border-gray-200 pt-4">
                                <div class="flex items-start mb-2">
                                    <div class="flex items-center h-5">
                                        <input id="use_enhanced_security" name="use_enhanced_security" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ old('use_enhanced_security') ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="use_enhanced_security" class="font-medium text-gray-700">
                                            Gunakan keamanan tingkat lanjut
                                        </label>
                                        <p class="text-gray-500">
                                            CVV Anda akan disimpan dengan enkripsi ganda menggunakan PBKDF2 + AES-256
                                        </p>
                                    </div>
                                </div>

                                <div id="enhanced-security-fields" class="mt-3 {{ old('use_enhanced_security') ? '' : 'hidden' }}">
                                    <div>
                                        <label for="cvv_enhanced" class="block text-sm font-medium text-gray-700">CVV dengan Perlindungan Tambahan</label>
                                        <input type="text" name="cvv_enhanced" id="cvv_enhanced" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Masukkan CVV lagi" value="{{ old('cvv_enhanced') }}" maxlength="4">
                                        <div class="mt-1 text-xs text-green-600 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            Dienkripsi dengan PBKDF2 + AES-256 (10.000 iterasi)
                                        </div>
                                        @error('cvv_enhanced')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Transfer Details (conditional) -->
                    <div id="bank-details" class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden p-6 hidden">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Detail Rekening Bank</h2>

                        <div class="space-y-4">
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-700">Nama Bank</label>
                                <input type="text" name="bank_name" id="bank_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="contoh: BCA, Mandiri, BNI" value="{{ old('bank_name') }}">
                                @error('bank_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="account_number" class="block text-sm font-medium text-gray-700">Nomor Rekening</label>
                                <input type="text" name="account_number" id="account_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Nomor rekening Anda" value="{{ old('account_number') }}">
                                @error('account_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="account_holder" class="block text-sm font-medium text-gray-700">Nama Pemilik Rekening</label>
                                <input type="text" name="account_holder" id="account_holder" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Nama pada rekening" value="{{ old('account_holder') }}">
                                @error('account_holder')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Security Notice -->
                    <div class="bg-indigo-50 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-indigo-700">
                                    Informasi pembayaran Anda dienkripsi secara aman menggunakan AES-256 yang diperkuat dengan PBKDF2.
                                    Kunci enkripsi kami menggunakan teknik key-stretching yang tahan terhadap serangan brute-force,
                                    dan setiap pengguna memiliki salt unik. Data Anda tidak pernah disimpan dalam bentuk plaintext.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Security Details (Collapsible) -->
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
                        <button type="button" id="security-details-toggle" class="w-full px-6 py-4 text-left flex justify-between items-center">
                            <span class="text-lg font-medium text-gray-900">Detail Keamanan Tambahan</span>
                            <svg id="security-details-arrow" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 transform transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div id="security-details-content" class="hidden px-6 pb-4 pt-2">
                            <div class="prose prose-sm text-gray-600">
                                <p>ShopX menggunakan kombinasi metode keamanan berikut untuk melindungi data pembayaran Anda:</p>

                                <h4 class="text-gray-800 font-semibold mt-3">1. AES-256 (Advanced Encryption Standard)</h4>
                                <p>Standar enkripsi simetris yang diakui secara global yang digunakan oleh lembaga pemerintah dan perusahaan terkemuka. Panjang kunci 256-bit dianggap tidak dapat dipecahkan dengan teknologi komputasi saat ini.</p>

                                <h4 class="text-gray-800 font-semibold mt-3">2. PBKDF2 (Password-Based Key Derivation Function 2)</h4>
                                <p>Memperkuat kunci enkripsi dengan menerapkan fungsi hash berulang kali, membuatnya sangat tahan terhadap serangan brute-force. Kami menerapkan 10.000+ iterasi untuk meningkatkan keamanan.</p>

                                <h4 class="text-gray-800 font-semibold mt-3">3. Salt Acak per Pengguna</h4>
                                <p>Setiap data pembayaran dilindungi dengan salt acak unik sepanjang 32-byte. Bahkan jika dua pengguna memiliki detail kartu yang identik, enkripsi yang dihasilkan akan berbeda.</p>

                                <h4 class="text-gray-800 font-semibold mt-3">4. Konteks Tambahan</h4>
                                <p>Kami memasukkan ID pengguna ke dalam proses enkripsi, memastikan bahwa hanya akun Anda yang dapat mendekripsi data pembayaran Anda.</p>

                                <p class="mt-3 text-xs text-gray-500">
                                    <strong>Catatan:</strong> Meskipun kami melakukan upaya maksimal untuk melindungi data Anda, tidak ada sistem yang 100% aman. Kami terus mengupdate dan memperbaiki keamanan sistem kami.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <a href="{{ route('payment-methods.index') }}" class="mr-4 bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Simpan Metode Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
      @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');
            const typeSelect = document.getElementById('type');
            const cardDetailsDiv = document.getElementById('card-details');
            const bankDetailsDiv = document.getElementById('bank-details');            // Enhanced security toggle
            const enhancedSecurityCheckbox = document.getElementById('use_enhanced_security');
            const enhancedSecurityFields = document.getElementById('enhanced-security-fields');

            // Only execute if these elements exist
            if (enhancedSecurityCheckbox && enhancedSecurityFields) {
                enhancedSecurityCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        enhancedSecurityFields.classList.remove('hidden');
                    } else {
                        enhancedSecurityFields.classList.add('hidden');
                        // Clear enhanced CVV field when disabling
                        document.getElementById('cvv_enhanced').value = '';
                    }
                });

                // When regular CVV is filled, auto-fill enhanced CVV if checkbox is checked
                const cvvInput = document.getElementById('cvv');
                const cvvEnhancedInput = document.getElementById('cvv_enhanced');

                if (cvvInput && cvvEnhancedInput) {
                    cvvInput.addEventListener('input', function() {
                        if (enhancedSecurityCheckbox.checked) {
                            cvvEnhancedInput.value = this.value;
                        }
                    });
                }
            }

            // Format CVV fields to numeric only
            const cvvInputs = document.querySelectorAll('#cvv, #cvv_enhanced');
            cvvInputs.forEach(input => {
                if (input) {
                    input.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/\D/g, '');
                        e.target.value = value;
                    });
                }
            });

            // Toggle payment methods based on type
            if (typeSelect && cardDetailsDiv && bankDetailsDiv) {
                function updateFormFields() {
                    const selectedType = typeSelect.value;
                    console.log('Selected type:', selectedType);

                    if (selectedType === 'credit_card' || selectedType === 'debit_card') {
                        console.log('Showing card details');
                        cardDetailsDiv.classList.remove('hidden');
                        bankDetailsDiv.classList.add('hidden');

                        // Pastikan input kartu kredit/debit diperlukan
                        document.getElementById('card_holder').setAttribute('required', 'required');
                        document.getElementById('card_number').setAttribute('required', 'required');
                        document.getElementById('expiry_month').setAttribute('required', 'required');
                        document.getElementById('expiry_year').setAttribute('required', 'required');
                        document.getElementById('cvv').setAttribute('required', 'required');

                        // Hapus required dari input bank transfer
                        document.getElementById('bank_name').removeAttribute('required');
                        document.getElementById('account_number').removeAttribute('required');
                        document.getElementById('account_holder').removeAttribute('required');

                    } else if (selectedType === 'bank_transfer') {
                        console.log('Showing bank details');
                        cardDetailsDiv.classList.add('hidden');
                        bankDetailsDiv.classList.remove('hidden');

                        // Pastikan input bank transfer diperlukan
                        document.getElementById('bank_name').setAttribute('required', 'required');
                        document.getElementById('account_number').setAttribute('required', 'required');
                        document.getElementById('account_holder').setAttribute('required', 'required');

                        // Hapus required dari input kartu kredit/debit
                        document.getElementById('card_holder').removeAttribute('required');
                        document.getElementById('card_number').removeAttribute('required');
                        document.getElementById('expiry_month').removeAttribute('required');
                        document.getElementById('expiry_year').removeAttribute('required');
                        document.getElementById('cvv').removeAttribute('required');

                    } else {
                        console.log('Hiding all details');
                        cardDetailsDiv.classList.add('hidden');
                        bankDetailsDiv.classList.add('hidden');

                        // Hapus required dari semua input
                        document.getElementById('card_holder').removeAttribute('required');
                        document.getElementById('card_number').removeAttribute('required');
                        document.getElementById('expiry_month').removeAttribute('required');
                        document.getElementById('expiry_year').removeAttribute('required');
                        document.getElementById('cvv').removeAttribute('required');
                        document.getElementById('bank_name').removeAttribute('required');
                        document.getElementById('account_number').removeAttribute('required');
                        document.getElementById('account_holder').removeAttribute('required');
                    }
                }

                // Initial setup
                updateFormFields();

                // Handle type changes
                typeSelect.addEventListener('change', updateFormFields);

                // Format card number with spaces
                const cardNumberInput = document.getElementById('card_number');
                if (cardNumberInput) {
                    cardNumberInput.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');

                        if (value.length > 0) {
                            value = value.match(new RegExp('.{1,4}', 'g')).join(' ');
                        }

                        e.target.value = value;
                    });
                }

                // Format expiry month and year to be 2 digits
                const expiryMonthInput = document.getElementById('expiry_month');
                if (expiryMonthInput) {
                    expiryMonthInput.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/\D/g, '');
                        if (value.length === 1 && parseInt(value) > 1) {
                            value = '0' + value;
                        }
                        if (value.length > 0 && parseInt(value) > 12) {
                            value = '12';
                        }
                        e.target.value = value;
                    });
                }

                const expiryYearInput = document.getElementById('expiry_year');
                if (expiryYearInput) {
                    expiryYearInput.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/\D/g, '');
                        e.target.value = value;
                    });
                }

                // Format CVV to be numeric only
                const cvvInput = document.getElementById('cvv');
                if (cvvInput) {
                    cvvInput.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/\D/g, '');
                        e.target.value = value;
                    });
                }

                // Format account number to be numeric only
                const accountNumberInput = document.getElementById('account_number');
                if (accountNumberInput) {
                    accountNumberInput.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/\D/g, '');
                        e.target.value = value;
                    });
                }

                // Toggle security details
                const securityDetailsToggle = document.getElementById('security-details-toggle');
                const securityDetailsContent = document.getElementById('security-details-content');
                const securityDetailsArrow = document.getElementById('security-details-arrow');

                if (securityDetailsToggle) {
                    securityDetailsToggle.addEventListener('click', function() {
                        securityDetailsContent.classList.toggle('hidden');
                        securityDetailsArrow.classList.toggle('rotate-180');
                    });
                }
            }
        });
    </script>
    @endpush
</x-layouts.main>
