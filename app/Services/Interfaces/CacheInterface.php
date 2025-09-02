<?php

namespace App\Services\Interfaces;

interface CacheInterface
{
    public function getItem($key);

    public function getItems(array $keys = array());

    public function hasItem($key);

    public static function clear();

    public static function deleteItem($key);

    public static function deleteItems(array $keys);

    public static function save($item, $key, $time);

    public function commit();
}
