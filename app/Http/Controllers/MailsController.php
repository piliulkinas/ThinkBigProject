<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Models\Client;
use App\Models\Template;

class MailsController extends Controller
{
    public function mailForClient(Request $request){
        $this->sendMail($request['clientId'], $request['templateId']);
        return redirect()->back();
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
}
