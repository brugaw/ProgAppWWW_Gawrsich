<?php
declare(strict_types=1);

require_once __DIR__ . '/cfg.php';
require_once __DIR__ . '/showpage.php';

$id_projektu = "v1.5";
$rawIdp = $_GET["idp"] ?? "";

if ($rawIdp === "") {
    $alias = "glowna";
    $validFormat = true;
} elseif (is_string($rawIdp) && preg_match('/^[a-z0-9-]{1,20}$/', $rawIdp) === 1) {
    $alias = $rawIdp;
    $validFormat = true;
} else {
    $alias = "";
    $validFormat = false;
}

$kod_bledu = 200;
$komunikat_bledu = "";
$aktywny_tytul = "Błąd";
$page = null;
$menuItems = [];

try {
    $menuStmt = $pdo->query('SELECT alias, page_title FROM page_list WHERE status = 1 ORDER BY id');
    $menuItems = $menuStmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$validFormat) {
        http_response_code(404);
        $kod_bledu = 404;
        $komunikat_bledu = "Błąd 404: Nie znaleziono żądanej podstrony.";
    } else {
        $page = PokazPodstrone($pdo, $alias);
        if ($page === null) {
            http_response_code(404);
            $kod_bledu = 404;
            $komunikat_bledu = "Błąd 404: Nie znaleziono żądanej podstrony.";
        } else {
            $aktywny_tytul = (string) $page['page_title'];
        }
    }
} catch (Throwable $e) {
    http_response_code(500);
    $kod_bledu = 500;
    $komunikat_bledu = "Błąd 500: Wewnętrzny błąd serwera.";
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($aktywny_tytul, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?> - Sklep Rowerowy</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/main.js" defer></script>
    <script src="vendor/jquery-4.0.0.min.js" defer></script>
    <script src="js/lab3.js" defer></script>
</head>

<body>
    <header>
        <h1>Rowerowy Sklep</h1>

        <input type="search" id="szukaj" placeholder="Szukaj ">
        <p id="licznik" aria-live="polite"></p>

        <nav aria-label="Menu glowne">
            <?php
            foreach ($menuItems as $item) {
                $itemAlias = (string) $item['alias'];
                $itemTitle = (string) $item['page_title'];
                $aria = ($itemAlias === $alias && $kod_bledu === 200) ? ' aria-current="page"' : '';
                echo '<a href="index.php?idp=' . htmlspecialchars($itemAlias, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '"' . $aria . '>'
                    . htmlspecialchars($itemTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
                    . '</a>';
            }
            ?>
            <a href="lab4.php">Katalog PHP</a>
            <a> <button type="button" id="przycisk-motywu" aria-pressed="false">Tryb Ciemny</button> </a>
        </nav>
    </header>

    <main>
        <?php
        if ($kod_bledu !== 200 || $page === null) {
            echo '<p style="color: red; font-weight: bold; padding: 20px;">'
                . htmlspecialchars($komunikat_bledu, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
                . '</p>';
            echo '<p style="padding: 0 20px;"><a href="index.php">Powrót do strony głównej</a></p>';
        } else {
            echo $page['page_content'];
        }
        ?>
    </main>

    <footer>
        <p>&copy; 11.2026 Programowanie Aplikacji www - <?php echo htmlspecialchars($id_projektu, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
    </footer>
</body>
</html>