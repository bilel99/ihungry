<?php
/**
 * Created by PhpStorm.
 * User: bilel
 * Date: 2019-04-01
 * Time: 19:21
 */

namespace App\Controller\Front;

use App\Entity\Restaurant;
use App\Entity\User;
use App\Entity\Ville;
use App\Form\RestaurantType;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RestaurantController extends AbstractController
{

    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @Route("/restaurant", name="restaurant.index")
     * @return Response
     */
    public function index(): Response
    {
        // All Restaurants
        $restaurants = $this->getDoctrine()->getRepository(Restaurant::class)
            ->getAll();

        // Average the note to restaurant
        $avg = $this->getDoctrine()->getRepository(Restaurant::class)
            ->averageNote();

        // Nbr Comments
        $countComments = $this->getDoctrine()->getRepository(Restaurant::class)
            ->countComments();


        return $this->render('front/restaurant/index.html.twig', [
            'restaurants' => $restaurants,
            'avg' => $avg[0],
            'nbrComments' => $countComments[0],
            'current_menu' => 'restaurant'
        ]);
    }

    /**
     * @Route("/create-restaurant", name="restaurant.create")
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function create(Request $request): Response
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ville = $this->getDoctrine()->getRepository(Ville::class)
                ->findBy(['libelle' => $form['libelleVille']->getData()]);
            $user = $this->getDoctrine()->getRepository(User::class)
                ->find($request->getSession()->get('USER')->getId());

            $em = $this->getDoctrine()->getManager();
            $restaurant->setCreatedAt(new DateTime());
            $restaurant->setVille($ville[0]);
            $restaurant->setUser($user);

            // Media
            foreach ($form['media']->getData() as $media) {
                $restaurant->addMedium($media);
            }

            $em->persist($restaurant);
            $em->flush();

            $this->addFlash('success', $this->translator->trans('success-message'));
            $this->redirectToRoute('restaurant.create');
        }

        return $this->render('front/restaurant/create.html.twig', [
            'form' => $form->createView(),
            'current_menu' => 'add-restaurant'
        ]);
    }

    /**
     * @Route("/getVilles/{libelleVille}", name="getVilles", methods={"GET"}, condition="request.isXmlHttpRequest()")
     * @param Request $request
     * @param $libelleVille
     * @return JsonResponse
     * @throws Exception
     */
    public function returnCity(Request $request, $libelleVille)
    {
        // AJAX
        if ($request->isXmlHttpRequest()) {
            $entityVille = $this->getDoctrine()->getRepository(Ville::class);
            $v = $entityVille->searchByField($libelleVille);

            $ville = [];

            if ($v) {
                foreach ($v as $key => $item) {
                    $ville = $item->getLibelle();
                }
            } else {
                $ville = null;
            }

            $response = new JsonResponse();
            return $response->setData([
                'libelle_ville' => $ville
            ]);
        } else {
            throw new \Exception($this->translator->trans('ajax.exceptionError'));
        }
    }


}