<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\PoeController;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
        $announcement = new AnnouncementController();
        $duePPmp = new PoeController();
        $announcement->NotifyNow();
        $duePPmp->PPMPDUE();
    }
}
