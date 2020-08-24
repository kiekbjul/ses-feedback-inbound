<?php

namespace Kiekbjul\SesFeedbackInbound\Traits;

use Illuminate\Support\Str;

trait AskForDomain
{
    protected function askForDomain()
    {
        return $this->ask(
            'For which Domain do you want to start the setup?',
            $this->getDomainFromAppUrl()
        );
    }

    protected function getDomainFromAppUrl()
    {
        return Str::of(config('app.url'))
            ->after('https://')
            ->after('http://')
            ->before('/');
    }
}
