<?php

namespace Gcd\Scaffold\Payments\Logic\Entities;

trait CastableEntityTrait
{
    public static function castFromObject($object):self
    {
        return self::castFromArray(get_object_vars($object));
    }

    public static function castFromArray($array):self
    {
        $entity = new self();

        foreach($array as $key => $value){
            $entity->$key = $value;
        }

        return $entity;
    }
}