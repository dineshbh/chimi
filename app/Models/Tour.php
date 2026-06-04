<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = ['slug', 'title', 'category', 'duration', 'snippet', 'content_html', 'content_text'];
}
