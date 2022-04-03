<?php

class Product extends Service
{

    public static function all()
    {
        return [
            ['name' => 'Phone', 'price' => 500],
            ['name' => 'Mouse', 'price' => 50],
            ['name' => 'keubprd', 'price' => 33],
            ['name' => 'mousbad', 'price' => 321],
        ];
    }

}