<?php

namespace App\Repositories\Abstracts;

/**
 * Class Repository
 * @package App\Repositories\Abstracts
 */
abstract class Repository
{
    /**
     * @var string
     */
    protected $key = 'key';

    /**
     * @var int
     */
    protected $time = 300;

    /**
     * Repository constructor.
     */
    public function __construct()
    {
        $this->key = auth_user()->dbConfig->base_dato;
    }
}
