<?php

declare(strict_types=1);

namespace tr33m4n\Life\Rules;

use tr33m4n\Life\Cell;

interface RuleInterface
{
    /**
     * @param \tr33m4n\Life\Cell[] $cellNeighbours
     */
    public function apply(Cell $cell, array $cellNeighbours = []): void;
}
