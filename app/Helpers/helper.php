<?php

function getAllowedFilters($filters)
{
    $allowed_filters = [];
    foreach ($filters as $value) {
        array_push($allowed_filters, $value['name']);
    }
    return $allowed_filters;
}

function getList($data, $value = 'name', $custom_id = true)
{
    $list = array();
    foreach ($data as $item) {
        $custom_id_section = $custom_id && is_int($item->id) ? $item->custom_id . " " : "";
        $list[strval($item->id)] = $custom_id_section . $item[$value];
    }
    return $list;
}
