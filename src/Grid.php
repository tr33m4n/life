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
final class Grid implements IteratorAggregate
{
    /**
     * @var array<\tr33m4n\Life\Cell[]>
     */
    private array $grid = [];

    /**
     * Grid constructor.
     */
    public function __construct(
        private readonly Config $config,
        private readonly CellFactory $cellFactory
    ) {
        $this->init();
    }

    public function init(): void
    {
        $bounds = $this->config->getBounds();
        $seed = $this->config->getSeed();

        for ($y = $bounds->getMinY(); $y <= $bounds->getMaxY(); $y++) {
            for ($x = $bounds->getMinX(); $x <= $bounds->getMaxX(); $x++) {
                $this->grid[$y][$x] = $this->cellFactory->create(
                    $x,
                    $y,
                    $seed->isCellAlive($x, $y)
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
        $this->config->getBounds()->validate($x, $y);

        return $this->grid[$y][$x] ?? throw new GridException(
            'Grid cell at "%s,%s" does not exist',
            [$x, $y]
        );
    }

    /**
     * TODO: Replace this with iterator
     *
     * @throws \tr33m4n\Life\Exception\GridException
     * @return array<\tr33m4n\Life\Cell[]>
     */
    public function getCells(): array
    {
        if ([] === $this->grid) {
            throw new GridException('Grid has not been built');
        }

        return $this->grid;
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
