<?php

namespace App\Controller\Admin;

use App\Entity\Restaurant;
use App\Entity\User;
use App\Entity\Ville;
use App\Form\AdminRestaurantType;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RestaurantsController extends AbstractController
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @Route("/admin/restaurant", name="admin.restaurant")
     * @return Response
     */
    public function index(): Response
    {
        $restaurants = $this->getDoctrine()->getRepository(Restaurant::class)
            ->findAll();
        return $this->render('admin/restaurant/index.html.twig', [
            'restaurants' => $restaurants,
            'current_menu' => 'restaurant'
        ]);
    }

    /**
     * @Route("/admin/create-restaurant", name="admin.create-restaurant")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(AdminRestaurantType::class, $restaurant);
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
            return $this->redirectToRoute('admin.restaurant');
        }

        return $this->render('admin/restaurant/create.html.twig', [
            'current_menu' => 'restaurant',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/restaurant/{id}", name="admin.show-restaurant")
     * @param Restaurant $restaurant
     * @return Response
     */
    public function show(Restaurant $restaurant)
    {
        $restaurant = $this->getDoctrine()->getRepository(Restaurant::class)
            ->getRestaurant($restaurant->getId());
        return $this->render('admin/restaurant/show.html.twig', [
            'current_menu' => 'restaurant',
            'restaurant' => $restaurant
        ]);
    }

    /**
     * @Route("/admin/edit-restaurant/{id}", name="admin.edit-restaurant")
     * @param Request $request
     * @param Restaurant $restaurant
     * @return Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $form = $this->createForm(AdminRestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ville = $this->getDoctrine()->getRepository(Ville::class)
                ->findBy(['libelle' => $form['libelleVille']->getData()]);

            $em = $this->getDoctrine()->getManager();
            $restaurant->setVille($ville[0]);

            // Media
            foreach ($form['media']->getData() as $media) {
                $restaurant->addMedium($media);
            }

            $em->persist($restaurant);
            $em->flush();

            $this->addFlash('success', $this->translator->trans('success-message'));
            return $this->redirectToRoute('admin.restaurant');
        }

        return $this->render('admin/restaurant/edit.html.twig', [
            'current_menu' => 'restaurant',
            'restaurant' => $restaurant,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/delete-restaurant/{id}", name="admin.delete-restaurant")
     * @param Restaurant $restaurant
     * @return RedirectResponse
     */
    public function destroy(Restaurant $restaurant)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($restaurant);
        $em->flush();

        $this->addFlash('success', $this->translator->trans('success-message'));
        return $this->redirectToRoute('admin.restaurant');
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