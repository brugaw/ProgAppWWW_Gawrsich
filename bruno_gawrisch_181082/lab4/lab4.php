<?php
session_start();
require_once __DIR__."/includes/produkty.php";
$idGrp="Grupa 3";
$komunikatBlednyPost = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idPost = filter_input(INPUT_POST, "produkt", FILTER_VALIDATE_INT);
    $iloscPost = filter_input(INPUT_POST, "ilosc", FILTER_VALIDATE_INT);

    if ($idPost === false || $idPost === null || $iloscPost === false || $iloscPost === null) {
        http_response_code(400);
        $komunikatBlednyPost = "Błąd: Przesłane dane muszą być liczbami całkowitymi.";
    } else {
        $znalezionyProdukt = null;
        $j = 0;
        while ($j < count($produkty)) {
            if ($produkty[$j]["id"] === $idPost) {
                $znalezionyProdukt = $produkty[$j];
                break;
            }
            $j++;
        }

        if ($znalezionyProdukt === null) {
            http_response_code(400);
            $komunikatBlednyPost = "Błąd: Taki produkt nie istnieje w katalogu.";
        } elseif ($iloscPost < 1 || $iloscPost > 5) {
            http_response_code(400);
            $komunikatBlednyPost = "Błąd: Możesz zamówić od 1 do 5 sztuk.";
        } elseif ($iloscPost > $znalezionyProdukt["stan"]) {
            http_response_code(400);
            $komunikatBlednyPost = "Błąd: Brak wystarczającej ilości towaru w magazynie (maksymalnie: " . $znalezionyProdukt["stan"] . ").";
        } else {
            $_SESSION["ostatni_wybor"] = [
                "id" => $idPost,
                "ilosc" => $iloscPost
            ];
            
            header("Location: lab4.php", true, 303);
            exit;
        }
    }
}

include __DIR__."/includes/naglowek.php";
?>
    <section class="karta" style="margin-bottom: 2rem; border-color: var(--kolor-akcentu);">
        <h2>Twój koszyk (Sesja)</h2>
        <?php
        if (isset($_SESSION["ostatni_wybor"])) {
            $zapisaneId = $_SESSION["ostatni_wybor"]["id"];
            $zapisanaIlosc = $_SESSION["ostatni_wybor"]["ilosc"];
            
            $nazwaZapisana = "Nieznany produkt";
            for ($k = 0; $k < count($produkty); $k++) {
                if ($produkty[$k]["id"] === $zapisaneId) {
                    $nazwaZapisana = $produkty[$k]["nazwa"];
                    break;
                }
            }
            echo "<p>Ostatnio dodano: <strong>" . htmlspecialchars($nazwaZapisana) . "</strong> (sztuk: " . $zapisanaIlosc . ")</p>";
        } else {
            echo "<p>Koszyk jest pusty. Zapisz swój pierwszy wybór z katalogu.</p>";
        }
        ?>
    </section>

    <?php if ($komunikatBlednyPost !== ""): ?>
        <p style="background: red; color: white; padding: 10px; border-radius: 4px; font-weight: bold;">
            <?php echo $komunikatBlednyPost; ?>
        </p>
    <?php endif; 
?>

    <section class="karta">
        <h2>Katalog - <?php echo $idGrp; ?></h2>
        <p>
            <a href="index.html">Powrót do strony głównej</a>
        </p>
        <form method="get" action="lab4.php" style="margin-bottom: 2rem; padding: 1rem; background: var(--kolor-karty); border-radius: 6px;">
            <label for="kategoria">Filtruj katalog:</label>
            <select name="kategoria" id="kategoria">
                <option value="wszystkie">Wszystkie</option>
                <option value="ksiazki">Książki i poradniki</option>
                <option value="akcesoria">Akcesoria rowerowe</option>
            </select>
            <button type="submit">Filtruj</button>
        </form>

        <section class="katalog">
        <?php
            $filtr = isset($_GET["kategoria"]) ? $_GET["kategoria"] : "wszystkie";
            
            if ($filtr !== "wszystkie" && $filtr !== "ksiazki" && $filtr !== "akcesoria") {
                echo "<p style=\"color: red; font-weight: bold; grid-column: 1 / -1;\">Nieznana kategoria!</p>";
                $filtr = "wszystkie";
            }

            $i = 0;
            $liczbaProduktow = count($produkty);

            while ($i < $liczbaProduktow) {
                $produkt = $produkty[$i];

                if ($filtr === "wszystkie" || $filtr === $produkt["kategoria"]) {
                    if ($produkt["stan"] == 0) {
                        $stanEtykieta = "Niedostępny";
                    } elseif ($produkt["stan"] >= 1 && $produkt["stan"] <= 5) {
                        $stanEtykieta = "Niski stan";
                    } else {
                        $stanEtykieta = "Dostępny";
                    }

                    switch ($produkt["kategoria"]) {
                        case "ksiazki":
                            $katEtykieta = "Książki i poradniki";break;
                        case "akcesoria":
                            $katEtykieta = "Akcesoria rowerowe";break;
                        default:
                            $katEtykieta = "Inne";
                    }
                    echo "<article class=\"karta\">";

                    echo "<h3>" . htmlspecialchars($produkt["nazwa"]) . "</h3>";
                    echo "<p>Kategoria: " . $katEtykieta . "</p>";
                    echo "<p>Status: <strong>" . $stanEtykieta . "</strong> (na stanie: " . $produkt["stan"] . ")</p>";

                    echo "<form method=\"post\" action=\"lab4.php\">";
                    echo "<input type=\"hidden\" name=\"produkt\" value=\"" . $produkt["id"] . "\">";
                    echo "<label>Ilość: <select name=\"ilosc\">";

                    for ($j = 1; $j <= 5; $j++) {
                        echo "<option value=\"" . $j . "\">" . $j . "</option>";
                    }
                    
                    echo "</select></label>";
                    echo "<button type=\"submit\" style=\"margin-top: 10px;\">Zapisz wybór</button>";
                    echo "</form>";

                    echo "</article>";
                }
                $i++; 
            }
        ?>
        </section>
    </section>

    </main>
    <footer>
        <p>&copy 11.2026 Programowanie Aplikacji www - Lab 4</p>
    </footer>
</body>
</html>
