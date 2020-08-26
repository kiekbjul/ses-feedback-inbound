# SES Inbound Setup

## Supported AWS Regions
Currently SES doesn't support every region for receiving Emails. So please be aware while choosing a region. More information are [here](https://docs.aws.amazon.com/ses/latest/DeveloperGuide/regions.html#region-receive-email) available.

Currently supported:
| Region Name           | Email Receiving Endpoint             |
|-----------------------|--------------------------------------|
| US East (N. Virginia) | inbound-smtp.us-east-1.amazonaws.com |
| US West (Oregon)      | inbound-smtp.us-west-2.amazonaws.com |
| Europe (Ireland)      | inbound-smtp.eu-west-1.amazonaws.com |

## Verify Domain
To receive Emails you need to verify the domain you want to use (not an email address).
More information are [here](https://docs.aws.amazon.com/ses/latest/DeveloperGuide/receiving-email-verification.html) available.

## DNS: MX Record
With this Record you tell sending Email Providers where your Emails are going to be received. In our case this are AWS Servers.
More information are [here](https://docs.aws.amazon.com/ses/latest/DeveloperGuide/receiving-email-mx-record.html) available.

You need to add an MX-Type Record for you domain.
If you want to only use a special subdomain you can set this MX Record for a specific subdomain:
- example.com.
- subdomain.example.com.

As value you must enter the Email Receiving Endpoint which you find above with the Priority of 10.

## IAM User
Your IAM User should have Access to S3, SNS and SES (FullAccess for creating, updating, storing and sending)

[WIP] How to setup IAM Users
For now you can look [here](https://mailcoach.app/docs/v2/app/mail-configuration/amazon-ses)

The Access Key and Secret can the be stored in the `services.php` config or your `.env` file

```php
'ses' => [
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
],
```

## Running the Setup Command
This creates an S3-Bucket with an Policy attached to it to allow SES to store Emails from your account to it. It then creates an SNS Topic and subscribes `route('ses-inbound')` to it.
Then it will create a SES Rule Set for Receiving Emails with the entered recipients.

You can then start receiving emails from your entered recipients in your application.

```sh
php artisan setup:ses-inbound
```
### Account ID
You must enter your Account ID, so that only your AWS Account is allowed to store emails and send it to your application.

You can see your Account ID [here](https://console.aws.amazon.com/billing/home?#/account)

### Domain
The domain is used to identify all resources which are created using this api. It will also generate a default setup for the recipients.

### Recipients
You can enter multiple recipients which are seperated by space.
More information are [here](https://docs.aws.amazon.com/ses/latest/DeveloperGuide/receiving-email-receipt-rules.html)

#### Match a specific email address
`user@example.com`

#### Match all addresses within a domain (without subdomains)
`example.com`

#### Match all addresses within a specific subdomain
`subdomain.example.com`

#### Match all addresses within all subdomains
`.example.com`

#### Match all addresses of a given domain and all subdomains
`example.com .example.com`

## [WIP] Manual Setup with AWS' Management Console

For now you can use this guide to make a manuell setup: [https://aws.amazon.com/de/premiumsupport/knowledge-center/ses-receive-inbound-emails/](https://aws.amazon.com/de/premiumsupport/knowledge-center/ses-receive-inbound-emails/)

The url to receive Emails with your application is visible in the config `ses-feedback-inbound` (Default: `/ses-inbound`)
<!--
### Setup S3 Bucket

### Setup SNS Notifications

### Setup SES Receipt Rules
-->