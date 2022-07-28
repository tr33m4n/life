<?php

declare(strict_types=1);

namespace tr33m4n\Life;

class Seed
{
    /**
     * Seed constructor.
     *
     * @param array<int[]> $aliveCoordinates
     */
    public function __construct(
        private readonly Bounds $bounds,
        private readonly int $seed = 0,
        private array $aliveCoordinates = []
    ) {
    }

    public function isCellAlive(int $x, int $y): bool
    {
        if ([] === $this->aliveCoordinates) {
            mt_srand($this->seed);

            $this->generateAliveCoordinates();
        }

        return in_array([$x, $y], $this->aliveCoordinates);
    }

    /**
     * @return array<int[]>
     */
    private function generateAliveCoordinates(int $count = null): array
    {
        if (null === $count) {
            // Randomly pick number of alive cells that will be created within the bounds of the grid
            $count = mt_rand(
                $this->bounds->getMinY() * $this->bounds->getMinX(),
                $this->bounds->getMaxY() * $this->bounds->getMaxX(),
            );
        }

        while ($count > 0) {
            $xY = [
                mt_rand($this->bounds->getMinX(), $this->bounds->getMaxX()),
                mt_rand($this->bounds->getMinY(), $this->bounds->getMaxY())
            ];

            // If coordinates already exist, generate the seed again until a new value is found
            if (in_array($xY, $this->aliveCoordinates)) {
                return $this->generateAliveCoordinates($count);
            }

            $this->aliveCoordinates[] = $xY;

            $count--;
        }

        return $this->aliveCoordinates;
    }
}
