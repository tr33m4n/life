<?php

declare(strict_types=1);

namespace tr33m4n\Life;

class PlayGod
{
    /**
     * @throws \tr33m4n\Life\Exception\GridException
     * @throws \tr33m4n\Life\Exception\OutOfBoundsException
     */
    public function execute(Grid $grid): void
    {
        foreach ($grid as $cell) {
            foreach ($this->getCellNeighbours($grid, $cell) as $cellNeighbour) {
                $this->toggleCellState($cellNeighbour);
            }
        }
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

    private function toggleCellState(Cell $cell): void
    {
        $cell->setState($cell->getState() === State::DEAD ? State::ALIVE : State::DEAD);
    }
}
