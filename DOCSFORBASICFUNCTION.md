#Update 22/3/2021 - DUY
#Add all basic function

1. Modify users table.
    + Thêm các cột phone, gender, dob, position_id, education_level_id, department_id.
    + Sau khi pull cần chạy câu lệnh "php artisan migrate", "php artisan db:seed --class=UserSeeder",
        "php artisan db:seed --class=ProjectSeeder" và "php artisan db:seed --class=DepartmentSeeder".

2. Modify TaskFactory
    + Đổi trường name thành task_name.
    + Thêm các cột start_date, end_date, status_id, qa_id, priority và các giá trị random cho chúng.
    + Chạy câu lệnh "php artisan db:seed --class=TaskSeeder".

3. Các Function chung của các Controller
    + index, store, show, update, destroy.

    + URL syntax: http://127.0.0.1:port/api/tên_của_resource
    
    + Các tên resource đặt biệt:
        - Loại 1: Tên theo kiểu camelCase có s đằng sau:
            + criteriaTypes, reportTypes, educationLevels
        
        - Loại 2:
            + criteria, status: Đã là số nhiều rồi. (Có chỉ định rõ tên table trong Model của nó rồi, không thì truy vấn SQL sẽ không hiểu).
            + salaries: Số nhiều thì y (dài) thành i (ngắn) thêm es.

4. Method Syntax
    + http://127.0.0.1:port/api/tên_của_method/{tham_số_nếu_có}

5. CriteriaController
    + getTaskCriteriaByUserID
        - Tham số vào: id của Người dùng.
        - Giá trị trả về: Các tiêu chí về Công việc của người dùng.

    + getUserCriteriaByUserID
        - Tham số vào: id của Người dùng.
        - Giá trị trả về: Các tiêu chí về Con người của người dùng.
    
    + calculateUserScoreByTaskCriteria
        - Tham số vào: id của Công việc.
        - Giá trị trả về: Tổng điểm của "một công việc" của người dùng theo các tiêu chí.
    
    + calculateUserScoreByUserCriteria
        - Tham số vào: id của Người dùng.
        - Giá trị trả về: Tổng điểm của một người dùng theo "các tiêu chí về Con người".

    + calculateUserScore
        - Tham số vào: id của Người dùng.
        - Giá trị trả về: Tổng tất cả các điểm của một người dùng.

6. TaskController
    + getUserTaskInfoByUserID
        - Tham số vào: id của Người dùng.
        - Giá trị trả về: Thông tin về người dùng kèm các task của họ.

    + getTaskCriteriaByTaskID
        - Tham số vào: id của Công việc.
        - Giá trị trả về: Thông tin về các tiêu chí ứng với Công việc đó.
    
    + getReportByTaskID
        - Tham số vào: id của Công việc.
        - Giá trị trả về: Thông tin về các báo cáo đã được lập ứng với Công việc này.
    
    + getCommentByTaskID
        - Tham số vào: id của Công việc.
        - Giá trị trả về: Thông tin về các bình luận đã được viết (Bởi nhiều người dùng) trong Công việc này.

    + getDocumentByTaskID
        - Tham số vào: id của Công việc.
        - Giá trị trả về: Thông tin về các tài liệu đã tải lên đối với Công việc này.

7. ReportController
    + getAllReport
        - Tham số vào: Ko có.
        - Giá trị trả về: Tất cả các báo cáo đã được lập.

    + getTaskReport
        - Tham số vào: Ko có.
        - Giá trị trả về: Các báo cáo đã lập thuộc loại Công việc.
    
    + getProjectReport
        - Tham số vào: Ko có.
        - Giá trị trả về: Các báo cáo đã lập thuộc loại Dự án.
    
    + getTaskReportByTaskID
        - Tham số vào: id của Công việc.
        - Giá trị trả về: Thông tin về các báo cáo đã được lập ứng với Công việc này.

    + getProjectReportByProjectID
        - Tham số vào: id của Dự án.
        - Giá trị trả về: Thông tin về các báo cáo đã được lập ứng với Dự án này.

8. CommentController
    + getCommentByUserID
        - Tham số vào: id của Người dùng.
        - Giá trị trả về: Các bình luận mà người dùng đó đã viết.
    
    + getCommentByTaskID
        - Tham số vào: id của Công việc.
        - Giá trị trả về: Các bình luận đã được những người dùng viết trong Công việc này.

    + getReplyComment
        - Tham số vào: id của Bình luận cha.
        - Giá trị trả về: Các bình luận đã phản hồi (con) của Bình luận này.

9. StatusController
    + getTaskByStatusID
        - Tham số vào: id của Status.
        - Giá trị trả về: Các Công việc có Status tương ứng.

10. DepartmentController
    + getUserByDepartmentID
        - Tham số vào: id của Phòng ban.
        - Giá trị trả về: Thông tin của các Người dùng thuộc Phòng ban đó.

11. PositionController
    + getSalaryInfoByPositionID
        - Tham số vào: id của Vị trí công việc của người dùng.
        - Giá trị trả về: Thông tin về lương ứng với Vị trí công việc đó.

12. EducationLevelController
    + getUserEducationLevelByUserID
        - Tham số vào: id của Người dùng.
        - Giá trị trả về: Thông tin về trình độ giáo dục của người dùng.

13. SalaryController
    + calculateUserSalaryByUserID
        - Tham số vào: id của Người dùng.
        - Giá trị trả về: Lương (tổng) của người dùng.
