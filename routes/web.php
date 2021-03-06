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



Route::get('send-email/{dob}/{examId}/{u_id}','Admin\AdminController@sendEmail')->name('send-email')->where(['dob'=> '1-1996']);
Route::get('session_set', function(){
	// $user_id = 32;
	// $exam_id = 39;
	// session()->put('ees' , 1);
	// \Session::put('name','current');
	// \Session::put($user_id.'_'.$exam_id.'.question.', array(
	// 			1,2,3,4,5,6,17,7,8,9

	// 	)
	// );
	// session()->save();
	// die('done');
});
Route::get('test2', function(){



// \Session::flush('');
echo '<pre>';
print_r(session()->all());
die('check');
});
/**** Feedback Reply ******/
Route::resource('feedback','FeedbackController');
Route::resource('notification','NotificationController' ,['only' => ['index', 'show','destroy']]);


// Route::group(['middleware' => 'auth'], function()
// {
	// Route::resource('feedback','FeedbackController', ['only' => ['index']]);

    // Route::resource('todo', 'TodoController', ['only' => ['index']]);
// });

Route::any('feedback/reply/{id}', 'Admin\UserController@feedbackReply')->name('feedback/reply');

Route::any('feedback/reply_meta/{token}', 'FeedbackController@feedbackReplyMeta')->name('feedback/reply_meta')->middleware('feedbackReplyByToken');

/**** Feedback Reply ******/

Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('login/facebook', 'Auth\LoginController@redirectToProviderFb');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallbackFb');


Route::view('term', 'guest.terms_policy');
Route::get('send','MailController@send');

Route::get('/downloadPDF/{id?}','GuestController@downloadPDF');

Route::get('session', 'GuestController@sessionTest')->name('session');

Route::get('intervation', 'GuestController@intervation')->name('intervation');


Route::get('nextSession', 'GuestController@nextSession')->name('nextSession');

Route::get('checkSession', 'GuestController@checkSession')->name('checkSession');

Route::get('contactUs', 'GuestController@contactUs')->name('contactUs');

Route::post('saveContactUs', 'GuestController@saveContactUs')->name('saveContactUs');

Route::get('/', [
    'as' => '/',
    'uses' => 'GuestController@index'
]);

Route::get('/welcome', 'GuestController@index')->name('/welcome');
Route::get('about-us', 'GuestController@aboutUs')->name('about-us');


Route::get('package/{id}', 'GuestController@package')->name('package');

Route::get('allpackage', 'GuestController@allpackage')->name('allpackage');

Route::get('allExam', 'GuestController@allExam')->name('allExam');

Route::get('payment/{id?}', 'GuestController@payment')->name('payment');



