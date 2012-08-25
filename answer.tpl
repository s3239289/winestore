<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css"/>
        <title>Winestore Database</title>
    </head>
    <body>
        <a href="search.php"><h1>Winestore Database</h1></a>

        <hr>
        Current session data:
        <table>
            <tr>
                <th>Wine ID</th>
                <th>Wine Name</th>
                <th>Grape Variety</th>
                <th>Year</th>
                <th>Winery Name</th>
                <th>Region</th>
                <th>Current Stock</th>
                <th>Cost</th>
                <th>Total Sold</th>
                <th>Total Revenue</th>
            </tr>

            {section name=field loop=$session}
            <tr>
                <td>{$result[field].wine_id}</td>
                <td>{$result[field].wine_name}</td>
                <td>{$result[field].variety}</td>
                <td>{$result[field].year}</td>
                <td>{$result[field].winery_name}</td>
                <td>{$result[field].region_name}</td>
                <td>{$result[field].on_hand}</td>
                <td>{$result[field].cost}</td>
                <td>{$result[field].total_qty}</td>
                <td>{$result[field].revenue}</td>
            </tr>
            {sectionelse}
                <tr>
                    <td colspan="10">No records match your search criteria</td>
                </tr>
            {/section}
        </table> 
        <a href="answer.php?session=destroy">End Session</a>

        <hr>
        SQL query (
<pre>
{$sql}
</pre>
        )
        <hr>
Returned {$num_rows} records
        <hr>
        <table>
            <tr>
                <th>Wine ID</th>
                <th>Wine Name</th>
                <th>Grape Variety</th>
                <th>Year</th>
                <th>Winery Name</th>
                <th>Region</th>
                <th>Current Stock</th>
                <th>Cost</th>
                <th>Total Sold</th>
                <th>Total Revenue</th>
            </tr>

            {section name=field loop=$result}
            <tr>
                <td>{$result[field].wine_id}</td>
                <td>{$result[field].wine_name}</td>
                <td>{$result[field].variety}</td>
                <td>{$result[field].year}</td>
                <td>{$result[field].winery_name}</td>
                <td>{$result[field].region_name}</td>
                <td>{$result[field].on_hand}</td>
                <td>{$result[field].cost}</td>
                <td>{$result[field].total_qty}</td>
                <td>{$result[field].revenue}</td>
            </tr>
            {sectionelse}
                <tr>
                    <td colspan="10">No records match your search criteria</td>
                </tr>
            {/section}
        </table>
    </body>
</html>
