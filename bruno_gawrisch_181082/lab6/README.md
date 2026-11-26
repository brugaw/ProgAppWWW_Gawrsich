# Dokumentacja projektu – Lab 6: MySQL (PDO), podstrony i obsługa błędów

## 1. Instrukcja uruchomienia i konfiguracji

Projekt wykorzystuje serwer Apache oraz bazę danych MySQL (MariaDB) w środowisku XAMPP wraz z rozszerzeniem PDO (pdo_mysql).

1. Skopiuj folder lab6 do katalogu htdocs (domyślnie C:\xampp\htdocs\lab6), otwórz panel sterowania XAMPP i uruchom moduły **Apache** oraz **MySQL** (oba powinny podświetlić się na zielono).

2. W panelu XAMPP kliknij **Admin** przy **MySQL**, aby otworzyć **phpMyAdmin**, a następnie:
   - przejdź do zakładki **Bazy danych**, utwórz bazę o nazwie moja_strona z kodowaniem utf8mb4_unicode_ci (lub utf8mb4_general_ci),
   - wejdź w bazę moja_strona -> zakładka **Import**, wybierz plik sql/schema.sql i zaimportuj strukturę tabel,
   - ponownie wejdź w **Import** w bazie moja_strona, wybierz plik sql/seed.sql i zaimportuj dane początkowe do tabeli page_list.

3. Utwórz lokalnego użytkownika bazy z uprawnieniem wyłącznie do odczytu tabeli page_list:
   - w **phpMyAdmin** przejdź na stronę główną serwera i otwórz zakładkę **Konta użytkowników**,
   - kliknij **Dodaj konto użytkownika**, podaj nazwę (np. cms_reader), host localhost oraz własne hasło (nie puste i nie domyślne),
   - utwórz konto bez zaznaczania uprawnień globalnych,
   - wróć do **Konta użytkowników**, wejdź w **Edytuj uprawnienia** dla utworzonego konta, w sekcji uprawnień dla bazy moja_strona przy tabeli page_list zaznacz wyłącznie SELECT i zapisz zmiany.

4. Skonfiguruj połączenie aplikacji z bazą danych:
   - w katalogu lab6 skopiuj plik cfg.example.php jako cfg.php,
   - wpisz w cfg.php dane połączenia (host, port, dbname=moja_strona, charset=utf8mb4, login oraz hasło),
   - sprawdź, czy cfg.php znajduje się w .gitignore, aby nie trafiał do repozytorium.

5. Otwórz w przeglądarce adres http://localhost/lab6/index.php i zweryfikuj ładowanie podstron z bazy.

6. Główne pliki wejściowe w projekcie:
   - index.php – główny punkt wejścia ładujący cfg.php i showpage.php, obsługujący parametr idp, menu oraz błędy 404 i 500,
   - showpage.php – zawiera funkcję PokazPodstrone pobierającą opublikowaną podstronę (status = 1) zapytaniem przygotowanym z parametrem :alias,
   - lab4.php – katalog produktów z filtrowaniem GET, obsługą sesji oraz przekierowaniem POST -> 303 -> GET 200,
   - admin/admin.php – szkielet panelu administracyjnego przygotowany pod kolejne laboratoria.

## 2. Logika działania (pseudokod i przebieg)

**Konfiguracja PDO i pobieranie podstrony (cfg.php, showpage.php, index.php)**

