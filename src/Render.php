<?php

declare(strict_types=1);

namespace tr33m4n\Life;

class Render
{
    private int $lines = 0;

    /**
     * @throws \tr33m4n\Life\Exception\GridException
     * @param \tr33m4n\Life\Grid $grid
     */
    public function grid(Grid $grid): void
    {
        foreach ($grid->getCells() as $column) {
            foreach ($column as $cell) {
                echo $cell->getState()->render();
            }

            $this->lines++;

            echo PHP_EOL;
        }

        $this->lines++;

        echo PHP_EOL;
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
