<?php

declare(strict_types=1);

namespace tr33m4n\Life\Grid;

enum State: int
{
    case ALIVE = 1;

    case DEAD = 0;

    /**
     * Render state
     *
     * @return string
     */
    public function render(): string
    {
        return match ($this) {
            State::ALIVE => '███',
            State::DEAD => ' '
        };
    }
}
