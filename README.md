# Hệ thống quản lý kho vật tư mạng & CCTV

Ứng dụng Laravel quản lý thiết bị mạng, camera và vật tư thi công; theo dõi tồn
kho theo phiếu nhập, xuất và kiểm kê; lưu serial/MAC; hỗ trợ CSV và in phiếu bàn giao.

## Cài đặt và chạy

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Trong terminal khác, cài dependencies frontend nếu cần rồi build assets:

```powershell
npm install
npm run build
```

## Truy cập

- Đăng nhập: `/dang-nhap`
- Tổng quan kho: `/admin`
- Vật tư: `/admin/products`
- Giao dịch: `/admin/transactions`
- Dọn phiếu/vật tư demo cũ: `php artisan db:seed --class=InventorySeeder`

Các tuyến kho yêu cầu đăng nhập và quyền quản trị (`admin_role = 2`) hoặc tài khoản
quản trị tối cao được cấu hình qua `SYSTEM_OWNER_EMAIL`. Tài khoản đăng ký mới có
quyền khách mặc định và không tự động được cấp quyền truy cập kho.

## Mô hình dữ liệu

- `categories`, `products`: danh mục, SKU/barcode, hãng, đơn vị, vị trí và định mức.
- `suppliers`, `projects`: nguồn nhập và địa điểm/dự án nhận vật tư.
- `inventory_transactions`, `inventory_transaction_items`: phiếu và chi tiết phiếu.
- `users`: nhân viên tạo phiếu; được giữ lại cùng các bảng xác thực.

`InventorySeeder` chỉ xóa các phiếu và SKU demo đã biết. Seeder sẽ dừng nếu vật tư
demo đang được tham chiếu bởi phiếu khác để bảo toàn lịch sử giao dịch thực tế.

## Nghiệp vụ

- Nhập/xuất/kiểm kê được lưu trong `DB::transaction`.
- Vật tư được khóa khi ghi phiếu; xuất vượt tồn và điều chỉnh âm tồn bị từ chối.
- Tồn kho chỉ thay đổi qua phiếu, không chỉnh trực tiếp trong màn hình vật tư.
- Cảnh báo sắp hết hàng khi tồn hiện tại nhỏ hơn hoặc bằng định mức.
- Giao dịch lưu danh sách serial/MAC dưới dạng JSON.
- Xuất CSV tại `/admin/exports/products.csv` và `/admin/exports/transactions.csv`.
- Phiếu giao dịch có bản in khổ A4/A5 tại nút **In phiếu**.

## Lưu ý nâng cấp từ phiên bản barbershop

Migration dọn dữ liệu cũ sẽ xóa các bảng đặt lịch, dịch vụ, barber, bài viết,
portfolio, đánh giá, liên hệ và thông báo. Hãy sao lưu database trước khi chạy
`php artisan migrate`; migration dọn dữ liệu này không thể khôi phục bằng rollback.
