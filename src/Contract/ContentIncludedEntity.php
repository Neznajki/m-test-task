<?php declare(strict_types=1);


namespace App\Contract;


use App\Entity\ExternalId;

interface ContentIncludedEntity
{

    /**
     * @return string
     */
    public function getContent(): string;

    /**
     * @return ExternalId
     */
    public function getExternal(): ExternalId;

    /**
     * @return string
     */
    public function getPlaceName(): string;
}
