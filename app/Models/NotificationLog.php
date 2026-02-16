<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationLog extends Model
{   
     Use HasFactory, SoftDeletes;

    protected $fillable = [
        'target_type', 
        'target_id', 
        'category', 
        'title', 
        'body', 
        'data_payload', 
        'total_sent', 
        'sent_by'
    ];

    protected $hidden = [
        //
    ];
    protected $casts = [
        'data_payload' => 'array', // Laravel otomatis mengubah Array <-> JSON
    ];
}
