<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\Cast\RecastingRemovalRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfReturnToEarlyReturnRector;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayParamDocTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector;
use Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector;

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
};
