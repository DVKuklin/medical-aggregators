<?php


namespace Veezex\Medical\Models;


class Model
{
    /**
     * @var array
     */
    private $data;

    /**
     * Model constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->get('id');
    }

    /**
     * @param string $dataKey
     * @return mixed
     */
    protected function get(string $dataKey)
    {
        return $this->data[$dataKey];
    }
}
