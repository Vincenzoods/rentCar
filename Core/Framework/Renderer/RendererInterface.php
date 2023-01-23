<?php

namespace core\Framework\Renderer;


interface RendererInterface
{

    public function addPath(string $namespace, ?string  $path = null): void;

    public function render(string $view, array $params = []): string;
}
