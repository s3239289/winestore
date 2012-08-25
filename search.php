<?php
    require_once('db.php');
    require_once('connect.php');
    require_once('config.php');

    try {
        $db = new PDO(
            "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME,
            DB_USER,
            DB_PW
        );
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
?>
<html>
    <head>
        <title>Winestore Database</title>
    </head>
    <body>
        <h1>Winestore Database</h1>
        <form name="form" action="answer.php" method="GET" accept-charset="utf-8">
            Wine Name: <input type="text" name="wine_name" /><br />
            Winery Name: <input type="text" name="winery_name" /><br />
            Region: <select name="region">
            <option value="" selected="selected"></option>
            <?php
                $sql = "select region_name from region";
                foreach ($db->query($sql) as $row) {
                    $tableName = $row[0];
                    echo "<option value=\"$tableName\">$tableName</option>";
                }
            ?>
            </select><br />
            Grape Variety: <select name="grape_variety">
            <option value="" selected="selected"></option>
            <?php
                $sql = "select variety from grape_variety;";
                foreach ($db->query($sql) as $row) {
                    $tableName = $row[0];
                    echo "<option value=\"$tableName\">$tableName</option>";
                }
            ?>
            </select><br />
            <!--http://stackoverflow.com/questions/2788398/how-to-select-first-empty-value-option-in-a-select-menu-->
            Year (low): <select name="year_low">
            <option value="" selected="selected"></option>
            <?php
                $sql = "select distinct year from wine order by year";
                foreach ($db->query($sql) as $row) {
                    $tableName = $row[0];
                    echo "<option value=\"$tableName\">$tableName</option>";
                }
            ?>
            </select><br />
            Year (high): <select name="year_high">
            <option value="" selected="selected"></option>
            <?php
                $sql = "select distinct year from wine order by year";
                foreach ($db->query($sql) as $row) {
                    $tableName = $row[0];
                    echo "<option value=\"$tableName\">$tableName</option>";
                }
            ?>
            </select><br />
            Minimum in stock: <input type="text" name="min_stock" /><br />
            Minimum ordered: <input type="text" name="min_order" /><br />
            Cost (minimum): <input type="text" name="cost_min" /><br />
            Cost (maximum): <input type="text" name="cost_max" /><br />
            <input type="submit" value="Search" /><br />
        </form>
    </body>
</html>
