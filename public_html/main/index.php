<?php

function processString($string){
    $result = str_replace(['.',"\x04", "\x1A"],'',$string);
    #$result = str_replace('\\','\\\\',$result);
    $result = str_replace('"','\'',$result);
    return $result;
}

$username = processString($_POST["username"]);
$password = processString($_POST["password"]);



$format = "echo \"CREATE TABLE UserCredentials (UserID INTEGER PRIMARY KEY AUTOINCREMENT, Username TEXT NOT NULL UNIQUE, Password TEXT NOT NULL); INSERT INTO UserCredentials (Username, Password) VALUES ('admin', 'Buraki_Z_Ziemniakami!!!123321Enedulejshrghdsjdfhslkdjhfrkuhcjvhgkjliy????'); SELECT Username From UserCredentials WHERE Username = '%s' and Password = '%s';\" | sqlite3";

$sqlRequest = sprintf($format, $username, $password);

#$sqlRequest = "echo \"CREATE TABLE UserCredentials (UserID INTEGER PRIMARY KEY AUTOINCREMENT, Username TEXT NOT NULL UNIQUE, Password TEXT NOT NULL); INSERT INTO UserCredentials (Username, Password) VALUES ('admin', 'Buraki_Z_Ziemniakami!!!123321Enedulejshrghdsjdfhslkdjhfrkuhcjvhgkjliy????'); SELECT Username From UserCredentials;\" | sqlite3";

$result = substr(shell_exec($sqlRequest),0,-1);

echo($username);
echo(":");
echo($password);
echo(":   :");
echo(strcmp($result, "admin"));
if (!is_null($result) && "admin"==$result) {
    //Logged in
    ?>

        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Authorized Page</title>
            <link rel="stylesheet" href="../style.css">
        </head>
        <body>
            <div id="info-bar">
                Welcome to 11th Hackademic Challenge! Go back to <a href="../index.html">login page</a>.
            </div>
            <div id="description">
                <h2>Congratulations!</h2>
                <p>
                    Secret code: 190
                </p>
                <p>
                    Good luck with others!
                </p>
            </div>
        </body>
        </html>
    <?php
} else {
    header('Location: ' . "../index.html?loginFailed=true", true, 303);
    die();
}
?>