<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanedMail extends Model
{
    protected $table = 'planed_mails';
    protected $fillable = [
        'clientID',
        'templadeID',
        'timeToSend'];
    public $timestamps = false;
}
