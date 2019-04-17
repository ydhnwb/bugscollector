<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BugModel extends Model
{
    protected $table = "bugs";
    protected $fillable = ['name','description','photo'];
    public $timestamps = false;
}
