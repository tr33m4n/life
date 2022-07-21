<?php

declare(strict_types=1);

namespace tr33m4n\Life\Grid;

use tr33m4n\Life\Exception\GridException;

class Grid
{
    /**
     * @var array<int, \tr33m4n\Life\Grid\Cell[]>
     */
    private array $grid = [];

    /**
     * Grid constructor.
     */
    public function __construct(
        private readonly Bounds $bounds,
        private readonly CellFactory $cellFactory
    ) {
    }

    public function build(): void
    {
        for ($y = $this->bounds->getMinY(); $y <= $this->bounds->getMaxY(); $y++) {
            for ($x = $this->bounds->getMinX(); $x <= $this->bounds->getMaxX(); $x++) {
                $this->grid[$y][$x] = $this->cellFactory->create($x, $y, State::DEAD);
            }
        }
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

    public function getCellNeighbours(Cell $cell): array
    {
        return array_map(
            fn (array $coordinates): Cell => $this->getCell(...$coordinates),
            $cell->getNeighbours()
        );
    }

    /**
     * @throws \tr33m4n\Life\Exception\GridException
     * @return array<string[]>
     */
    public function toArray(): array
    {
        if ([] === $this->grid) {
            throw new GridException('Grid has not been built');
        }

        $output = [];
        foreach ($this->grid as $y => $column) {
            /** @var \tr33m4n\Life\Grid\Cell $cell */
            foreach ($column as $x => $cell) {
                $output[$y][$x] = (string) $cell;
            }
        }

        return $output;
    }
}
