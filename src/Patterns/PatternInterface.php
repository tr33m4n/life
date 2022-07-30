<?php

declare(strict_types=1);

namespace tr33m4n\Life\Patterns;

use tr33m4n\Life\Bounds;

interface PatternInterface
{
    /**
     * Get array of alive cell coordinates
     *
     * @return array<int[]>
     */
    public function coordinates(): array;

    /**
     * A pattern should define the size of the grid to display the alive cells
     *
     * @return \tr33m4n\Life\Bounds
     */
    public function bounds(): Bounds;
}
