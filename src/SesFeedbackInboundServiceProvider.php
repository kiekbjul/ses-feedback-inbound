<?php
namespace Kiekbjul\SesFeedbackInbound;

use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Kiekbjul\SesFeedbackInbound\Console\Commands\RemoveSesFeedbackCommand;
use Kiekbjul\SesFeedbackInbound\Console\Commands\RemoveSesInboundCommand;
use Kiekbjul\SesFeedbackInbound\Console\Commands\SetupSesFeedbackCommand;
use Kiekbjul\SesFeedbackInbound\Console\Commands\SetupSesInboundCommand;
use Kiekbjul\SesFeedbackInbound\Http\Controllers\SesFeedbackController;
use Kiekbjul\SesFeedbackInbound\Http\Controllers\SesInboundController;
use Kiekbjul\SesFeedbackInbound\Http\Middleware\AknowledgeSetupReceipt;
use Kiekbjul\SesFeedbackInbound\Http\Middleware\ConfirmSubscription;
use Kiekbjul\SesFeedbackInbound\Http\Middleware\VerifySnsSignature;
use Kiekbjul\SesFeedbackInbound\Listeners\MessageSentListener;

class SesFeedbackInboundServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/ses-feedback-inbound.php',
            'ses-feedback-inbound'
        );
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishes();
            $this->registerCommands();
        }

        $this->registerRoutes();
        $this->registerListeners();
    }

    private function registerRoutes()
    {
        Route::middleware([VerifySnsSignature::class, ConfirmSubscription::class])->group(function () {
            Route::name('ses-feedback')
                ->post(
                    config('SesFeedbackInbound.route_feedback'),
                    SesFeedbackController::class
                );

            Route::name('ses-inbound')
                ->middleware(AknowledgeSetupReceipt::class)
                ->post(
                    config('SesFeedbackInbound.route_inbound'),
                    SesInboundController::class
                );
        });
    }

    private function registerCommands()
    {
        $this->commands([
            SetupSesFeedbackCommand::class,
            SetupSesInboundCommand::class,
        ]);
    }

    private function registerListeners()
    {
        Event::listen(MessageSent::class, MessageSentListener::class);
    }

    private function registerPublishes()
    {
        $this->publishes([
            __DIR__.'/../config/ses-feedback-inbound.php' => config_path('ses-feedback-inbound.php')
        ], 'ses-feedback-inbound-config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'ses-feedback-inbound-migrations');
    }
}
