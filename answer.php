<?php

$wineNameSQL = "SELECT * winestore.wine WHERE wine_name LIKE '%".$input."%'";
$wineryNameSQL = "SELECT * winestore.winery WHERE winery_name LIKE '%".$input."%'";
$regionSQL = "SELECT * winestore.region WHERE region_name = '".$input."'";
$grapeVarietySQL = "SELECT * winestore.region WHERE variety = '".$input."'";
$yearRangeSQL = "";
/*
 * Reference for INNER JOIN: 
 *     http://stackoverflow.com/questions/6411202/inner-join-with-sum-aggregate-function-in-sql-server
 *     
 * Test for correctness:
 *     SELECT SUM(qty) FROM winestore.items where wine_id=888;
 */
$minStockSQL = "SELECT a.wine_id, SUM(a.qty) FROM winestore.items a inner join wine b on b.wine_id = a.wine_id group by wine_id";
$minOrderSQL = "SELECT winestore.orders WHERE variety = '".$input."'";
    $costRangeSQL = "";

SELECT a.wine_id, SUM(a.qty) FROM winestore.items a inner join orders b on b.order_id = a.order_id group by wine_id;
?>
