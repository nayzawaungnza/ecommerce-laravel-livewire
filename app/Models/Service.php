<?php

namespace App\Models;

use App\Services\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image',
        'icon',
        'parents',
        'gallery',
        'user_id',
        'status',
        'service_card',
        'call_to_action',
        'static_card',
        'og_title',
        'og_description',
        'og_image',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'schema_json'
    ];

    protected $casts = [
        'status' => Status::class
    ];

    public function getParentsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setParentsAttribute($value)
    {
        $this->attributes['parents'] = json_encode($value);
    }

    public function children()
    {
        return $this->hasMany(Service::class, 'parents');
    }

    public function parents()
    {
        return $this->belongsTo(Service::class, 'parents');
    }

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

    public function getGalleryAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setGalleryAttribute($value)
    {
        $this->attributes['gallery'] = json_encode($value);
    }

    public function getStaticCardAttribute($value)
    {
        return json_decode($value, true);
    }
    public function setStaticCardAttribute($value)
    {
        $this->attributes['static_card'] = json_encode($value);
    }
    public function getServiceCardAttribute($value)
    {
        return json_decode($value, true);
    }
    public function setServiceCardAttribute($value)
    {
        $this->attributes['service_card'] = json_encode($value);
    }
    public function getImageAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = json_encode($value);
    }

    public function getCallToActionAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setCallToActionAttribute($value)
    {
        $this->attributes['call_to_action'] = json_encode($value);
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
