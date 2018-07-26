<?php

namespace BlogBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BlogExtension extends AbstractExtension
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * BlogExtension constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return array|\Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        $renderService = function($controller, $parameters = []) {
            list($serviceId, $method) = explode(':', $controller);

            $service = $this->container->get($serviceId);

            return call_user_func_array([$service, $method], $parameters)->getContent();
        };
        return [
            new TwigFunction('renderService', $renderService, ['is_safe' => ['html']]),
        ];
    }

}