<?php
/**
 * Created by PhpStorm.
 * User: bilel
 * Date: 2019-04-01
 * Time: 19:21
 */

namespace App\Controller\Front;

use App\Entity\Comments;
use App\Entity\Notes;
use App\Entity\Restaurant;
use App\Entity\User;
use App\Entity\Ville;
use App\Form\CommentType;
use App\Form\NoteRestaurantType;
use App\Form\RestaurantType;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;


class ByRestaurantsController extends AbstractController
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
     * @Route("/restaurant/{id}", name="restaurant.show")
     * @param Restaurant $restaurant
     * @param Request $request
     * @return Response
     */
    public function show(Restaurant $restaurant, Request $request)
    {
        $restaurant = $this->getDoctrine()->getRepository(Restaurant::class)
            ->getRestaurant($restaurant->getId());

        $user = $this->getDoctrine()->getRepository(User::class)
            ->find($request->getSession()->get('USER')->getId());

        // Notes
        $notes = new Notes();
        $form_note = $this->createForm(NoteRestaurantType::class, $notes);
        $form_note->handleRequest($request);
        if ($form_note->isSubmitted() && $form_note->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $notes->setRestaurant($restaurant[0]);
            $notes->setUser($user);

            $em->persist($notes);
            $em->flush();

            $this->addFlash('success', $this->translator->trans('success-message'));
            return $this->redirectToRoute('restaurant.show', ['id' => $restaurant[0]->getId()]);
        }

        // Comments
        $comments = new Comments();
        $form = $this->createForm(CommentType::class, $comments);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $comments->setUser($user);
            $comments->setRestaurant($restaurant[0]);

            $em->persist($comments);
            $em->flush();

            $this->addFlash('success', $this->translator->trans('success-message'));
            return $this->redirectToRoute('restaurant.show', ['id' => $restaurant[0]->getId()]);
        }

        $lengthComments = $this->getDoctrine()->getRepository(Comments::class)
            ->findBy(['restaurant' => $restaurant[0]->getId()]);

        $avg = $this->getDoctrine()->getRepository(Restaurant::class)
            ->averageNote();

        $request_is_comment = $this->getDoctrine()->getRepository(Notes::class)
            ->isCommentRestaurant($user);
        if (count($request_is_comment) > 0)
            $is_comment = true;
        else
            $is_comment = false;

        return $this->render('front/restaurant/show.html.twig', [
            'restaurant' => $restaurant,
            'current_menu' => 'restaurant',
            'form_note' => $form_note->createView(),
            'form' => $form->createView(),
            'is_comment' => $is_comment,
            'lengthComments' => $lengthComments,
            'avg' => $avg[0]['avg_note']
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

    /**
     * @Route("/restaurant/fav/{id}", name="addToFavRestaurant")
     * @param Request $request
     * @param Restaurant $restaurant
     * @return void
     */
    public function addToFav(Request $request, Restaurant $restaurant)
    {
        $restaurant = $this->getDoctrine()->getRepository(Restaurant::class)
            ->getRestaurant($restaurant->getId());

        // Add to Cookies
        $response = new Response();
        $cookie = new Cookie('fav_rest', $restaurant[0]->getId(), time() + ( 2 * 365 * 24 * 60 * 60), '/', 'http://localhost:8000', 'true', 'true');
        $response->headers->setCookie($cookie);
        $response->send();
        return $this->redirectToRoute('restaurant.show', ['id' => $restaurant[0]->getId()]);
    }

}