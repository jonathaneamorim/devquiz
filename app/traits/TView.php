<?php

namespace app\traits;

use core\Twig;

// 
trait TView{

    protected function twig() {
        $twigEngine = new Twig; // instancia da classe twig interna do projeto | nao da biblioteca twig
        $twig = $twigEngine->loadTwig();
        $twigEngine->loadExtensions();
        $twigEngine->loadFunctions();
        return $twig;
    }

    public function view($data, $view) {
        $template = $this->twig()->load(str_replace('.','/', $view).'.html');
        return $template->display($data);
    }
}