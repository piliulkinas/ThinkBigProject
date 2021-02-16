<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Template;
use App\Models\PlanedMail;
use Illuminate\Support\Facades\DB;

class ScheduledEmailsController extends Controller
{
    public function index(){
        $planedMails = DB::table('planed_mails')
                        ->join('templates', 'planed_mails.templateID', '=', 'templates.id')
                        ->join('clients', 'planed_mails.clientID', '=', 'clients.id')
                        ->select('planed_mails.*', 'templates.name', 'clients.email')
                        ->get();
        return view('scheduledEmails')->with('planedMails', $planedMails);
    }

    public function deleteScheduledEmail($id){
        PlanedMail::where('id',$id)->delete();
        return redirect()->back()->with('message', 'Planed email deleted successfully!');
    }
}
