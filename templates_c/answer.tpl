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
                <th>Quantity</th>
            </tr>
            SQL query ({$sql}) returned {$num_rows} records<p />;

            {section name=field loop=$wine}
            <tr>
                <td>{$wine[field].wine_name}"</td>
                <td>{$wine[field].variety}</td>
                <td>{$wine[field].year}</td>
                <td>{$wine[field].winery_name}</td>
                <td>{$wine[field].region_name}</td>
                <td>{$wine[field].cost}</td>
                <td>{$wine[field].qty}</td>
            </tr>
            {sectionelse}
                <tr>
                    <td colspan="7">No items found</td>
                </tr>
            {/section}
        </table>
    </body>
</html>
