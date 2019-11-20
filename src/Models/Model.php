<?php


namespace Veezex\Medical\Models;


use InvalidArgumentException;

class Model
{
    protected $required = [];

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
        $required = $this->required;
        $required[] = 'id';

        foreach ($required as $key) {
            if (!array_key_exists($key, $data)) {
                throw new InvalidArgumentException("Missing required field: $key");
            }
        }

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
