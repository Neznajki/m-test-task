<?php declare(strict_types=1);


namespace App\Contract;


interface ContentGatheringSupport
{

    /**
     * @return ContentIncludedEntity[]
     */
    public function getEntityWithContentList(): array;
}
