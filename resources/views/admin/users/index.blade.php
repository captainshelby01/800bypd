@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 sm:space-y-8">
    <!-- Admin Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-purple-200/60 pb-5">
        <div>
            <div class="flex flex-wrap items-center gap-2 mb-1">
                <span class="bg-[#FACC15] text-[#312E81] font-black px-2.5 py-0.5 rounded-full text-[10px] uppercase">Admin Management Panel</span>
                <span class="text-xs text-slate-500 font-mono">/admin/users</span>
            </div>
            <h1 class="font-whimsical font-bold text-2xl sm:text-3xl text-slate-900">Admin Logins & User Management</h1>
            <p class="text-xs text-slate-500">Manage admin credentials, grant staff access, and control platform user roles.</p>
        </div>

        <div class="flex flex-wrap sm:flex-nowrap items-center gap-2.5 w-full sm:w-auto">
            <a href="{{ route('home') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-2.5 rounded-2xl text-xs transition flex items-center justify-center gap-1.5 w-full sm:w-auto">
                <i class="bi bi-shop text-sm"></i> Public Storefront
            </a>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex overflow-x-auto border-b border-slate-200 gap-2 text-xs font-bold whitespace-nowrap pb-0.5 scrollbar-none">
        <a href="{{ route('admin.verifications') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
            <i class="bi bi-receipt"></i> Orders & Payment Receipts
        </a>
        <a href="{{ route('admin.products.index') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
            <i class="bi bi-journal-bookmark-fill"></i> Product Catalog Management
        </a>
        <a href="{{ route('admin.users.index') }}" class="px-4 sm:px-5 py-3 border-b-2 border-[#7C3AED] text-[#312E81] font-black flex items-center gap-2 bg-purple-50/50 rounded-t-2xl flex-shrink-0">
            <i class="bi bi-shield-lock-fill text-[#7C3AED]"></i> Admin & Staff Logins
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-xs font-bold flex items-center gap-2">
            <i class="bi bi-check-circle-fill text-emerald-600 text-base"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-xs font-bold flex items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill text-rose-600 text-base"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Form: Create New Admin / Staff Login -->
    <div class="bg-white border border-purple-200/80 rounded-3xl p-6 shadow-sm space-y-4">
        <h3 class="font-whimsical font-bold text-[#312E81] text-lg sm:text-xl flex items-center gap-2">
            <i class="bi bi-person-plus-fill text-[#7C3AED]"></i> Create New Admin / Staff Account
        </h3>

        <form action="{{ route('admin.users.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 text-xs font-semibold">
            @csrf

            <div>
                <label class="block text-slate-700 font-bold mb-1">Full Name</label>
                <input type="text" name="name" required placeholder="Staff / Admin Name" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
            </div>

            <div>
                <label class="block text-slate-700 font-bold mb-1">Email Address</label>
                <input type="email" name="email" required placeholder="admin@800bypd.com" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
            </div>

            <div>
                <label class="block text-slate-700 font-bold mb-1">Phone Number</label>
                <input type="text" name="phone" placeholder="0816 425 4442" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
            </div>

            <div>
                <label class="block text-slate-700 font-bold mb-1">Password</label>
                <input type="password" name="password" required placeholder="Min 6 characters" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
            </div>

            <div>
                <label class="block text-slate-700 font-bold mb-1">Account Role</label>
                <select name="role" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none font-bold text-[#312E81] bg-purple-50">
                    <option value="admin">Admin (Full Access)</option>
                    <option value="customer">Customer</option>
                </select>
            </div>

            <div class="sm:col-span-2 md:col-span-5 flex justify-end">
                <button type="submit" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold px-6 py-3 rounded-xl shadow-md transition flex items-center gap-2 text-xs">
                    <i class="bi bi-shield-check text-base"></i> Create Account Credentials
                </button>
            </div>
        </form>
    </div>

    <!-- Table of Existing Accounts -->
    <div class="bg-white border border-purple-200/80 rounded-3xl p-5 sm:p-6 shadow-sm space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="font-whimsical font-bold text-slate-900 text-lg sm:text-xl flex items-center gap-2">
                <i class="bi bi-people-fill text-[#7C3AED]"></i> Registered Accounts & Admins
            </h3>
            <span class="text-xs font-bold text-slate-500">Total Users: {{ $users->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse min-w-[650px] sm:min-w-full">
                <thead>
                    <tr class="bg-purple-50/60 border-b border-slate-200 text-[#312E81] uppercase font-bold text-[11px]">
                        <th class="p-3.5 whitespace-nowrap">Name</th>
                        <th class="p-3.5 whitespace-nowrap">Email</th>
                        <th class="p-3.5 whitespace-nowrap">Phone</th>
                        <th class="p-3.5 whitespace-nowrap">Role</th>
                        <th class="p-3.5 whitespace-nowrap">Joined Date</th>
                        <th class="p-3.5 text-right whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @foreach($users as $user)
                        <tr class="hover:bg-purple-50/30 transition">
                            <td class="p-3.5 font-bold text-slate-900 whitespace-nowrap flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-[#312E81] text-[#FACC15] font-bold flex items-center justify-center text-xs font-whimsical">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                {{ $user->name }}
                                @if($user->id === Auth::id())
                                    <span class="bg-purple-100 text-[#7C3AED] text-[9px] font-bold px-2 py-0.5 rounded-full uppercase">You</span>
                                @endif
                            </td>
                            <td class="p-3.5 font-mono text-slate-700 whitespace-nowrap">{{ $user->email }}</td>
                            <td class="p-3.5 text-slate-600 whitespace-nowrap">{{ $user->phone ?? 'N/A' }}</td>
                            <td class="p-3.5 whitespace-nowrap">
                                @if($user->role === 'admin')
                                    <span class="bg-[#312E81] text-[#FACC15] font-black px-3 py-1 rounded-full text-[10px] uppercase shadow-sm inline-flex items-center gap-1">
                                        <i class="bi bi-shield-lock-fill"></i> Admin
                                    </span>
                                @else
                                    <span class="bg-slate-100 text-slate-700 font-bold px-3 py-1 rounded-full text-[10px] uppercase inline-flex items-center gap-1">
                                        <i class="bi bi-person-fill"></i> Customer
                                    </span>
                                @endif
                            </td>
                            <td class="p-3.5 text-slate-500 whitespace-nowrap">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="p-3.5 text-right whitespace-nowrap">
                                @if($user->id !== Auth::id())
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this account?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold px-3 py-1.5 rounded-xl text-xs transition border border-rose-200 inline-flex items-center gap-1">
                                            <i class="bi bi-trash-fill"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
