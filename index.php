<?php
  // Bao gồm file route
  require_once 'routes.php';
  // Lấy URL từ request
  $request = $_SERVER['REQUEST_URI'];
  // Gọi route dựa trên URL
  route($request);
?>
