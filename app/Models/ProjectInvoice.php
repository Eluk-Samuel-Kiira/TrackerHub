<?php

namespace App\Models;

use App\Http\Controllers\CurrencyController;
use Illuminate\Database\Eloquent\Model;

class ProjectInvoice extends Model
{
    protected $fillable = [
        'project_id',
        'client_id',
        'amount',
        'description',
        'billing_date',
        'due_date',
        'isPaid',
        'reference_number',
        'createdBy',
        'paidBy',
        'isActive',
    ];

    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }

    public function client(){
        return $this->belongsTo(Client::class,'client_id');
    }

    public function paidBy(){
        return $this->belongsTo(User::class,'paidBy');
    }

    public function createdByUser(){
        return $this->belongsTo(User::class,'createdBy');
    }
}
