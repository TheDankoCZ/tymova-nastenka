<?php

namespace nastenka\data;

class Uzivatel extends \DB\Cortex
{
    protected $db = 'DB';
    protected $table = 'uzivatel';
    protected $primary = 'id';

    protected $fieldConf = [
        'jmeno' => [
            'type' => 'VARCHAR256',
            'nullable' => false,
        ],
        'heslo' => [
            'type' => 'VARCHAR256',
            'nullable' => false,
        ],
        'dokument'=> [
            'has-many' => ['\nastenka\data\Listecky','autor'],
        ],
    ];
}