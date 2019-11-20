<?php


namespace Veezex\Medical\Models;


class Area extends Model
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->get('name');
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->get('short_name');
    }
}
