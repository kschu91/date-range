<?php

namespace Aeq\DateRange;

use Aeq\DateRange\Exception\NotADateTimeException;
use Aeq\DateRange\Filter\WeekendFilter;
use PHPUnit\Framework\TestCase;

class DateRangeTest extends TestCase
{
    /**
     * @test
     */
    public function shouldGetRanges()
    {
        $dates = [
            $start = new \DateTime('2018-09-01'),
            new \DateTime('2018-09-02'),
            new \DateTime('2018-09-03'),
            new \DateTime('2018-09-08'),
            new \DateTime('2018-10-02'),
            $end = new \DateTime('2018-10-03'),
        ];

        $range = new DateRangeInterval($interval = new \DateInterval('P1D'), $dates);

        $this->assertCount(3, $actual = $range->getDatePeriods());

        $expected = [
            new \DatePeriod(new \DateTime('2018-09-01'), $interval, new \DateTime('2018-09-03')),
            new \DatePeriod(new \DateTime('2018-09-08'), $interval, new \DateTime('2018-09-08')),
            new \DatePeriod(new \DateTime('2018-10-02'), $interval, new \DateTime('2018-10-03')),
        ];

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function shouldGetSortedRanges()
    {
        $dates = [
            new \DateTime('2018-10-02'),
            $end = new \DateTime('2018-10-03'),
            new \DateTime('2018-09-03'),
            new \DateTime('2018-09-02'),
            $start = new \DateTime('2018-09-01'),
            new \DateTime('2018-09-08'),
        ];

        $range = new DateRangeInterval($interval = new \DateInterval('P1D'), $dates);

        $this->assertCount(3, $actual = $range->getDatePeriods());

        $expected = [
            new \DatePeriod(new \DateTime('2018-09-01'), $interval, new \DateTime('2018-09-03')),
            new \DatePeriod(new \DateTime('2018-09-08'), $interval, new \DateTime('2018-09-08')),
            new \DatePeriod(new \DateTime('2018-10-02'), $interval, new \DateTime('2018-10-03')),
        ];

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenNoDateTimeObject()
    {
        $dates = [
            $start = new \DateTime('2018-09-01'),
            new \DateTime('2018-09-02'),
            'this is a string',
            new \DateTime('2018-09-08'),
            new \DateTime('2018-10-02'),
            $end = new \DateTime('2018-10-03'),
        ];

        $this->expectException(NotADateTimeException::class);
        $this->expectExceptionCode(1538864918);

        (new DateRangeInterval(new \DateInterval('P1D'), $dates))->getDatePeriods();
    }

    /**
     * @test
     */
    public function shouldFilter()
    {
        $dates = [
            $start = new \DateTime('2018-09-01'),
            new \DateTime('2018-09-02'),
            new \DateTime('2018-09-03'),
            new \DateTime('2018-09-04'),
            new \DateTime('2018-09-05'),
            new \DateTime('2018-09-07'),
            new \DateTime('2018-09-08'),
            new \DateTime('2018-09-09'),
            new \DateTime('2018-09-12'),
            new \DateTime('2018-09-13'),
            new \DateTime('2018-09-14'),
            new \DateTime('2018-09-15'),
            $end = new \DateTime('2018-09-16'),
        ];

        $range = new DateRangeInterval($interval = new \DateInterval('P1D'), $dates);
        $range->addFilter(new WeekendFilter());

        $this->assertCount(3, $actual = $range->getDatePeriods());

        $expected = [
            new \DatePeriod(new \DateTime('2018-09-03'), $interval, new \DateTime('2018-09-05')),
            new \DatePeriod(new \DateTime('2018-09-07'), $interval, new \DateTime('2018-09-07')),
            new \DatePeriod(new \DateTime('2018-09-12'), $interval, new \DateTime('2018-09-14')),
        ];

        $this->assertEquals($expected, $actual);
    }
}
