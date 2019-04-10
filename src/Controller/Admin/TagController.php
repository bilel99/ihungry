<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Form\TagType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @IsGranted("ROLE_ADMIN", statusCode=403, message="Access denied")
 * Class TagController
 * @package App\Controller\Admin
 */
class TagController extends AbstractController
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @Route("/admin/tag", name="admin.tag")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request): Response
    {
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $tag->setCreatedAt(new \DateTime());
            $em->persist($tag);
            $em->flush();
            $this->addFlash('success', $this->translator->trans('success-message'));
            $this->redirectToRoute('admin.tag');
        }

        $entityTag = $this->getDoctrine()->getRepository(Tag::class);
        $tag = $entityTag->findAll();

        return $this->render('admin/tag/index.html.twig', [
            'current_menu' => 'tag',
            'tag' => $tag,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/tag/delete-tag/{id}", name="admin.tag.delete", condition="request.isXmlHttpRequest()")
     * @param Request $request
     * @param Tag $tag
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Request $request, Tag $tag)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($tag);
        $em->flush();

        // Ajax
        $message = $this->translator->trans('success-message');
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