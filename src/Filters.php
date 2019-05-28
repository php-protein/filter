<?php declare(strict_types=1);

/**
 * Filters
 *
 * Class trait for permitting users to override data via callback hooks.
 *
 * @package Proteins
 * @author  "Stefano Azzolini"  <lastguest@gmail.com>
 */

namespace Proteins;

trait Filters {
    protected static $_modders = [];

    final public static function filter($names, callable $modder = null) {
        if (null === $modder) {
            foreach ((array)$names as $name => $callback) {
                static::$_modders[$name][] = $callback;
            }
        } else {
            foreach ((array)$names as $name) {
                static::$_modders[$name][] = $modder;
            }
        }
    }

    final public static function filterSingle($name, callable $modder) {
        static::$_modders[$name] = [$modder];
    }

    final public static function filterRemove($name, callable $modder = null) {
        if (null === $modder) {
            unset(static::$_modders[$name]);
        } else {
            if ($idx = array_search($modder, static::$_modders[$name], true)) {
                unset(static::$_modders[$name][$idx]);
            }
        }
    }

    final public static function filterWith($names, $default, ...$args) {
        foreach ((array)$names as $name) {
            if (!empty(static::$_modders[$name])) {
                $value = $default;
                foreach (static::$_modders[$name] as $modder) {
                    $value = $modder($value, $args);
                }
                return $value;
            }
        }
        return $default;
    }
}
