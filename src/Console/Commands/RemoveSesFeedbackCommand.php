<?php

namespace Kiekbjul\SesFeedbackInbound\Console\Commands;

use Illuminate\Console\Command;
use Kiekbjul\SesFeedbackInbound\Actions\RemoveSesFeedback;

class RemoveSesFeedbackCommand extends Command
{
    use AskForDomain;

    public $signature = 'remove:ses-feedback';

    public $description = 'Remove the SES feedback setup';

    private $setup;

    public function __construct(RemoveSesFeedback $setup)
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
