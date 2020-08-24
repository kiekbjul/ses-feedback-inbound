<?php
namespace Kiekbjul\SesFeedbackInbound\Console\Commands;

use Illuminate\Console\Command;
use Kiekbjul\SesFeedbackInbound\Actions\SetupSesFeedback;
use Kiekbjul\SesFeedbackInbound\Traits\AskForDomain;

class SetupSesFeedbackCommand extends Command
{
    use AskForDomain;

    public $signature = 'setup:ses-feedback';

    public $description = 'Setup SES for Email Feedback and Inbound (inludes SNS)';

    private $setup;

    public function __construct(SetupSesFeedback $setup)
    {
        parent::__construct();
        $this->setup = $setup;
    }

    public function handle()
    {
        $this->setup->run(
            $this->askForDomain(),
            $this->askForFeedbackEvents()
        );

        $this->info('SES Feedback Setup completed.');

        return 0;
    }

    protected function askForFeedbackEvents()
    {
        $this->line("\n\nFor multiple Selections enter e.g. 2,3,4");
        return $this->choice(
            'Which Email Feedback do you want to receive?',
            SetupSesFeedback::$events,
            '2,3,4', // Delivery, Bounce, Complaint
            null, // max Attempts
            true // Allow Multiple Selections
        );
    }
}
