<?php

use Twig\TwigFunction;

$this->functions[] = $this->functionsToView('user', function() {
    return 'dados user';
});
