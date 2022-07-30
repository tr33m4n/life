<?php

declare(strict_types=1);

namespace tr33m4n\Life\Rules;

use tr33m4n\Life\Cell;
use tr33m4n\Life\State;

final class DefaultRule implements RuleInterface
{
    /**
     * @inheritDoc
     */
    public function apply(Cell $cell, array $cellNeighbours = []): void
    {
        $livingNeighbours = count(
            array_filter(
                $cellNeighbours,
                static fn (Cell $cell): bool => $cell->getState() === State::ALIVE
            )
        );

        if ($cell->getState() === State::DEAD && $livingNeighbours === 3) {
            $cell->setState(State::ALIVE);
        } elseif ($cell->getState() === State::ALIVE && in_array($livingNeighbours, [2, 3])) {
            $cell->setState(State::ALIVE);
        } else {
            $cell->setState(State::DEAD);
        }
    }
}
