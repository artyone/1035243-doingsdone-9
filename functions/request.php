<?php

function getGet()
{
    return $_GET ?? [];
}



function updateGet ($get, $param, $value)
{
    if (isset($get[$param]))
    {
        $get[$param] = $value;
    } else {
        $get += [$param => $value];
    }
    return '/?' . http_build_query($get);
}

function unpackGet ($get, $value)
{

    return $get[$value] ?? 0;
}