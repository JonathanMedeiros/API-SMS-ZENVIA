<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{

    protected $table = 'logs';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'application_id', 
        'partId', 
        'type', 
        'phone', 
        'email', 
        'category', 
        'datetime'
    ];

    protected $casts = [
        'datetime' => 'datetime:Y-m-d H:i:s',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
