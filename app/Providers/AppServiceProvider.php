<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Str;
use App\Policies\CoursePolicy;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        VerifyEmail::createUrlUsing(function(User $user) {
            $frontendUrl = config('app.frontend_url').'/email/verify';
            $baseUrl = config('app.url');

            $verifyUrl = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(60),
                [
                    'user' => $user->hashid,
                    'hash' => sha1($user->getEmailForVerification())
                ]
            );

            return $frontendUrl . '?verify_url='.urlencode(Str::of($verifyUrl)->replace($baseUrl.'/api/', ''));
        });
    }
}
