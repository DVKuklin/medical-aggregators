<?php


namespace DVKuklin\Medical\Docdoc\Models;


class Slot extends Model
{
    protected $required = ['Id', 'StartTime', 'FinishTime'];

    /**
     * @return string
     */
    public function getSlotId(): string
    {
        return $this->get('Id');
    }

    /**
     * @return string
     */
    public function getStartTime(): string
    {
        return $this->get('StartTime');
    }

    /**
     * @return string
     */
    public function getFinishTime(): string
    {
        return $this->get('FinishTime');
    }
}
