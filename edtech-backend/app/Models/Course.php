<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'thumbnail_url', 'price' // Add 'price' to the fillable array
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'courses';
}
