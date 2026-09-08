<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SystemLog;

class LogActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $user = $request->user();
            
            if ($user) {
                $routeName = $request->route() ? $request->route()->getName() : null;

                if ($routeName === 'login' || $request->is('login')) {
                    $action = 'login';
                    $module = 'Authentication';
                } elseif ($routeName === 'logout' || $request->is('logout')) {
                    $action = 'logout';
                    $module = 'Authentication';
                } else {
                    $action = $this->mapMethodToAction($request->method());
                    $module = $this->extractModuleFromRoute($routeName);
                }
                
                SystemLog::create([
                    'user_id' => $user->id,
                    'action' => $action,
                    'event' => $action,
                    'module' => $module,
                    'description' => "{$action} request to {$request->path()}",
                    'ip_address' => $request->ip(),
                    'status' => $response->getStatusCode() >= 400 ? 'failed' : 'success',
                ]);
            }
        }

        return $response;
    }

    private function mapMethodToAction(string $method): string
    {
        return match($method) {
            'POST' => 'create',
            'PUT', 'PATCH' => 'update',
            'DELETE' => 'delete',
            default => 'unknown',
        };
    }

    private function extractModuleFromRoute(?string $routeName): string
    {
        if (!$routeName) {
            return 'Unknown';
        }

        $parts = explode('.', $routeName);

        $portalPrefixes = ['super-admin', 'admin', 'city-vet', 'admin-asst', 'assistant-vet', 'api', 'password'];

        $index = 0;
        while ($index < count($parts) && in_array($parts[$index], $portalPrefixes)) {
            $index++;
        }

        if ($index >= count($parts)) {
            return 'Unknown';
        }

        $module = $parts[$index];

        if ($module === 'meat-inspection' && isset($parts[$index + 1])) {
            $meatInspectionSubModules = [
                'reports',
                'meat-shop',
                'establishments',
                'establishments-overview',
            ];

            if (in_array($parts[$index + 1], $meatInspectionSubModules)) {
                return $parts[$index + 1];
            }
        }

        return $module;
    }
}
