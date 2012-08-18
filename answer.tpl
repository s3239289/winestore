<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css"/>
    </head>
    <body>
        <table>
            <tr>
                <th>Wine Name</th>
                <th>Grape Variety</th>
                <th>Year</th>
                <th>Winery Name</th>
                <th>Region</th>
                <th>Cost</th>
                <th>Current Stock</th>
                <th>Total Sold</th>
                <th>Total Revenue</th>
            </tr>
            SQL query ({$sql}) returned {$num_rows} records<p />

            {section name=field loop=$result}
            <tr>
                <td>{$result[field].wine_name}</td>
                <td>{$result[field].variety}</td>
                <td>{$result[field].year}</td>
                <td>{$result[field].winery_name}</td>
                <td>{$result[field].region_name}</td>
                <td>{$result[field].cost}</td>
                <td>{$result[field].on_hand}</td>
                <td>{$result[field].total_qty}</td>
                <td>{$result[field].revenue}</td>
            </tr>
            {sectionelse}
                <tr>
                    <td colspan="7">No records match your search criteria</td>
                </tr>
            {/section}
        </table>
    </body>
</html>
