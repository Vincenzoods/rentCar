<?php

namespace Core\Framework\Renderer;

class PHPRenderer implements RendererInterface
{
    const DEFAULT_NAMESPACE = "__MAIN";
    private array $paths = [];

    private array $globals = [];
    public function addPath(string $namespace, ?string $path = null): void
    {
        if (is_null($path)) {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        } else {
            $this->paths[$namespace] = $path;
        }
    }
    //$renderer ->render('@blog/addVehicule')
    //$renderer ->render('header')
    //$renderer ->render('test',['name'=> 'Cedric'])
    public function render(string $view, array $params = []): string
    {
        if ($this->hasNamespace($view)) {
            $path = $this->replaceNamespace($view) . '.php';
        } else {
            $path = $this->paths[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . $view . '.php';
        }
        ob_start();
        extract($this->globals);
        extract($params);
        require($path);
        // mettre en pause l'execution
        return ob_get_clean();
    }
    private function hasNamespace(string $view): bool
    {
        return $view[0] === '@';
    }
    private function replaceNamespace(string $view): string
    {
        $namespace = substr($view, 1, strpos($view, '/') - 1);
        $str = str_replace('@' . $namespace, $this->paths[$namespace], $view);
        return str_replace('/', '\\', $str);
    }
    public function addGlobal(string $key, $value): void
    {
        $this->globals[$key] = $value;
    }
}
