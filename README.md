# Barbershop Website

Dự án Laravel dựng theo **logic & cấu trúc** của một ứng dụng đặt vé rạp phim
(Controller / Model / Migration / Blade tách theo tính năng, khu vực admin
riêng dùng CRUD pattern), nhưng đổi toàn bộ nghiệp vụ sang **tiệm cắt tóc**.
Chưa gắn CSS/framework giao diện — phần này để bạn tự thiết kế lại sau.

## Sơ đồ trang (khớp yêu cầu)

```
Trang chủ            /                      HomeController@index
Giới thiệu           /gioi-thieu            AboutController@index
Kiểu tóc (danh sách) /kieu-toc              HairstyleController@index
Kiểu tóc (chi tiết)  /kieu-toc/{slug}       HairstyleController@show
Dịch vụ              /dich-vu               ServiceController@index
Portfolio            /portfolio             PortfolioController@index
Blog (danh sách)     /blog                  BlogController@index
Blog (chi tiết)      /blog/{slug}           BlogController@show
Đặt lịch (form)      /dat-lich              BookingController@create
Đặt lịch (lưu)       /dat-lich (POST)       BookingController@store
Đặt lịch (thành công)/dat-lich/thanh-cong/{code}  BookingController@success
Liên hệ              /lien-he               ContactController@index/store

Trạng thái & Sự kiện (công khai — MỌI người xem và bình luận, kể cả khách):
/trang-thai                          AnnouncementController@index
/trang-thai/{id}                     AnnouncementController@show
/trang-thai/{id}/binh-luan (POST)    AnnouncementController@storeComment

Khu vực quản trị (yêu cầu đăng nhập + middleware `admin`):
/admin                Admin\DashboardController  (tổng quan doanh thu, lịch hẹn...)
/admin/lich-hen       Admin\BookingController    (xác nhận / hoàn thành / huỷ)
/admin/dich-vu        Admin\ServiceController    (CRUD dịch vụ)
/admin/kieu-toc       Admin\HairstyleController  (CRUD kiểu tóc)
/admin/barber         Admin\BarberController     (CRUD barber — chỉ "Tên" bắt buộc)
/admin/trang-thai     Admin\AnnouncementController (đăng trạng thái/sự kiện kèm ảnh,
                                                      hiện ở khung phải Trang chủ)

Khu vực Quản lý tối cao (yêu cầu thêm middleware `system_owner`):
/admin/quan-ly-toi-cao  Admin\SystemOwnerController (thống kê, thăng/giáng Sub-Owner,
                                                       phân quyền toàn bộ user)
```

## Tài khoản mẫu sau khi `php artisan migrate --seed`

| Vai trò              | Email                  | Mật khẩu   |
|-----------------------|------------------------|------------|
| Chủ Tiệm (System Owner)| owner@barbershop.vn   | password   |
| Nhân viên quản trị     | nhanvien@barbershop.vn| password   |
| Khách hàng             | khach@barbershop.vn   | password   |

> Email `owner@barbershop.vn` phải trùng với `SYSTEM_OWNER_EMAIL` trong `.env` để có
> quyền Quản lý tối cao tuyệt đối kể cả khi field `admin_role` trong DB bị đổi.
> Có thể đăng nhập bằng "Chìa khoá vạn năng" tại `/quan-ly-toi-cao/dang-nhap` bằng
> mật khẩu cấu hình ở biến `MASTER_PASS_OWNER_BARBERSHOP_VN` trong `.env`.

## Cấu trúc thư mục chính

