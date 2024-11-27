<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFile extends Model
{
    protected $fillable = [
        'project_id',
        'document_name',
        'document_path',
        'created_by',
        'isActive',
        'document_type',
    ];

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function documentType(){
        return $this->belongsTo(DocumentType::class, 'document_type');
    }

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }
}