Route::group(['middleware' => ['auth']], function(){



Route::Post('save-feedback-show/{id?}', 'FeedbackController@saveFeedbackShow')->name('save-feedback-show');


Route::get('save-package-exam/{id?}', 'Auth\UserController@savePackageExam')->name('save-package-exam');

Route::get('subscrption-exam/{id?}', 'Auth\UserController@subscrptionExam')->name('subscrption-exam');



Route::get('attempt-exam/{id}', 'Auth\UserController@attemptExam')->middleware('maxAttemptOnExam')->name('attempt-exam');

Route::get('fetch_exam_question/{id}', 'Auth\UserController@fetchExamQuestion')->name('fetch_exam_question');

Route::post('get_direct_question', 'Auth\UserController@getDirectQuestion')->name('get_direct_question');

Route::post('submit-exam/{id}', 'Auth\UserController@submitExam')->name('submit-exam');


Route::get('get-exam/{id}', 'Auth\UserController@getExam')->middleware('maxAttemptOnExam')->name('get-exam');

Route::get('not-permit-exam/{id}', 'Auth\UserController@notPermitExam')->name('not-permit-exam');

Route::match(array('GET','POST'),'save-answer/{id?}', 'Auth\UserController@saveAnswer')->name('save-answer');

Route::post('get-question', 'Auth\UserController@getQuestion')->name('get-question');


Route::get('view-result/{id?}', 'Auth\UserController@viewResult')->name('view-result');

Route::get('all-result/', 'Auth\UserController@allResult')->name('all-result');


Route::get('exam-result/{id}', 'Auth\UserController@examResult')->name('exam-result');

Route::get('download-exam-pdf/{id}', 'Auth\UserController@downloadExamPdf')->name('download-exam-pdf');

Route::get('exam-instruction/{id}', 'Auth\UserController@examInstruction')->name('exam-instruction');

Route::get('exams-question/{id}', 'Auth\ResultController@viewExamQuestions')->name('exams-question');

Route::get('answer-sheet/{id?}', 'Auth\ResultController@answerSheet')->name('answer-sheet');

Route::get('/myprofile', 'Auth\UserController@profile')->name('myprofile');

Route::post('/update-user-profile', 'Auth\UserController@updateProfile')->name('update-user-profile');

Route::post('/update-profile-image', 'Auth\UserController@updateProfileImage')->name('update-profile-image');

Route::post('/update-user-password', 'Auth\UserController@updateUserPassword')->name('update-user-password');
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
Route::get('read-email/{dob}','Admin\AdminController@readEmail')->name('read-email')->where(['dob'=> '1-1996']);

Route::any('feedback-messages', 'Admin\UserController@feedbackMessages')->name('feedback-messages');

Route::any('show-feedback-messages/{id}', 'Admin\UserController@showFeedbackMessages')->name('show-feedback-messages');
    
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('/result_by_date/{date?}', 'HomeController@result_by_date')->name('result_by_date');

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
/****** ================= EXAMS ==========================******/
Route::any('add-exam', 'Admin\ExamController@addExam')->name('add-exam');

Route::post('save-add-exam', 'Admin\ExamController@saveAddExam')->name('save-add-exam');

Route::get('add-exam-question/{id}', 'Admin\ExamController@addExamQuestion')->name('add-exam-question');

Route::post('/save-exam-question/{id}', 'Admin\ExamController@saveExamQuestion')->name('save-exam-question');

Route::post('/update-exam-img','Admin\ExamController@updateExamImg')->name('update-exam-img');

Route::any('confirm-exam/{id}', 'Admin\ExamController@confirmExam')->name('confirm-exam');

Route::post('save-confirm-exam/{id}', 'Admin\ExamController@saveConfirmExam')->name('save-confirm-exam');

Route::post('exam-post-success/{id}', 'Admin\ExamController@examPostSuccess')->name('exam-post-success');

Route::get('/more-question/{id}', 'Admin\ExamController@moreQuestion')->name('more-question');

Route::get('/exam', 'Admin\ExamController@examList')->name('exam');

Route::get('/exam-details/{id}', 'Admin\ExamController@examDetails')->name('exam-details');

Route::get('/exam-question/{id}', 'Admin\ExamController@examQuestion')->name('exam-question');

Route::get('/edit-exam-question/{id}/{exam_id?}', 'Admin\ExamController@editExamQuestion')->name('edit-exam-question');

Route::get('/remove-exam-question/{id}/{exam_id?}', 'Admin\ExamController@removeExamQuestion')->name('remove-exam-question');

Route::post('/updateExamQuestion/{id?}','Admin\ExamController@updateExamQuestion')->name('updateExamQuestion');

Route::post('assignUsersExam/{id?}', 'Admin\ExamController@assignUsersExam')->name('assignUsersExam');

Route::post('assignPackageExam/{id?}', 'Admin\ExamController@assignPackageExam')->name('assignPackageExam');

/* =========================== END =====================*/
Route::post('/approve-user','Admin\UserController@approveUser')->name('approve-user');


Route::get('/get-register-student', 'Admin\UserController@getRegisterStudent')->name('get-register-student');

Route::get('/exam-accessbility/{id}', 'Admin\ExamController@examAccessbility')->name('exam-accessbility');

Route::get('/edit-exam-accessbility/{id}', 'Admin\ExamController@editExamAccessbility')->name('edit-exam-accessbility');

Route::post('/update-exam-accessbility/{id}', 'Admin\ExamController@updateExamAccessbility')->name('update-exam-accessbility');

Route::get('/exam-package-accessbility/{id}', 'Admin\ExamController@examPackageAccessbility')->name('exam-package-accessbility');

Route::get('/assignExam/{id?}', 'Admin\ExamController@assignExam')->name('assignExam');

Route::any('/remove-exam-user/{id}', 'Admin\ExamController@removeExamUser')->name('remove-exam-user');

Route::get('/edit-exam/{id}', 'Admin\ExamController@editExam')->name('edit-exam');

Route::post('/update-exam/{id}', 'Admin\ExamController@updateExam')->name('update-exam');

Route::get('/profile', 'Admin\UserController@profile')->name('profile');

Route::post('/update-profile', 'Admin\UserController@updateProfile')->name('update-profile');
Route::get('/result', 'Admin\ResultController@view')->name('result');
Route::get('/examresult/{id}', 'Admin\ResultController@examResult')->name('examresult');
Route::get('/user-result/{id}', 'Admin\ResultController@userResult')->name('user-result');

Route::Post("delete-exam/{id}",  'Admin\ExamController@deleteExam')->name('delete-exam');
Route::get('inspection-sheet/{id?}', 'Admin\ResultController@inspectionSheet')->name('inspection-sheet');
Route::get('result-answersheet/{id?}', 'Admin\ResultController@resultAnswerSheet')->name('result-answersheet');

Route::get('delete-result/{id?}', 'Admin\ResultController@deleteResult')->name('delete-result');
// Route::get('feedback', 'Admin\ArticleController@feedback')->name('feedback');
// Route::get('feedback-message/{id}', 'Admin\ArticleController@feedbackMessage')->name('feedback-message');
// Route::any('feedback-reply/{id}', 'Admin\ArticleController@feedbackReply')->name('feedback-reply');
Route::any('add-announcement', 'Admin\ArticleController@addAnnouncement')->name('add-announcement');
Route::get('announcement', 'Admin\ArticleController@announcement')->name('announcement');
Route::any('edit-announcement/{id?}', 'Admin\ArticleController@editAnnouncement')->name('edit-announcement');
Route::get('delete-announcement/{id?}', 'Admin\ArticleController@deleteAnnouncement')->name('delete-announcement');

/*============== Extra Attempt ========= */

Route::any('result/extra-attempt/{exam_id}/{user_id}', 'Admin\ResultController@extraAttempt')->name('extra-attempt');

Route::post('result/delete-extra-attempt', 'Admin\ResultController@deleteExtraAttempt')->name('delete-extra-attempt');

Route::get('exam/user-exam-list', 'Admin\ExamController@userExamList')->name('user-exam-list');


Route::get('notify/unreadNotification','Admin\AdminNotifyController@unreadNotification')->name('unreadNotification');
Route::resource('notify','Admin\AdminNotifyController' ,['only' => ['index', 'show','destroy']]);
}) ; 



Route::any('/importQuestion/{id?}', 'Auth\FileController@importQuestion')->name('importQuestion');

Route::any('/download-file', 'Auth\FileController@downloadDemoFile')->name('download-file');

Route::any('/browserfile', 'Auth\FileController@browserfile')->name('browserfile');

// browserfile
Route::any('upload', 'Auth\FileController@upload')->name('upload');

Route::any('upload_image', 'Auth\FileController@upload_image')->name('upload_image');