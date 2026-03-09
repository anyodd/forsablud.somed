<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/webhook/github',
    ];

    public function handle($request, \Closure $next)
    {
        if ($request->is('api/webhook/github')) {
            \Illuminate\Support\Facades\Log::info('CSRF check for GitHub webhook: started', [
                'is_excluded' => $this->inExceptArray($request),
                'method' => $request->method()
            ]);
        }
        return parent::handle($request, $next);
    }
}
