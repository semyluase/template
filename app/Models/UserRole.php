<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['role'];

    public function role()
    {
        return $this->belongsTo(Role::class,'role_id','id');
    }
}
