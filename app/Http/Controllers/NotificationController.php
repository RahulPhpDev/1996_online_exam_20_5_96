<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('notification.index');
       Auth::user()->unreadNotifications[0]['data']['subject']
    }

    // public function create()
    // {
       
    // }

    // public function store(Request $request)
    // {
       
    // }

    public function show($id)
    {
        
    }

    // public function edit($id)
    // {
        
    // }

    // public function update(Request $request, $id)
    // {
    //     //
    // }

    public function destroy($id)
    {
       
    }
}
