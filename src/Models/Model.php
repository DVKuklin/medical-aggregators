<?php


namespace Veezex\Medical\Models;


class Model
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Model constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
