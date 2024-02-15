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
            'type' => 'TEXT',
        ],
        'x' => [
            'type' => 'INT8',
            'nullable' => false,
        ],
        'y' => [
            'type' => 'INT8',
            'nullable' => false,
        ],
        'z' => [
            'type' => 'INT8',
            'nullable' => false,
        ],
        'stav' => [
            'type' => 'INT4',
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
        'pridano' => [
            'type' => 'VARCHAR256',
            'nullable' => false,
        ],
        'konec' => [
            'type' => 'VARCHAR256'
        ],
        'editovano' => [
            'type' => 'VARCHAR256'
        ],
    ];
}