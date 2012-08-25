<?php
    // /usr/local/stow/php-5.2.5/pkg/php-5.2.5/bin/php-cgi -f answer.php wine_name=Archibald

    session_start();

    define("USER_HOME_DIR", "/home/stud/s3239289"); // CHANGE HERE
    define("USER_HOME_DIR", "/home/stud/s3239289"); // CHANGE HERE

    require(USER_HOME_DIR . "/php/Smarty-3.1.11/libs/Smarty.class.php");
    require_once('db.php');
    require_once('connect.php');

    function simpleCheck($input) {
        if (!is_numeric($input)) {
            die('A required numeric value was not numeric');
        }
    }

    $db = new PDO(
            "mysql:host=".DB_HOST.
            ";port=".DB_PORT.
            ";dbname=".DB_NAME,
            DB_USER,
            DB_PW
          );

    $smarty = new Smarty();
    $smarty->template_dir = USER_HOME_DIR . "/php/Smarty-Work-Dir/templates";
    $smarty->compile_dir = USER_HOME_DIR . "/php/Smarty-Work-Dir/templates_c";
    $smarty->cache_dir = USER_HOME_DIR . "/php/Smarty-Work-Dir/cache";
    $smarty->config_dir = USER_HOME_DIR . "/php/Smarty-Work-Dir/configs";

    $wine_name = $_GET['wine_name'];
    $winery_name = $_GET['winery_name'];
    $region = $_GET['region'];
    $grape_variety = $_GET['grape_variety'];
    $year_low = (int) $_GET['year_low'];
    $year_high = (int) $_GET['year_high'];
    $min_stock = (int) $_GET['min_stock'];
    $min_order = (int) $_GET['min_order'];
    $cost_min = (int) $_GET['cost_min'];
    $cost_max = (int) $_GET['cost_max'];

    if ($_GET['session'] == "destroy") {
        session_destroy();
    }

    /*
     * Reference for INNER JOIN: 
     *     http://stackoverflow.com/questions/6411202/inner-join-with-sum-aggregate-function-in-sql-server
     *     
     * Test for correctness:
     *     SELECT SUM(qty) FROM winestore.items where wine_id=888;
     */

    $sql = "
            SELECT 
                wine_id,
                wine_name,
                variety,
                year,
                winery_name,
                region_name,
                on_hand,
                cost,
                sum(qty) AS total_qty,
                cost * sum(qty) AS revenue 
            FROM wine 
                INNER JOIN winery 
                   USING (winery_id) 
                INNER JOIN region 
                   USING (region_id) 
                INNER JOIN wine_variety 
                   USING (wine_id) 
                INNER JOIN grape_variety 
                   USING (variety_id) 
                INNER JOIN inventory 
                   USING (wine_id) 
                INNER JOIN items 
                   USING (wine_id)";

    $vars = array(
                $wine_name,
                $winery_name,
                $region,
                $grape_variety,
                $year_low,
                $year_high,
                $cost_min,
                $cost_max,
                $min_stock,
                $min_order,
            );

    //var_dump($vars);
    $where = 0;

    //something strange here
    //if (!empty($_GET)) {
        //$sql .= " WHERE ";
        //$where = 1;
    //}

    foreach ($vars as $var) {
        if (!empty($var)) {
        $sql .= "
            WHERE
                ";
            $where = 1;
            break;
        }
    }

    if (!empty($wine_name))
        $sql .= "wine_name LIKE '%".$wine_name."%' AND ";
    if (!empty($winery_name))
        $sql .= "winery_name LIKE '%".$winery_name."%' AND ";
    if (!empty($region))
        $sql .= "region_name = '".$region."' AND ";
    if (!empty($grape_variety))
        $sql .= "variety = '".$grape_variety."' AND ";
    if (!empty($year_low)) {
        simpleCheck($year_low);
        $sql .= "year >= '".$year_low."' AND ";
    }
    if (!empty($year_high)) {
        simpleCheck($year_high);
        $sql .= "year <= '".$year_high."' AND ";
    }
    if (!empty($cost_min)) {
        simpleCheck($cost_min);
        $sql .= "cost >= '".$cost_min."' AND ";
    }
    if (!empty($cost_max)) {
        simpleCheck($cost_max);
        $sql .= "cost <= '".$cost_max."' AND ";
    }
    if (!empty($min_stock)) {
        simpleCheck($min_stock);
        $sql .= "on_hand = '".$min_stock."' AND ";
    }
    if (!empty($min_order)) {
        simpleCheck($min_order);
        $sql .= "total_qty = '".$min_order."'";
    }

    if ($year_low > $year_high && !empty($year_high)) {
        die('Year max cannot be smaller than year min');
    }
    if ($cost_min > $cost_max && !empty($cost_max)) {
        die('Cost max cannot be smaller than cost min');
    }

    //Trim the trailing AND if it exists
    if ($where != 0) {
        $len = strrpos($sql, " AND ", 0);
        $sql = substr($sql, 0, $len);
    }
    $sql .= "
            GROUP BY
                wine_id,
                wine_name,
                variety,
                year
            ORDER BY
                wine_id
    ";

    $results = Array();

    $query = $db->prepare($sql);
    $query->execute();

    foreach ($query->fetchAll() as $row) {
        $results[] = $row;

        if (session_id()) {
            $_SESSION['wines'][] = $row;
        }
    }

    //MySQL errors
    //http://stackoverflow.com/questions/6059589/warning-mysql-num-rows-supplied-argument-is-not-a-valid-mysql-result-resourc

    //Notes on how to use Smarty: http://www.smarty.net/forums/viewtopic.php?t=9199
    $smarty->assign('num_rows', count($results));
    $smarty->assign('sql', $sql);
    $smarty->assign('session', $_SESSION['wines']);
    $smarty->assign('result', $results);

    $smarty->display('answer.tpl');

    $db = null; // close the database connection
?>
