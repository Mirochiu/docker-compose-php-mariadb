<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Show settings</h1>
<?
    echo "<h3>show current time</h3>";
    // date_default_timezone_set("asia/taipei"); // we apply env["TZ"]
    echo date("Y-m-d h:i:s")."<br/>";
    echo date(DATE_ATOM)."<br/>";
    echo date(DATE_RFC2822)."<br/>";

    $array = array(
        "DB_HOST",
        "DB_USERNAME",
        "DB_PASSWORD",
        "DB_NAME",
    );
    echo "<h3>var_dump</h3><pre>";
    var_dump($array); // cannot get the output of var_dump
    echo "</pre>";
    echo "<h3>print_r</h3><pre>".print_r($array, true)."</pre>"; // print_r is better
    echo "<h3>var_export</h3><pre>".var_export($array, true)."</pre>";

    echo "<h3>print envs</h3>";
    foreach ($array as $el) {
        $v = getenv($el);
        echo $el."=".$v."<br/>";
        switch ($el) {
            case "DB_HOST":$host=$v;break;
            case "DB_USERNAME":$dbuser=$v;break;
            case "DB_PASSWORD":$dbpassword=$v;break;
            case "DB_NAME":$dbname=$v;break;
        }
    }

    echo "<h3>connect to db</h3>";
    echo $host.'=>'.gethostbyname($host)."<br/>";

    $connection = mysqli_init();
    $connection->options(MYSQLI_OPT_CONNECT_TIMEOUT, 1);
    $connection->options(MYSQLI_OPT_READ_TIMEOUT, 1);
    $connection->real_connect($host,$dbuser,$dbpassword,$dbname);
    // $connection = new mysqli($host,$dbuser,$dbpassword,$dbname);
    if ($connection->connect_error) {
        echo "fail to connect DB, reason:".$connection->connect_error."<br/>";
    } else {
        $connection->close();
        echo "connect to DB success"."<br/>";
    }

    echo "<h3>php info</h3>";
    phpinfo();
?>
</body>
</html>


