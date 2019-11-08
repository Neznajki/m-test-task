<?php declare(strict_types=1);


namespace App\Contract;


use App\Entity\ExternalId;

interface ContentIncludedEntity
{

    /**
     * @return string
     */
    public function getContent(): string;

    public function getExternal(): ExternalId;
}
