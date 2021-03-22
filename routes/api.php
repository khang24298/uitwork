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
    Route::get('logout', 'APIController@logout');
    Route::get('users', 'UserController@index');
    Route::resource('/tasks','TaskController');

    // Route::get('/dashboard', 'DashboardController@create');

    Route::resource('/projects', 'ProjectsController');
    // Route::get('/projects', 'ProjectsController@index');

    // Route::get('/projects/create', 'ProjectsController@create');

    // Route::get('/projects/{project}', 'ProjectsController@show');

    // Route::post('/projects', 'ProjectsController@store');

    // Route::get('/projects/{project}/edit', 'ProjectsController@edit');

    // Route::put('/projects/{project} ', 'ProjectsController@update');

    Route::resource('/criteria', 'CriteriaController');
    Route::get('/calculateScoreByUserTask/{task_id}', 'CriteriaController@calculateScoreByUserTask');
    Route::get('/calculateScoreByUserCriteria/{user_id}', 'CriteriaController@calculateScoreByUserCriteria');
    Route::get('/getTaskCriteria', 'CriteriaController@getTaskCriteria');
    Route::get('/getUserCriteria', 'CriteriaController@getUserCriteria');

    Route::resource('/criteriaTypes', 'CriteriaTypeController');

    Route::resource('/reports', 'ReportController');
    Route::get('getAllReport', 'ReportController@getAllReport');
    Route::get('getTaskReport', 'ReportController@getTaskReport');
    Route::get('getProjectReport', 'ReportController@getProjectReport');

    Route::resource('/reportTypes', 'ReportTypeController');

    Route::get('/getUserInfo/{user_id}', 'TaskController@getUserInfo');
    Route::get('/getReportByTaskID/{task_id}', 'TaskController@getReportByTaskID');
    Route::get('/getTaskCriteria/{task_id}', 'TaskController@getTaskCriteria');
    Route::get('/getCommentByTaskID/{task_id}', 'TaskController@getCommentByTaskID');
    Route::get('/getDocumentByTaskID/{task_id}', 'TaskController@getDocumentByTaskID');

    Route::resource('/comments', 'CommentController');
    Route::get('/getUserInfoByComment/{user_id}', 'CommentController@getUserInfoByComment');
    Route::get('/getCommentByTask/{task_id}', 'CommentController@getCommentByTask');
    Route::get('/getReplyComment/{parent_id}', 'CommentController@getReplyComment');

    Route::resource('/documents', 'DocumentController');
    Route::get('/getDocumentByTaskID/{task_id}', 'DocumentController@getDocumentByTaskID');

    Route::resource('/status', 'StatusController');
    Route::get('/getTaskByStatusID/{type_id}', 'StatusController@getTaskByStatusID');

    Route::resource('/departments', 'DepartmentController');
    Route::get('/getUserByDepartmentID/{department_id}', 'DepartmentController@getUserByDepartmentID');

    Route::resource('/positions', 'PositionController');
    Route::get('/getSalaryInfoByPosition/{salary_id}', 'PositionController@getSalaryInfoByPosition');

    Route::resource('/salaries', 'SalaryController');
    Route::get('/calculateSalaryByUserID/{user_id}', 'SalaryController@calculateSalaryByUserID');

    Route::resource('/educationLevels', 'EducationLevelController');
    Route::get('/getUserEducationLevel/{user_id}', 'EducationLevelController@getUserEducationLevel');
});
