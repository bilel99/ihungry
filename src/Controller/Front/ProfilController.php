<?php

namespace App\Controller\Front;

use App\Entity\User;
use App\Form\ProfilType;
use App\Notification\UpdateSecretPassNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProfilController extends AbstractController
{
    private $translator;
    private $session;

    public function __construct(TranslatorInterface $translator, SessionInterface $session)
    {
        $this->translator = $translator;
        $this->session = $session;
    }

    /**
     * @Route("/profil/{id}", name="profil", methods={"GET", "POST"})
     * @param User $user
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @throws \Exception
     */
    public function index(User $user, Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(ProfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            // Update session User
            $this->get('session')->set('_security_main', $user);

            $message = $this->translator->trans('profil.success');
            if ($request->isXmlHttpRequest()) {
                $response = new JsonResponse();
                return $response->setData([
                    'message' => $message
                ]);
            } else {
                throw new \Exception($this->translator->trans('ajax.exceptionError'));
            }
        }

        return $this->render('front/profil/index.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'current_menu' => 'profil'
        ]);
    }

    /**
     * @Route("/update-password/{id}", name="profil.updatePassword")
     * @param Request $request
     * @param User $user
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     * @throws \Exception
     */
    public function updatePassword(Request $request, User $user, UserPasswordEncoderInterface $encoder)
    {
        $secretPassword = sha1($request->request->get('secretpass'));
        $isValid = $request->request->get('password') == $request->request->get('confirmPassword');
        $isValidSecretPass = $secretPassword == $user->getSecretpass();
        if ($isValid && $isValidSecretPass) {
            $em = $this->getDoctrine()->getManager();
            $validator = true;
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
            $em->persist($user);
            $em->flush();
            // Update session User
            $this->get('session')->set('_security_main', $user);
            $message = $this->translator->trans('profil.update.password.success');
        } else {
            $validator = false;
            $message = $this->translator->trans('no.equals.password.or.secretpass.undefined');
        }

        // AJAX
        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse();
            return $response->setData([
                'message' => $message,
                'validator' => $validator
            ]);
        } else {
            throw new \Exception($this->translator->trans('ajax.exceptionError'));
        }
    }

    /**
     * @Route("/update-secretpass/{id}", name="profil.updateSecretpass")
     * @param Request $request
     * @param User $user
     * @param UpdateSecretPassNotification $notification
     * @return JsonResponse
     * @throws \Exception
     */
    public function updateSecretpass(Request $request, User $user, UpdateSecretPassNotification $notification)
    {
        $secretPass = $request->request->get('secretPass');
        $confSecretPass = $request->request->get('confirm_secretpass');
        $isValid = $secretPass == $confSecretPass;
        if ($isValid) {
            // Send email for confirmation, return params getter
            $notification->notify($user, $secretPass);
            $validator = true;
            $message = 'Un mail de confirmation vous à été envoyer à votre adresse mail, merci de confirmer votre changement de mot secret';
        } else {
            $validator = false;
            $message = $this->translator->trans('field.not.equals');
        }

        // AJAX
        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse();
            return $response->setData([
                'message' => $message,
                'validator' => $validator
            ]);
        } else {
            throw new \Exception($this->translator->trans('ajax.exceptionError'));
        }
    }

    /**
     * @Route("/confirm-update-secretpass/{id}/{secretpass}", name="profil.update-confirm-secretpass")
     * @param Request $request
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateConfirmPassword(Request $request, User $user): Response
    {
        // Get Url and explode url per '/', and get the end element in table[]
        $url = $request->getUri();
        $table = explode('/', $url);
        $secretpass = end($table);

        // Save the new secret pass and hash sha1 algorithm
        $em = $this->getDoctrine()->getManager();
        $user->setSecretpass(sha1($secretpass));
        $em->persist($user);
        $em->flush();
        $message = $this->translator->trans('success-message');
        $this->addFlash('success', $message);
        return $this->redirectToRoute('profil', ['id' => $user->getId()]);
    }

    /**
     * @Route("/request-ajax-profil/{id}", name="profil.refresh", condition="request.isXmlHttpRequest()", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function profilRefresh(Request $request)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($request->attributes->get('id'));

        // AJAX
        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse();
            return $response->setData([
                'isActive' => $user->getIsActive(),
            ]);
        } else {
            throw new \Exception($this->translator->trans('ajax.exceptionError'));
        }
    }

    /**
     * @Route("/profil-disable/{id}", name="profil.disable", condition="request.isXmlHttpRequest()")
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws \Exception
     */
    public function disableAccount(Request $request, User $user)
    {
        $user->setIsActive(false);
        $this->getDoctrine()->getManager()->flush();

        // AJAX
        $message = $this->translator->trans('profil.disable.success');
        $redirectTo = $this->generateUrl('security_logout');
        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse();
            return $response->setData([
                'message' => $message,
                'redirectTo' => $redirectTo
            ]);
        } else {
            throw new \Exception($this->translator->trans('ajax.exceptionError'));
        }
    }

    /**
     * @Route("/profil-enable/{id}", name="profil.enable", condition="request.isXmlHttpRequest()")
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws \Exception
     */
    public function enableAccount(Request $request, User $user)
    {
        $user->setIsActive(true);
        $this->getDoctrine()->getManager()->flush();

        // AJAX
        $message = $this->translator->trans('profil.account.enable');
        $redirectTo = $this->generateUrl('profil', ['id' => $user->getId()]);
        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse();
            return $response->setData([
                'message' => $message,
                'redirectTo' => $redirectTo
            ]);
        } else {
            throw new \Exception($this->translator->trans('ajax.exceptionError'));
        }
    }

    /**
     * @Route("/delete-account/{id}", name="profil.delete", condition="request.isXmlHttpRequest()")
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteAccount(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        // AJAX
        $message = $this->translator->trans('profil.delete.success');
        $redirectTo = $this->generateUrl('security_logout');
        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse();
            return $response->setData([
                'message' => $message,
                'redirectTo' => $redirectTo,
            ]);
        } else {
            throw new \Exception($this->translator->trans('ajax.exceptionError'));
        }
    }

}