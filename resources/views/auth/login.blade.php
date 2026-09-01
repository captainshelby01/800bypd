@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto my-6 sm:my-10 bg-white p-6 sm:p-8 rounded-3xl border border-purple-200/80 shadow-xl relative overflow-hidden">
    <div class="text-center mb-8">
        <div class="w-14 h-14 bg-[#312E81] text-[#FACC15] rounded-2xl flex items-center justify-center font-whimsical font-bold text-2xl mx-auto mb-3 shadow-md">
            8
        </div>
        <h1 class="font-whimsical text-3xl font-bold text-[#312E81]">Welcome Back</h1>
        <p class="text-xs text-slate-500 mt-1">Log in to view your orders and account details</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-xs space-y-1">
            @foreach ($errors->all() as $error)
                <p class="flex items-center gap-1.5"><i class="bi bi-exclamation-triangle-fill text-rose-500"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="space-y-4 text-xs font-semibold">
        @csrf

        <div>
            <label class="block text-slate-700 font-bold mb-1">Email Address</label>
            <div class="relative">
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com" class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                <i class="bi bi-envelope-fill absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
            </div>
        </div>

        <div>
            <label class="block text-slate-700 font-bold mb-1">Password</label>
            <div class="relative">
                <input type="password" name="password" required placeholder="Enter your password" class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                <i class="bi bi-lock-fill absolute left-3.5 top-3.5 text-slate-400 text-sm"></i>
            </div>
        </div>

        <div class="flex items-center justify-between text-xs">
            <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-[#7C3AED] focus:ring-[#7C3AED]">
                <span>Remember me</span>
            </label>
        </div>

        <button type="submit" class="w-full bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold py-3.5 rounded-xl shadow-md transition flex items-center justify-center gap-2 text-sm mt-4">
            <i class="bi bi-box-arrow-in-right text-base"></i> Log In
        </button>
    </form>

    <div class="text-center mt-6 pt-6 border-t border-slate-100 text-xs text-slate-500">
        Don't have an account yet? 
        <a href="{{ route('register') }}" class="text-[#7C3AED] font-bold hover:underline">Create Account</a>
    </div>
</div>
@endsection
