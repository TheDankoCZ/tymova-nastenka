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
        $listecek->autor = 1;
        $listecek->copyfrom($base->get("POST"));
        $listecek->save();
        $base->reroute('/');
    }
    public function post_zmena_pozice(\Base $base)
    {
        // Get the raw JSON data from the request body
        $json = file_get_contents('php://input');

        // Decode the JSON data into an associative array
        $data = json_decode($json, true);

        $list = new Listecky();
        $listecek = $list->findone(["id=?", $data['id']]);
        $listecek->x = $data['x'];
        $listecek->y = $data['y'];
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