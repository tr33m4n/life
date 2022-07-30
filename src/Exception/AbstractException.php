<?php

declare(strict_types=1);

namespace tr33m4n\Life\Exception;

use Exception;
use Throwable;

abstract class AbstractException extends Exception
{
    /**
     * AbstractException constructor.
     *
     * @param string[]|int[]  $replacements
     * @param \Throwable|null $throwable
     */
    public function __construct(
        string $message = '',
        array $replacements = [],
        int $code = 0,
        Throwable $throwable = null
    ) {
        parent::__construct(
            empty($replacements) ? $message : vsprintf($message, $replacements),
            $code,
            $throwable
        );
    }
}
