<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\TestMail;
use App\Models\Client;
use App\Models\Template;
use App\Models\PlanedMail;
use Carbon\Carbon;

class cronEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minute:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send scheduled emails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        date_default_timezone_set('Europe/Vilnius');
        $mails = DB::table('planed_mails')
                        ->join('templates', 'planed_mails.templateID', '=', 'templates.id')
                        ->join('clients', 'planed_mails.clientID', '=', 'clients.id')
                        ->select('planed_mails.*', 'templates.id as templateID', 'clients.id as clientID')
                        ->where('planed_mails.timeToSend', '<=', date('Y-m-d H:i:s'))
                        ->get();

        foreach($mails as $mail){
            $this->sendMail($mail->clientID, $mail->templateID);
            $this->cases($mail);
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
        echo "Mail send";
    }

    public function cases($e){
        switch($e->repeat){
            case "No":
                PlanedMail::where('id',$e->id)->delete();
                break;
            case "Every day":
                $after = Carbon::now()->addDay()->format('Y-m-d H:i:00');
                if($after > $e->validUntil){
                    PlanedMail::where('id',$e->id)->delete();
                    echo "brake every day";
                    break;
                }
                else{
                    PlanedMail::where('id',$e->id)
                                ->update(array(
                                    'timeToSend' => $after,
                                ));
                    break;
                }
            case "Every week":
                $after = Carbon::now()->addWeek()->format('Y-m-d H:i:00');
                if($after > $e->validUntil){
                    PlanedMail::where('id',$e->id)->delete();
                    echo "brake every week";
                    break;
                }
                else{
                    PlanedMail::where('id',$e->id)
                                ->update(array(
                                    'timeToSend' => $after,
                                ));
                    break;
                }
            case "Every month":
                $after = Carbon::now()->addMonth()->format('Y-m-d H:i:00');
                if($after > $e->validUntil){
                    PlanedMail::where('id',$e->id)->delete();
                    echo "brake every month";
                    break;
                }
                else{
                    PlanedMail::where('id',$e->id)
                                ->update(array(
                                    'timeToSend' => $after,
                                ));
                    break;
                }
            case "Every year":
                $after = Carbon::now()->addYear()->format('Y-m-d H:i:00');
                if($after > $e->validUntil){
                    PlanedMail::where('id',$e->id)->delete();
                    echo "brake every year";
                    break;
                }
                else{
                    PlanedMail::where('id',$e->id)
                                ->update(array(
                                    'timeToSend' => $after,
                                ));
                    break;
                }
        }
    }
}
