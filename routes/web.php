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
Route::get('send','MailController@send');

Route::get('/downloadPDF/{id?}','GuestController@downloadPDF');

Route::get('session', 'GuestController@sessionTest')->name('session');

Route::get('intervation', 'GuestController@intervation')->name('intervation');


Route::get('nextSession', 'GuestController@nextSession')->name('nextSession');

Route::get('checkSession', 'GuestController@checkSession')->name('checkSession');


Route::get('/', [
    'as' => '/',
    'uses' => 'GuestController@index'
]);

Route::get('/welcome', 'GuestController@index')->name('/welcome');
Route::get('about-us', 'GuestController@aboutUs')->name('about-us');


Route::get('package/{id}', 'GuestController@package')->name('package');

Route::get('allpackage', 'GuestController@allpackage')->name('allpackage');

Route::get('payment/{id?}', 'GuestController@payment')->name('payment');


Route::group(['middleware' => ['auth']], function(){

Route::get('save-package-exam/{id?}', 'Auth\UserController@savePackageExam')->name('save-package-exam');

Route::get('subscrption-exam/{id?}', 'Auth\UserController@subscrptionExam')->name('subscrption-exam');

Route::get('get-exam/{id}', 'Auth\UserController@getExam')->name('get-exam');

Route::match(array('GET','POST'),'save-answer/{id?}', 'Auth\UserController@saveAnswer')->name('save-answer');

Route::get('view-result/{id}', 'Auth\UserController@viewResult')->name('view-result');

Route::get('all-result/', 'Auth\UserController@allResult')->name('all-result');

Route::get('exam-result/{id}', 'Auth\UserController@examResult')->name('exam-result');

Route::get('download-exam-pdf/{id}', 'Auth\UserController@downloadExamPdf')->name('download-exam-pdf');

Route::get('exam-instruction/{id}', 'Auth\UserController@examInstruction')->name('exam-instruction');


Route::get('exams-question/{id}', 'Auth\UserExamController@viewExamQuestions')->name('exams-question');


});




Route::get('/db' ,function(){
	$msg = 'rahul';
	echo "'$msg'";
	die();
	echo Config::get('mail.from.name');
	echo Config::get('mail.from.address');

	//  echo env('mail.from.name');die();
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
Route::get('/edit-subscription/{id}','Admin\AdminController@editSubscription')->name('edit-subscription');
Route::post('/update-subscription/{id}','Admin\AdminController@updateSubscription')->name('update-subscription');
Route::post('/delete-subscription/{id}','Admin\AdminController@deleteSubscription')->name('delete-subscription');
Route::post('/update-subscription-img','Admin\AdminController@updateSubscriptionImg')->name('update-subscription-img');


Route::post('/save-subscription', 'Admin\AdminController@saveSubscription')->name('save-subscription');

Route::any('add-exam', 'Admin\ExamController@addExam')->name('add-exam');


Route::post('save-add-exam', 'Admin\ExamController@saveAddExam')->name('save-add-exam');

Route::get('add-exam-question/{id}', 'Admin\ExamController@addExamQuestion')->name('add-exam-question');

Route::post('/save-exam-question/{id}', 'Admin\ExamController@saveExamQuestion')->name('save-exam-question');

Route::post('/update-exam-img','Admin\ExamController@updateExamImg')->name('update-exam-img');

Route::get('confirm-exam/{id}', 'Admin\ExamController@confirmExam')->name('confirm-exam');

Route::post('save-confirm-exam/{id}', 'Admin\ExamController@saveConfirmExam')->name('save-confirm-exam');

Route::post('exam-post-success/{id}', 'Admin\ExamController@examPostSuccess')->name('exam-post-success');

Route::get('/more-question/{id}', 'Admin\ExamController@moreQuestion')->name('more-question');


Route::get('/exam', 'Admin\ExamController@examList')->name('exam');

Route::get('/exam-question/{id}', 'Admin\ExamController@examQuestion')->name('exam-question');

Route::get('/edit-exam-question/{id}/{exam_id?}', 'Admin\ExamController@editExamQuestion')->name('edit-exam-question');

Route::get('/remove-exam-question/{id}/{exam_id?}', 'Admin\ExamController@removeExamQuestion')->name('remove-exam-question');

Route::post('/updateExamQuestion/{id?}','Admin\ExamController@updateExamQuestion')->name('updateExamQuestion');

Route::post('/approve-user','Admin\UserController@approveUser')->name('approve-user');


Route::get('/get-register-student', 'Admin\UserController@getRegisterStudent')->name('get-register-student');

Route::get('/exam-accessbility/{id}', 'Admin\ExamController@examAccessbility')->name('exam-accessbility');


Route::any('/remove-exam-user/{id}', 'Admin\ExamController@removeExamUser')->name('remove-exam-user');

Route::get('/edit-exam/{id}', 'Admin\ExamController@editExam')->name('edit-exam');

Route::post('/update-exam/{id}', 'Admin\ExamController@updateExam')->name('update-exam');

Route::get('/profile', 'Admin\UserController@profile')->name('profile');

Route::post('/update-profile', 'Admin\UserController@updateProfile')->name('update-profile');
Route::get('/result', 'Admin\ResultController@view')->name('result');

Route::Post("delete-exam/{id}",  'Admin\ExamController@deleteExam')->name('delete-exam');
 
}) ; 