1. W cfg.php zainicjuj obiekt $pdo dla sterownika pdo_mysql (charset=utf8mb4), włączając PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION i wyłączając PDO::ATTR_EMULATE_PREPARES`. W razie błędu połączenia zwróć kod HTTP 500 i ogólny komunikat o błędzie.

2. W showpage.php zdefiniuj funkcję PokazPodstrone($pdo, $alias), która przygotowuje (prepare) i wykonuje (execute) zapytanie:
   
   SELECT id, page_title, page_content FROM page_list WHERE alias = :alias AND status = 1 LIMIT 1

   i zwraca znaleziony wiersz lub null.

3. W index.php pobierz parametr idp (domyślnie glowna, gdy brak parametru lub jest pusty) i sprawdź zgodność z wyrażeniem /^[a-z0-9-]{1,20}$/.

4. W bloku try/catch pobierz opublikowane pozycje menu (Status = 1, sortowane po id), a następnie wywołaj PokazPodstrone($pdo, $alias).

5. Jeśli idp nie przejdzie walidacji lub okazPodstrone zwróci null, ustaw kod HTTP 404 i komunikat o nieistniejącej podstronie. Jeśli wystąpi wyjątek PDO, ustaw kod HTTP 500 i ogólny komunikat bez ujawniania szczegółów połączenia lub zapytania.

6. Wyrenderuj dokument HTML: bezpieczne wartości escapuj funkcją htmlspecialchars(..., ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8"), dla aktywnego linku przy statusie 200 dodaj aria-current="page", a dla poprawnej podstrony wyrenderuj $page["page_content"].

## 3. Raport z testów aplikacji

**Odczyt i aktualizacja treści:**
Wejście na index.php oraz index.php?idp=glowna zwraca kod HTTP 200. Edycja pola page_content w phpMyAdmin i odświeżenie strony od razu pokazuje nową treść bez modyfikacji plików PHP/HTML.

**Nowa strona i menu:**

Dodanie nowego rekordu ze statusem 1 i unikalnym aliasem powoduje automatyczne pojawienie się pozycji w menu, otwarcie podstrony przez index.php?idp=<alias> oraz ustawienie aria-current="page" na aktywnym odnośniku.

**Szkic i unikalność aliasu:**
Rekord szkic-test ze statusem 0 nie jest widoczny w menu, a bezpośrednie wywołanie index.php?idp=szkic-test zwraca HTTP 404. Zmiana statusu na 1 udostępnia stronę, natomiast próba dodania drugiego rekordu z tym samym aliasem kończy się błędem indeksu UNIQUE.

**Niepoprawne parametry idp:**

Żądania typu ?idp=nieznana, ?idp[]=filmy, ?idp=../cfg.php oraz ciągi z cudzysłowami i operatorami SQL zwracają w narzędziach deweloperskich przeglądarki kod HTTP 404 bez ostrzeżeń PHP.

**Błąd bazy i odtworzenie środowiska:**
Po tymczasowym wpisaniu błędnego portu w cfg.php aplikacja zwracała HTTP 500 bez szczegółów technicznych (po teście przywrócono właściwy port). Ponowny import sql/schema.sql i sql/seed.sql na czystej bazie przebiega bez błędów i zachowuje polskie znaki.

**Funkcje z wcześniejszych laboratoriów:**

Style, grafiki, animacje, AJAX, materiały wideo oraz katalog w lab4.php działają poprawnie. Zapis wyboru w katalogu realizuje przejście POST -> 303 -> GET 200, a stan utrzymuje się w sesji podczas przechodzenia między podstronami.

## 4. Zdiagnozowane problemy

**Problem 1: Szukanie statycznych plików widoków zamiast pobierania treści z bazy**
Po uruchomieniu index.php aplikacja nadal sprawdzała pliki na dysku i zwracała błąd Plik widoku niedostępny.
*Rozwiązanie:* Usunięto przestarzałą tablicę mapowania plików i weryfikację istnienia plików na dysku, zastępując je wywołaniem PokazPodstrone() z showpage.php.

**Problem 2: Niepoprawne ścieżki w nawigacji z poziomu lab4.php**
Podczas przechodzenia z katalogu (lab4.php) do innych sekcji część linków nie działała poprawnie.
*Rozwiązanie:* W includes/naglowek.php zaktualizowano dawne odnośniki do plików HTML na adresy oparte o index.php?idp=...

**Problem 3: Obsługa rekordów nieopublikowanych (szkic-test) i wyjątków PDO**
Należało jednoznacznie rozdzielić strony robocze od opublikowanych oraz zabezpieczyć aplikację przed wypisywaniem surowych komunikatów błędów bazy danych.
*Rozwiązanie:* Przyjęto, że rekord szkic-test ma status = 0 i jest odrzucany przez filtr status = 1 (zwracając 404), a połączenie i zapytania PDO objęto blokami try/catch zwracającymi ogólny komunikat oraz kod HTTP 500.