<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title_en',
        'title_np',
        'description_en',
        'description_np',
        'icon',
        'sort_order',
    ];
}
