<?php

namespace Aeq\DateRange\Filter;

use PHPUnit\Framework\TestCase;

class WeekendFilterTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnFalseIfMonday()
    {
        $filter = new WeekendFilter();
        $this->assertFalse($filter->filter(new \DateTime('2018-10-01')));
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfTuesday()
    {
        $filter = new WeekendFilter();
        $this->assertFalse($filter->filter(new \DateTime('2018-10-02')));
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfWednesday()
    {
        $filter = new WeekendFilter();
        $this->assertFalse($filter->filter(new \DateTime('2018-10-03')));
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfThursday()
    {
        $filter = new WeekendFilter();
        $this->assertFalse($filter->filter(new \DateTime('2018-10-04')));
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfFriday()
    {
        $filter = new WeekendFilter();
        $this->assertFalse($filter->filter(new \DateTime('2018-10-05')));
    }

    /**
     * @test
     */
    public function shouldReturnTrueIfSaturday()
    {
        $filter = new WeekendFilter();
        $this->assertTrue($filter->filter(new \DateTime('2018-10-06')));
    }

    /**
     * @test
     */
    public function shouldReturnTrueIfSunday()
    {
        $filter = new WeekendFilter();
        $this->assertTrue($filter->filter(new \DateTime('2018-10-07')));
    }
}
