<?php

function filterItensByStoreId(array $items, $storeId)
{
    return array_filter($items, function($line) use($storeId){
        return $line['store_id'] == $storeId;
    });
}

function formatPriceToDatabase($price)
{
    return str_replace(['.',','],['','.'], $price);
}

function formatPriceToView($price)
{
    return str_replace(['.'],[','], $price);
}