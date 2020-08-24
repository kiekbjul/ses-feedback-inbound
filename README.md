# [WIP] Laravel SES Feedback & Inbound for Emails

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kiekbjul/ses-feedback-inbound.svg?style=flat-square)](https://packagist.org/packages/kiekbjul/ses-feedback-inbound)
![](https://github.com/kiekbjul/ses-feedback-inbound/workflows/Run%20Tests/badge.svg?branch=master)
[![StyleCI](https://github.styleci.io/repos/289879761/shield?branch=master)](https://github.styleci.io/repos/289879761?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/kiekbjul/ses-feedback-inbound.svg?style=flat-square)](https://packagist.org/packages/kiekbjul/ses-feedback-inbound)


## Requirements

Laravel v5.8.* | v6.x | v7.x

## Installation

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
php artisan vendor:publish --tag="ses-feedback-inbound-config"
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

## Credits

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.