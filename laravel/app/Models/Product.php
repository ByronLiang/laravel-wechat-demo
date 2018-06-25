<?php

namespace App\Models;

class Product extends Model
{
    public $timestamps = false;

    protected $table = 'product';

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
