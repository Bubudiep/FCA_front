<?php
function route($url)
{
    // Xóa query string khỏi URL nếu có
    $url = parse_url($url, PHP_URL_PATH);
    // Các route trong ứng dụng
    switch ($url) {
        case '/':
            require 'app/home.php';
            break;
        case '/login':
            require 'app/login.php';
            break;
        case '/home':
            require 'app/home.php';
            break;
        case '/register':
            require 'app/register.php';
            break;
        default:
            require 'app/404.php';
            break;
    }
}
