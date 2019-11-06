<?php declare(strict_types=1);


namespace App\Controller;


use App\Security\AuthHelper;
use Psr\Cache\InvalidArgumentException;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorizationController extends AbstractController
{
    /** @var AuthHelper */
    protected $authHelper;

    /**
     * AuthorizationController constructor.
     * @param AuthHelper $authHelper
     */
    public function __construct(AuthHelper $authHelper)
    {
        $this->authHelper = $authHelper;
    }

    /**
     * @Route("/provide/token/{sessionId}/{token}", name="app_login")
     * @param $sessionId
     * @param $token
     * @return Response
     * @throws InvalidArgumentException
     */
    public function provideToken(string $sessionId, string $token): Response
    {
        $this->authHelper->saveToken($sessionId, $token);

        return new Response('OK');
    }

    /**
     * @Route("/login", name="app_check_login")
     * @return Response
     */
    public function actLogin(): Response
    {
        return new RedirectResponse('/');
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new RuntimeException('should not reach here');
    }
}
