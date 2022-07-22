<?php

declare(strict_types=1);

namespace tr33m4n\Life\Grid;

use tr33m4n\Life\Exception\GridException;

class Grid
{
    /**
     * @var array<\tr33m4n\Life\Grid\Cell[]>
     */
    private array $grid = [];

    /**
     * Grid constructor.
     */
    public function __construct(
        private readonly Bounds $bounds,
        private readonly CellFactory $cellFactory,
        private readonly int $seed = 0
    ) {
        $this->init();
    }

    public function init(): void
    {
        mt_srand($this->seed);

        $aliveCells = $this->seedAliveCells();

        for ($y = $this->bounds->getMinY(); $y <= $this->bounds->getMaxY(); $y++) {
            for ($x = $this->bounds->getMinX(); $x <= $this->bounds->getMaxX(); $x++) {
                $this->grid[$y][$x] = $this->cellFactory->create(
                    $x,
                    $y,
                    in_array([$x, $y], $aliveCells)
                        ? State::ALIVE
                        : State::DEAD
                );
            }
        }
    }

    /**
     * @param array<int[]> $aliveCells
     * @return array<int[]>
     */
    public function seedAliveCells(array $aliveCells = [], int $cellCount = null): array
    {
        if (null === $cellCount) {
            // Randomly pick number of alive cells that will be created within the bounds of the grid
            $cellCount = mt_rand(
                $this->bounds->getMinY() * $this->bounds->getMinX(),
                $this->bounds->getMaxY() * $this->bounds->getMaxX(),
            );
        }

        while ($cellCount > 0) {
            $coordinates = [
                mt_rand($this->bounds->getMinX(), $this->bounds->getMaxX()),
                mt_rand($this->bounds->getMinY(), $this->bounds->getMaxY())
            ];

            // If coordinates already exist, generate the seed again until a new value is found
            if (in_array($coordinates, $aliveCells)) {
                return $this->seedAliveCells($aliveCells, $cellCount);
            }

            $aliveCells[] = $coordinates;

            $cellCount--;
        }

        return $aliveCells;
    }

    /**
     * @throws \tr33m4n\Life\Exception\GridException
     * @throws \tr33m4n\Life\Exception\OutOfBoundsException
     */
    public function getCell(int $x, int $y): Cell
    {
        $this->bounds->validate($x, $y);

        return $this->grid[$y][$x] ?? throw new GridException(
            'Grid cell at "%s,%s" does not exist',
            [$x, $y]
        );
    }

    /**
     * @throws \tr33m4n\Life\Exception\GridException
     * @throws \tr33m4n\Life\Exception\OutOfBoundsException
     * @return \tr33m4n\Life\Grid\Cell[]
     */
    public function getCellNeighbours(Cell $cell): array
    {
        return array_map(
            fn (array $coordinates): Cell => $this->getCell(...$coordinates),
            $cell->getNeighbours()
        );
    }

    /**
     * @throws \tr33m4n\Life\Exception\GridException
     * @return array<\tr33m4n\Life\Grid\Cell[]>
     */
    public function getGrid(): array
    {
        if ([] === $this->grid) {
            throw new GridException('Grid has not been built');
        }

        return $this->grid;
    }
}
