<?php

declare(strict_types=1);

namespace tr33m4n\Life;

use IteratorAggregate;
use tr33m4n\Life\Exception\GridException;
use Traversable;

/**
 * Class Grid
 *
 * @implements IteratorAggregate<int, \tr33m4n\Life\Cell>
 * @package tr33m4n\Life
 */
class Grid implements IteratorAggregate
{
    /**
     * @var array<\tr33m4n\Life\Cell[]>
     */
    private array $grid = [];

    /**
     * Grid constructor.
     */
    public function __construct(
        private readonly Bounds $bounds,
        private readonly CellFactory $cellFactory,
        private readonly Seed $seed
    ) {
        $this->init();
    }

    public function init(): void
    {
        for ($y = $this->bounds->getMinY(); $y <= $this->bounds->getMaxY(); $y++) {
            for ($x = $this->bounds->getMinX(); $x <= $this->bounds->getMaxX(); $x++) {
                $this->grid[$y][$x] = $this->cellFactory->create(
                    $x,
                    $y,
                    $this->seed->isCellAlive($x, $y)
                        ? State::ALIVE
                        : State::DEAD
                );
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

    /**
     * Render grid
     *
     * @throws \tr33m4n\Life\Exception\GridException
     */
    public function render(): void
    {
        if ([] === $this->grid) {
            throw new GridException('Grid has not been built');
        }

        foreach ($this->grid as $column) {
            foreach ($column as $cell) {
                echo $cell->getState()->render();
            }

            echo PHP_EOL;
        }
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        foreach ($this->grid as $rowIndex => $column) {
            foreach ($column as $columnIndex => $cell) {
                /**
                 * Iterator index/key will be output as a number with the row index joined with the column index, eg.
                 * 00,
                 * 01,
                 * 02,
                 * 03,
                 * 10,
                 * 11,
                 * 12,
                 * 13
                 * etc...
                 */
                yield (int) ($rowIndex . $columnIndex) => $cell;
            }
        }
    }
}
