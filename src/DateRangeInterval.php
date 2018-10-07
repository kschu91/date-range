<?php

namespace Aeq\DateRange;

use Aeq\DateRange\Exception\NotADateTimeException;
use Aeq\DateRange\Filter\FilterInterface;
use Aeq\DateRange\Sorting\AscendingDateSorting;
use Aeq\DateRange\Sorting\SortingInterface;

class DateRangeInterval
{
    /**
     * @var \DateInterval
     */
    private $interval;

    /**
     * @var \DateTime[]
     */
    private $dates = [];

    /**
     * @var FilterInterface[]
     */
    private $filters = [];

    /**
     * @var SortingInterface
     */
    private $sorting;

    /**
     * @param \DateInterval $interval
     * @param \DateTime[] $dates
     */
    public function __construct(\DateInterval $interval, array $dates)
    {
        $this->interval = $interval;
        $this->dates = $dates;

        array_walk($this->dates, function ($dateTime) {
            if (false === $dateTime instanceof \DateTime) {
                throw new NotADateTimeException($dateTime, 1538864918);
            }
        });

        $this->sorting = new AscendingDateSorting();
    }

    /**
     * @return \DatePeriod[]
     */
    public function getDatePeriods(): array
    {
        $this->filter()->sort();
        $datePeriod = new \DatePeriod($this->getMin(), $this->getInterval(), $this->getMax());
        if (count($this->dates) === 1) {
            return [$datePeriod];
        }
        $ranges = [];
        $index = 0;
        $start = null;
        $end = null;
        foreach ($datePeriod as $date) {
            /** @var \DateTime $date */
            if (in_array($date, $this->dates)) {
                if (null === $start) {
                    $start = $date;
                }
            } else {
                if ($start instanceof \DateTime) {
                    $end = (clone $date)->sub($datePeriod->interval);
                    $ranges[$index] = new \DatePeriod($start, $this->getInterval(), $end);
                    $index++;
                    $start = null;
                }
            }
            /** @var \DateTime $last */
            $last = clone $datePeriod->end;
            if (null !== $start && $last->sub($datePeriod->interval) == $date) {
                $ranges[$index] = new \DatePeriod($start, $this->getInterval(), $last->add($datePeriod->interval));
            }
        }
        return $ranges;
    }

    /**
     * @return \DateInterval
     */
    public function getInterval(): \DateInterval
    {
        return $this->interval;
    }

    /**
     * @return \DateTime
     */
    public function getMin(): \DateTime
    {
        $copy = array_values($this->dates);
        return array_shift($copy);
    }

    /**
     * @return \DateTime
     */
    public function getMax(): \DateTime
    {
        $copy = array_values($this->dates);
        return array_pop($copy);
    }

    /**
     * @param FilterInterface $filter
     */
    public function addFilter(FilterInterface $filter): void
    {
        $this->filters[] = $filter;
    }

    /**
     * @param SortingInterface $sorting
     */
    public function setSorting(SortingInterface $sorting): void
    {
        $this->sorting = $sorting;
    }

    /**
     * @return DateRangeInterval
     */
    private function filter(): self
    {
        $this->dates = array_filter($this->dates, function ($date) {
            foreach ($this->filters as $filter) {
                if ($filter->filter($date)) {
                    return false;
                }
            }
            return true;
        });
        return $this;
    }

    /**
     * @return DateRangeInterval
     */
    private function sort(): self
    {
        usort($this->dates, [$this->sorting, 'sort']);
        return $this;
    }
}
