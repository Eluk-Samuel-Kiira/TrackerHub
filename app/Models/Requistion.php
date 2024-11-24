<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requistion extends Model
{
    
    protected $fillable = ['name', 'description', 'amount','project_id', 'isActive', 'status', 'created_by'];

    public function requisitionCreater()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
