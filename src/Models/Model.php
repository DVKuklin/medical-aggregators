<?php


namespace Veezex\Medical\Models;


use Illuminate\Support\Arr;
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
        foreach ($this->required as $key) {
            if (!Arr::has($data, $key)) {
                throw new InvalidArgumentException("Missing required field: \"$key\"");
            }
        }

        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->get('Id');
    }

    /**
     * @param string $dataKey
     * @param null $default
     * @return mixed
     */
    protected function get(string $dataKey, $default = null)
    {
        return Arr::get($this->data, $dataKey, $default);
    }
}
