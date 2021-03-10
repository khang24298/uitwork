#Update 11/3/2021 - Khang
#USER SIDE PERIOD

1. Route của user chuyển về hết file routes/api.php
    +  Sử dụng package API JWT cho việc login/logout đối với user.
    => Sau khi pull cần chạy câu lệnh "composer require tymon/jwt-auth"
2. Multi authentication
    +  Đã tách được admin và user (Admin sử dụng admin.php/ User sử dụng web.php và api.php).
3. Modify users table.
    +  Thêm cột role 
    => Sau khi pull cần chạy câu lệnh "php artisan migrate" và "php artisan db:seed --class=UserSeeder"
4. Validate lại toàn bộ controller và sử dụng chung một mẫu trả về
    +  Response()->json([
        '<Data_can_tra>' => $<Data_can_tra> //Nếu ko cần thì skip dòng này
        'message' => 'Success' // Nếu ko lấy được message = $e->getMessage()
        ], <StatusCode>);  // HTTPStatusCode. Tự tìm hiểu
    +  
5. Đã setup xong FrontEnd sử dụng Vuejs