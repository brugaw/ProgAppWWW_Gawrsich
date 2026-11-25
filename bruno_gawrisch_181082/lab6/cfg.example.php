<?php
$pdo = new PDO(
    'mysql:host=127.0.0.1;port=3306;dbname=moja_strona;charset=utf8mb4',
    'userName',
    'userHaslo',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=> PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
);