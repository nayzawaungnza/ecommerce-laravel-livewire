<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'content',
        'excerpt',
        'image',
        'video',
        'gallery',
        'challenges',
        'system_title',
        'system_description',
        'system_desktop',
        'system_mobile',
        'colors',
        'colorscheme',
        'typography',
        'call_to_action',
        'approaches',
        'status',
        'user_id',
        'og_title',
        'og_description',
        'og_image',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'schema_json'
    ];

    public function stacks()
    {
        return $this->belongsToMany(Stack::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for 'gallery' attribute
    public function getGalleryAttribute($value)
    {
        return json_decode($value, true);
    }

    // Mutator for 'gallery' attribute
    public function setGalleryAttribute($value)
    {
        $this->attributes['gallery'] = json_encode($value);
    }

    // Repeat the above pattern for other JSON columns

    // Accessor for 'challenges' attribute
    public function getChallengesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setChallengesAttribute($value)
    {
        $this->attributes['challenges'] = json_encode($value);
    }

    // Accessor for 'system_desktop' attribute
    public function getSystemDesktopAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setSystemDesktopAttribute($value)
    {
        $this->attributes['system_desktop'] = json_encode($value);
    }

    // Repeat the pattern for other JSON columns as needed

    // Accessor for 'approaches' attribute
    public function getApproachesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setApproachesAttribute($value)
    {
        $this->attributes['approaches'] = json_encode($value);
    }

    // Accessor for 'schema_json' attribute
    public function getSchemaJsonAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setSchemaJsonAttribute($value)
    {
        $this->attributes['schema_json'] = json_encode($value);
    }
    public function getImageAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = json_encode($value);
    }
    public function setTypographyAttribute($value)
    {
        $this->attributes['typography'] = json_encode($value);
    }

    public function getTypographyAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getCallToActionAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setCallToActionAttribute($value)
    {
        $this->attributes['call_to_action'] = json_encode($value);
    }
    public function getSystemMobileAttribute($value)
    {
        return json_decode($value, true);
    }
    public function setSystemMobileAttribute($value)
    {
        $this->attributes['system_mobile'] = json_encode($value);
    }
}
