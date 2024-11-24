<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequisitionFiles extends Model
{
    protected $fillable = ['requisition_id', 'file_type', 'file_path', 'file_name', 'isActive', 'created_by'];

    public function fileType()
    {
        return $this->belongsTo(DocumentType::class, 'file_type', 'id');
    }
}
