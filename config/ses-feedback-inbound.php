<?php

use Illuminate\Support\Str;

/**
 * Most information which is given here will only be used on the setup.
 * It will not update, add or delete anything on your SES, SNS, S3 Account until you run
 * `php artisan ses:setup`
 *
 * For local testing of your implementation I recommend Expose to
 */
return [

    /** Should models be saved to database? Then you must publish the migrations (ses-feedback-inbound-migrations) */
    'should_save_sent_messages' => true,
    'should_save_feedback' => true,
    'should_save_inbound' => true,

    /** Which urls should be used for the webhooks from AWS? */
    'route_feedback' => 'ses-feedback',
    'route_inbound' => 'ses-inbound',

];
