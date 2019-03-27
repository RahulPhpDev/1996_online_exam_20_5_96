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

    public function show($id)
    {

        $notificationData = Auth::user()->Notifications->find($id);
        return View('admin.notify.show_notification', $notificationData)
        
    }

   
   
    public function destroy($id)
    {
        //
    }
}
