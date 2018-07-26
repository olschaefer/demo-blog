<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\BlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function listAction()
    {
        $repo = $this->get('doctrine')->getRepository(BlogPost::class);
        $posts = $repo->findAll();
        $serializer = $this->get('blog.service.blog_post_serializer');
        $posts = array_map(function(BlogPost $post) use ($serializer) {
            return $serializer->serializeShort($post);
        }, $posts);

        return new JsonResponse($posts);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $repo = $this->get('doctrine')->getRepository(BlogPost::class);
        $post = $repo->find($id);
        $serializer = $this->get('blog.service.blog_post_serializer');

        return new JsonResponse($serializer->serializeFull($post));
    }

    /**
     * showAction() is requested using GET verb, which means it cannot modify the state of the resource.
     * In order to be able to count page views a client will need this method.
     * @param int $id
     * @return Response
     */
    public function incrementViewsAction($id)
    {
        $repo = $this->get('doctrine')->getRepository(BlogPost::class);
        $post = $repo->find($id);
        $repo->incrementViews($post);

        return new Response();
    }
}