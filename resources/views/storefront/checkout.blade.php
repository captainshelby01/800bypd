@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="font-whimsical text-2xl sm:text-3xl font-bold text-[#312E81]">Checkout & Order Placement</h1>
            <p class="text-xs text-slate-500">Complete your shipping details and select your preferred payment method.</p>
        </div>

        @guest
            <div class="bg-purple-50 border border-purple-300 text-purple-900 px-4 py-2.5 rounded-2xl text-xs flex items-center gap-2 w-full sm:w-auto">
                <i class="bi bi-info-circle-fill text-[#7C3AED] text-base flex-shrink-0"></i>
                <span>Have an account? <a href="{{ route('login') }}" class="font-bold underline text-[#312E81]">Log in</a> to auto-fill details!</span>
            </div>
        @else
            <div class="bg-purple-100 border border-purple-300 text-[#312E81] px-4 py-2 rounded-2xl text-xs font-bold flex items-center gap-2 w-full sm:w-auto">
                <i class="bi bi-person-check-fill text-[#7C3AED] text-base flex-shrink-0"></i>
                <span>Logged in as {{ auth()->user()->name }}</span>
            </div>
        @endguest
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
            
            <!-- Customer Information & Shipping Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Step 1: Customer Details -->
                <div class="bg-white p-5 sm:p-6 rounded-3xl border border-purple-200/80 shadow-sm">
                    <h3 class="font-bold text-slate-900 text-base mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-[#312E81] text-[#FACC15] rounded-full text-xs flex items-center justify-center font-bold">1</span>
                        Customer & Delivery Address
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-semibold">
                        <div>
                            <label class="block text-slate-700 mb-1">Full Name *</label>
                            <input type="text" name="customer_name" required value="{{ old('customer_name', auth()->user()->name ?? '') }}" placeholder="e.g. Adebayo Johnson" class="w-full border border-slate-300 px-3 py-2.5 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">Email Address *</label>
                            <input type="email" name="customer_email" required value="{{ old('customer_email', auth()->user()->email ?? '') }}" placeholder="e.g. adebayo@example.com" class="w-full border border-slate-300 px-3 py-2.5 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-slate-700 mb-1">Phone Number (Required for Courier Delivery) *</label>
                            <input type="text" name="customer_phone" required value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" placeholder="e.g. 08164254442" class="w-full border border-slate-300 px-3 py-2.5 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-slate-700 mb-1">Delivery Address *</label>
                            <textarea name="shipping_address" rows="2" required placeholder="House number, street name, landmark..." class="w-full border border-slate-300 px-3 py-2.5 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">{{ old('shipping_address') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">City / Town *</label>
                            <input type="text" name="city" required value="{{ old('city') }}" placeholder="e.g. Ikeja, Lekki" class="w-full border border-slate-300 px-3 py-2.5 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">State *</label>
                            <input type="text" name="state" required value="{{ old('state') }}" placeholder="e.g. Lagos, Rivers" class="w-full border border-slate-300 px-3 py-2.5 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-slate-700 mb-1">Special Delivery Instructions / Notes (Optional)</label>
                            <textarea name="special_instructions" rows="2" placeholder="e.g. Please deliver after 2 PM or leave with security gate..." class="w-full border border-slate-300 px-3 py-2.5 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">{{ old('special_instructions') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Shipping Delivery Options -->
                <div class="bg-white p-5 sm:p-6 rounded-3xl border border-purple-200/80 shadow-sm">
                    <h3 class="font-bold text-slate-900 text-base mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-[#312E81] text-[#FACC15] rounded-full text-xs flex items-center justify-center font-bold">2</span>
                        Shipping & Delivery Option
                    </h3>

                    <div class="space-y-3 text-xs font-semibold">
                        <label class="flex items-center justify-between p-4 border border-slate-200 rounded-2xl cursor-pointer hover:border-[#7C3AED] transition bg-purple-50/30">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="shipping_method" value="lagos_flat" checked onchange="updateShippingFee(2500)" class="text-[#7C3AED] focus:ring-[#7C3AED]">
                                <div>
                                    <p class="font-bold text-slate-900">Lagos Flat Rate Standard Delivery</p>
                                    <p class="text-[11px] text-slate-500">Delivered within 1 - 3 business days across Lagos</p>
                                </div>
                            </div>
                            <span class="font-bold text-[#312E81] price-convertible flex-shrink-0" data-price-ngn="2500">₦2,500</span>
                        </label>

                        <label class="flex items-center justify-between p-4 border border-slate-200 rounded-2xl cursor-pointer hover:border-[#7C3AED] transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="shipping_method" value="nationwide_courier" onchange="updateShippingFee(4500)" class="text-[#7C3AED] focus:ring-[#7C3AED]">
                                <div>
                                    <p class="font-bold text-slate-900">Nationwide Express Courier (Outside Lagos)</p>
                                    <p class="text-[11px] text-slate-500">Delivered via GIG / Red Star Courier (3 - 5 Days)</p>
                                </div>
                            </div>
                            <span class="font-bold text-[#312E81] price-convertible flex-shrink-0" data-price-ngn="4500">₦4,500</span>
                        </label>
                    </div>
                </div>

                <!-- Step 3: Payment Method Selection -->
                <div class="bg-white p-5 sm:p-6 rounded-3xl border border-purple-200/80 shadow-sm">
                    <h3 class="font-bold text-slate-900 text-base mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-[#312E81] text-[#FACC15] rounded-full text-xs flex items-center justify-center font-bold">3</span>
                        Select Payment Gateway / Method
                    </h3>

                    <div class="space-y-3 text-xs font-semibold">
                        <!-- Option A: Paystack Gateway -->
                        <label class="flex items-center justify-between p-4 border border-slate-200 rounded-2xl cursor-pointer hover:border-[#7C3AED] transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="paystack" checked onclick="toggleBankTransferUpload(false)" class="text-[#7C3AED] focus:ring-[#7C3AED]">
                                <div>
                                    <p class="font-bold text-slate-900">Paystack (Instant Online Payment)</p>
                                    <p class="text-[11px] text-slate-500">Instant approval via Bank Transfer, USSD, Cards or QR Code</p>
                                </div>
                            </div>
                            <i class="bi bi-lightning-charge-fill text-amber-500 text-lg flex-shrink-0"></i>
                        </label>

                        <!-- Option B: Direct Debit / Credit Card -->
                        <label class="flex items-center justify-between p-4 border border-slate-200 rounded-2xl cursor-pointer hover:border-[#7C3AED] transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="card" onclick="toggleBankTransferUpload(false)" class="text-[#7C3AED] focus:ring-[#7C3AED]">
                                <div>
                                    <p class="font-bold text-slate-900">Debit / Credit Card (Visa, Mastercard, Verve)</p>
                                    <p class="text-[11px] text-slate-500">Secure 3D Card authentication</p>
                                </div>
                            </div>
                            <i class="bi bi-credit-card-fill text-[#7C3AED] text-lg flex-shrink-0"></i>
                        </label>

                        <!-- Option C: Direct Bank Transfer with Receipt Upload -->
                        <label class="flex items-center justify-between p-4 border border-slate-200 rounded-2xl cursor-pointer hover:border-[#7C3AED] transition bg-purple-50/30">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="bank_transfer" onclick="toggleBankTransferUpload(true)" class="text-[#7C3AED] focus:ring-[#7C3AED]">
                                <div>
                                    <p class="font-bold text-slate-900">Direct GTBank Transfer (With Receipt Upload)</p>
                                    <p class="text-[11px] text-slate-500">Transfer directly to GTBank & upload proof of payment</p>
                                </div>
                            </div>
                            <i class="bi bi-bank text-[#7C3AED] text-lg flex-shrink-0"></i>
                        </label>
                    </div>

                    <!-- Bank Transfer Account Details & File Upload -->
                    <div id="bank_transfer_section" class="hidden mt-4 p-4 bg-purple-50 border border-purple-200 rounded-2xl space-y-3 text-xs">
                        <div class="border-b border-purple-200 pb-2">
                            <p class="font-bold text-[#312E81] mb-1"><i class="bi bi-bank mr-1"></i> Bank Account for Transfer:</p>
                            <p class="text-slate-700">Bank Name: <strong>{{ env('BANK_NAME', 'Guaranty Trust Bank (GTBank)') }}</strong></p>
                            <p class="text-slate-700">Account Number: <strong class="font-mono text-sm text-[#312E81]">{{ env('BANK_ACCOUNT_NUMBER', '0123456789') }}</strong></p>
                            <p class="text-slate-700">Account Name: <strong>{{ env('BANK_ACCOUNT_NAME', '800BYPD Ltd') }}</strong></p>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-800 mb-1">Upload Payment Receipt Screenshot *</label>
                            <input type="file" name="receipt" accept="image/*,.pdf" class="w-full text-xs border border-purple-300 p-2 rounded-xl bg-white">
                            <span class="text-[10px] text-slate-500 mt-1 block">Supported file formats: JPG, PNG, PDF (Max size 4MB)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Total & Submit Sidebar -->
            <div class="bg-white p-6 rounded-3xl border border-purple-200/80 shadow-sm h-fit">
                <h3 class="font-bold text-slate-900 text-base mb-4 border-b pb-2">Order Breakdown</h3>
                
                <div class="space-y-2 text-xs mb-6 font-semibold">
                    <div class="flex justify-between text-slate-600">
                        <span>Items Subtotal</span>
                        <span class="font-bold text-slate-900 price-convertible" data-price-ngn="{{ $subtotal }}">₦{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Shipping Delivery Fee</span>
                        <span id="shippingFeeDisplay" class="font-bold text-slate-900 price-convertible" data-price-ngn="2500">₦2,500</span>
                    </div>
                    <div class="flex justify-between text-sm font-bold text-[#312E81] border-t border-slate-100 pt-3">
                        <span>Total Payable</span>
                        <span id="totalPayableDisplay" class="price-convertible" data-price-ngn="{{ $subtotal + 2500 }}">₦{{ number_format($subtotal + 2500, 2) }}</span>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold py-4 rounded-2xl text-xs flex items-center justify-center gap-2 shadow-lg transition">
                    Place Order & Proceed <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    let currentSubtotal = {{ $subtotal }};
    function toggleBankTransferUpload(show) {
        document.getElementById('bank_transfer_section').classList.toggle('hidden', !show);
    }

    function updateShippingFee(fee) {
        document.getElementById('shippingFeeDisplay').setAttribute('data-price-ngn', fee);
        document.getElementById('totalPayableDisplay').setAttribute('data-price-ngn', currentSubtotal + fee);
        
        const curr = sessionStorage.getItem('selected_currency') || 'NGN';
        changeCurrency(curr);
    }
</script>
@endsection
