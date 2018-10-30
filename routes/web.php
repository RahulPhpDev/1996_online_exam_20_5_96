<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     ['uses' => 'GuestController@index']	
//     // return view('welcome');
// });


//================ Guest ====================

Route::get('/', [
    'as' => '/',
    'uses' => 'GuestController@index'
]);

Route::get('/welcome', 'GuestController@index')->name('/welcome');
Route::get('about-us', 'GuestController@aboutUs')->name('about-us');


Route::get('package/{id}', 'GuestController@package')->name('package');

Route::get('payment/{id?}', 'GuestController@payment')->name('payment');

Route::group(['middleware' => ['auth']], function(){

Route::get('save-package-exam/{id?}', 'Auth\UserController@savePackageExam')->name('save-package-exam');
Route::get('subscrption-exam/{id?}', 'Auth\UserController@subscrptionExam')->name('subscrption-exam');

Route::get('get-exam/{id}', 'Auth\UserController@getExam')->name('get-exam');

Route::match(array('GET','POST'),'save-answer/{id}', 'Auth\UserController@saveAnswer')->name('save-answer');
});

Route::get('/db' ,function(){
$db = Config::get('database.connections.'.Config::get('database.default').'.database');
echo $db;
});

Route::get('/dbname', function(){
    return DB::select('select database();');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// =========================== ADMIN ===========================
Route::group(['middleware' => ['admin']], function(){
    
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

Route::get('/course', 'Admin\CourseController@courseList')->name('course');
Route::get('/add-course', 'Admin\CourseController@addCourse')->name('add-course');
Route::post('/save-course', 'Admin\CourseController@saveCourse')->name('save-course');
Route::any('/edit-course/{id}', 'Admin\CourseController@EditCourse')->name('edit-course');
Route::any('/update-course/{id}', 'Admin\CourseController@UpdateCourse')->name('update-course');
Route::any('/delete-course/{id}', 'Admin\CourseController@deleteCourse')->name('delete-course');
Route::get('/course-description/{id?}','Admin\CourseController@courseDescription')->name('course-description');

Route::get('/testing', 'Admin\CourseController@testing')->name('testing');

Route::get('/institution', 'Admin\AdminController@institutionList')->name('institution');
Route::any('/editinstitution/{id}', 'Admin\AdminController@editInstitution')->name('editinstitution');
Route::post('/updateinstitution', 'Admin\AdminController@updateInstitution')->name('updateinstitution');

//========= USER ============
Route::get('/add-user', 'Admin\UserController@addUser')->name('add-user');
Route::post('/save-user', 'Admin\UserController@saveUser')->name('save-user');
Route::get('/users', 'Admin\UserController@userList')->name('users');
Route::get('/user-other-details/{id}', 'Admin\UserController@userOtherDetails')->name('user-other-details');
Route::get('/edit-user/{id}','Admin\UserController@editUser')->name('edit-user');
Route::post('/update-user/{id}','Admin\UserController@updateUser')->name('update-user');
Route::get('delete-user/{id}', 'Admin\UserController@deleteUser')->name('delete-user');


Route::get('/subscription','Admin\AdminController@subscriptionList')->name('subscription');
Route::get('/add-subscription','Admin\AdminController@addSubscription')->name('add-subscription');

Route::post('/save-subscription', 'Admin\AdminController@saveSubscription')->name('save-subscription');

Route::any('add-exam', 'Admin\ExamController@addExam')->name('add-exam');


Route::post('save-add-exam', 'Admin\ExamController@saveAddExam')->name('save-add-exam');

Route::get('add-exam-question/{id}', 'Admin\ExamController@addExamQuestion')->name('add-exam-question');

Route::post('/save-exam-question/{id}', 'Admin\ExamController@saveExamQuestion')->name('save-exam-question');


Route::get('confirm-exam/{id}', 'Admin\ExamController@confirmExam')->name('confirm-exam');

Route::post('save-confirm-exam/{id}', 'Admin\ExamController@saveConfirmExam')->name('save-confirm-exam');

Route::post('exam-post-success/{id}', 'Admin\ExamController@examPostSuccess')->name('exam-post-success');

Route::get('/more-question/{id}', 'Admin\ExamController@moreQuestion')->name('more-question');


Route::get('/exam', 'Admin\ExamController@examList')->name('exam');

Route::get('/exam-question/{id}', 'Admin\ExamController@examQuestion')->name('exam-question');

Route::get('/edit-exam-question/{id}', 'Admin\ExamController@editExamQuestion')->name('edit-exam-question');

Route::post('/updateExamQuestion','Admin\ExamController@updateExamQuestion')->name('updateExamQuestion');

Route::post('/approve-user','Admin\UserController@approveUser')->name('approve-user');

}) ; 
