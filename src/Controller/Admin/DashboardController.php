<?php


namespace App\Controller\Admin;


use App\Entity\Contact;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class DashboardController extends AbstractController
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @Route("/dashboard", name="admin.dashboard")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {

        // length contact
        $entityContact = $this->getDoctrine()->getRepository(Contact::class);
        $lengthContact = $entityContact->count(array('done' => 0));

        // length User
        $entityUser = $this->getDoctrine()->getRepository(User::class);
        $lengthUser = $entityUser->lengthUser()[0][1];

        // lenght comments

        // length restaurant


        return $this->render('admin/dashboard/index.html.twig', [
            'lengthContact' => $lengthContact,
            'lengthUser' => $lengthUser,
            'current_menu' => 'dashboard'
        ]);
    }

}