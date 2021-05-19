<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{

    protected $table = 'applications';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['company', 'name', 'token', 'active'];

    public function logs()
    {
        return $this->hasMany(Logs::class);
    }
}
