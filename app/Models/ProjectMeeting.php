<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMeeting extends Model
{

    protected $table = 'project_meetings';
    protected $fillable = [
        'project_id',
        'meetingDate',
        'meetingType',
        'meetingLocation',
        'description',
        'status',
    ];
}
