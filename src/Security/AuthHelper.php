<?php declare(strict_types=1);


namespace App\Security;


use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

class AuthHelper
{
    const USER_TOKEN_PLACE = 'userAuthToken';
    const AUTH_SESSION_ID_PLACE = '_sessionUsedForAuth';

    /** @var CacheItemPoolInterface */
    protected $cache;

    /**
     * AuthHelper constructor.
     * @param CacheItemPoolInterface $cache
     */
    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param string $targetSessionId
     * @param string $authToken
     * @throws InvalidArgumentException
     */
    public function saveToken(string $targetSessionId, string $authToken): void
    {
        $this->cache->save($this->cache->getItem($targetSessionId)->set($authToken));
    }

    /**
     * @param string $targetSessionId
     * @return bool
     * @throws InvalidArgumentException
     */
    public function hasToken(string $targetSessionId): bool
    {
        return $this->cache->hasItem($targetSessionId);
    }

    /**
     * @param string $targetSessionId
     * @return string
     * @throws InvalidArgumentException
     */
    public function getToken(string $targetSessionId): string
    {
        return $this->cache->getItem($targetSessionId)->get();
    }

    /**
     * @param string $sessionId
     * @throws InvalidArgumentException
     */
    public function cleanToken(string $sessionId)
    {
        $this->cache->deleteItem($sessionId);
    }
}