```
app/
  Http/Controllers/         Controller cho phần công khai (public)
  Http/Controllers/Admin/   Controller cho khu vực quản trị
  Http/Middleware/          AdminMiddleware bảo vệ /admin/*
  Models/                   Barber, Service, Hairstyle, Portfolio, Post, Booking, Review

database/
  migrations/                Bảng: barbers, services, hairstyles, portfolios,
                              posts, bookings, reviews, contact_messages
  seeders/DatabaseSeeder.php Dữ liệu mẫu (dùng luôn 3 ảnh tiệm bạn gửi)

resources/views/
  layouts/app.blade.php      Layout công khai (nav đủ 8 mục theo sơ đồ)
  layouts/admin.blade.php    Layout khu vực quản trị
  home.blade.php, about.blade.php, contact.blade.php
  hairstyles/, services/, portfolio/, blog/, booking/
  admin/bookings/, admin/services/, admin/hairstyles/

routes/web.php               Toàn bộ route, đặt tên theo domain "barbershop"
public/images/                3 ảnh bạn upload, đã đổi tên gợi nhớ:
  - fade-cut-closeup.jpg      (ảnh cận cảnh cắt fade)
  - shop-working.jpg          (ảnh camera an ninh, barber đang làm việc)
  - shop-interior.jpg         (ảnh không gian tiệm, khách đang chờ)
```

## Logic đáng chú ý (mirror lại từ mã nguồn tham khảo)

- **Đặt lịch (`BookingController`)**: giống logic khoá ghế khi checkout vé —
  dùng `DB::transaction()` + `lockForUpdate()` để tránh 2 khách đặt trùng
  khung giờ của cùng một barber, sinh mã đặt lịch duy nhất kiểu `BAR-XXXXXXXX`.
- **Blog (`Post` model)**: có scope `published()` y hệt scope `Post::published()`
  bên rạp phim (chỉ hiện bài đã publish và tới giờ đăng).
- **Trang kiểu tóc**: có tìm kiếm + lọc theo độ khó, dùng scope `search()`.
- **Khu vực Admin**: cùng pattern index/store/update/destroy như
  `Admin\MovieController`, `Admin\VoucherController` trong mã tham khảo,
  bảo vệ bởi middleware `admin` (tự chỉnh lại điều kiện phân quyền theo
  bảng `users` thật của bạn trong `AdminMiddleware`).

## Ảnh & Upload (Kiểu tóc, Dịch vụ, Barber, Trạng thái/Sự kiện)

Tất cả các form quản trị có ảnh giờ dùng nút **"➕ Chọn ảnh từ máy"** — bấm vào sẽ
mở thẳng hộp thoại duyệt file của hệ điều hành (ổ C:, thư mục ảnh...) để chọn ảnh,
thay vì phải gõ tay đường dẫn. Ảnh được lưu qua `Storage::disk('public')` tại
`storage/app/public/uploads/...` và phục vụ qua `/storage/...`.

**Bắt buộc chạy 1 lần** sau khi cài đặt để ảnh hiển thị được:

```bash
php artisan storage:link
```

## Trạng thái & Sự kiện (mới)

- Admin đăng bài tại `/admin/trang-thai`, có thể kèm ảnh và giờ diễn ra sự kiện
  (không bắt buộc — để trống nếu chỉ là thông báo/trạng thái thường).
- 5 bài mới nhất tự động hiện ở **khung bên phải Trang chủ**.
- Trang `/trang-thai` liệt kê toàn bộ bài đăng; vào chi tiết từng bài để bình luận.
- Bình luận **mở cho tất cả mọi người**, kể cả khách chưa đăng nhập (chỉ cần nhập tên).

## Cách chạy thử (khi có PHP/Composer)

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Sau đó truy cập:
- Trang công khai: http://localhost:8000
- Đăng nhập bằng tài khoản mẫu ở bảng phía trên (không cần chỉnh `is_admin`
  thủ công — hệ thống dùng field `admin_role` có sẵn trong bảng `users`).
- Khu vực quản trị: http://localhost:8000/admin

## Bước tiếp theo gợi ý

1. Gắn hệ thống đăng nhập (Laravel Breeze/Fortify) cho phần admin.
2. Thiết kế lại CSS/giao diện theo phong cách riêng của bạn.
3. Thay ảnh mẫu trong `public/images` bằng ảnh thật của tiệm.
4. Có thể thêm upload ảnh (Cloudinary hoặc storage local) cho Portfolio/Post
   tương tự `CloudinaryUploader` trong mã tham khảo nếu cần.
