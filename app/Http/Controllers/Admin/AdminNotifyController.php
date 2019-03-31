<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class AdminNotifyController extends Controller
{
    public function index()
    {
       return View('admin.notify.index');
    }

    public function show(Request $request,$id)
    {
       
        $notificationData = Auth::user()->Notifications->find($id);
        $notificationData->markAsRead();
        return View('admin.notify.show_notification', compact('notificationData'));
        
    }

    public function show_ajax(Request $request,$id)
    {
        $notificationData = Auth::user()->Notifications->find($id);

        return View('admin.notify.show_notification', $notificationData);

        
    }

   
   
    public function destroy($id)
    {
       $notificationData = Auth::user()->Notifications->find($id);
       $notificationData->delete();
       return Auth::user()->unreadNotifications;
    }

    public function unreadNotification(){
      return  Auth::user()->unreadNotifications;
           // $not['notification'] =
//       INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
// ('a4d550b7-f45a-4b97-883c-e8faee1f8111', 'App\\Notifications\\notifyExamSubmission', 'App\\User', 1, '{\"subject\":\"Rahul Chauhan has taken Sports\",\"message\":\"<div>\\r\\nRahul Chauhan has taken Sports on 27-03-2019 and here is the result\\r\\n<div class = \\\"nopadding\\\">\\r\\n <table class = \'table res_table\' border = \'1\'>\\r\\n                      <tr>\\r\\n                        <th> Exam <\\/th>\\r\\n                        <th> Obtain Mark <\\/th>\\r\\n                        <th> MarkSheet <\\/th>\\r\\n                      <\\/tr>\\r\\n                      <tr>\\r\\n                          <td> Sports; <\\/td>\\r\\n                          <td> Result::findOrFail(1317)[\'obtain_mark\']; <\\/td>\\r\\n                          <td> <a href = \'\'> Click  <\\/a> <\\/td>\\r\\n                      <\\/tr>\\r\\n                      <\\/table>\\r\\n<\\/div>\\r\\n<\\/div>\",\"email\":null}', NULL, '2019-03-27 11:12:06', '2019-03-28 12:07:20'),
// ('a4d550b7-f45a-4b97-883c-e8faee1f8311', 'App\\Notifications\\notifyExamSubmission', 'App\\User', 1, '{\"subject\":\"Rahul Chauhan has taken Sports\",\"message\":\"<div>\\r\\nRahul Chauhan has taken Sports on 27-03-2019 and here is the result\\r\\n<div class = \\\"nopadding\\\">\\r\\n <table class = \'table res_table\' border = \'1\'>\\r\\n                      <tr>\\r\\n                        <th> Exam <\\/th>\\r\\n                        <th> Obtain Mark <\\/th>\\r\\n                        <th> MarkSheet <\\/th>\\r\\n                      <\\/tr>\\r\\n                      <tr>\\r\\n                          <td> Sports; <\\/td>\\r\\n                          <td> Result::findOrFail(1317)[\'obtain_mark\']; <\\/td>\\r\\n                          <td> <a href = \'\'> Click  <\\/a> <\\/td>\\r\\n                      <\\/tr>\\r\\n                      <\\/table>\\r\\n<\\/div>\\r\\n<\\/div>\",\"email\":null}', NULL, '2019-03-27 11:12:06', '2019-03-28 09:52:28'),
// ('a4d550b7-f45a-4b97-883c-e8faee1f8313', 'App\\Notifications\\notifyExamSubmission', 'App\\User', 1, '{\"subject\":\"Rahul Chauhan has taken Sports\",\"message\":\"<div>\\r\\nRahul Chauhan has taken Sports on 27-03-2019 and here is the result\\r\\n<div class = \\\"nopadding\\\">\\r\\n <table class = \'table res_table\' border = \'1\'>\\r\\n                      <tr>\\r\\n                        <th> Exam <\\/th>\\r\\n                        <th> Obtain Mark <\\/th>\\r\\n                        <th> MarkSheet <\\/th>\\r\\n                      <\\/tr>\\r\\n                      <tr>\\r\\n                          <td> Sports; <\\/td>\\r\\n                          <td> Result::findOrFail(1317)[\'obtain_mark\']; <\\/td>\\r\\n                          <td> <a href = \'\'> Click  <\\/a> <\\/td>\\r\\n                      <\\/tr>\\r\\n                      <\\/table>\\r\\n<\\/div>\\r\\n<\\/div>\",\"email\":null}', '2019-03-28 12:23:29', '2019-03-27 11:12:06', '2019-03-28 12:23:29');

    }
}
