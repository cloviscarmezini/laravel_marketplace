<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function notifications()
    {
        $unreadNotifications = Auth()->user()->unreadNotifications;

        return view('admin.notifications', compact('unreadNotifications'));
    }

    public function readAll()
    {
        $unreadNotifications = Auth()->user()->unreadNotifications;
        $unreadNotifications->each(function($notification){
            $notification->markAsRead();
        });

        flash('Notificações marcadas como lidas com sucesso')->success();

        return redirect()->back();
    }

    public function read($notification)
    {
        $notification = Auth()->user()->notifications()->find($notification);
        $notification->markAsRead();
        flash('Notificação marcada como lida com sucesso')->success();

        return redirect()->back();
    }
}
