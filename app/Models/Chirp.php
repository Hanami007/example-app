<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Chirp extends Model
{
    //
    protected $fillable = [
        'message',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); //Chirp แต่ละอันเป็นของ ผู้ใช้หนึ่งคน
    }
}
