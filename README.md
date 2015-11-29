# Actions Bundle

[![Latest Version](https://img.shields.io/github/release/ThrusterIO/actions-bundle.svg?style=flat-square)]
(https://github.com/ThrusterIO/actions-bundle/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)]
(LICENSE)
[![Build Status](https://img.shields.io/travis/ThrusterIO/actions-bundle.svg?style=flat-square)]
(https://travis-ci.org/ThrusterIO/actions-bundle)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/ThrusterIO/actions-bundle.svg?style=flat-square)]
(https://scrutinizer-ci.com/g/ThrusterIO/actions-bundle)
[![Quality Score](https://img.shields.io/scrutinizer/g/ThrusterIO/actions-bundle.svg?style=flat-square)]
(https://scrutinizer-ci.com/g/ThrusterIO/actions-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/thruster/actions-bundle.svg?style=flat-square)]
(https://packagist.org/packages/thruster/actions-bundle)

[![Email](https://img.shields.io/badge/email-team@thruster.io-blue.svg?style=flat-square)]
(mailto:team@thruster.io)

The Thruster Actions Bundle.


## Install

Via Composer

``` bash
$ composer require thruster/actions-bundle
```

## Usage

This bundle wraps Actions Component and provides support actions as tagged services.

Example configuration:

```xml
<service id="some_action_executor" class="SomeActionExecutor">
    <tag name="thruster_action_executor"/>
</service>
```

Usage:

```php
$this->container->get('thruster_actions.executor')->execute(new AllAction('hello'));
```

Using provided trait:

```php
use ActionsAwareTrait;
//...
$this->executeActions(new AllAction('hello'));
```



## Testing

``` bash
$ composer test
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.


## License

Please see [License File](LICENSE) for more information.
