<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyActivity extends Model
{
    use HasFactory;
    protected $table = "daily_activities";
    protected $fillable = ['actv_date', 'usrId', 'task', 'time_tkn', 'actv_stat'];
}
