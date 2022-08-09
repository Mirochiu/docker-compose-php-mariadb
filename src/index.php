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

    $sslConfig = array(
        "ca.crt" => "/etc/certs/root-ca.crt",
        "certificate" => "/etc/certs/client.crt", // for 2-way SSL/TLS
        "private.key" => "/etc/certs/client-key.pem", // for 2-way SSL/TLS
    );
    echo "<h3>print certificate configs</h3>";
    foreach ($sslConfig as $name) {
        echo $name." is readable?".is_readable($name)."<br/>";
    }

    echo "<h3>connect to db</h3>";
    echo $host.'=>'.gethostbyname($host)."<br/>";

    $connection = mysqli_init();
    $connection->options(MYSQLI_OPT_CONNECT_TIMEOUT, 1);
    $connection->options(MYSQLI_OPT_READ_TIMEOUT, 1);
    $connection->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
    if (!$connection->ssl_set(
        $sslConfig["private.key"],
        $sslConfig["certificate"],
        $sslConfig["ca.crt"],
        NULL,
        NULL)) {
        echo "fail to ssl_set".
            ", code: ".$connection->connect_errno.
            " reason:".$connection->connect_error."<br/>";
        exit();
    }

    if (!$connection->real_connect(
        "mineserver.localhost",
        $dbuser,
        $dbpassword,
        $dbname,
        3306,
        NULL,
        MYSQLI_CLIENT_SSL)) {
        echo "fail to connect DB".
            ", code: ".$connection->connect_errno.
            " reason:".$connection->connect_error."<br/>";
        exit();
    }

    echo 'connected to DB:'.$connection->host_info."<br/>";

    $tableName = "mytable";
    $sql = sprintf(
        "SELECT * FROM %s",
        $tableName
    );
    $result = $connection->query($sql);
    if (!$result) {
        echo 'query failed, messag:'.$connection->error."<br/>";
    } else {
        print_r($result);
    }

    $connection->close();

    echo "<h3>php info</h3>";
    phpinfo();
?>
</body>
</html>


