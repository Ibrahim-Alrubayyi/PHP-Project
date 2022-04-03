<?php
class Service
{

    public $availbe = false;

    public function __construct()
    {
        $this->availbe = true;
    }

    public function __destruct()
    {

    }
    public static function all()
    {
        return [
            ['name' => 'Counsulation', 'price' => 500, 'days' => ['Sun', 'Mon']],
            ['name' => 'Trsing', 'price' => 33, 'days' => ['Sun', 'Mon']],
            ['name' => 'Design', 'price' => 78, 'days' => ['Sun', 'Mon']],
            ['name' => 'Coding', 'price' => 232, 'days' => ['Sun', 'Mon']],
        ];

    }
    public function price($price)
    {
        if ($this->taxRate > 0) {
            return $price + ($price * $this->taxRate);
        }
        return $price;
    }
}