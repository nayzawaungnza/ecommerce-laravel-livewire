<?php

namespace App\Models;

use App\Services\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Technology extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'excerpt',
        'user_id',
        'status',
        'og_title',
        'og_description',
        'og_image',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'schema_json',

    ];

    protected $casts = [
        'status' => Status::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setSchemaJsonAttribute($value)
    {
        $this->attributes['schema_json'] = json_encode($value);
    }
    public function getSchemaJsonAttribute($value)
    {
        return json_decode($value);
    }
    public function getImageAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = json_encode($value);
    }
}
