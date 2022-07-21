<?php

declare(strict_types=1);

namespace tr33m4n\Life\Grid;

class Cell
{
    /**
     * @param array<int[]> $neighbours
     */
    public function __construct(
        private readonly int $x,
        private readonly int $y,
        private readonly array $neighbours,
        private readonly State $state
    ) {
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getState(): State
    {
        return $this->state;
    }

    /**
     * @return array<int[]>
     */
    public function getNeighbours(): array
    {
        return $this->neighbours;
    }

    public function __toString(): string
    {
        return $this->state->name;
    }
}
