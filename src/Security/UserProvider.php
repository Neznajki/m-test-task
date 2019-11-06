<?php declare(strict_types=1);

namespace App\Security;


use AuthorizationClient\AuthorizationClient;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class UserProvider
 * @package App\Security
 */
class UserProvider implements UserProviderInterface
{
    /** @var AuthorizationClient */
    protected $client;
    /** @var Request */
    protected $request;
    /** @var CacheItemPoolInterface */
    protected $cache;
    /** @var AuthHelper */
    protected $authHelper;

    /**
     * UserProvider constructor.
     * @param AuthorizationClient $client
     * @param Request $request
     * @param CacheItemPoolInterface $cache
     * @param AuthHelper $authHelper
     */
    public function __construct(
        AuthorizationClient $client,
        Request $request,
        CacheItemPoolInterface $cache,
        AuthHelper $authHelper
    ) {
        $this->client     = $client;
        $this->request    = $request;
        $this->cache      = $cache;
        $this->authHelper = $authHelper;
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws InvalidArgumentException
     */
    public function loadUserByUsername($username): UserInterface
    {
        return $this->getUserByToken();
    }

    /**
     * Refreshes the user.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @param UserInterface $user
     * @return UserInterface|User
     *
     * @throws InvalidArgumentException
     */
    public function refreshUser(UserInterface $user): User
    {
        return $this->getUserByToken();
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return true;
    }

    /**
     * @return string
     * @throws InvalidArgumentException
     */
    protected function getUserToken(): string
    {
        $session = $this->request->getSession();

        if ($session->has(AuthHelper::USER_TOKEN_PLACE)) {
            return $session->get(AuthHelper::USER_TOKEN_PLACE);
        }

        $sessionId = $session->getId();
        if ($this->authHelper->hasToken($sessionId)) {
            $session->set(AuthHelper::USER_TOKEN_PLACE, $this->authHelper->getToken($sessionId));
            $session->set(AuthHelper::AUTH_SESSION_ID_PLACE, $sessionId);
            $this->authHelper->cleanToken($sessionId);

            return $session->get(AuthHelper::USER_TOKEN_PLACE);
        }

        throw new UsernameNotFoundException('user is not authorized');
    }

    /**
     * @return User
     * @throws InvalidArgumentException
     */
    protected function getUserByToken(): User
    {
        $token          = $this->getUserToken();
        $clientResponse = $this->client->isAuthorizedLoginToken(
            $token,
            $this->request->getSession()->get(AuthHelper::AUTH_SESSION_ID_PLACE),
            $this->request
        );
        $responseResult = $clientResponse->getResult();

        if ($responseResult === null) {
            $this->request->getSession()->remove(AuthHelper::USER_TOKEN_PLACE);
            $this->request->getSession()->remove(AuthHelper::AUTH_SESSION_ID_PLACE);
            throw new UsernameNotFoundException($clientResponse->getErrorMessage(), $clientResponse->getErrorCode());
        }

        if (empty($responseResult['user'])) {
            throw new RuntimeException('isAuthorizedLoginToken response should have user index');
        }

        if (empty($responseResult['user']['userName'])) {
            throw new RuntimeException('isAuthorizedLoginToken response should have user.userName index');
        }

        $result = new User($token);
        $result->setUserName($responseResult['user']['userName']);

        return $result;
    }
}
