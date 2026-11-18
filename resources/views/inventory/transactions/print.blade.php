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
        .actions { display: flex; flex-wrap: wrap; align-items: center; justify-content: flex-end; gap: 10px; margin: 0 auto 20px; max-width: 900px; }
        .actions label { font-weight: 600; }
        body.paper-a4 { page: a4; }
        body.paper-a5 { page: a5; }
        button, select { border: 1px solid #cbd5e1; border-radius: 6px; background: white; padding: 9px 14px; color: #172033; font: inherit; cursor: pointer; }
        button.primary { border-color: #1e3a8a; background: #1e3a8a; color: white; font-weight: 700; }
        button[aria-pressed="true"] { border-color: #1e3a8a; background: #dbeafe; color: #1e3a8a; }
        .editing [contenteditable="true"] { outline: 1px dashed #94a3b8; outline-offset: 3px; border-radius: 2px; }
        .editing [data-placeholder]:empty::before { content: attr(data-placeholder); color: #94a3b8; }
        @page a4 { size: A4 portrait; margin: 14mm; }
        @page a5 { size: A5 portrait; margin: 10mm; }
        @media print {
            body { padding: 0; }
            .actions { display: none !important; }
            .sheet [contenteditable="true"] { outline: none !important; border: 0 !important; }
            .sheet [data-placeholder]:empty::before { content: none !important; }
        }
        @media (max-width: 600px) {
            body { padding: 14px; }
            .meta { grid-template-columns: 1fr; }
            .top { flex-direction: column; }
            .actions { justify-content: flex-start; }
        }
    </style>
</head>
<body class="paper-a4">
    <div class="actions">
        <button id="edit-document" type="button" aria-pressed="false">Chỉnh sửa nội dung phiếu</button>
        <label for="paper-size">Khổ giấy</label>
        <select id="paper-size">
            <option value="paper-a4">A4</option>
            <option value="paper-a5">A5</option>
        </select>
        <button class="primary" id="print-document" type="button">In phiếu</button>
    </div>
    <main class="sheet">
        <header class="top">
            <div>
                <h1 class="editable">QUẢN LÝ KHO VẬT TƯ</h1>
                <span class="muted editable">Hạ tầng mạng &amp; CCTV</span>
            </div>
            <div class="muted editable">Mẫu phiếu bàn giao vật tư</div>
        </header>
        <h2 class="editable">{{ ['import' => 'Phiếu nhập kho', 'export' => 'Phiếu xuất kho / bàn giao', 'adjustment' => 'Phiếu kiểm kê / điều chỉnh'][$transaction->type] }}</h2>
        <div class="meta">
            <div><strong>Mã phiếu:</strong> {{ $transaction->transaction_code }}</div>
            <div><strong>Ngày lập:</strong> <span class="editable">{{ $transaction->transaction_date->format('d/m/Y H:i') }}</span></div>
            <div><strong>Nhà cung cấp / nơi nhận:</strong> <span class="editable">{{ $transaction->project_or_supplier_name }}</span></div>
            <div><strong>Người thực hiện:</strong> <span class="editable">{{ $transaction->user?->fullname ?? '________________' }}</span></div>
        </div>
        <table>
            <thead><tr><th style="width: 36px">STT</th><th style="width: 100px">Mã vật tư</th><th>Tên vật tư</th><th style="width: 90px">Số lượng</th><th style="width: 70px">Đơn vị</th><th>Serial / MAC</th></tr></thead>
            <tbody>
                @foreach ($transaction->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product->sku }}</td>
                        <td class="editable">{{ $item->product->name }}</td>
                        <td class="editable">{{ number_format((float) $item->quantity, 3) }}</td>
                        <td class="editable">{{ $item->product->unit }}</td>
                        <td class="editable" data-placeholder="—">{{ implode(', ', $item->serial_numbers ?? []) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p><strong>Ghi chú:</strong> <span class="editable" data-placeholder="Bấm để thêm ghi chú">{{ $transaction->note }}</span></p>
        <div class="signatures">
            <div><strong class="editable">Người lập phiếu</strong><br><span class="muted">(Ký, ghi rõ họ tên)</span></div>
            <div><strong class="editable">Người giao</strong><br><span class="muted">(Ký, ghi rõ họ tên)</span></div>
            <div><strong class="editable">Người nhận</strong><br><span class="muted">(Ký, ghi rõ họ tên)</span></div>
        </div>
    </main>
    <script>
        (() => {
            const body = document.body;
            const editButton = document.getElementById('edit-document');
            const paperSize = document.getElementById('paper-size');
            const editableFields = document.querySelectorAll('.editable');

            editButton.addEventListener('click', () => {
                const editing = editButton.getAttribute('aria-pressed') !== 'true';
                editButton.setAttribute('aria-pressed', String(editing));
                editButton.textContent = editing ? 'Hoàn tất chỉnh sửa' : 'Chỉnh sửa nội dung phiếu';
                body.classList.toggle('editing', editing);

                editableFields.forEach((field) => {
                    if (editing) {
                        field.setAttribute('contenteditable', 'true');
                        field.setAttribute('spellcheck', 'false');
                    } else {
                        field.removeAttribute('contenteditable');
                        field.removeAttribute('spellcheck');
                    }
                });
            });

            paperSize.addEventListener('change', () => {
                body.classList.remove('paper-a4', 'paper-a5');
                body.classList.add(paperSize.value);
            });

            document.getElementById('print-document').addEventListener('click', () => window.print());
        })();
    </script>
</body>
</html>
