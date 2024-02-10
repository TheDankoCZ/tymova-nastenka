<?php

namespace nastenka;

class Index
{
    public function index(\Base $base)
    {
        $base->set("title","Nástěnka");
        $base->set("content","nastenka.html");
        echo \Template::instance()->render("index.html");
    }
}