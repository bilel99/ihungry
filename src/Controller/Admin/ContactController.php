<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactController extends AbstractController
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @Route("/contact", name="admin.contact")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $entityContact = $this->getDoctrine()->getRepository(Contact::class);
        $contact = $entityContact->findAll();

        return $this->render('admin/contact/index.html.twig', [
            'current_menu' => 'contact',
            'contact' => $contact
        ]);
    }

    /**
     * @Route("/toggle-is-done/{id}", name="admin.contact.toggleIsDone", condition="request.isXmlHttpRequest()")
     * @param Request $request
     * @param Contact $contact
     * @return JsonResponse
     * @throws \Exception
     */
    public function toggleIsDone(Request $request, Contact $contact)
    {
        $em = $this->getDoctrine()->getManager();
        if ($contact->getDone() === true) {
            $contact->setDone(false);
        } else {
            $contact->setDone(true);
        }
        $em->persist($contact);
        $em->flush();

        // Ajax
        $message = $this->translator->trans('success-message');
        $isDone = $contact->getDone();
        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse();
            return $response->setData([
                'message' => $message,
                'isDone' => $isDone
            ]);
        } else {
            throw new \Exception($this->translator->trans('ajax.exceptionError'));
        }
    }
}