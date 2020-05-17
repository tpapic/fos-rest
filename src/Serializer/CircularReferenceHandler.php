<?php
/**
 * Created by PhpStorm.
 * User: tomislavpapic
 * Date: 22/04/2020
 * Time: 01:00
 */

namespace App\Serializer;


class CircularReferenceHandler
{
    public function __invoke($object)
    {
        return $object->getId();
    }
}