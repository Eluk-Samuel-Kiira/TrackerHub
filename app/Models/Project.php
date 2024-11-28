<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'projectCode',
        'projectName',
        'projectStartDate',
        'projectDeadlineDate',
        'projectDescription',
        'projectCategoryId',
        'projectDepartmentId',
        'projectClientId',
        'projectCost',
        'isPaidOff',
        'projectBudget',
        'projectBudgetLimit',
        'projectCurrencyId',
        'completionStatus',
        'created_by',
        'isActive',
    ];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function projectCategory(){
        return $this->belongsTo(ProjectCategory::class, 'projectCategoryId');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'projectDepartmentId');
    }

    public function client(){
        return $this->belongsTo(Client::class, 'projectClientId');
    }

    public function currency(){
        return $this->belongsTo(Currency::class, 'projectCurrencyId');
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function projectFiles(){
        return $this->hasMany(ProjectFile::class, 'project_id');
    }

    public function invoices(){
        return $this->hasMany(ProjectInvoice::class,'project_id');
    }
}
