<?php

use Cake\Datasource\QueryInterface;

if (!function_exists('toSql')) {

    /**
     * Returns the formatted SQL based on params
     *
     * @param QueryInterface $query        The Query to format
     * @param bool           $prettyFormat whether to pretty print or not
     * @param bool           $showValues   Whether to bind the values in the SQL
     *
     * @return string
     */
    function toSql(QueryInterface $query, $prettyFormat = true, $showValues = true) {
        return \LilHermit\Toolkit\Utility\DebugSql::sql($query, $showValues, $prettyFormat);
    }
}
