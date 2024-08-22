<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'logo_alt',
        'favicon',
        'description',
        'social',
        'contact',
        'footer',
        'copyright',
        'user_id'
    ];
    protected $casts = [
        'social' => 'array',
        'contact' => 'array',
        'footer' => 'array',
        'copyright' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSocialAttribute($value)
    {
        return json_decode($value);
    }

    public function getContactAttribute($value)
    {
        return json_decode($value);
    }



    public function getFooterAttribute($value)
    {
        return json_decode($value);
    }

    public function getCopyrightAttribute($value)
    {
        return json_decode($value);
    }
    public function setSocialAttribute($value)
    {
        $this->attributes['social'] = json_encode($value);
    }

    public function setContactAttribute($value)
    {
        $this->attributes['contact'] = json_encode($value);
    }


    public function setFooterAttribute($value)
    {
        $this->attributes['footer'] = json_encode($value);
    }

    public function setCopyrightAttribute($value)
    {
        $this->attributes['copyright'] = json_encode($value);
    }
}