@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-black text-slate-900">Checkout & Order Placement</h1>
        <p class="text-xs text-slate-500">Complete your shipping details and select your preferred payment method.</p>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Customer Information & Shipping Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Step 1: Customer Details -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <h3 class="font-black text-slate-900 text-base mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-purple-600 text-white rounded-full text-xs flex items-center justify-center font-bold">1</span>
                        Customer & Delivery Address
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Full Name *</label>
                            <input type="text" name="customer_name" required value="{{ old('customer_name') }}" placeholder="e.g. Adebayo Johnson" class="w-full border border-slate-300 px-3 py-2 rounded-xl focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Email Address *</label>
                            <input type="email" name="customer_email" required value="{{ old('customer_email') }}" placeholder="e.g. adebayo@example.com" class="w-full border border-slate-300 px-3 py-2 rounded-xl focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-bold text-slate-700 mb-1">Phone Number (Required for Courier Delivery) *</label>
                            <input type="text" name="customer_phone" required value="{{ old('customer_phone') }}" placeholder="e.g. 08164254442" class="w-full border border-slate-300 px-3 py-2 rounded-xl focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-bold text-slate-700 mb-1">Delivery Address *</label>
                            <textarea name="shipping_address" rows="2" required placeholder="House number, street name, landmark..." class="w-full border border-slate-300 px-3 py-2 rounded-xl focus:ring-2 focus:ring-purple-500">{{ old('shipping_address') }}</textarea>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">City / Town *</label>
                            <input type="text" name="city" required value="{{ old('city') }}" placeholder="e.g. Ikeja, Lekki" class="w-full border border-slate-300 px-3 py-2 rounded-xl focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">State *</label>
                            <input type="text" name="state" required value="{{ old('state') }}" placeholder="e.g. Lagos, Rivers" class="w-full border border-slate-300 px-3 py-2 rounded-xl focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-bold text-slate-700 mb-1">Special Delivery Instructions / Notes (Optional)</label>
                            <textarea name="special_instructions" rows="2" placeholder="e.g. Please deliver after 2 PM or leave with security gate..." class="w-full border border-slate-300 px-3 py-2 rounded-xl focus:ring-2 focus:ring-purple-500">{{ old('special_instructions') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Shipping Delivery Options -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <h3 class="font-black text-slate-900 text-base mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-purple-600 text-white rounded-full text-xs flex items-center justify-center font-bold">2</span>
                        Shipping & Delivery Option
                    </h3>

                    <div class="space-y-3 text-xs">
                        <label class="block p-4 border rounded-2xl cursor-pointer hover:border-purple-600 bg-amber-50/40 border-amber-200 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="shipping_method" value="lagos_flat" checked onchange="updateShippingFee(2500)">
                                <div>
                                    <span class="font-black text-slate-900 block">Lagos Delivery (Flat Rate Courier)</span>
                                    <span class="text-slate-500">Estimated Delivery: 1-3 Business Days</span>
                                </div>
                            </div>
                            <span class="font-black text-purple-900 price-convertible" data-price-ngn="2500">₦2,500</span>
                        </label>

                        <label class="block p-4 border rounded-2xl cursor-pointer hover:border-purple-600 bg-amber-50/40 border-amber-200 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="shipping_method" value="nationwide_courier" onchange="updateShippingFee(4500)">
                                <div>
                                    <span class="font-black text-slate-900 block">Nationwide Delivery (Outside Lagos)</span>
                                    <span class="text-slate-500">Estimated Delivery: 3-5 Business Days</span>
                                </div>
                            </div>
                            <span class="font-black text-purple-900 price-convertible" data-price-ngn="4500">₦4,500</span>
                        </label>
                    </div>
                </div>

                <!-- Step 3: Payment Gateway Selector -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <h3 class="font-black text-slate-900 text-base mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 bg-purple-600 text-white rounded-full text-xs flex items-center justify-center font-bold">3</span>
                        Payment Method
                    </h3>

                    <div class="space-y-3 text-xs">
                        <!-- Paystack -->
                        <label class="block p-4 border rounded-2xl cursor-pointer hover:border-purple-600 bg-slate-50 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="paystack" checked onclick="toggleBankTransferUpload(false)">
                                <div>
                                    <span class="font-black text-slate-900 block">Paystack (Card, USSD, Bank Transfer)</span>
                                    <span class="text-slate-500">Visa, Mastercard, Verve, or instant Paystack USSD</span>
                                </div>
                            </div>
                            <span class="bg-blue-100 text-blue-900 text-[10px] font-bold px-2 py-0.5 rounded-full">Paystack</span>
                        </label>

                        <!-- Direct Bank Transfer -->
                        <label class="block p-4 border rounded-2xl cursor-pointer hover:border-purple-600 bg-slate-50 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="payment_method" value="bank_transfer" onclick="toggleBankTransferUpload(true)">
                                <div>
                                    <span class="font-black text-slate-900 block">Direct Bank Transfer (Upload Receipt)</span>
                                    <span class="text-slate-500">Transfer directly to our account and upload proof of payment screenshot</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-building-columns text-green-600 text-lg"></i>
                        </label>
                    </div>

                    <!-- Bank Transfer Account Details & File Upload -->
                    <div id="bank_transfer_section" class="hidden mt-4 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl space-y-3 text-xs">
                        <div class="border-b border-emerald-200 pb-2">
                            <p class="font-black text-emerald-950 mb-1"><i class="fa-solid fa-building-columns mr-1"></i> Bank Account for Transfer:</p>
                            <p class="text-slate-700">Bank Name: <strong>{{ env('BANK_NAME', 'Guaranty Trust Bank (GTBank)') }}</strong></p>
                            <p class="text-slate-700">Account Number: <strong class="font-mono text-sm text-emerald-950">{{ env('BANK_ACCOUNT_NUMBER', '0123456789') }}</strong></p>
                            <p class="text-slate-700">Account Name: <strong>{{ env('BANK_ACCOUNT_NAME', '800bypd Nigeria Ltd') }}</strong></p>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-800 mb-1">Upload Payment Receipt Screenshot *</label>
                            <input type="file" name="receipt" accept="image/*,.pdf" class="w-full text-xs border border-emerald-300 p-2 rounded-xl bg-white">
                            <span class="text-[10px] text-slate-500 mt-1 block">Supported file formats: JPG, PNG, PDF (Max size 4MB)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Total & Submit Sidebar -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm h-fit">
                <h3 class="font-black text-slate-900 text-base mb-4 border-b pb-2">Order Breakdown</h3>
                
                <div class="space-y-2 text-xs mb-6">
                    <div class="flex justify-between text-slate-600">
                        <span>Items Subtotal</span>
                        <span class="font-bold text-slate-900 price-convertible" data-price-ngn="{{ $subtotal }}">₦{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Shipping Delivery Fee</span>
                        <span id="shippingFeeDisplay" class="font-bold text-slate-900 price-convertible" data-price-ngn="2500">₦2,500</span>
                    </div>
                    <div class="flex justify-between text-sm font-black text-purple-950 border-t border-slate-100 pt-3">
                        <span>Total Payable</span>
                        <span id="totalPayableDisplay" class="price-convertible" data-price-ngn="{{ $subtotal + 2500 }}">₦{{ number_format($subtotal + 2500, 2) }}</span>
                    </div>
                </div>

                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-black py-4 rounded-2xl text-xs flex items-center justify-center gap-2 shadow-lg transition">
                    Place Order & Proceed <i class="fa-solid fa-arrow-right"></i>
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
