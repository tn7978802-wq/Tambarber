# Module "Thư Viện Tác Phẩm" (Portfolio)
Module này bổ sung phần **Portfolio / Gallery** cho website barbershop, theo đúng sơ đồ bạn đưa ra (mục 6). Copy các file vào đúng vị trí trong project Laravel hiện tại.
## 1. Copy file vào project
| File trong module này | Copy vào |
|---|---|
| `database/migrations/2026_09_08_000000_create_portfolio_items_table.php` | `database/migrations/` |
| `database/seeders/PortfolioItemSeeder.php` | `database/seeders/` |
| `app/Models/PortfolioItem.php` | `app/Models/` |
| `app/Http/Controllers/PortfolioController.php` | `app/Http/Controllers/` |
| `app/Http/Controllers/Admin/PortfolioController.php` | `app/Http/Controllers/Admin/` |
| `resources/views/portfolio/index.blade.php` | `resources/views/portfolio/` |
| `resources/views/admin/portfolio/*.blade.php` | `resources/views/admin/portfolio/` |
## 2. Route
Mở `routes_snippet.php`, copy đoạn route vào `routes/web.php` (đặt route `/thu-vien` cùng nhóm `/kieu-toc`, `/gioi-thieu`; đặt route `admin/portfolio` trong group middleware `auth` + role Admin/SuperAdmin hiện có của bạn).
Nếu sidebar Admin dùng danh sách menu tĩnh, thêm 1 mục:
```blade
<a href="{{ route('admin.portfolio.index') }}">Thư viện tác phẩm</a>
```
Và ở menu công khai (header/footer), thêm:
```blade
<a href="{{ route('portfolio.index') }}">Portfolio</a>
```
## 3. Migrate & liên kết bảng `barbers`
Migration có khóa ngoại `barber_id` tham chiếu tới bảng `barbers` — đúng với bảng barber bạn đã có (chỉ bắt buộc field `name`). Nếu tên bảng/model barber của bạn khác (`staff`, `employees`...), sửa lại trong migration + model trước khi chạy:
```bash
php artisan migrate
php artisan db:seed --class=PortfolioItemSeeder   # dữ liệu mẫu (ảnh demo từ picsum.photos)
```
Nhớ đã chạy `php artisan storage:link` để ảnh upload qua `Storage::disk('public')` hiển thị được ở `/storage/...`.
## 4. Cách hoạt động
- **Trang công khai** `/thu-vien`: lưới ảnh có bộ lọc theo danh mục (Fade, Tạo kiểu, Cạo râu, Trẻ em, Khác), click ảnh mở lightbox so sánh **Trước/Sau** nếu có, không cần JavaScript (dùng checkbox + Tailwind `peer`).
- **Trang Admin** `/admin/portfolio`: CRUD đầy đủ — thêm/sửa/xoá tác phẩm, upload ảnh bằng nút "+" mở file picker gốc của hệ điều hành (đúng pattern bạn đang dùng ở các form khác), có preview ảnh ngay khi chọn, đánh dấu "Nổi bật", gắn barber thực hiện.
- Dùng lại các component có sẵn của bạn: `x-page-header`, `x-form-card`, `x-btn`, `x-status-pill` — nếu tên prop/slot trong component thật của bạn khác một chút, chỉnh lại cho khớp.
## 5. Việc cần làm tiếp theo
- Thay ảnh demo (picsum.photos) bằng ảnh thật của tiệm qua trang Admin.
- Nếu bạn muốn thêm bình luận/đánh giá dưới mỗi tác phẩm (giống phần Announcements), có thể tái dùng bảng comment đa hình đã có sẵn — báo tôi để nối thêm.
