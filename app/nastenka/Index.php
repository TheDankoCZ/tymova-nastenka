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

        $uzivatel_id = $base->get('SESSION.user["id"]');

        if ($uzivatel_id)
        {
            $listecky = new Listecky;
            $data = $listecky->find(['archiv=? AND autor=?',0,$uzivatel_id]);
            $base->set("data", $data);
        }
        else
        {
            $base->set("data", null);
        }

        echo \Template::instance()->render("index.html");
    }

    public function get_novy_list(\Base $base)
    {
        if($base->get('SESSION.user'))
        {
            $base->set("title","Nový lístek");
            $base->set("content","novy_list.html");
            echo \Template::instance()->render("index.html");
        }else{
            $base->reroute('/prihlaseni');
        }
    }

    public function post_novy_list(\Base $base)
    {
        $listecek = new Listecky();
        $listecek->autor = $base->get('SESSION.user["id"]');
        $listecek->copyfrom($base->get("POST"));
        $listecek->pridatno = date("d.m.Y H:i");
        $konec = date("d.m.Y H:i", strtotime($base->get('POST.konec')));
        $listecek->konec = $konec;
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

    public function post_zmena_barvy(\Base $base)
    {
        // Get the raw JSON data from the request body
        $json = file_get_contents('php://input');

        // Decode the JSON data into an associative array
        $data = json_decode($json, true);

        $list = new Listecky();
        $listecek = $list->findone(["id=?", $data['id']]);
        $listecek->barva = $data['barva'];
        $listecek->barva_textu = $data['barva_textu'];
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
    public function post_odebrat(\Base $base)
    {
        $json = file_get_contents('php://input');

        // Decode the JSON data into an associative array
        $data = json_decode($json, true);

        $list = new Listecky();
        $listecek = $list->findone(["id=?", $data['id']]);
        $listecek->archiv = 1;
        $listecek->save();

    }

    public function get_archiv(\Base $base)
    {
        $base->set("title","Nástěnka");
        $base->set("content","archiv.html");
        $uzivatel_id = $base->get('SESSION.user["id"]');
        $listecky = new Listecky;
        $data = $listecky->find(['archiv=? AND autor=?',1,$uzivatel_id]);

        $base->set("data", $data);

        echo \Template::instance()->render("index.html");
    }

    public function get_obnovit(\Base $base)
    {
        $list = new Listecky();
        $listecek = $list->findone(["id=?", $base->get('PARAMS.id')]);
        $listecek->archiv = 0;
        $listecek->save();
        $base->reroute('/archiv');

    }
    public function get_smazat(\Base $base)
    {
        $list = new Listecky();
        $listecek = $list->findone(["id=?", $base->get('PARAMS.id')]);
        $listecek->erase();
        $base->reroute('/archiv');

    }
}