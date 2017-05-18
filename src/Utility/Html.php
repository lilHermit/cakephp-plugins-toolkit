<?php

namespace LilHermit\Toolkit\Utility;

use Cake\Utility\Hash;

/**
 * Html Utility class
 */
class Html
{
    /**
     * Adds a class and returns a unique list either in array or space separated
     *
     * ### Options
     *
     * - `useIndex` if you are inputting an array with an 'element' other than 'class'.
     *              Also setting to 'false' will manipulate the whole array (default is 'class')
     * - `asString` Setting this to `true` will return a space separated string (default is `false`)
     *
     * @param array|string $input    The array or string to add the class to
     * @param array|string $newClass the new class or classes to add
     * @param array        $options  See above for options
     *
     * @return array|string
    */
    public static function addClass($input, $newClass, $options = [])
    {
        // NOOP
        if (empty($newClass)) {
            return $input;
        }

        $options += [
            'useIndex' => 'class',
            'asString' => false
        ];

        $useIndex = $options['useIndex'];
        if (is_string($useIndex) && is_array($input)) {
            $class = Hash::get($input, $useIndex, []);
        } else {
            $class = $input;
        }

        // Convert and sanitise the inputs
        if (!is_array($class)) {
            if (is_string($class) && !empty($class)) {
                $class = explode(' ', $class);
            } else {
                $class = [];
            }
        }

        if (is_string($newClass)) {
            $newClass = explode(' ', $newClass);
        }

        $class = array_unique(array_merge($class, $newClass));

        if ($options['asString'] === true) {
            $class = implode(' ', $class);
        }

        if (is_string($useIndex)) {
            if (!is_array($input)) {
                $input = [];
            }
            $input = Hash::insert($input, $useIndex, $class);
        } else {
            $input = $class;
        }

        return $input;
    }

    /**
     * Checks if a class is contained within the input
     *
     * ### Options
     *
     * - `useIndex` if you are inputting an array with an 'element' other than 'class'.
     *              Also setting to 'false' will manipulate the whole array (default is 'class')
     * - `Or` perform an OR rather than AND on multiple $containsClass
     *
     * @param array|string $input        The array or string to add the class to
     * @param array|string $containClass the new class or classes to add
     * @param array        $options      See above for options
     *
     * @return boolean
     */
    public static function containsClass($input, $containClass, $options = [])
    {
        // NOOP
        if (empty($containClass)) {
            return false;
        }

        $options += [
            'useIndex' => 'class',
            'or' => false
        ];

        $useIndex = $options['useIndex'];
        if (is_string($useIndex) && is_array($input)) {
            $haystack = Hash::get($input, $useIndex, []);
        } else {
            $haystack = $input;
        }

        // Convert and sanitise the inputs
        if (!is_array($haystack)) {
            if (is_string($haystack) && !empty($haystack)) {
                $haystack = explode(' ', $haystack);
            } else {
                $haystack = [];
            }
        }

        if (is_string($containClass)) {
            $containClass = explode(' ', $containClass);
        }

        $results = [];
        foreach ($containClass as $item) {
            $results[] = in_array($item, $haystack);
        }

        return $options['or'] ? in_array(true, $results) : !in_array(false, $results);
    }
}