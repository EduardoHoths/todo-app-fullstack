<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task',
        'checked'
    ];

    protected $casts = [
        'checked' => 'boolean'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
