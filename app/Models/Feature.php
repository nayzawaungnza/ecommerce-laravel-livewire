<?php

namespace App\Models;

use App\Services\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'icon',
        'excerpt',
        'status',
        'user_id',
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
        'status' => Status::class
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

    public function getIconAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setIconAttribute($value)
    {
        $this->attributes['icon'] = json_encode($value);
    }
}
