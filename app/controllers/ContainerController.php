<?php 

namespace app\controllers;

use app\traits\TView;

// Container onde serão guardados recursos base para todos os outros controllers
abstract class ContainerController {
    use TView;
}