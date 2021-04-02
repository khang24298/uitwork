#Update 02/04/2021 - DUY
#Add evaluation table, ranking table and some editing.

1. Evaluation and Ranking table.
    + evaluation: task_id, user_id, score, note và EvaluationFactory + EvaluationSeeder.
    + ranking: ranking_id, user_id, rank_by_task_criteria_score, rank_by_user_criteria_score, total_rank.

    + Sau khi pull cần chạy câu lệnh "php artisan migrate", "php artisan db:seed --class=EvaluationSeeder".

2. Đổi tên DOCSFORBASICFUNCTION.md -> README_2.md

3. Modify tasks table
    + Thêm trường project_id, edit TaskFactory.
    + Chạy "php artisan db:seed --class=TaskSeeder".

4. ProjectController
    + getTasksByProjectID
        - Tham số vào: id của Dự án.
        - Giá trị trả về: Danh sách công việc nằm trong Dự án đó.

    + getProjectsUserJoinedOrCreated
        - Tham số vào: id của Người dùng.
        - Giá trị trả về:
            * Nếu role = Manager: Trả về list project mà user đã tạo.
            * Nếu role = Employee: Trả về list project mà user đã tham gia.

5. EvaluationController
    + getTaskEvaluationByTaskID
        - Tham số vào: id của Công việc.
        - Giá trị trả về: Thông tin về các đánh giá cũng như điểm số của Công việc đó.

    + getUserEvaluationByUserID
        - Tham số vào: id của Người dùng.
        - Giá trị trả về: Thông tin về các đánh giá cũng như điểm số của Người dùng đó.
    
    + getTaskEvaluationList
        - Tham số vào: Không có.
        - Giá trị trả về: Danh sách các thông tin đánh giá của tất cả các Công việc.

    + getUserEvaluationList
        - Tham số vào: Không có.
        - Giá trị trả về: Danh sách các thông tin đánh giá của tất cả các Người dùng.
    
    + calcTaskCriteriaScoreByTaskID
        - Tham số vào: id của Công việc.
        - Giá trị trả về: Tổng điểm đánh giá của các tiêu chí thuộc loại Công việc của Công việc đó. (Một Công việc có thể có nhiều tiêu chí đánh giá cùng thuộc loại về Công việc).
    
    + calcUserCriteriaScoreByUserID
        - Tham số vào: id của Người dùng.
        - Giá trị trả về: Tổng điểm đánh giá của các tiêu chí thuộc loại Con người của Người dùng đó. (Một Người dùng có thể có nhiều tiêu chí đánh giá cùng thuộc loại về Con người).

    + calcTotalTaskCriteriaScoreByUserID
        - Tham số vào: id của Người dùng.
        - Giá trị trả về: Tổng điểm đánh giá về tất cả các Công việc của Người dùng đó. (Một người dùng có thể thực hiện nhiều công việc. Các công việc có thể có nhiều tiêu chí đánh giá khác nhau).

    + calcTotalUserScore
        - Tham số vào: id của Người dùng.
        - Giá trị trả về: Tổng tất cả các điểm đánh giá (Tiêu chí công việc + Tiêu chí con người) của Người dùng.

6. RankingController
    + getUserRankByTaskCriteriaScore
        - Tham số vào: id của Người dùng.
        - Giá trị trả về: Thông tin xếp hạng dựa theo điểm của các tiêu chí Công việc của Người dùng đó.

    + getUserRankByUserCriteriaScore
        - Tham số vào: id của Người dùng.
        - Giá trị trả về: Thông tin xếp hạng dựa theo điểm của các tiêu chí Con người của Người dùng đó.
    
    + getUserTotalRank
        - Tham số vào: id của Người dùng.
        - Giá trị trả về: Thông tin xếp hạng dựa theo tổng tất cả các điểm của Người dùng đó.
    
    + getTaskCriteriaScoreRankList
        - Tham số vào: Không có.
        - Giá trị trả về: Danh sách thông tin xếp hạng dựa theo điểm của các tiêu chí về Công việc của toàn bộ Người dùng.

    + getUserCriteriaScoreRankList
        - Tham số vào: Không có.
        - Giá trị trả về: Danh sách thông tin xếp hạng dựa theo điểm của các tiêu chí về Con người của toàn bộ Người dùng.
    
    + getUserTotalRankList
        - Tham số vào: Không có.
        - Giá trị trả về: Danh sách thông tin xếp hạng dựa theo tổng tất cả các điểm của toàn bộ Người dùng.

    + Còn 1 hàm test failed đang sửa.
