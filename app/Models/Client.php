<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;
    protected $fillable = ['name', 'email', 'phone', 'address', 'created_by', 'isActive'];

    public function projects(){
        return $this->hasMany(Project::class);
    }
}
