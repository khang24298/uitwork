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
// Route::group(['middleware' => 'auth.jwt'], function () {
    // dd(Auth::user());
    Route::get('logout', 'APIController@logout');
    Route::get('users', 'UserController@index');

    // Route::get('/dashboard', 'DashboardController@create');

    Route::resource('/projects', 'ProjectsController');

    Route::resource('/criteria', 'CriteriaController');
    Route::get('/calculateUserScoreByTaskCriteria/{task_id}', 'CriteriaController@calculateUserScoreByTaskCriteria');
    Route::get('/calculateUserScoreByUserCriteria/{user_id}', 'CriteriaController@calculateUserScoreByUserCriteria');
    Route::get('/calculateUserScore/{user_id}', 'CriteriaController@calculateUserScore');
    Route::get('/getTaskCriteriaByUserID/{user_id}', 'CriteriaController@getTaskCriteriaByUserID');
    Route::get('/getUserCriteriaByUserID/{user_id}', 'CriteriaController@getUserCriteriaByUserID');

    Route::resource('/criteriaTypes', 'CriteriaTypeController');

    Route::resource('/reports', 'ReportController');
    Route::get('/getAllReport', 'ReportController@getAllReport');
    Route::get('/getTaskReport', 'ReportController@getTaskReport');
    Route::get('/getProjectReport', 'ReportController@getProjectReport');
    Route::get('/getTaskReportByTaskID/{task_id}', 'ReportController@getTaskReportByTaskID');
    Route::get('/getProjectReportByProjectID/{project_id}', 'ReportController@getProjectReportByProjectID');

    Route::resource('/reportTypes', 'ReportTypeController');

    Route::resource('/tasks','TaskController');
    Route::get('/getUserTaskInfoByUserID/{user_id}', 'TaskController@getUserTaskInfoByUserID');
    Route::get('/getTaskCriteriaByTaskID/{task_id}', 'TaskController@getTaskCriteriaByTaskID');
    Route::get('/getReportByTaskID/{task_id}', 'TaskController@getReportByTaskID');
    Route::get('/getCommentByTaskID/{task_id}', 'TaskController@getCommentByTaskID');
    Route::get('/getDocumentByTaskID/{task_id}', 'TaskController@getDocumentByTaskID');

    Route::resource('/comments', 'CommentController');
    Route::get('/getCommentByUserID/{user_id}', 'CommentController@getCommentByUserID');
    Route::get('/getCommentByTaskID/{task_id}', 'CommentController@getCommentByTaskID');
    Route::get('/getReplyComment/{parent_id}', 'CommentController@getReplyComment');

    Route::resource('/documents', 'DocumentController');
    // Route::get('/getDocumentInfoByTaskID/{task_id}', 'DocumentController@getDocumentInfoByTaskID');

    Route::resource('/status', 'StatusController');
    Route::get('/getTaskByStatusID/{status_id}', 'StatusController@getTaskByStatusID');

    Route::resource('/departments', 'DepartmentController');
    Route::get('/getUserByDepartmentID/{department_id}', 'DepartmentController@getUserByDepartmentID');

    Route::resource('/positions', 'PositionController');
    Route::get('/getSalaryInfoByPositionID/{position_id}', 'PositionController@getSalaryInfoByPositionID');

    Route::resource('/salaries', 'SalaryController');
    Route::get('/calculateUserSalaryByUserID/{user_id}', 'SalaryController@calculateUserSalaryByUserID');

    Route::resource('/educationLevels', 'EducationLevelController');
    Route::get('/getUserEducationLevelByUserID/{user_id}', 'EducationLevelController@getUserEducationLevelByUserID');
// });
