<?php

namespace App\Services\Contracts;

interface CacheInterface
{
    public function getItem($key);

    public function getItems(array $keys = array());

    public function hasItem($key);

    public function clear();

    public function deleteItem($key);

    public function deleteItems(array $keys);

    public function save($item, $key, $time);

    public function commit();
}
