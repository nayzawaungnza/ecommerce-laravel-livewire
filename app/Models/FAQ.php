<?php

namespace App\Models;

use App\Services\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FAQ extends Model
{
    use HasFactory;

    protected $table = 'faqs';

    protected $fillable = [
        'question',
        'answer',
        'user_id',
        'status'
    ];

    protected $casts = [
        'status' => Status::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
