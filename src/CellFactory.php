<?php

declare(strict_types=1);

namespace tr33m4n\Life;

use tr33m4n\Life\Exception\OutOfBoundsException;

final class CellFactory
{
    public function __construct(
        private readonly Bounds $bounds
    ) {
    }

    public function create(int $x, int $y, State $state): Cell
    {
        return new Cell($x, $y, $this->calculateNeighbourCoordinates($x, $y), $state);
    }

    /**
     * @return array<int[]>
     */
    private function calculateNeighbourCoordinates(int $x, int $y): array
    {
        $possibleNeighbours = [];
        // Possible columns to the left, middle and right of the cell
        foreach ([$x - 1, $x, $x + 1] as $possibleX) {
            // Possible rows to the top, middle and bottom of the cell
            foreach ([$y - 1, $y, $y + 1] as $possibleY) {
                // No "middle column, middle row" as that's this new cell's own coordinates
                if ($possibleX === $x && $possibleY === $y) {
                    continue;
                }

                $possibleNeighbours[] = [$possibleX, $possibleY];
            }
        }

        return array_filter(
            $possibleNeighbours,
            function (array $coordinates): bool {
                try {
                    // Filter any coordinates that are out of bounds
                    $this->bounds->validate(...$coordinates);
                } catch (OutOfBoundsException) {
                    return false;
                }

                return true;
            }
        );
    }
}
