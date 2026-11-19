# Dokumentacja projektu - Lab 5 PHP szablon i dynamiczne podstrony


## 1. Instrukcja uruchomienia projektu

Projekt wymaga serwera Apache w środowisku XAMPP do obsługi routingu przez PHP, dynamicznego dołączania plików oraz sesji.

1. Skopiuj cały folder z projektem i wklej go do katalogu "htdocs" (domyślnie "C:\xampp\htdocs\lab5").

2. Otwórz panel XAMPP i uruchom moduł Apache.

3. Wejdź w przeglądarce pod adres: "http://localhost/lab5/index.php".

4. Dostępne punkty wejścia w projekcie:
   - "index.php" – główny szablon obsługujący podstrony przez parametr "?idp=" (glowna, produkt, kontakt, filmy).
   - "lab4.php" – katalog produktów z filtrowaniem GET i koszykiem w sesji (POST + PRG).
   - "status.php" – punkt końcowy dla asynchronicznych zapytań AJAX.



## 2. Pseudokody (Logika wyboru widoku w index.php)

**Wybór widoku i obsługa błędów:**

1. Zdefiniuj zmienną z identyfikatorem projektu dla stopki ("sklep-demo") oraz tablicę asocjacyjną (mapę stron) wiążącą klucz z tytułem i ścieżką do pliku w folderze "html/".

2. Odczytaj parametr "idp" z tablicy $_GET.

3. Jeśli parametr nie istnieje lub jest pustym tekstem "": ustaw domyślnie klucz "glowna".

4. Sprawdź poprawność klucza: czy wartość jest tekstem (is_string) oraz czy istnieje w mapie stron (array_key_exists).

5. Jeśli klucz nie jest tekstem (np. tablica) lub nie ma go w mapie:
   - Ustaw kod odpowiedzi HTTP 404 (Not Found).
   - Zapisz komunikat o braku podstrony i nie ładuj żadnego pliku.

6. Jeśli klucz jest poprawny:
   - Pobierz tytuł widoku z mapy.
   - Zbuduj bezpieczną ścieżkę systemową za pomocą stałej __DIR__ oraz ścieżki z mapy.
   - Sprawdź funkcjami is_file() oraz is_readable(), czy plik fizycznie istnieje i da się go odczytać.

7. Jeśli plik nie istnieje lub brak uprawnień do odczytu:
   - Ustaw kod odpowiedzi HTTP 500 (Internal Server Error).
   - Zapisz ogólny komunikat błędu (bez ujawniania ścieżki systemowej serwera).

8. Wygeneruj wspólny szablon HTML (nagłówek, dynamiczne menu z atrybutem aria-current="page", main, stopka).

9. Wewnątrz sekcji <main>: jeśli wystąpił błąd (404 lub 500), wyświetl komunikat i link powrotny; w przeciwnym razie dołącz zweryfikowany plik za pomocą include.



## 3. Raport z testów aplikacji

**Adres domyślny i menu**
Wejście na "index.php" oraz "index.php?idp=" otwiera stronę główną. Klikanie w menu podmienia samą treść podstrony bez przeładowywania reszty szablonu, zmienia tytuł karty i podświetla aktywny link ("aria-current").

**Nieznany lub tablicowy klucz**
Wpisanie w adresie "?idp=nieznana" albo "?idp[]=filmy" zwraca w sieci błąd HTTP 404. Strona wyświetla komunikat o braku podstrony i link powrotny, bez wyrzucania błędów PHP.

**Próba podania ścieżki**
Wpisanie "?idp=..%2Fstatus.php" również kończy się kodem HTTP 404. Zawartość pliku status.php nie zostaje dołączona, bo skrypt szuka tylko dokładnych kluczy z mapy zamiast sklejać ścieżkę z adresu.

**Brak pliku widoku**
Po tymczasowej zmianie nazwy pliku "html/filmy.html" wejście na "?idp=filmy" zwraca kod HTTP 500. Zabezpieczenie blokuje dołączenie brakującego pliku i pokazuje ogólny komunikat bez zdradzania ścieżek na dysku.

**Strona główna i AJAX**
Po przeniesieniu do szablonu na stronie głównej normalnie działają style CSS, zdjęcia, wyszukiwarka, zegar i animacje. Przycisk sprawdzania serwera wysyła zapytanie do "status.php" (w sieci widać status 200) i wypisuje odpowiedź.

**Katalog i sesja po migracji**
W zakładce "Katalog PHP" ("lab4.php") działa filtrowanie oraz zapisywanie wyboru do koszyka (w sieci widać przekierowanie POST 303 i GET 200). Po przejściu na inne podstrony i powrocie do katalogu wybrany produkt nadal siedzi w sesji.

**Filmy i układ mobilny**
Na podstronie "?idp=filmy" wszystkie trzy osadzone materiały z YouTube normalnie się odtwarzają, a do linków pod nimi można przejść klawiszem Tab. Po zwężeniu okna do 360 px odtwarzacze skalują się do ekranu i nie pojawia się poziomy pasek przewijania.



## 4. Zdiagnozowane problemy

**Problem 1:**
Po przeniesieniu zawartości strony głównej do "html/glowna.html" zniknęło pole wyszukiwania oraz licznik produktów.

**Rozwiązanie:**
Elementy wyszukiwarki znajdowały się w oryginalnym nagłówku <header> zamiast w sekcji <main>. Przywrócono je do głównego szablonu w "index.php", dzięki czemu wyszukiwarka działa na całej stronie.


**Problem 2:**
Brak ładowania obrazków na podstronie "Produkt" po przejściu na dynamiczne dołączanie fragmentów w "index.php".

**Rozwiązanie:**
Pliki w folderze "html/" miały ścieżki względne z prefiksem "../img/", które działały tylko przy bezpośrednim otwieraniu plików z podfolderu. Ponieważ przeglądarka liczy ścieżki od lokalizacji "index.php" w katalogu głównym, zmieniono je na "img/".


**Problem 3:**
Błąd "ERR_BLOCKED_BY_RESPONSE" w ramkach iframe na podstronie z filmami.

**Rozwiązanie:**
W atrybucie "src" użyto zwykłego adresu URL filmu, który jest blokowany przez nagłówki bezpieczeństwa YouTube wewnątrz ramek. Podmieniono adresy na oficjalny format osadzania ("youtube.com/embed/...").