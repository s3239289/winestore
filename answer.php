<?php
    require_once('db.php');
    require_once('connect.php');

    $wine_name = $_GET['wine_name'];
    $winery_name = $_GET['winery_name'];
    $region = $_GET['region'];
    $grape_variety = $_GET['grape_variety'];
    $year_low = (int) $_GET['year_low'];
    $year_high = (int) $_GET['year_high'];
    $min_stock = (int) $_GET['min_stock'];
    $max_stock = (int) $_GET['max_stock'];
    $cost_min = (int) $_GET['cost_min'];
    $cost_max = (int) $_GET['cost_max'];

    $wineNameSQL = sprintf("SELECT * winestore.wine WHERE wine_name LIKE '%%%s%%'",
        mysql_real_escape_string($wine_name));
    $wineryNameSQL = sprintf("SELECT * winestore.winery WHERE winery_name LIKE '%%%s%%'",
        mysql_real_escape_string($winery_name));
    $regionSQL = sprintf("SELECT * winestore.region WHERE region_name LIKE '%%%s%%'",
        mysql_real_escape_string($region));
    $grapeVarietySQL = sprintf("SELECT * winestore.region WHERE variety LIKE '%%%s%%'",
        mysql_real_escape_string($grape_variety));
    $yearRangeSQL = sprintf("SELECT * winestore.wine where year between %d AND %d",
        mysql_real_escape_string(year_low),
        mysql_real_escape_string(year_high));

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

    //SELECT a.wine_id, SUM(a.qty) FROM winestore.items a inner join orders b on b.order_id = a.order_id group by wine_id;
?>
