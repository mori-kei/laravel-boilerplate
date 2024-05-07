<?php

// @see https://qiita.com/ucan-lab/items/bfd15b096a916f811468

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RequestLogger
{
    private array $excludes = ['_debugbar'];

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->canWrite($request)) {
            $this->before($request);
        }

        $response = $next($request);

        if ($this->canWrite($request)) {
            $this->after($request);
        }

        return $response;
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function canWrite(Request $request): bool
    {
        return config('logging.request.enable') && !in_array($request->path(), $this->excludes, true);
    }

    /**
     * @param Request $request
     */
    private function before(Request $request): void
    {
        Log::debug(join(' ', [$request->method(), $request->fullUrl(), 'params:', json_encode($request->all())]));
    }

    /**
     * @param Request $request
     */
    private function after(Request $request): void
    {
        Log::debug(join(' ', ['  <end>', $request->method(), $request->fullUrl()]));
    }
}
