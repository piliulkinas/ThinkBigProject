<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Models\Client;
use App\Models\Template;
use App\Models\PlanedMail;

class MailsController extends Controller
{
    public function mailForClient(Request $request){
        if($request['planedTime'] != null){
            $this->mailPlaning($request, $request['clientId']);
            return redirect()->back()->with('message', 'Success! Email planed.');
        }
        else{
            $this->sendMail($request['clientId'], $request['templateId']);
            return redirect()->back()->with('message', 'Email sent successfully!');
        }
    }

    public function mailForGroup(Request $request){
        $clients = Client::where('group_id', $request['group_id'])->get();
        if($request['planedTime'] != null){
            foreach($clients as $client){
                $this->mailPlaning($request, $client->id);
            }
            return redirect()->back()->with('message', 'Success! Emails planed.');
        }
        else {
            foreach($clients as $client){
                $this->sendMail($client->id, $request['templateId']);
            }
            return redirect()->back()->with('message', 'Emails sent successfully!');
        }
    }

    public function sendMail($clientId, $templateId){
        $client = Client::where('id', $clientId)->first();
        $template = Template::where('id', $templateId)->first();
        $content = str_replace("!NAME!",$client->name,$template->content);
        $content = str_replace("!EMAIL!",$client->email,$content);
        $content = str_replace("!SURNAME!",$client->surname,$content);
        $title = str_replace("!NAME!",$client->name,$template->title);
        $title = str_replace("!SURNAME!",$client->surname,$title);
        $title = str_replace("!EMAIL!",$client->email,$title);
        $details = [
            'title' => $title,
            'body'  => $content,
        ];

        Mail::to($client->email)->send(new TestMail($details));
    }

    public function mailPlaning($request, $clientId){
        $request->validate([
            'planedTime' => 'after:'.date('Y-m-d H:i')
            ]);

            $planedMail = new PlanedMail();
            $planedMail->clientID = $clientId;
            $planedMail->templateID = $request['templateId'];
            $planedMail->timeToSend = $request['planedTime'];
            $planedMail->save();
    }
}
