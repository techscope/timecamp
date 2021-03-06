# timecamp

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This package is a PHP wrapper to interact with the Timecamp API wrapper.

## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practises by being named the following.

```
bin/        
config/
src/
tests/
vendor/
```


## Install

Via Composer

``` bash
$ composer require techscope/timecamp
```

## Usage

``` php
$skeleton = new Techscope\Timecamp();
echo $skeleton->echoPhrase('Hello, League!');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email christian.soseman@techscopellc.com instead of using the issue tracker.

## Credits

- [TechScope LLC][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/techscope/timecamp.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/techscope/timecamp/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/techscope/timecamp.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/techscope/timecamp.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/techscope/timecamp.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/techscope/timecamp
[link-travis]: https://travis-ci.org/techscope/timecamp
[link-scrutinizer]: https://scrutinizer-ci.com/g/techscope/timecamp/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/techscope/timecamp
[link-downloads]: https://packagist.org/packages/techscope/timecamp
[link-author]: https://github.com/techscope
[link-contributors]: ../../contributors
