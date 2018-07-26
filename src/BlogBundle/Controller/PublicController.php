<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PublicController extends Controller
{
    /**
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction($page)
    {
        return $this->render('@Blog/index.html.twig', [
            'page' => $page
        ]);
    }

    /**
     * @param $identifier
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($identifier)
    {
        $repo = $this->get('doctrine')->getRepository(BlogPost::class);
        $post = $repo->findOneBySlug($identifier);
        if (!$post) {
            throw new NotFoundHttpException();
        }

        $repo->incrementViews($post);

        return $this->render('@Blog/show.html.twig', [
            'post' => $post,
        ]);
    }
}
