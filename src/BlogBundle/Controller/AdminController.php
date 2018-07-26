<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\BlogPost;
use BlogBundle\Form\BlogPostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminController extends Controller
{
    /**
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction($page)
    {
        return $this->render('@Blog/admin_index.html.twig', [
            'page' => $page
        ]);
    }

    /**
     * @param Request $request
     * @param int $identifier
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $identifier = null)
    {
        if ($identifier) {
            $repo = $this->get('doctrine')->getRepository(BlogPost::class);
            $post = $repo->find($identifier);
            if (!$post) {
                throw new NotFoundHttpException();
            }
        } else {
            $post = new BlogPost();
        }

        $form = $this->createForm(BlogPostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $refresh = (bool) $post->getId();

            $em = $this->get('doctrine')->getManager();
            $em->persist($form->getData());
            $em->flush();

            if ($refresh) {
                return $this->redirect($request->getUri());
            } else {
                return $this->redirectToRoute('blog_admin_edit', ['identifier' => $post->getId()]);
            }
        }

        return $this->render('@Blog/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}