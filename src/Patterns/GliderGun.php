<?php

declare(strict_types=1);

namespace tr33m4n\Life\Patterns;

use tr33m4n\Life\Bounds;

class GliderGun implements PatternInterface
{
    /**
     * @inheritDoc
     */
    public function coordinates(): array
    {
        return [
            [2, 6],
            [3, 6],
            [2, 7],
            [3, 7], // 1st object
            [12, 6],
            [12, 7],
            [12, 8],
            [13, 5],
            [13, 9],
            [14, 4],
            [14, 10],
            [15, 4],
            [15, 10],
            [16, 7],
            [17, 5],
            [17, 9],
            [18, 6],
            [18, 7],
            [18, 8],
            [19, 7], // 2nd object
            [22, 4],
            [22, 5],
            [22, 6],
            [23, 4],
            [23, 5],
            [23, 6],
            [24, 3],
            [24, 7],
            [26, 2],
            [26, 3],
            [26, 7],
            [26, 8], // 3rd object
            [36, 4],
            [36, 5],
            [37, 4],
            [37, 5] // 4th object
        ];
    }

    /**
     * @inheritDoc
     */
    public function bounds(): Bounds
    {
        return new Bounds(1, 38, 1, 76);
    }
}
