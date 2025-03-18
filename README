testapi: http://localhost:888/trangwebtutien/backend/api/login.php
http://localhost:888/trangwebtutien/admin/api/update.php

{
    "id": 1,
    "ten_truyen": "Truyện cập nhật",
    "mo_ta": "Nội dung truyện",
    "tac_gia": "Tác giả mới",
    "anh_bia": "link_hinh_moi.jpg"
}
Key: Authorization
Value: Bearer <JWT_TOKEN>
📁 TRANGWEBTUTIEN/
│── 📁 .vscode/                      # Cấu hình VS Code (nếu có)
│   │── launch.json                  # Cấu hình Debug cho VS Code
│
│── 📁 assets/                        # Chứa tài nguyên frontend
│   │── 📁 css/                        # File CSS
│   │   ├── style.css                  # CSS chính cho giao diện người dùng
│   │   ├── responsive.css             # CSS responsive cho mobile, tablet
│   │   ├── admin.css                  # CSS dành cho trang admin
│   │   ├── animations.css             # Hiệu ứng động
│   │   ├── colors.css                 # Cấu hình màu sắc
│   │   ├── bootstrap.min.css          # Thư viện Bootstrap (nếu sử dụng)
│   │
│   │── 📁 js/                         # File JavaScript
│   │   ├── main.js                    # JavaScript chính cho frontend
│   │   ├── auth.js                    # Xử lý đăng nhập, đăng ký, đăng xuất
│   │   ├── search.js                  # Xử lý tìm kiếm truyện
│   │   ├── story.js                   # Hiển thị nội dung truyện
│   │   ├── user.js                    # Quản lý thông tin người dùng
│   │   ├── admin.js                   # JavaScript dành riêng cho trang admin
│   │   ├── bootstrap.min.js           # Thư viện Bootstrap (nếu sử dụng)
│   │   ├── jquery.min.js              # Thư viện jQuery (nếu sử dụng)
│
│── 📁 admin/                          # Trang quản trị
│   │── 📁 assets/                     # Tài nguyên của admin
│   │   ├── 📁 css/                     # CSS riêng cho admin panel
│   │   │   ├── admin.css              # Giao diện quản trị
│   │   │   ├── dashboard.css          # Trang thống kê admin
│   │   │   ├── tables.css             # CSS cho bảng dữ liệu
│   │   │
│   │   ├── 📁 js/                      # JavaScript riêng cho admin
│   │   │   ├── admin.js               # JavaScript chính cho admin panel
│   │   │   ├── dashboard.js           # Xử lý dashboard admin
│   │   │   ├── users.js               # Quản lý người dùng trong admin
│   │   │   ├── stories.js             # Quản lý truyện trong admin
│   │
│── 📁 backend/                        # Chứa file xử lý backend
│   │── autoload.php                   # Nạp tự động các thư viện PHP
│   │── db.php                         # Kết nối database
│
│── 📁 api/                            # API PHP xử lý dữ liệu
│   │── get_truyen.php                 # API lấy danh sách truyện
│   │── get_users.php                  # API lấy danh sách người dùng
│   │── add.php                        # API thêm dữ liệu
│   │── fetch_truyen.php               # API lấy truyện theo ID
│   │── fetch_users.php                # API lấy user theo ID
│   │── insert_story.php               # API thêm truyện
│   │── login.php                      # API đăng nhập
│   │── logout.php                     # API đăng xuất
│   │── register.php                   # API đăng ký người dùng
│   │── truyen.php                     # API xử lý truyện
│
│── 📁 vendor/                         # Thư viện Composer (tự động tạo)
│   │── autoload.php                    # File autoload của Composer
│   │── composer/                       # Chứa các thư viện của Composer
│
│── composer.json                      # Cấu hình Composer
│── composer.lock                      # Lock file Composer
│
│── 📁 views/                          # Giao diện người dùng
│   │── chapter.html                    # Trang chi tiết chương truyện
│   │── dangky.html                     # Trang đăng ký
│   │── dangnhap.html                   # Trang đăng nhập
│   │── index.html                      # Trang chính
│   │── theloai.html                    # Trang thể loại truyện
│   │── timkiem.html                     # Trang tìm kiếm
│   │── toptruyen.html                   # Trang top truyện
│   │── truyen.html                      # Trang chi tiết truyện

