<?php

declare(strict_types=1);

namespace tr33m4n\Life;

use tr33m4n\Life\Patterns\PatternInterface;
use tr33m4n\Life\Rules\DefaultRule;
use tr33m4n\Life\Rules\RuleInterface;

final class Config
{
    private ?Bounds $bounds = null;

    private ?Seed $seed = null;

    public function __construct(
        private readonly int $x,
        private readonly int $y,
        private readonly int $seedInit,
        private readonly ?PatternInterface $pattern = null,
        private ?RuleInterface $rule = null
    ) {
    }

    public function getBounds(): Bounds
    {
        if ($this->bounds instanceof Bounds) {
            return $this->bounds;
        }

        return $this->bounds = $this->pattern
            ? $this->pattern->bounds()
            : new Bounds(1, $this->x, 1, $this->y);
    }

    public function getSeed(): Seed
    {
        if ($this->seed instanceof Seed) {
            return $this->seed;
        }

        return $this->seed = new Seed(
            $this->getBounds(),
            $this->seedInit,
            $this->pattern ? $this->pattern->coordinates() : []
        );
    }

    public function getRule(): RuleInterface
    {
        if ($this->rule instanceof RuleInterface) {
            return $this->rule;
        }

        return $this->rule = new DefaultRule();
    }
}
