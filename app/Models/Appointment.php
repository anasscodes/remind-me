<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'appointment_at',
        'remind_before',
        'is_done',
    ];

     protected $casts = [
        'appointment_at' => 'datetime',
        'is_done' => 'boolean',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

}
