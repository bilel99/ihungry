<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class CategoryController extends AbstractController
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @Route("/category", name="admin.category")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request): Response
    {
        $category = new Categories();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $category->setCreatedAt(new \DateTime());
            $em->persist($category);
            $em->flush();

            $message = $this->translator->trans('success-message');
            // Ajax
            if ($request->isXmlHttpRequest()) {
                $response = new JsonResponse();
                return $response->setData([
                    'message' => $message
                ]);
            } else {
                throw new \Exception($this->translator->trans('ajax.exceptionError'));
            }
        }

        // List categories
        $entityCategory = $this->getDoctrine()->getRepository(Categories::class);
        $categories = $entityCategory->findAll();

        return $this->render('admin/category/index.html.twig', [
            'current_menu' => 'category',
            'categories' => $categories,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit-category/{id}", name="admin.edit.category")
     * @param Request $request
     * @param Categories $categories
     * @return JsonResponse
     * @throws \Exception
     */
    public function edit(Request $request, Categories $categories): Response
    {
        // save
        $em = $this->getDoctrine()->getManager();
        $categories->setTitle($request->request->get('category_title_' . $categories->getId()));
        $em->persist($categories);
        $em->flush();

        // select title from categories where 'id' = :id
        $title = $categories->getTitle();

        // message
        $message = $this->translator->trans('success-message');

        // Ajax
        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse();
            return $response->setData([
                'message' => $message,
                'title' => $title
            ]);
        } else {
            throw new \Exception($this->translator->trans('ajax.exceptionError'));
        }
    }

    /**
     * @Route("/delete-category/{id}", name="admin.category.delete", condition="request.isXmlHttpRequest()")
     * @param Request $request
     * @param Categories $categories
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Request $request, Categories $categories)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($categories);
        $em->flush();

        // Ajax
        $message = $this->translator->trans('delete-message');
        if ($request->isXmlHttpRequest()) {
            $response = new JsonResponse();
            return $response->setData([
                'message' => $message
            ]);
        } else {
            throw new \Exception($this->translator->trans('ajax.exceptionError'));
        }
    }


}