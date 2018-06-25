<?php

namespace App\Models;

class Banner extends Model
{
    public $timestamps = false;

    protected $table = 'banner';

    protected $casts = [
        'picture' => 'array',
    ];

}
