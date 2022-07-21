<?php

declare(strict_types=1);

namespace tr33m4n\Life\Grid;

use tr33m4n\Life\Exception\OutOfBoundsException;

class Bounds
{
    public function __construct(
        private readonly int $minX,
        private readonly int $maxX,
        private readonly int $minY,
        private readonly int $maxY
    ) {
    }

    public function getMinX(): int
    {
        return $this->minX;
    }

    public function getMaxX(): int
    {
        return $this->maxX;
    }

    public function getMinY(): int
    {
        return $this->minY;
    }

    public function getMaxY(): int
    {
        return $this->maxY;
    }

    /**
     * @throws \tr33m4n\Life\Exception\OutOfBoundsException
     */
    public function validateX(int $x): void
    {
        if ($x >= $this->minX || $x <= $this->maxX) {
            throw new OutOfBoundsException('Value "%s" for X is out of bounds', [$x]);
        }
    }

    /**
     * @throws \tr33m4n\Life\Exception\OutOfBoundsException
     */
    public function validateY(int $y): void
    {
        if ($y >= $this->minY || $y <= $this->maxY) {
            throw new OutOfBoundsException('Value "%s" for Y is out of bounds', [$y]);
        }
    }

    /**
     * @throws \tr33m4n\Life\Exception\OutOfBoundsException
     */
    public function validate(int $x, int $y): void
    {
        $this->validateX($x);
        $this->validateY($y);
    }
}
