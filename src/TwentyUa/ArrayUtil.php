<?php


namespace TwentyUa;

use Symfony\Component\PropertyAccess\PropertyAccess;

class ArrayUtil
{
    public static function isTraversable($object)
    {
        return is_array($object) || $object instanceof \Traversable;
    }

    public static function getColumn($array, $path)
    {
        $result = array();

        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($array as $item) {
            $result[] = $propertyAccessor->getValue($item, $path);
        }

        return $result;
    }

    public static function removeKey(array& $array, $key)
    {
        if (!isset($array[$key])) {
            return null;
        }
        $value = $array[$key];
        unset($array[$key]);

        return $value;
    }


    public static function indexBy($array, $keyPath)
    {
        $result = array();
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($array as $item) {
            $key = $propertyAccessor->getValue($item, $keyPath);
            $result[$key] = $item;
        }

        return $result;
    }

    public static function getValue($object, $path, $default = null)
    {
        $value = PropertyAccess::createPropertyAccessor()
            ->getValue($object, $path);

        return $value === null ? $default : $value;
    }

    public static function toArray($value)
    {
        if (is_array($value)) {
            return $value;
        }

        return [$value];
    }

    public static function groupBy($array, $path)
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $result = array();
        foreach ($array as $item) {
            $key = $propertyAccessor->getValue($item, $path);
            $result[$key][] = $item;
        }

        return $result;
    }
}