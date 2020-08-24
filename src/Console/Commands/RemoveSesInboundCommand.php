<?php

namespace Kiekbjul\SesFeedbackInbound\Console\Commands;

use Illuminate\Console\Command;
use Kiekbjul\SesFeedbackInbound\Actions\RemoveSesInbound;

class RemoveSesInboundCommand extends Command
{
    use AskForDomain;

    public $signature = 'remove:ses-inbound';

    public $description = 'Remove the SES inbound setup';

    private $setup;

    public function __construct(RemoveSesInbound $setup)
    {
        parent::__construct();
        $this->setup = $setup;
    }

    public function handle()
    {
        $this->setup->run(
            $this->askForDomain()
        );

        $this->error('Coming soon...');
        // $this->info('SES Inbound Setup removed.');

        return 0;
    }
}
