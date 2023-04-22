<?php

function getAllowedFilters($filters)
{
    $allowed_filters = [];
    foreach ($filters as $value) {
        array_push($allowed_filters, $value['name']);
    }
    return $allowed_filters;
}
