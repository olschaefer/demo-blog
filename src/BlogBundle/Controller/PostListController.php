<?php

namespace BlogBundle\Controller;

use BlogBundle\Service\BlogPostProvider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Renders paginated list of posts provided by BlogPostProvider.
 * @package BlogBundle\Controller
 */
class PostListController extends Controller
{
    /**
     * @var integer
     */
    private $postsPerPage;
    /**
     * @var string
     */
    private $paginationRoute;
    /**
     * @var string
     */
    private $detailPageRoute;
    /**
     * @var string
     */
    private $detailPageIdentifierField;
    /**
     * @var BlogPostProvider
     */
    private $blogPostProvider;

    /**
     * PostListController constructor.
     * @param int $postsPerPage
     * @param string $paginationRoute
     * @param string $detailPageRoute
     * @param string $detailPageIdentifierField
     * @param BlogPostProvider $blogPostProvider
     */
    public function __construct($postsPerPage, $paginationRoute, $detailPageRoute, $detailPageIdentifierField, BlogPostProvider $blogPostProvider)
    {
        $this->postsPerPage = $postsPerPage;
        $this->paginationRoute = $paginationRoute;
        $this->detailPageRoute = $detailPageRoute;
        $this->detailPageIdentifierField = $detailPageIdentifierField;
        $this->blogPostProvider = $blogPostProvider;
    }

    /**
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($page)
    {
        if ($page < 1) {
            throw new NotFoundHttpException();
        }

        $limit = $this->postsPerPage;
        $offset = ($page - 1) * $limit;

        $postCount = $this->blogPostProvider->getCount();
        $posts = $this->blogPostProvider->getPosts($offset, $limit);

        if ($posts->isEmpty() && $page !== 1) {
            throw new NotFoundHttpException();
        }

        return $this->render('@Blog/post_list.html.twig', [
            'posts' => $posts,
            'numPages' => ceil($postCount / $limit),
            'currentPage' => $page,
            'paginationRoute' => $this->paginationRoute,
            'detailPageRoute' => $this->detailPageRoute,
            'detailPageParamName' => $this->detailPageIdentifierField,
            'accessor' => new PropertyAccessor(),
        ]);
    }
}