<?php

namespace nastenka;

use nastenka\data\Uzivatel;
use nastenka\data\Listecky;
class Install
{
    public function instal(\Base $base)
    {
        Uzivatel::setdown();
        Uzivatel::setup();

        Listecky::setdown();
        Listecky::setup();



        $base->reroute('/');
    }
}