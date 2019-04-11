<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @IsGranted("ROLE_ADMIN", statusCode=403, message="Access denied")
 * Class UserController
 * @package App\Controller\Admin
 */
class UserController extends AbstractController
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @Route("/admin/user", name="admin.user")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $entity_user = $this->getDoctrine()->getRepository(User::class);
        $user = $entity_user->findAll();

        return $this->render('admin/user/index.html.twig', [
            'current_menu' => 'user',
            'user' => $user
        ]);
    }

    /**
     * @Route("/admin/user/toggle-is-active/{id}", name="admin.user.toggleIsActive", condition="request.isXmlHttpRequest()")
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws \Exception
     */
    public function toggleIsActive(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        if ($user->getIsActive() === true) {
            $user->setIsActive(false);
        } else {
            $user->setIsActive(true);
        }
        $em->persist($user);
        $em->flush();

        // Ajax
        $message = $this->translator->trans('success-message');
        $isActive = $user->getIsActive();
        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse();
            return $response->setData([
                'message' => $message,
                'isActive' => $isActive
            ]);
        } else {
            throw new \Exception($this->translator->trans('ajax.exceptionError'));
        }
    }

    /**
     * @Route("/admin/user/change-role/{id}", name="admin.user.changerole", condition="request.isXmlHttpRequest()")
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws \Exception
     */
    public function changeRole(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();

        if ($user->getRoles()[0] == 'ROLE_USER') {
            $user->setRoles(User::ROLE_ADMIN);
        } else {
            $user->setRoles(User::ROLE_USER);
        }

        $em->persist($user);
        $em->flush();

        // Ajax
        $message = $this->translator->trans('success-message');
        $redirectTo = $this->generateUrl('admin.dashboard');

        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse();
            return $response->setData([
                'is_role' => $user->getRoles()[0],
                'message' => $message,
                'redirectTo' => $redirectTo
            ]);
        } else {
            throw new \Exception($this->translator->trans('ajax.exceptionError'));
        }
    }

}