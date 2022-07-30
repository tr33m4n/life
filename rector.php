<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->import(SetList::DEAD_CODE);
    $rectorConfig->import(SetList::NAMING);
    $rectorConfig->import(SetList::EARLY_RETURN);
    $rectorConfig->import(SetList::CODE_QUALITY);
    $rectorConfig->import(SetList::PRIVATIZATION);
    $rectorConfig->import(SetList::TYPE_DECLARATION);
    $rectorConfig->import(SetList::TYPE_DECLARATION_STRICT);
    $rectorConfig->import(SetList::PHP_81);

    $rectorConfig->paths([__DIR__ . '/src']);
    $rectorConfig->skip([
        RenameForeachValueVariableToMatchExprVariableRector::class => [
            __DIR__ . '/src/Tick.php',
            __DIR__ . '/src/Render.php'
        ],
        RenameVariableToMatchMethodCallReturnTypeRector::class => [
            __DIR__ . '/src/Grid.php'
        ]
    ]);
};
