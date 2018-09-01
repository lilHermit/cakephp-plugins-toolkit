<?php

namespace LilHermit\Toolkit\Utility;

use Cake\Datasource\QueryInterface;
use SqlFormatter;

class DebugSql {

    /**
     * Returns the formatted SQL based on params
     *
     * @param QueryInterface $query        The Query to format
     * @param bool           $prettyFormat whether to pretty print or not
     * @param bool           $showValues   Whether to bind the values in the SQL
     *
     * @return string
     */
    public static function sql(QueryInterface $query, $prettyFormat = true, $showValues = true) {
        $sql = (string)$query;
        if ($showValues) {
            $sql = method_exists($query, 'getValueBinder')
                ? static::interpolate($sql, $query->getValueBinder()->bindings())
                : static::interpolate($sql, $query->valueBinder()->bindings());
        }

        return $prettyFormat ? SqlFormatter::format($sql, false) : $sql;
    }

    /**
     * Helper function used to replace query placeholders by the real
     * params used to execute the query.
     *
     * @param string $sql      The SQL statement
     * @param array  $bindings The Query bindings
     *
     * @return string
     */
    private static function interpolate($sql, array $bindings) {
        $params = array_map(function ($binding) {
            $p = $binding['value'];

            if ($p === null) {
                return 'NULL';
            }
            if (is_bool($p)) {
                return $p ? '1' : '0';
            }

            if (is_string($p)) {
                $replacements = [
                    '$' => '\\$',
                    '\\' => '\\\\\\\\',
                    "'" => "''",
                ];

                $p = strtr($p, $replacements);

                return "'$p'";
            }

            return $p;
        }, $bindings);

        $keys = [];
        $limit = is_int(key($params)) ? 1 : -1;
        foreach ($params as $key => $param) {
            $keys[] = is_string($key) ? "/$key\b/" : '/[?]/';
        }

        return preg_replace($keys, $params, $sql, $limit);
    }
}