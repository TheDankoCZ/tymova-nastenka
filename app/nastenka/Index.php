<?php

namespace nastenka;

class Index
{
    public function index(\Base $base)
    {
        $base->set("content","");
        echo \Template::instance()->render("index.html");
    }
}