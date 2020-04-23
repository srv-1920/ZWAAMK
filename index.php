<!doctype html>
<html lang="en">
<head>
    <meta charset="UCS-2">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
$newdata = [];
$headers = true;
$csv = array_map('str_getcsv', file('data.csv'));
$data = mb_convert_encoding($csv, "UTF-8", "UCS-2");
//var_dump($data);
foreach ($data as $str) {
    $parts = preg_split('/\t/', $str[0]);
    if ($headers) {
//        var_dump($parts);
        $headers = false;
        $test = 'zwaamk';
        $sql = "create table if not exists $test (";
        foreach ($parts as $header) {
//            var_dump($header);
            $name = strtolower($header);
            $name = str_replace(' ', '_', $name);
//            $name = preg_match('/^[\w]+$/', $name);
            $name = preg_replace("/\([^)]+\)/", "", $name);
            $name = str_replace('.', '', $name);
            $name = str_replace('ä', 'a', $name);
            $name = str_replace('å', 'a', $name);
            $name = str_replace('ö', 'o', $name);
            $sql .= "$name varchar(255),";
        }
        $sql = rtrim($sql, ",");
        $sql .= ');';
        var_dump($sql);

        runQuery($sql);
    } else {

        $newdata[] = $parts;
    }
}
//seed($newdata);

//var_dump($newdata);



function seed($data)
{
    foreach ($data as $datum) {
        $query = "insert into zwaamk values(";
        foreach ($datum as $value) {
            $query .= "'$value'" . ",";
        }
        $query = rtrim($query, ",");
        $query .= ");";
        runQuery($query);
    }
}

?>

</body>
</html>

