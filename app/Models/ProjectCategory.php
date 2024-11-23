<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectCategoryFactory> */
    use HasFactory;
    protected $fillable = ['name', 'isActive', 'created_by'];

    public function projects(){
        return $this->hasMany(Project::class);
    }

    public function categoryCreater()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
