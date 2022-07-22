<?php

declare(strict_types=1);

namespace tr33m4n\Life;

use tr33m4n\Life\Grid\Grid;

class Output
{
    /**
     * @throws \tr33m4n\Life\Exception\GridException
     */
    public function render(Grid $grid): void
    {
        foreach ($grid->getGrid() as $column) {
            foreach ($column as $cell) {
                echo $cell->getState()->render();
            }

            echo PHP_EOL;
        }
    }
}
