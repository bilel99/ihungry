<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Notification\RegistrationNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'current_menu' => 'login'
        ]);
    }

    /**
     * @Route("/registration", name="security.registration")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param RegistrationNotification $notification
     * @return Response
     * @throws \Exception
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder, RegistrationNotification $notification): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setCreatedAt(new \DateTime());
            $user->setRoles($user::ROLE_USER);
            $user->setSecretpass(sha1($form['secretpass']->getData()));
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $em->persist($user);
            $em->flush();

            // Send mailer
            $notification->notify($user);
            $this->addFlash('success', $this->translator->trans('register.success'));
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
            'current_menu' => 'registration'
        ]);
    }

    /**
     * @route("/logout", name="security_logout")
     * the framework use the empty function logout()
     */
    public function logout()
    {
    }
}
