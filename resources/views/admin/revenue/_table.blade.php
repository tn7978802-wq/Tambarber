{{--
    Bảng doanh thu theo Barber.
    Sắp xếp theo thời gian (giờ + ngày) — KHÔNG theo tên barber.
    Gồm cả khách vãng lai và khách đặt lịch online đã "Hoàn thành".
--}}
<div class="overflow-x-auto bg-[#171008]/50 rounded-[4px] border border-[#3c2c15]">
    <table class="w-full text-xs text-left text-[#f4ecd8]/90">
        <thead class="border-b border-[#3c2c15] bg-[#070503] text-[10px] font-bold uppercase tracking-wider text-[#6f6248]">
            <tr>
                <th class="py-3 px-4">Barber</th>
                <th class="py-3 px-4">Dịch vụ</th>
                <th class="py-3 px-4">Giờ</th>
                <th class="py-3 px-4">Ngày</th>
                <th class="py-3 px-4 text-right">Giá (VND)</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#3c2c15]/50">
            @forelse ($rows ?? [] as $row)
                <tr class="hover:bg-[#171008] transition-colors">
                    <td class="py-3 px-4 font-semibold text-[#f2d788] whitespace-nowrap">
                        {{ optional($row->barber)->name ?? 'N/A' }}
                    </td>
                    <td class="py-3 px-4 text-[#f4ecd8]">
                        {{ $row->services_label ?: ($row->source === 'online' ? 'Đặt lịch online' : '—') }}
                    </td>
                    <td class="py-3 px-4 font-mono text-[#f4ecd8]/80 whitespace-nowrap">
                        {{ optional($row->started_at)->format('H:i') ?? '—' }}
                    </td>
                    <td class="py-3 px-4 font-mono text-[#f4ecd8]/80 whitespace-nowrap">
                        {{ optional($row->started_at)->format('d/m/Y') ?? '—' }}
                    </td>
                    <td class="py-3 px-4 text-right font-mono font-bold text-[#f2d788] whitespace-nowrap">
                        {{ number_format($row->total_price ?? 0) }}đ
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-[#6f6248] italic">
                        <i class="fa-regular fa-folder-open text-2xl mb-2 block"></i>
                        Chưa có dữ liệu doanh thu trong khoảng thời gian này.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="border-t border-[#3c2c15] bg-[#070503] font-bold text-[#f2d788]">
                <td class="py-3 px-4 uppercase tracking-wider text-[11px]" colspan="4">
                    Tổng Doanh Thu
                </td>
                <td class="py-3 px-4 text-right font-mono text-sm text-[#f2d788]">
                    {{ number_format($total ?? 0) }}đ
                </td>
            </tr>
        </tfoot>
    </table>
</div>