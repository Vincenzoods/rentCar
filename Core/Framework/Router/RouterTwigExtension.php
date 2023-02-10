<?php

namespace Core\Framework\Router;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class RouterTwigExtension extends AbstractExtension
{
    private Router $router;
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getFunctions(){
        return [
            new TwigFunction('path', [$this, 'path'])
        ];
    }



    public function path(string $name, array $params= [] ): string{
        return $this->router->generateUri($name, $params);
    }
}
