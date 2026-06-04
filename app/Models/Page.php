<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['slug', 'title', 'description', 'keywords', 'content_html', 'content_text', 'type'];
}
