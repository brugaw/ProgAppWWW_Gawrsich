<?php
$id_projektu = "sklep-demo";

$mapa_stron = [
    "glowna" => [
        "tytul" => "Strona Główna",
        "plik" => "html/glowna.html"
    ],
    "produkt" => [
        "tytul" => "Produkt",
        "plik" => "html/produkt.html"
    ],
    "kontakt" => [
        "tytul" => "Kontakt",
        "plik" => "html/kontakt.html"
    ],
    "filmy" => [
        "tytul" => "Filmy Wideo",
        "plik" => "html/filmy.html"
    ]
];

$idp = isset($_GET["idp"]) ? $_GET["idp"] : "glowna";
if ($idp === "") {
    $idp = "glowna";
}

$kod_bledu = 200;
$komunikat_bledu = "";
$aktywny_tytul = "Błąd";
$sciezka_do_pliku = "";

// Walidacja klucza w mapie
if (!is_string($idp) || !array_key_exists($idp, $mapa_stron)) {
    http_response_code(404);
    $kod_bledu = 404;
    $komunikat_bledu = "Błąd 404: Nie znaleziono żądanej podstrony.";
} else {
    $aktywny_tytul = $mapa_stron[$idp]["tytul"];
    $sciezka_do_pliku = __DIR__ . "/" . $mapa_stron[$idp]["plik"];

    // Walidacja fizycznego pliku
    if (!is_file($sciezka_do_pliku) || !is_readable($sciezka_do_pliku)) {
        http_response_code(500);
        $kod_bledu = 500;
        $komunikat_bledu = "Błąd 500: Wewnętrzny błąd serwera. Plik widoku niedostępny.";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($aktywny_tytul); ?> - Sklep Rowerowy</title>
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
            foreach ($mapa_stron as $klucz => $dane) {
                $aria = ($klucz === $idp && $kod_bledu === 200) ? ' aria-current="page"' : '';
                echo '<a href="index.php?idp=' . $klucz . '"' . $aria . '>' . htmlspecialchars($dane["tytul"]) . '</a>';
            }
            ?>
            <a href="lab4.php">Katalog PHP</a>
            <a> <button type="button" id="przycisk-motywu" aria-pressed="false">Tryb Ciemny</button> </a>
        </nav>
    </header>

    <main>
        <?php
        if ($kod_bledu !== 200) {
            echo "<p style=\"color: red; font-weight: bold; padding: 20px;\">" . $komunikat_bledu . "</p>";
            echo "<p style=\"padding: 0 20px;\"><a href=\"index.php\">Powrót do strony głównej</a></p>";
        } else {
            include $sciezka_do_pliku;
        }
        ?>
    </main>

    <footer>
        <p>&copy; 11.2026 Programowanie Aplikacji www - <?php echo $id_projektu; ?></p>
    </footer>
</body>
</html>