TRANGWEBTUTIEN  
│── .vscode/  
│── assets/  
│   ├── css/  
│   ├── img/  
│   ├── js/  
│── backend/  
│   ├── config/           # Cấu hình database, constants  
│   │   ├── db.php  
│   │   ├── config.php  
│   ├── api/              # API xử lý dữ liệu  
│   │   ├── auth/         # Nhóm API liên quan đến xác thực  
│   │   │   ├── login.php  
│   │   │   ├── logout.php  
│   │   │   ├── register.php  
│   │   ├── truyện/       # Nhóm API liên quan đến truyện  
│   │   │   ├── get_truyen.php  
│   │   │   ├── fetch_truyen.php  
│   │   ├── users/        # Nhóm API liên quan đến người dùng  
│   │   │   ├── get_users.php  
│   │   │   ├── fetch_users.php  
│   ├── functions.php     # Các function dùng chung  
│── admin/                # Khu vực quản trị  
│   ├── assets/           # CSS, JS, Images riêng cho Admin  
│   ├── views/            # Giao diện Admin  
│   │   ├── dashboard.php # Trang quản lý chính  
│   │   ├── manage_users.php  
│   │   ├── manage_truyen.php  
│   │   ├── settings.php  
│   ├── index.php         # Trang login admin  
│   ├── config.php        # Cấu hình riêng cho admin  
│── vendor/               # Composer packages  
│── views/                # Giao diện Frontend (Người dùng)  
│   ├── chapter.html  
│   ├── đăng ký.html  
│   ├── đăng nhập.html  
│   ├── index.html  
│   ├── thể loại.html  
│   ├── tìm kiếm.html  
│   ├── toptruyen.html  
│   ├── truyen.html  
│── composer.json  
│── composer.lock  

📁 TRANGWEBTUTIEN/
Thư mục gốc chứa toàn bộ dự án, bao gồm các phần frontend (giao diện người dùng), backend (xử lý logic), admin panel (quản lý), và các thư viện hỗ trợ (vendor).

Cấu trúc Frontend (Giao diện người dùng)
📁 assets/
Chứa các tài nguyên như CSS, hình ảnh, JavaScript phục vụ giao diện.

css/ → Chứa file CSS để định dạng giao diện.
img/ → Chứa hình ảnh của website.
js/ → Chứa các file JavaScript để xử lý giao diện, hiệu ứng.

📁 views/
; Chứa các trang giao diện chính của người dùng.
chapter.html → Trang hiển thị nội dung từng chương truyện.
dangky.html → Trang đăng ký tài khoản.
dangnhap.html → Trang đăng nhập tài khoản.
index.html → Trang chủ.
theloai.html → Hiển thị danh sách thể loại truyện.
timkiem.html → Trang tìm kiếm truyện.
toptruyen.html → Hiển thị danh sách truyện phổ biến.
truyen.html → Trang chi tiết một truyện cụ thể.

📁 backend/
; Chứa toàn bộ code xử lý dữ liệu (PHP), gồm API và các chức năng liên quan.
📁 backend/config/
db.php → Kết nối cơ sở dữ liệu (MySQL).
config.php → Cấu hình chung của hệ thống (ví dụ: biến toàn cục, URL API).
📁 backend/api/
; Chứa API xử lý dữ liệu giữa frontend và backend.
📁 auth/ → Xử lý xác thực người dùng (đăng nhập, đăng ký, đăng xuất).

login.php → API đăng nhập.
logout.php → API đăng xuất.
register.php → API đăng ký.

📁 truyện/ → Xử lý dữ liệu truyện.
get_truyen.php → Lấy danh sách truyện.
fetch_truyen.php → Lấy chi tiết từng truyện.

📁 users/ → Xử lý dữ liệu người dùng.
get_users.php → Lấy danh sách người dùng.
fetch_users.php → Lấy chi tiết từng người dùng.
functions.php → Chứa các hàm hỗ trợ (ví dụ: xử lý chuỗi, kiểm tra dữ liệu).

📁 admin/
; Dùng để quản lý nội dung website như người dùng, truyện, cấu hình hệ thống.
📁 admin/assets/
Chứa CSS, JavaScript và hình ảnh dành riêng cho admin.
📁 admin/views/
Chứa giao diện của trang quản lý:

dashboard.php → Trang chính của admin panel (thống kê, báo cáo).
manage_users.php → Quản lý danh sách người dùng.
manage_truyen.php → Quản lý danh sách truyện.
settings.php → Trang cài đặt hệ thống.
Các file khác trong admin/
index.php → Trang đăng nhập dành riêng cho admin.
config.php → Cấu hình riêng cho trang admin.

📁 vendor/
Chứa các thư viện PHP cài đặt bằng Composer.
❗ Không chỉnh sửa trực tiếp thư mục này.
composer.json → Danh sách thư viện PHP cần thiết.
composer.lock → Lưu trạng thái chính xác của thư viện đã cài đặt.