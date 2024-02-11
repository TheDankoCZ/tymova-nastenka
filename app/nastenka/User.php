<?php

namespace nastenka;

use nastenka\data\Uzivatel;

class User
{
    //REGISTRACE

    public function get_registrace(\Base $base)
    {
        $base->set("title","Nástěnka - registrace");
        $base->set("content","user/registrace.html");
        echo \Template::instance()->render("index.html");
    }

    public function post_registrace(\base $base)
    {
        $user = new Uzivatel();
        $data = $base->get('POST');
        if (!$user->findone(array("email=?", $base->get("POST.email"))))
        {
            try {
                $user->copyfrom($data);
                $user->save();
                $this->fillUser($user);
                $base->reroute("/");
            }
            catch (\Exception $e)
            {
                $base->reroute("/registrace");
            }

        } else
        {
            $base->reroute("/registrace");
        }
    }


    //PŘIHLÁŠENÍ

    public function get_prihlaseni(\Base $base)
    {
        $base->set("title","Nástěnka - přihlášení");
        $base->set("content","user/prihlaseni.html");
        echo \Template::instance()->render("index.html");
    }

    public function post_prihlaseni(\Base $base)
    {
        $user = new Uzivatel();
        $base->clear('SESSION.user');
        $email = $base->get("POST.email");
        $user = $user->findone(["email = ?", $email]);
        if ($user)
        {
            if (password_verify($base->get("POST.heslo"), $user->heslo))
            {
                try
                {
                    $this->fillUser($user);
                    $base->reroute("/");
                }
                catch (\Exception $e)
                {
                    $base->reroute("/prihlaseni");
                }
            }
        }
        $base->reroute("/prihlaseni");
    }


    private function fillUser(Uzivatel $user)
    {
        $base = \Base::instance();
        $base->clear('SESSION.user');
        $base->set('SESSION.user["id"]', (string)$user->id);
        $base->set('SESSION.user["email"]', (string)$user->email);
        $base->set('SESSION.user["name"]', (string)$user->name);
        $base->set("SESSION.isLoggedIn", true);
    }

    public function get_odhlaseni(\Base $base)
    {
        $base->clear("SESSION.user");
        $base->clear("SESSION.isLoggedIn");
        $base->set("SESSION.isLoggedIn", false);
        $base->reroute("/");
    }
}