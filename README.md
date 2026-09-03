# ZipToTimezone PHP SDK

[![PHP Version](https://img.shields.io/badge/php-%3E%3D7.0-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

PHP SDK for [ZipToTimezone] - convert zip codes to time zones.

## Requirements

- PHP 7.0 or higher
- Composer

## Installation

```bash
composer require LakeshoreTim/ZipToTimezone-php
```

## Example

```php
use LakeshoreTim\ZipToTimezonePhp\ZipAndTimeZones;

// Get the TimeZone "name" from a given zip code
$input  = "60606";
$output = ZipAndTimeZones::calcTimezoneName ($input)
echo "The time zone for " .$input. " is " .$output;

// Get the time zone offset from UTC from a given zip code (Standard Time)
$input  = "90210";
$output = ZipAndTimeZones::getStandardTimeOffset ($input)
echo "The Standard Time offset for " .$input. " is " .$output;

// Get the time zone offset from UTC from a given zip code (Daylight Savings Time)
$input  = "86023";
$output = ZipAndTimeZones::getDSTOffset ($input)
echo "The Daylight Savings Time offset for " .$input. " is " .$output;

```

## License

MIT License - see [LICENSE](LICENSE) file.

## Links

- [GitHub Repository](https://github.com/LakeshoreTim/ZipToTimezone-php)
