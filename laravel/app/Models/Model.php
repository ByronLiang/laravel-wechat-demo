<?php

namespace App\Models;

// use App\Models\Traits\ISO8601TimeFormat;
use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    // use ISO8601TimeFormat;
    protected $guarded = ['id'];
}
