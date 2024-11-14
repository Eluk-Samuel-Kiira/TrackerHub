<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /** @use HasFactory<\Database\Factories\CurrencyFactory> */
    use HasFactory;
    protected $fillable = ['name', 'created_by', 'isActive'];

    public function projects(){
        return $this->hasMany(Project::class);
    }
}
