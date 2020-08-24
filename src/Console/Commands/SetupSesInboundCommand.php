<?php

namespace Kiekbjul\SesFeedbackInbound\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Kiekbjul\SesFeedbackInbound\Actions\SetupSesInbound;
use Kiekbjul\SesFeedbackInbound\Traits\AskForDomain;

class SetupSesInboundCommand extends Command
{
    use AskForDomain;

    public $signature = 'setup:ses-inbound';

    public $description = 'Setup SES inbound to receive email messages in your application (includes SNS and S3)';

    private $setup;

    public function __construct(SetupSesInbound $setup)
    {
        $this->setup = $setup;
        parent::__construct();
    }

    public function handle()
    {
        $this->setup->run(
            $this->askForAccountId(),
            $domain = $this->askForDomain(),
            $this->recipients($domain)
        );

        $this->info('SES Inbound Setup completed.');

        return 0;
    }

    protected function recipients($domain)
    {
        return Str::of($this->askForRecipients($domain))->explode(' ')->toArray();
    }

    protected function askForRecipients($domain)
    {
        return $this->ask(
            'Which recipients should be accepted?',
            $this->defaultRecipients($domain)
        );
    }

    protected function defaultRecipients($domain)
    {
        // Domain and all of its subdomains
        return $domain.' .'.$domain;
    }

    protected function askForAccountId()
    {
        return $this->ask('Please enter your Account ID');
    }
}
