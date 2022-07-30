<?php

declare(strict_types=1);

namespace tr33m4n\Life;

use tr33m4n\Life\Rules\RuleInterface;

class Tick
{
    public function __construct(
        private readonly Render $render,
        private readonly RuleInterface $rule,
        private readonly float $tick = 0.7
    ) {
    }

    /**
     * @throws \tr33m4n\Life\Exception\GridException
     * @throws \tr33m4n\Life\Exception\OutOfBoundsException
     */
    public function execute(Grid $grid): void
    {
        foreach ($grid as $cell) {
            $this->rule->apply($cell, $this->getCellNeighbours($grid, $cell));
        }

        $this->render->grid($grid);

        usleep((int) $this->tick * 1000000);

        $this->render->clear();
    }

    /**
     * @throws \tr33m4n\Life\Exception\GridException
     * @throws \tr33m4n\Life\Exception\OutOfBoundsException
     * @return \tr33m4n\Life\Cell[]
     */
    private function getCellNeighbours(Grid $grid, Cell $cell): array
    {
        return array_map(
            static fn (array $coordinates): Cell => $grid->getCell(...$coordinates),
            $cell->getNeighbours()
        );
    }
}
