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
                                    @error('cvv')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
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
                                    Informasi pembayaran Anda dienkripsi secara aman menggunakan AES-256. Kami tidak pernah menyimpan detail kartu Anda dalam bentuk plaintext.
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
            const bankDetailsDiv = document.getElementById('bank-details');

            console.log('Type select:', typeSelect);
            console.log('Card details div:', cardDetailsDiv);
            console.log('Bank details div:', bankDetailsDiv);

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
        });
    </script>
    @endpush
</x-layouts.main>
