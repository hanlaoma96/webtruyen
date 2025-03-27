<?php
// Tự động load class từ models, controllers
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . './../admin/models/',
        __DIR__ . '../controllers/',
    ];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Kết nối database
require_once __DIR__ . '/db.php';

// Load Auth (JWT)
require_once __DIR__ . '/auth.php';

// Load helpers (các hàm tiện ích nếu có)
require_once __DIR__ . '/helpers.php';

// Nếu dùng Composer, load thư viện
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}
?>
