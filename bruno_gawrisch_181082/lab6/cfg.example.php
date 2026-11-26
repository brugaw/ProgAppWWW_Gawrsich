<?php
declare(strict_types=1);
try{
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
}catch(Throwable $e) {
    http_response_code(500);
        exit('Błąd 500: Wewnętrzny błąd serwera.');
}
