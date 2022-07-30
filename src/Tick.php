<?php

declare(strict_types=1);

namespace tr33m4n\Life;

class Tick
{
    public function __construct(
        private readonly Render $render,
    ) {
    }

    /**
     * @throws \tr33m4n\Life\Exception\GridException
     * @throws \tr33m4n\Life\Exception\OutOfBoundsException
     */
    public function execute(Grid $grid): void
    {
        foreach ($grid as $cell) {
            $livingNeighbours = count(
                array_filter(
                    $this->getCellNeighbours($grid, $cell),
                    static fn (Cell $cell): bool => $cell->getState() === State::ALIVE
                )
            );

            if ($cell->getState() === State::DEAD && $livingNeighbours === 3) {
                $cell->setState(State::ALIVE);
            } elseif ($cell->getState() === State::ALIVE && ($livingNeighbours === 2 || $livingNeighbours === 3)) {
                $cell->setState(State::ALIVE);
            } else {
                $cell->setState(State::DEAD);
            }
        }

        $this->render->grid($grid);

        sleep(1);

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
