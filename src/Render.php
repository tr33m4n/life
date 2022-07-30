<?php

declare(strict_types=1);

namespace tr33m4n\Life;

class Render
{
    private int $lines = 0;

    /**
     * @throws \tr33m4n\Life\Exception\GridException
     */
    public function grid(Grid $grid): void
    {
        $cellStates = [];

        foreach ($grid->getCells() as $column) {
            foreach ($column as $cell) {
                $cellState = $cell->getState();

                $cellStates[] = $cellState;
                echo $cellState->render();
            }

            $this->lines++;

            echo PHP_EOL;
        }

        $this->lines++;

        echo PHP_EOL;

        $aliveCells = array_filter(
            $cellStates,
            static fn (State $state): bool => $state === State::ALIVE
        );

        $deadCells = array_filter(
            $cellStates,
            static fn (State $state): bool => $state === State::DEAD
        );

        $this->lines += 2;

        echo 'Alive cells: ' . count($aliveCells) . PHP_EOL;
        echo 'Dead cells: ' . count($deadCells) . PHP_EOL;
    }

    public function clear(): void
    {
        if (0 === $this->lines) {
            return;
        }

        echo chr(27) . '[0G';
        echo chr(27) . '[' . $this->lines . 'A';

        $this->lines = 0;
    }
}
