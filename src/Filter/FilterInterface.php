<?php

namespace Aeq\DateRange\Filter;

interface FilterInterface
{
    public function filter(\DateTime $dateTime): bool;
}
