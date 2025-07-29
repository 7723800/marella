<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return object
     */
    public function boot()
    {
         // Override the email notification for verifying email
        VerifyEmail::toMailUsing(function ($notifiable, $url)
        {
            $message = "Мы так счастливы, что Вы присоединились к нам. Для подтверждения данного электронного адреса перейдите по ссылке.";
            return (new MailMessage)
                    ->subject("Подтверждение регистрации в интернет-магазине Donato")
                    ->from('account@donato.kz', 'Donato.kz')
                    ->markdown("emails.account", ["url" => $url, "message" => $message, "action" => "Подтвердить e-mail"]);
        });
    }
}
