<?php

namespace App\Controller\Front;

use App\Entity\Contact;
use App\Entity\Faq;
use App\Form\ContactType;
use App\Form\FaqType;
use App\Notification\ContactNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('front/home/index.html.twig', [
            'current_menu' => 'accueil'
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param ContactNotification $notification
     * @return Response
     * @throws \Exception
     */
    public function contact(Request $request, ContactNotification $notification): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $contact->setDone(false);
            $contact->setCreatedAt(new \DateTime());
            $em->persist($contact);
            $em->flush();

            // send mail
            $notification->notify($contact);
            $this->addFlash('success', $this->translator->trans('contact.success'));
        }

        $faq = new Faq();
        $faqForm = $this->createForm(FaqType::class, $faq);
        $faqForm->handleRequest($request);

        if ($faqForm->isSubmitted() && $faqForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $question = $faqForm['question']->getData();
            if (substr($question, -1) != '?') {
                $faq->setQuestion($question . ' ?');
            }
            $faq->setAnswer($this->translator->trans('faq.answer'));
            $faq->setDone(false);
            $faq->setCreatedAt(new \DateTime());
            $em->persist($faq);
            $em->flush();
            $this->addFlash('success', $this->translator->trans('submit.faq.success'));
        }

        // Get FAQ
        $entityFaq = $this->getDoctrine()->getRepository(Faq::class);
        $faq = $entityFaq->findAll();

        return $this->render('front/contact/index.html.twig', [
            'form' => $form->createView(),
            'faqForm' => $faqForm->createView(),
            'faq' => $faq,
            'current_menu' => 'contact'
        ]);
    }

}