# SES Sending Feedback Setup

## Verify Domain
To send Emails you need to verify the domain you want to use.
More information are [here](https://docs.aws.amazon.com/ses/latest/DeveloperGuide/verify-domain-procedure.html) available.

## Running the Setup Command
```sh
php artisan setup:ses-feedback
```

To received the email feedback you need to add something to the emails which you are sending.
There are two different ways to do this:
1. Using the options in the `services.php` config
```php
'ses' => [
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    'options' => [
        'ConfigurationSetName' => 'laravel-ses-feedback-<YOUR_KEBAB_DOMAIN>',
    ],
],
```
2. Using a Header for each email
```php
// For Notifications
(new MailMessage)->withSwiftMessage(function ($message) {
    $message->getHeaders()->addTextHeader(
        'X-SES-CONFIGURATION-SET',
        'laravel-ses-feedback-<YOUR_KEBAB_DOMAIN>'
    );
});

// For Mailables
$this->withSwiftMessage(function ($message) {
    $message->getHeaders()->addTextHeader(
        'X-SES-CONFIGURATION-SET',
        'laravel-ses-feedback-<YOUR_KEBAB_DOMAIN>'
    );
});
```

`<YOUR_KEBAB_DOMAIN>` is a placeholder for your domain in kebab style.

For example: `example.com => example-com`

### Domain
The domain is used to identify all resources which are created using this api.

### Events
There are different kinds of events for which you can listen:
| Event          | Description                                                                                                                                                                                                                        |
|----------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| send           | The call to Amazon SES was successful and Amazon SES will attempt to deliver the email.                                                                                                                                            |
| reject         | Amazon SES accepted the email, determined that it contained a virus, and rejected it. Amazon SES didn't attempt to deliver the email to the recipient's mail server.                                                               |
| delivery       | Amazon SES successfully delivered the email to the recipient's mail server.                                                                                                                                                        |
| bounce         | The recipient's mail server permanently rejected the email. This event corresponds to hard bounces. Soft bounces are only included when Amazon SES fails to deliver the email after retrying for a period of time.                 |
| complaint      | The email was successfully delivered to the recipient. The recipient marked the email as spam.                                                                                                                                     |
| open           | The recipient received the message and opened it in their email client.                                                                                                                                                            |
| click          | The recipient clicked one or more links in the email.                                                                                                                                                                              |
| delivery_delay | The email couldn't be delivered to the recipient because a temporary issue occurred. Delivery delays can occur, for example, when the recipient's inbox is full, or when the receiving email server experiences a transient issue. |


## [WIP] Manual Setup with AWS' Management Console

For now you can use this guide to make a manuell setup: [https://aws.amazon.com/de/premiumsupport/knowledge-center/ses-receive-inbound-emails/](https://aws.amazon.com/de/premiumsupport/knowledge-center/ses-receive-inbound-emails/)

The url to receive Emails with your application is visible in the config `ses-feedback-inbound` (Default: `/ses-inbound`)