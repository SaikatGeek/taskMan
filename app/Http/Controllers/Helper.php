<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class Helper extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public static function notify($details, $reference, $notified_by, $notified_to, $entity)
    {
        $Notification = new Notification;
        $Notification->details = $details;
        $Notification->entity = $entity;
        $Notification->reference = $reference;
        $Notification->notified_by = $notified_by;
        $Notification->notified_to = $notified_to;
        $Notification->read_status = 0;
        $Notification->save();

        return true;
    }

   
}
