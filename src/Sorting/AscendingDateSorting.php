<?php

namespace Aeq\DateRange\Sorting;

class AscendingDateSorting implements SortingInterface
{
    /**
     * @param \DateTime $a
     * @param \DateTime $b
     * @return int
     */
    public function sort(\DateTime $a, \DateTime $b): int
    {
        return $a->getTimestamp() - $b->getTimestamp();
    }
}
