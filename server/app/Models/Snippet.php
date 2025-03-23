<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Snippet extends Model
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'lang',
        'code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
