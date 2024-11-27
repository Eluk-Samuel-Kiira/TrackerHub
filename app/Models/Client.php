<?php

namespace App\Models;

use App\Http\Controllers\ProjectInvoiceController;
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

    public function clientCreater()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function invoices(){
        return $this->hasMany(ProjectInvoice::class,'client_id');
    }
}
