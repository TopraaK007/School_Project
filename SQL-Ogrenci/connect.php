<?php
try {
    $db=new PDO("sqlsrv:Server=DESKTOP-9VTPEG5\SQLEXPRESS;database=Okul");

} catch (PDOException $e) {
    echo $e->getMessage();
}

?>