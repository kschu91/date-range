[![Build Status](https://travis-ci.org/kschu91/date-range.svg?branch=master)](https://travis-ci.org/kschu91/date-range)
[![Code Coverage](https://scrutinizer-ci.com/g/kschu91/date-range/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/kschu91/date-range/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kschu91/date-range/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kschu91/date-range/?branch=master)

# PHP Date Range

A small PHP library to extract date ranges out of a list of dates.

## Installation

```bash
composer require "kschu91/date-range"
```

If you are not familiar with composer:
[composer basic usage](https://getcomposer.org/doc/01-basic-usage.md)

### Requirements
- PHP >= 7.1

## Basic Usage

```php
$datePeriods = (new DateRangeInterval(new \DateInterval('P1D'), $dates))->getDatePeriods();
```
### Example
```php
$dates = [
    new \DateTime('2018-09-02'),
    new \DateTime('2018-09-03'),
    new \DateTime('2018-09-04'),
    new \DateTime('2018-09-08'),
    new \DateTime('2018-10-02'),
    new \DateTime('2018-10-03'),
];

$range = new DateRangeInterval(new \DateInterval('P1D'), $dates);

$datePeriods = $range->getDatePeriods();

foreach ($datePeriods as $datePeriod) {
    echo $datePeriod->start->format('Y-m-d') . ' - ' . $datePeriod->end->format('Y-m-d') . PHP_EOL;
}
```
will output:
```
2018-09-02 - 2018-09-04
2018-09-08 - 2018-09-08
2018-10-02 - 2018-10-03
```