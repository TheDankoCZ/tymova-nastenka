<?php

namespace nastenka;

use nastenka\data\Listecky;
use nastenka\data\Uzivatel;

class  Install
{
    public function Install(\Base $base)
    {
        Uzivatel::setdown();
        Uzivatel::setup();

        Listecky::setdown();
        Listecky::setup();

        $base->reroute("/");
    }
}