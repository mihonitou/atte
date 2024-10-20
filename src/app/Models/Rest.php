<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_time',
        'end_time',
        'total',
        'date',
    ];
    public function attendance() {
        return $this->belongsTo(attendance::class);
    }



}
