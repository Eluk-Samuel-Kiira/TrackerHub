<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{

    protected $fillable = ['name', 'isActive', 'created_by'];


    public function docTypeCreater()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function projectFiles()
    {
        return $this->hasMany(ProjectFile::class, 'document_type');
    }
}
