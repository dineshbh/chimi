<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $fillable = [
        'ip_address',
        'url_path',
        'referer',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'country',
        'city',
        'is_proxy',
        'proxy_headers',
    ];

    protected function casts(): array
    {
        return [
            'is_proxy' => 'boolean',
            'proxy_headers' => 'array',
        ];
    }
}
