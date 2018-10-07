<?php

namespace Aeq\DateRange\Sorting;

interface SortingInterface
{
    public function sort(\DateTime $a, \DateTime $b): int;
}
