<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorized Page</title>
    <link rel="stylesheet" href="style-search.css">
    <script>
        function showCongratulationsMessage() {
            alert("Congratulations, You won!");
        }
    </script>
</head>
<body>
    <h2>Orders Details</h2>
    <div id="info-bar">
        <form action="" method="get">
                <label for="searchQuery">Search:</label>
                <input type="text" id="searchQuery" name="Search" placeholder="Enter your search term">
                <button type="submit">Search</button>
                <button type="submit" name="Reset">Reset</button>
        </form>
    </div>
    <div class="table">

<?php
$cookiePatch = "/~apaczek/main/";
function processString($string){
    $result = str_replace(["\x04", "\x1A"],'',$string);
    $result = str_replace(['.auth', '.backup', '.bail', '.binary ', '.changes', '.clone', '.databases', '.dbinfo', '.dump', '.echo', '.eqp', '.exit', '.explain', '.fullschema', '.headers', '.help', '.import', '.indexes', '.limit', '.load', '.log', '.mode', '.nullvalue', '.once', '.open', '.output', '.print', '.prompt', '.quit', '.read', '.restore', '.save', '.scanstats', '.schema', '.separator', '.shell', '.show', '.stats', '.system', '.tables', '.timeout', '.timer', '.trace', '.vfsinfo', '.vfslist', '.vfsname', '.width'],'',$result);
    $result = str_replace('"','\\"',$result);
    return $result;
}


// If new user provide id and database
if (isset($_COOKIE["UserId"])) {
    $UserId = $_COOKIE["UserId"];
    $databaseID = hash('MD5', $UserId);

    //Reset Database if user wants
    if (isset($_GET["Reset"])) {
        unlink(sprintf("../../databases/%s", $databaseID));
        $format = "cat ../../databases/initdb.sql | sqlite3 ../../databases/%s ";
        shell_exec(sprintf($format, $databaseID));
    }
} else {
    $UserId = uniqid("",TRUE);
    $expiration_time = time() + 31536000; // 60 seconds/minute * 60 minutes/hour * 24 hours/day * 365 days/year
    setcookie('UserId', $UserId, $expiration_time, $cookiePatch, "", false, true);
    $databaseID = hash('MD5', $UserId);
    
    $format = "cat ../../databases/initdb.sql | sqlite3 ../../databases/%s ";
    shell_exec(sprintf($format, $databaseID));
}


// process query
if (!isset($_GET["Search"]) or $_GET["Search"] == ""){
    $query = "%";
}else{
    $query = $_GET["Search"];
    $query = "%" . processString($query) . "%";
}



$format = "echo \"SELECT clients.name as clientName, products.name, orders.order_date FROM orders
INNER JOIN clients ON orders.client_id = clients.id
INNER JOIN products ON products.id = orders.product_id
WHERE clientName LIKE '%s' ; " . PHP_EOL . ";\" | sqlite3 '../../databases/%s' ";

$sqlRequest = sprintf($format, $query, $databaseID);
//$result = substr(shell_exec($sqlRequest),0,-1);
$result = shell_exec($sqlRequest);


$result =  str_replace("|","</td><td>",$result);
$result =  str_replace(["\n","\r"],"</td></tr><tr><td>",$result);

?>
        <table>
            <tr>
                <th>Client Name</th>
                <th>Product Name</th>
                <th>Order Date</th>
            </tr>
            <tr>
                <td>
                    <?php
                    print_r($result);
                    ?>
                </td>
            </tr>
        </table>
    </div>
<?php
$testQuery = "echo \"SELECT COUNT(*) FROM orders;\" | sqlite3 '../../databases/%s' ";
$testQuery = sprintf($testQuery, $databaseID);
$testResult = substr(shell_exec($testQuery),0,-1);
if ($testResult == "10"){
    echo '<script>showCongratulationsMessage();</script>';
?>
<?php
}
?>
</body>
</html>