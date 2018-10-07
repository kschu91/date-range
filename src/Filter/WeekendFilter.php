<?php

namespace Aeq\DateRange\Filter;

class WeekendFilter implements FilterInterface
{
    /**
     * @param \DateTime $dateTime
     * @return bool
     */
    public function filter(\DateTime $dateTime): bool
    {
        return date('N', $dateTime->getTimestamp()) >= 6;
    }
}
