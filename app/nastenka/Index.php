<?php

namespace nastenka;

use nastenka\data\Listecky;
use nastenka\data\Uzivatel;

class Index
{
    public function index(\Base $base)
    {
        $base->set("title", "Nástěnka");
        $base->set("content", "nastenka.html");
        $base->set("SESSION.verejna", 0);

        $uzivatel_id = $base->get('SESSION.user["id"]');

        if ($uzivatel_id) {
            $listecky = new Listecky;
            $data = $listecky->find(['archiv=? AND autor=? AND verejny=?', 0, $uzivatel_id, 0]);
            if ($data) {
                foreach ($data as $key => $value) {
                    $data[$key]->text = nl2br(str_replace("\\n", "\\n", htmlspecialchars($value->text, ENT_QUOTES, 'UTF-8')));
                }
                $base->set("data", $data);
            } else {
                $base->set("data", null);
            }

        } else {
            $base->set("SESSION.isLoggedIn", false);
            $base->set("data", null);
        }

        echo \Template::instance()->render("index.html");
    }

    public function novy_listecek(\Base $base)
    {
        $listecek = new Listecky();
        $listecek->autor = $base->get('SESSION.user["id"]');
        $listecek->pridano = date("d.m.Y H:i");
        $listecek->editovano = $listecek->pridano;
        $listecek->x = 50;
        $listecek->y = 100;
        $listecek->z = 1000;
        $listecek->barva = "#ffffff";
        $listecek->barva_textu = "#000000";
        $listecek->text = "";
        $listecek->stav = 1;
        $listecek->verejny = $base->get('SESSION.verejna');
        $listecek->save();
        echo json_encode(array("x" => 50, "y" => 100, "z" => 1000, "barva" => "#ffffff", "barva_textu" => "#000000", "text" => "", "id" => $listecek->id, "editovano" => $listecek->editovano, "pridano" => $listecek->pridano, "stav" => 1));
    }

    public function get_ziskej_text(\Base $base)
    {
        $list = new Listecky();
        $listecek = $list->findone(["id=?", $base->get('PARAMS.id')]);
        $formated = str_replace("\\n", "\n", $listecek->text);
        echo json_encode($formated);
    }

    public function post_zmena_textu(\Base $base)
    {
        // Get the raw JSON data from the request body
        $json = file_get_contents('php://input');

        // Decode the JSON data into an associative array
        $data = json_decode($json, true);
        $data['text'] = str_replace(["\r\n", "\r", "\n"], "\\n", $data['text']);

        $list = new Listecky();
        $listecek = $list->findone(["id=?", $data['id']]);
        $listecek->text = $data['text'];
        $listecek->editovano = date("d.m.Y H:i");
        $listecek->save();
    }

    public function post_zmena_stavu(\Base $base)
    {
        // Get the raw JSON data from the request body
        $json = file_get_contents('php://input');

        // Decode the JSON data into an associative array
        $data = json_decode($json, true);

        $list = new Listecky();
        $listecek = $list->findone(["id=?", $data['id']]);
        $listecek->stav = $data['stav'];
        $listecek->save();
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
        $listecek->z = $data['z'];
        $listecek->save();
    }

    public function post_zmena_z(\Base $base)
    {
        // Get the raw JSON data from the request body
        $json = file_get_contents('php://input');

        // Decode the JSON data into an associative array
        $data = json_decode($json, true);

        $list = new Listecky();
        $listecek = $list->findone(["id=?", $data['id']]);
        $listecek->z = $data['z'];
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

    public function post_odebrat(\Base $base)
    {
        $json = file_get_contents('php://input');

        // Decode the JSON data into an associative array
        $data = json_decode($json, true);

        $list = new Listecky();
        $listecek = $list->findone(["id=?", $data['id']]);
        $listecek->archiv = 1;
        $listecek->konec = date("d.m.Y H:i");
        $listecek->save();
    }

    public function get_archiv(\Base $base)
    {
        if (!$base->get('SESSION.user')) {
            $base->reroute('/');
        }
        $base->set("title", "Nástěnka");
        $base->set("content", "archiv.html");
        $uzivatel_id = $base->get('SESSION.user["id"]');
        $listecky = new Listecky;
        $data = $listecky->find(['archiv=? AND autor=?', 1, $uzivatel_id]);

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

    public function verejna(\Base $base)
    {
        $base->set("title", "Veřejná Nástěnka");
        $base->set("content", "nastenka.html");
        $base->set("SESSION.verejna", 1);

        $uzivatel_id = $base->get('SESSION.user["id"]');

        if ($uzivatel_id) {
            $listecky = new Listecky;
            $data = $listecky->find(['archiv=? AND verejny=?', 0, 1]);
            if ($data) {
                foreach ($data as $key => $value) {
                    $data[$key]->text = nl2br(str_replace("\\n", "\\n", htmlspecialchars($value->text, ENT_QUOTES, 'UTF-8')));
                }
                $base->set("data", $data);
            } else {
                $base->set("data", null);
            }

        } else {
            $base->set("SESSION.isLoggedIn", false);
            $base->set("data", null);
        }

        echo \Template::instance()->render("index.html");
    }

    public function zverejnit(\Base $base)
    {
        $json = file_get_contents('php://input');

        // Decode the JSON data into an associative array
        $data = json_decode($json, true);

        $list = new Listecky();
        $listecek = $list->findone(["id=?", $data['id']]);
        if ($listecek->verejny == 1)
        {
            $listecek->verejny = 0;
        }else{
            $listecek->verejny = 1;
        }
        $listecek->save();
    }
}