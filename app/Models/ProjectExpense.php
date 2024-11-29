<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectExpense extends Model
{
    protected $fillable = [
        'project_id',
        'approved_amount',
        'requested_by',
        'isActive',
    ];
}
