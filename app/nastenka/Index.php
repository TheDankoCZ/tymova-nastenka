<?php

namespace nastenka;

use nastenka\data\Listecky;
use nastenka\data\Uzivatel;
class Index
{
    public function index(\Base $base)
    {
        $base->set("title","Nástěnka");
        $base->set("content","nastenka.html");
        echo \Template::instance()->render("index.html");
    }

    public function get_novy_list(\Base $base)
    {
        $base->set("title","Nový lístek");
        $base->set("content","novy_list.html");
        echo \Template::instance()->render("index.html");
    }

    public function post_novy_list(\Base $base)
    {
        $listecek = new Listecky();
        //nemám přehled jak je udělaná SESSION tak to pak bude potřeba opravit
        $listecek->author = $base->get('SESSION.user[id]');
        $listecek->copyfrom($base->get("POST"));
        $listecek->save();
        $base->reroute('/');
    }
    public function get_upravit(\Base $base)
    {

    }
}