<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $transaction->transaction_code }} - Phiếu kho</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 28px; color: #172033; font: 13px/1.5 Arial, sans-serif; }
        .sheet { max-width: 900px; margin: auto; }
        .top { display: flex; justify-content: space-between; gap: 24px; border-bottom: 2px solid #1e3a8a; padding-bottom: 18px; }
        .muted { color: #64748b; }
        h1 { margin: 0 0 5px; font-size: 22px; color: #0f172a; }
        h2 { margin: 22px 0 10px; text-align: center; font-size: 20px; text-transform: uppercase; }
        .meta { display: grid; grid-template-columns: 1fr 1fr; gap: 8px 24px; margin: 18px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #cbd5e1; padding: 8px; text-align: left; vertical-align: top; }
        th { background: #f1f5f9; }
        .signatures { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 48px; text-align: center; }
        .signatures div { min-height: 100px; }
        .actions { margin: 0 auto 20px; max-width: 900px; text-align: right; }
        body.paper-a4 { page: a4; }
        body.paper-a5 { page: a5; }
        button { border: 0; border-radius: 6px; background: #1e3a8a; padding: 10px 18px; color: white; font-weight: 700; cursor: pointer; }
        @page a4 { size: A4 portrait; margin: 14mm; }
        @page a5 { size: A5 portrait; margin: 10mm; }
        @media print { body { padding: 0; } .actions { display: none; } }
        @media (max-width: 600px) { body { padding: 14px; } .meta { grid-template-columns: 1fr; } }
    </style>
</head>
<body class="paper-a4">
    <div class="actions">
        <label for="paper-size">Khổ giấy</label>
        <select id="paper-size" onchange="document.body.className = this.value">
            <option value="paper-a4">A4</option>
            <option value="paper-a5">A5</option>
        </select>
        <button onclick="window.print()">In phiếu</button>
    </div>
    <main class="sheet">
        <header class="top">
            <div><h1>QUẢN LÝ KHO VẬT TƯ</h1><span class="muted">Hạ tầng mạng &amp; CCTV</span></div>
            <div class="muted">Mẫu phiếu bàn giao vật tư</div>
        </header>
        <h2>{{ ['import' => 'Phiếu nhập kho', 'export' => 'Phiếu xuất kho / bàn giao', 'adjustment' => 'Phiếu kiểm kê / điều chỉnh'][$transaction->type] }}</h2>
        <div class="meta">
            <div><strong>Mã phiếu:</strong> {{ $transaction->transaction_code }}</div>
            <div><strong>Ngày lập:</strong> {{ $transaction->transaction_date->format('d/m/Y H:i') }}</div>
            <div><strong>Nhà cung cấp / nơi nhận:</strong> {{ $transaction->project_or_supplier_name }}</div>
            <div><strong>Người thực hiện:</strong> {{ $transaction->user?->fullname ?? '________________' }}</div>
        </div>
        <table>
            <thead><tr><th style="width: 36px">STT</th><th style="width: 100px">Mã vật tư</th><th>Tên vật tư</th><th style="width: 90px">Số lượng</th><th style="width: 70px">Đơn vị</th><th>Serial / MAC</th></tr></thead>
            <tbody>
                @foreach ($transaction->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product->sku }}</td>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ number_format((float) $item->quantity, 3) }}</td>
                        <td>{{ $item->product->unit }}</td>
                        <td>{{ implode(', ', $item->serial_numbers ?? []) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($transaction->note)<p><strong>Ghi chú:</strong> {{ $transaction->note }}</p>@endif
        <div class="signatures">
            <div><strong>Người lập phiếu</strong><br><span class="muted">(Ký, ghi rõ họ tên)</span></div>
            <div><strong>Người giao</strong><br><span class="muted">(Ký, ghi rõ họ tên)</span></div>
            <div><strong>Người nhận</strong><br><span class="muted">(Ký, ghi rõ họ tên)</span></div>
        </div>
    </main>
</body>
</html>
