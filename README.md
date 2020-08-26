# [WIP] Laravel SES Feedback & Inbound for Emails

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kiekbjul/ses-feedback-inbound.svg?style=flat-square)](https://packagist.org/packages/kiekbjul/ses-feedback-inbound)
![](https://github.com/kiekbjul/ses-feedback-inbound/workflows/Run%20Tests/badge.svg?branch=master)
[![StyleCI](https://github.styleci.io/repos/289879761/shield?branch=master)](https://github.styleci.io/repos/289879761?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/kiekbjul/ses-feedback-inbound.svg?style=flat-square)](https://packagist.org/packages/kiekbjul/ses-feedback-inbound)

**!!! Work in Progess !!!**
Use at own risk in production

## Introduction

## Requirements

Laravel v5.8.* | v6.x | v7.x

## Installation & Setup

**Install Package**
```sh
composer require kiekbjul/ses-feedback-inbound
```

**Publish config**
More information about the config [here](docs/config.md)
```sh
php artisan vendor:publish --tag="ses-feedback-inbound-config"
```

**Publish migrations**
(only if you want to save the incoming webhooks to your database automaticly)
```sh
php artisan vendor:publish --tag="ses-feedback-inbound-migrations"
```

**Setup SES Feedback for Emails**
More information about the feedback setup [here](docs/ses-feedback-setup.md)
```sh
php artisan setup:ses-feedback
```

**Setup SES Inbound**
More information about the inbound setup [here](docs/ses-inbound-setup.md)
```sh
php artisan setup:ses-inbound
```

## Full Documentation

### Testing
Using [Expose](#todo)

### Changelog

## Contributing

### Security

### Roadmap
- Documentation
- Tests
- Full customization: InboundConfig & FeedbackConfig
- Add "Remove Inbound & Feedback Command"
- Possibility to publish Delivery, Bounce, Complaint Events via Identity (Domain)
- Custom open and click provider for domain
- forwarding incoming emails to another destination
- Add "Inbound via SNS Action or S3 Action"

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.