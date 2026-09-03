@extends('layouts.admin')

@section('title', 'Khu vực Chủ Tiệm - Tâm Barbershop Admin')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 py-4">

    <!-- HEADER SECTION -->
    <div class="relative overflow-hidden rounded-[4px] border border-[#a8342f]/40 bg-[#110d07]/95 p-6 sm:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.8)] backdrop-blur-md"
         style="box-shadow: 0 0 35px rgba(124,31,34,0.18), inset 0 0 15px rgba(242,215,136,0.02);">
        
        <div class="flex items-center gap-3 mb-2">
            <span class="flex h-8 w-8 items-center justify-center rounded-[2px] border border-[#a8342f] bg-[#070503] text-[#f2d788] shadow-[0_0_10px_rgba(168,52,47,0.3)]">
                <i class="fa-solid fa-crown text-xs"></i>
            </span>
            <div>
                <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#a8342f]">Khu vực đặc quyền</span>
                <h1 class="font-['Bebas_Neue'] text-3xl sm:text-4xl tracking-widest bg-gradient-to-r from-[#f2d788] via-[#fff5d6] to-[#cf9f3f] bg-clip-text text-transparent uppercase leading-tight">
                    Khu Vực Chủ Tiệm
                </h1>
            </div>
        </div>
        <p class="text-xs text-[#f4ecd8]/70 pl-11">
            Khu vực dành riêng cho Chủ Tiệm — toàn quyền kiểm soát hệ thống, theo dõi doanh thu và phân quyền nhân sự.
        </p>

        <div class="mt-4 h-[1px] w-full bg-gradient-to-r from-[#a8342f]/50 via-[#3c2c15] to-transparent"></div>
    </div>

    <!-- OVERVIEW STATS METRICS GRID -->
    <div class="space-y-3">
        <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase flex items-center gap-2">
            <i class="fa-solid fa-chart-pie text-xs text-[#a8342f]"></i>
            Thống Kê Tổng Quan
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <!-- Total Users -->
            <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-4 shadow-lg flex flex-col justify-between space-y-2 hover:border-[#a8342f]/50 transition-all">
                <span class="text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">Tổng người dùng</span>
                <span class="font-['Bebas_Neue'] text-2xl tracking-wider text-[#f2d788]">{{ number_format($stats['total_users']) }}</span>
            </div>

            <!-- Total Admins -->
            <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-4 shadow-lg flex flex-col justify-between space-y-2 hover:border-[#a8342f]/50 transition-all">
                <span class="text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">Nhân sự quản trị</span>
                <span class="font-['Bebas_Neue'] text-2xl tracking-wider text-[#f2d788]">{{ number_format($stats['total_admins']) }}</span>
            </div>

            <!-- Total Revenue -->
            <div class="rounded-[4px] border border-[#8a641d]/50 bg-[#171008] p-4 shadow-lg flex flex-col justify-between space-y-2 hover:border-[#f2d788] transition-all">
                <span class="text-[10px] font-bold uppercase tracking-wider text-[#f2d788]/80">Tổng doanh thu</span>
                <span class="font-['Bebas_Neue'] text-2xl tracking-wider text-[#f2d788]">{{ number_format($stats['total_revenue'], 0, ',', '.') }}đ</span>
            </div>

            <!-- New Users Today -->
            <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-4 shadow-lg flex flex-col justify-between space-y-2 hover:border-[#a8342f]/50 transition-all">
                <span class="text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">Đăng ký hôm nay</span>
                <span class="font-['Bebas_Neue'] text-2xl tracking-wider text-emerald-400">+{{ number_format($stats['new_users_today']) }}</span>
            </div>

            <!-- Bookings Today -->
            <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-4 shadow-lg flex flex-col justify-between space-y-2 hover:border-[#a8342f]/50 transition-all">
                <span class="text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">Lịch hẹn hôm nay</span>
                <span class="font-['Bebas_Neue'] text-2xl tracking-wider text-amber-400">{{ number_format($stats['bookings_today']) }}</span>
            </div>

            <!-- Pending Contacts -->
            <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-4 shadow-lg flex flex-col justify-between space-y-2 hover:border-[#a8342f]/50 transition-all">
                <span class="text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">Liên hệ chờ xử lý</span>
                <span class="font-['Bebas_Neue'] text-2xl tracking-wider text-red-400">{{ number_format($stats['pending_contact_messages']) }}</span>
            </div>
        </div>
    </div>

    <!-- TOP SERVICES & SYSTEM COUNCIL GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- TOP SERVICES CARD -->
        <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl space-y-4">
            <div class="flex items-center gap-2 border-b border-[#3c2c15] pb-3">
                <i class="fa-solid fa-fire text-[#a8342f] text-sm"></i>
                <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase">
                    Dịch Vụ Đặt Nhiều Nhất
                </h2>
            </div>

            <ul class="space-y-3">
                @forelse ($topServices as $index => $service)
                    <li class="flex items-center justify-between p-3 rounded-[2px] border border-[#3c2c15]/60 bg-[#070503] hover:border-[#8a641d] transition-all">
                        <div class="flex items-center gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#171008] border border-[#3c2c15] font-['Bebas_Neue'] text-xs font-bold text-[#f2d788]">
                                {{ $index + 1 }}
                            </span>
                            <span class="text-xs font-semibold text-[#f4ecd8]">{{ $service->name }}</span>
                        </div>
                        <span class="rounded-[2px] border border-[#8a641d]/40 bg-[#171008] px-2.5 py-1 text-[11px] font-bold text-[#f2d788]">
                            {{ $service->total_bookings }} lượt đặt
                        </span>
                    </li>
                @empty
                    <li class="py-6 text-center text-[#6f6248] italic text-xs">Chưa có dữ liệu đặt lịch.</li>
                @endforelse
            </ul>
        </div>

        <!-- SYSTEM COUNCIL SECTION (Root Owner Only) -->
        @if (auth()->user()->isRootOwner())
            <div class="rounded-[4px] border border-[#a8342f]/60 bg-[#110d07] p-6 shadow-2xl space-y-6 relative overflow-hidden"
                 style="box-shadow: 0 0 25px rgba(124,31,34,0.15);">
                
                <div class="border-b border-[#3c2c15] pb-3">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-user-shield text-[#a8342f] text-sm"></i>
                        <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase">
                            Quản Lý
                        </h2>
                    </div>
                    <span class="text-[10px] text-[#6f6248] italic block mt-0.5">(Đặc quyền độc bản chỉ Root Owner mới nhìn thấy)</span>
                </div>

                <!-- Promote Form -->
                <form action="{{ route('admin.system-owner.sub-owners.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#f4ecd8]/90 block">Thăng chức Quản lý</span>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <input type="email" name="email" placeholder="Email nhân sự..." required
                               class="rounded-[2px] border border-[#3c2c15] bg-[#070503] px-3 py-2 text-xs text-[#f4ecd8] placeholder-[#4a3b22] focus:border-[#a8342f] focus:outline-none">
                        <input type="text" name="note" placeholder="Ghi chú (vd: Quản lý CS2)"
                               class="rounded-[2px] border border-[#3c2c15] bg-[#070503] px-3 py-2 text-xs text-[#f4ecd8] placeholder-[#4a3b22] focus:border-[#a8342f] focus:outline-none">
                    </div>
                    <button type="submit" 
                            class="w-full inline-flex items-center justify-center gap-2 rounded-[2px] border border-[#f2d788]/60 bg-gradient-to-r from-[#7c1f22] via-[#cf9f3f] to-[#8a641d] px-4 py-2 text-xs font-bold uppercase tracking-wider text-[#f4ecd8] hover:brightness-125 transition-all">
                        <i class="fa-solid fa-angles-up text-[10px]"></i>
                        <span>Thăng Chức Quản Lý</span>
                    </button>
                </form>

                <!-- Sub-owners List -->
                <div class="space-y-2 pt-2 border-t border-[#3c2c15]/60">
                    <span class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#6f6248] block">Danh sách Quản lý hiện tại</span>
                    <ul class="space-y-2">
                        @forelse ($subOwners as $sub)
                            <li class="flex items-center justify-between p-2.5 rounded-[2px] border border-[#3c2c15] bg-[#070503]">
                                <div class="space-y-0.5">
                                    <div class="text-xs font-bold text-[#f2d788]">{{ $sub->email }}</div>
                                    <span class="inline-block text-[10px] text-[#a8342f] font-semibold">{{ $sub->note ?: 'Quản lý' }}</span>
                                </div>
                                <form action="{{ route('admin.system-owner.sub-owners.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn tước quyền Quản của tài khoản này?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="rounded-[2px] border border-[#a8342f] bg-[#7c1f22]/30 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-red-300 hover:bg-[#a8342f] hover:text-white transition-all">
                                        Tước chức
                                    </button>
                                </form>
                            </li>
                        @empty
                            <li class="py-3 text-center text-[#6f6248] italic text-xs">Chưa có nhân sự nào được cấp quyền bổ sung.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        @endif

    </div>

    <!-- USER ROLE MANAGEMENT TABLE -->
    <div class="rounded-[4px] border border-[#3c2c15] bg-[#110d07] p-6 shadow-2xl space-y-4">
        
        <div class="flex items-center justify-between border-b border-[#3c2c15] pb-3">
            <h2 class="font-['Bebas_Neue'] text-2xl tracking-wide text-[#f2d788] uppercase flex items-center gap-2">
                <i class="fa-solid fa-users-gear text-xs text-[#a8342f]"></i>
                Quản Lý Phân Quyền Nhân Sự &amp; Người Dùng
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-[#f4ecd8]/90">
                <thead class="border-b border-[#3c2c15] bg-[#070503] text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">
                    <tr>
                        <th class="py-3 px-4">Thành viên</th>
                        <th class="py-3 px-4">Email / SĐT</th>
                        <th class="py-3 px-4">Vai trò hiện tại</th>
                        <th class="py-3 px-4">Thay đổi vai trò</th>
                        <th class="py-3 px-4 text-right">Thao tác xóa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#3c2c15]/50">
                    @foreach ($users as $user)
                        <tr class="hover:bg-[#171008] transition-colors">
                            <!-- Fullname -->
                            <td class="py-3 px-4 font-bold text-[#f2d788]">
                                {{ $user->fullname }}
                            </td>

                            <!-- Email & Phone -->
                            <td class="py-3 px-4 leading-relaxed">
                                <div class="text-[#f4ecd8]">{{ $user->email }}</div>
                                <div class="text-[11px] text-[#6f6248]">{{ $user->phone ?? '—' }}</div>
                            </td>

                            <!-- Current Role Badge -->
                            <td class="py-3 px-4">
                                @if ($user->isSystemOwner())
                                    <span class="inline-flex items-center gap-1 rounded-[2px] border border-[#f2d788]/60 bg-gradient-to-r from-[#7c1f22] to-[#8a641d] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-[#f2d788] shadow-sm">
                                        <i class="fa-solid fa-crown text-[9px]"></i> Chủ Tiệm
                                    </span>
                                @elseif ($user->admin_role == \App\Models\User::ROLE_ADMIN)
                                    <span class="inline-flex items-center gap-1 rounded-[2px] border border-amber-500/40 bg-amber-950/40 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-amber-300">
                                        <i class="fa-solid fa-user-shield text-[9px]"></i> Nhân viên quản trị
                                    </span>
                                @elseif ($user->admin_role == \App\Models\User::ROLE_CLIENT)
                                    <span class="inline-flex items-center gap-1 rounded-[2px] border border-[#3c2c15] bg-[#070503] px-2.5 py-1 text-[10px] font-semibold text-[#f4ecd8]/80">
                                        Khách hàng
                                    </span>
                                @else
                                    <span class="text-[11px] text-[#6f6248] italic">Khách vãng lai</span>
                                @endif
                            </td>

                            <!-- Change Role Select -->
                            <td class="py-3 px-4 min-w-[200px]">
                                @if (! $user->isSystemOwner())
                                    <form action="{{ route('admin.system-owner.update-role', $user->id) }}" method="POST">
                                        @csrf 
                                        @method('PUT')
                                        <select name="admin_role" onchange="this.form.submit()"
                                                class="w-full rounded-[2px] border border-[#3c2c15] bg-[#070503] px-3 py-1.5 text-xs text-[#f4ecd8] focus:border-[#a8342f] focus:outline-none cursor-pointer transition-all">
                                            <option value="0" @selected($user->admin_role == 0)>0 - Khách vãng lai</option>
                                            <option value="1" @selected($user->admin_role == 1)>1 - Khách hàng</option>
                                            <option value="2" @selected($user->admin_role == 2)>2 - Nhân viên</option>
                                            @if (auth()->user()->isRootOwner())
                                                <option value="3" @selected($user->admin_role == 3)>3 - Quản lý</option>
                                            @endif
                                        </select>
                                    </form>
                                @else
                                    <span class="text-[11px] text-[#8a641d] font-bold italic uppercase tracking-wider">Chủ Tiệm</span>
                                @endif
                            </td>

                            <!-- Delete Action -->
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                @php
                                    $auth = auth()->user();
                                    $canDelete = false;
                                    if (! $auth->isSubOwner()) {
                                        if ($auth->isRootOwner() && ! $user->isSystemOwner()) {
                                            $canDelete = true;
                                        }
                                        if (strtolower($auth->email) === 'admin@gmail.com') {
                                            $canDelete = true;
                                        }
                                    }
                                    if ($user->id === $auth->id || $user->isRootOwner()) {
                                        $canDelete = false;
                                    }
                                @endphp

                                @if ($canDelete)
                                    <form action="{{ route('admin.system-owner.destroy-user', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này? Hành động không thể hoàn tác.');">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 rounded-[2px] border border-[#a8342f] bg-[#7c1f22]/30 px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-red-300 transition-all hover:bg-[#a8342f] hover:text-white">
                                            <i class="fa-solid fa-trash text-[10px]"></i>
                                            <span>Xóa</span>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[#6f6248] font-mono">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-4 border-t border-[#3c2c15]">
            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection