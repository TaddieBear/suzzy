<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        'api/*', // ✅ Exclude all API routes
        'test',
        'admin/logout',
        'debug', // ✅ Exclude debug route
    ];    
    
}