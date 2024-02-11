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

        //$uzivatel_id = $base->get('SESSION.user[id]');
        $uzivatel_id = 1;
        $listecky = new Listecky;
        $data = $listecky->find(['autor=?',$uzivatel_id]);

        $base->set("data", $data);

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
        //$listecek->author = $base->get('SESSION.user[id]');
        $listecek->author = 1;
        $listecek->copyfrom($base->get("POST"));
        $listecek->save();
        $base->reroute('/');
    }
    public function post_zmena_pozice(\Base $base)
    {
        //ok Evidentně neumím pracovat s JSON
        //TODO Nevím jak na to tak se na to pls někdo mrkněte, konzole tvrdí že data to posílá správný
        $list = new Listecky();
        $listecek = $list->load(["id=?",$base->get('POST.id')]);
        $listecek->x = $base->get('POST.x');
        $listecek->y = $base->get('POST.y');
        $listecek->save();
    }
    public function get_upravit(\Base $base)
    {
        $base->set("title","Nový lístek");
        $base->set("content","upravit_list.html");
        $listecek = new Listecky();
        $data = $listecek->findone(["id=?",$base->get('PARAMS.id')]);
        $base->set("data", $data);
        echo \Template::instance()->render("index.html");
    }

    public function post_upravit(\Base $base)
    {
        $listecek = new Listecky();
        $listecek->load(['id=?', $base->get('PARAMS.id')]);
        $listecek->copyfrom($base->get("POST"));
        $listecek->save();
        $base->reroute('/');
    }
}