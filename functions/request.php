<?php

function updateGet ($param, $value)
{
    $newGet = $_GET;
    if (isset($newGet[$param]))
    {
        $newGet[$param] = $value;
    } else {
        $newGet += [$param => $value];
    }
    return '/?' . http_build_query($newGet);
}

function unpackGet ($value)
{

    return $_GET[$value] ?? 0;
}