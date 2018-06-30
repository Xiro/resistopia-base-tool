<?php


namespace app\components;


class SpeedTest
{

    public $start;
    public $name;

    public function start($name = null)
    {
        $this->start = microtime(true);
        $this->name = $name;
    }

    public function stop($repeats = 1)
    {
        $time = (microtime(true) - $this->start) / $repeats;
        echo '<pre>';
        echo print_r(array(
            $this->name,
            "EXECUTION TIME:",
            $time,
        ));
        echo '</pre>';
    }

}