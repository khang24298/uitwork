<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', 'APIController@login');

Route::group(['middleware' => 'auth.jwt'], function () {
    // dd(Auth::user());
    Route::get('/logout', 'APIController@logout');

    Route::get('/users', 'UserController@index');
    Route::get('/currentUser', 'UserController@currentUser');

    Route::get('/getUserInfo/{user_id}', 'UserController@getUserInfo');
    Route::get('/getUsersWithEmployeeRole', 'UserController@getUsersWithEmployeeRole');
    Route::get('/getUsersWithManagerRole', 'UserController@getUsersWithManagerRole');

    // Route::get('/dashboard', 'DashboardController@create');

    // Projects
    Route::resource('/projects', 'ProjectsController');
    Route::get('/getTasksByProjectID/{project_id}', 'ProjectsController@getTasksByProjectID');
    Route::get('/getProjectsUserJoinedOrCreated/{user_id}', 'ProjectsController@getProjectsUserJoinedOrCreated');
    Route::get('/getUsersJoinedProject/{project_id}', 'ProjectsController@getUsersJoinedProject');

    // Criteria
    Route::resource('/criteria', 'CriteriaController');
    Route::get('/getTaskCriteriaList', 'CriteriaController@getTaskCriteriaList');
    Route::get('/getUserCriteriaList', 'CriteriaController@getUserCriteriaList');
    Route::get('/getTaskCriteriaByTaskID/{task_id}', 'CriteriaController@getTaskCriteriaByTaskID');
    Route::get('/getUserCriteriaByUserID/{user_id}', 'CriteriaController@getUserCriteriaByUserID');

    // CriteriaTypes
    Route::resource('/criteriaTypes', 'CriteriaTypeController');

    // Reports
    Route::resource('/reports', 'ReportController');
    Route::get('/getReportList', 'ReportController@getReportList');
    Route::get('/getTaskReport', 'ReportController@getTaskReport');
    Route::get('/getProjectReport', 'ReportController@getProjectReport');
    Route::get('/getTaskReportByTaskID/{task_id}', 'ReportController@getTaskReportByTaskID');
    Route::get('/getProjectReportByProjectID/{project_id}', 'ReportController@getProjectReportByProjectID');

    // ReportTypes
    Route::resource('/reportTypes', 'ReportTypeController');

    // Tasks
    Route::resource('/tasks','TaskController');
    Route::get('/getTaskInfo/{task_id}', 'TaskController@getTaskInfo');
    Route::get('/getTasksByAssignerOrAssignee/{user_id}', 'TaskController@getTasksByAssignerOrAssignee');
    // Route::get('/getTaskCriteriaByTaskID/{task_id}', 'TaskController@getTaskCriteriaByTaskID');
    // Route::get('/getReportByTaskID/{task_id}', 'TaskController@getReportByTaskID');
    // Route::get('/getCommentByTaskID/{task_id}', 'TaskController@getCommentByTaskID');
    // Route::get('/getDocumentByTaskID/{task_id}', 'TaskController@getDocumentByTaskID');
    Route::get('/getTasksByStatusID/{status_id}', 'TaskController@getTasksByStatusID');

    // Comments
    Route::resource('/comments', 'CommentController');
    Route::get('/getCommentByUserID/{user_id}', 'CommentController@getCommentByUserID');
    Route::get('/getCommentByTaskID/{task_id}', 'CommentController@getCommentByTaskID');
    Route::get('/getReplyComment/{parent_id}', 'CommentController@getReplyComment');

    // Documents
    Route::resource('/documents', 'DocumentController');
    // Route::get('/getDocumentInfoByTaskID/{task_id}', 'DocumentController@getDocumentInfoByTaskID');

    // Status
    Route::resource('/status', 'StatusController');
    Route::get('/getTaskByStatusID/{status_id}', 'StatusController@getTaskByStatusID');

    // Departments
    Route::resource('/departments', 'DepartmentController');
    Route::get('/getUserByDepartmentID/{department_id}', 'DepartmentController@getUserByDepartmentID');

    // Positions
    Route::resource('/positions', 'PositionController');
    Route::get('/getSalaryInfoByPositionID/{position_id}', 'PositionController@getSalaryInfoByPositionID');

    // Salaries
    Route::resource('/salaries', 'SalaryController');
    Route::get('/calculateUserSalaryByUserID/{user_id}', 'SalaryController@calculateUserSalaryByUserID');

    // EducationLevels
    Route::resource('/educationLevels', 'EducationLevelController');
    Route::get('/getUserEducationLevelByUserID/{user_id}', 'EducationLevelController@getUserEducationLevelByUserID');

    // Evaluation
    Route::resource('/evaluation', 'EvaluationController');
    Route::get('/getTaskEvaluationList', 'EvaluationController@getTaskEvaluationList');
    Route::get('/getUserEvaluationList', 'EvaluationController@getUserEvaluationList');
    Route::get('/getTaskEvaluationByTaskID/{task_id}', 'EvaluationController@getTaskEvaluationByTaskID');
    Route::get('/getUserEvaluationByUserID/{user_id}', 'EvaluationController@getUserEvaluationByUserID');

    Route::get('/calcTaskCriteriaScoreByTaskID/{task_id}', 'EvaluationController@calcTaskCriteriaScoreByTaskID');
    Route::get('/calcUserCriteriaScoreByUserID/{user_id}', 'EvaluationController@calcUserCriteriaScoreByUserID');
    Route::get('/calcTotalTaskCriteriaScoreByUserID/{user_id}', 'EvaluationController@calcTotalTaskCriteriaScoreByUserID');
    Route::get('/calcTotalUserScore/{user_id}', 'EvaluationController@calcTotalUserScore');

    // Ranking
    Route::resource('/ranking', 'RankingController');
    Route::get('/getTaskCriteriaScoreRankList', 'RankingController@getTaskCriteriaScoreRankList');
    Route::get('/getUserCriteriaScoreRankList', 'RankingController@getUserCriteriaScoreRankList');
    Route::get('/getUserTotalRankList', 'RankingController@getUserTotalRankList');

    Route::get('/getUserRankByTaskCriteriaScore/{user_id}', 'RankingController@getUserRankByTaskCriteriaScore');
    Route::get('/getUserRankByUserCriteriaScore/{user_id}', 'RankingController@getUserRankByUserCriteriaScore');
    Route::get('/getUserTotalRank/{user_id}', 'RankingController@getUserTotalRank');

    Route::get('/calcValuesForOneUser/{user_id}', 'RankingController@calcValuesForOneUser');
    Route::get('/insertToDatabase', 'RankingController@insertToDatabase');

    // Just for some testing
    Route::get('/draftFunction', 'TestingController@draftFunction');

    // Temp
    Route::resource('/temp', 'TempController');

    // RefusedTask
    Route::post('/refusedTask', 'RefusedTaskController@refuseTask');

    // Notification
    Route::resource('/notifications', 'NotificationController');
    Route::get('/getNotificationByUserID/{user_id}', 'NotificationController@getNotificationByUserID');

    // NotificationTypes
    Route::resource('/notificationTypes', 'NotificationTypeController');
});
