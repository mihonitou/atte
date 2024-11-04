<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;
    protected $fillable = [
        'start',
        'end',
        'total',
    ];
    public function attendance() {
        return $this->belongsTo(attendance::class);
    }



}
