<?php declare(strict_types=1);

namespace App\Security;


use App\Service\RegistryService;
use AuthorizationClient\AuthorizationClient;
use Psr\Cache\InvalidArgumentException;
use RuntimeException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AuthorizationModuleLogin extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    /** @var Kernel */
    protected $kernel;
    /** @var RouterInterface */
    protected $router;
    /** @var AuthorizationClient */
    protected $authorizationClient;
    /** @var RegistryService */
    protected $registryService;
    /** @var UserProviderInterface */
    protected $authHelper;

    /**
     * LoginFormAuthenticator constructor.
     * @param Kernel $kernel
     * @param RouterInterface $router
     * @param AuthorizationClient $authorizationClient
     * @param RegistryService $registryService
     * @param AuthHelper $authHelper
     */
    public function __construct(
        Kernel $kernel,
        RouterInterface $router,
        AuthorizationClient $authorizationClient,
        RegistryService $registryService,
        AuthHelper $authHelper
    ) {
        $this->kernel              = $kernel;
        $this->router              = $router;
        $this->authorizationClient = $authorizationClient;
        $this->registryService     = $registryService;
        $this->authHelper          = $authHelper;
    }

    public function supports(Request $request)
    {
        return 'app_check_login' === $request->attributes->get('_route');
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'login'      => $request->request->get('login'),
            'password'   => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['login']
        );

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername('you know 😉');
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return $this->getSuccessLoginPage();
    }

    /**
     * Override to control what happens when the user hits a secure page
     * but isn't logged in yet.
     *
     * @param Request $request
     * @param AuthenticationException|null $authException
     * @return RedirectResponse
     * @throws InvalidArgumentException
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        if ($this->authHelper->hasToken($request->getSession()->getId())) {
            return new RedirectResponse($this->router->generate('app_check_login'));
        }

        $authServiceResponse = $this->authorizationClient->getLoginPage(
            sprintf('%s/provide/token', $this->registryService->getServerGuiUri()),
            sprintf('%s/%s', $this->registryService->getServerGuiUri(), rtrim($request->getRequestUri(), '/')),
            $request->getSession()->getId(),
            $request
        );

        $result = $authServiceResponse->getResult();
        if ($result === null) {
            throw new RuntimeException(
                $authServiceResponse->getErrorMessage(),
                $authServiceResponse->getErrorCode()
            );
        }

        return new RedirectResponse($result['url']);
    }

    /**
     * @return RedirectResponse
     */
    public function getSuccessLoginPage(): RedirectResponse
    {
        return new RedirectResponse($this->router->generate('index'));
    }

    protected function getLoginUrl()
    {
        throw new AuthenticationException('user not authorized');
    }
}
