<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requistion extends Model
{
    
    protected $fillable = ['name', 'description', 'requisitionCategoryId','amount','approvedAmount','project_id', 'isActive', 'status', 'created_by', 'paid_by'];

    public function requisitionCreater()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function requisitionAccountant()
    {
        return $this->belongsTo(User::class, 'paid_by', 'id');
    }

    
    public function requisitionProject()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function requisitionCategory()
    {
        return $this->belongsTo(Department::class, 'requisitionCategoryId', 'id');
    }
    
    public function requisitionItems()
    {
        return $this->hasMany(RequisitionItem::class, 'requisition_id', 'id');
    }

}
