<?php

namespace nastenka\data;

use nastenka\data\Uzivatel;
class Listecky extends \DB\Cortex
{
    protected $db = 'DB';
    protected $table = 'listecky';
    protected $primary = 'id';

    protected $fieldConf = [
        'text' => [
            'type' => 'VARCHAR256',
        ],
        'x' => [
            'type' => 'VARCHAR256',
            'nullable' => false,
        ],
        'y' => [
            'type' => 'VARCHAR256',
            'nullable' => false,
        ],
        'z' => [
            'type' => 'VARCHAR256',
            'nullable' => false,
        ],
        'stav' => [
            'type' => 'VARCHAR256',
            'nullable' => false,
        ],
        'barva' => [
            'type' => 'VARCHAR256',
            'nullable' => false,
            'default' => '#ffffff',
        ],
        'barva_textu' => [
            'type' => 'VARCHAR256',
            'nullable' => false,
            'default' => '#000000',
        ],
        'autor' => [
            'belongs-to-one' => 'nastenka\data\Uzivatel',
            'nullable' => false,
        ],
        'archiv' => [
            'type' => 'BOOLEAN',
            'nullable' => false,
            'default' => 0,
        ],
    ];
}