# Dokumentacja projektu - Lab 4 PHP formularze i sesja


## 1. Instrukcja uruchomienia projektu

Projekt wymaga środowiska XAMPP do obsługi sesji i żądań POST na serwerze Apache.

1. Skopiuj cały folder z projektem i wklej go do katalogu "htdocs" w miejscu instalacji XAMPP (domyślnie "C:\xampp\htdocs").

2. Otwórz panel XAMPP i uruchom moduł apache.

3. Wejdź w przeglądarce pod adres: "http://localhost/lab4/".

4. Wszystkie funkcjonalności testuj w zakładce "Katalog PHP" (plik "lab4.php").


## 2. Pseudokody (Logika PHP)

**Poprawne żądanie POST (sukces):**

1. Odbierz dane z formularza ("produkt" i "ilosc").

2. Sprawdź, czy wartości są liczbami całkowitymi (walidacja).

3. Odszukaj produkt w tablicy po przesłanym ID.

4. Sprawdź, czy ilość mieści się w przedziale 1-5 oraz czy nie przekracza stanu magazynowego.

5. Zapisz ID i ilość w zmiennej sesyjnej $_SESSION.

6. Wyślij nagłówek HTTP 303 (przekierowanie na "lab4.php") i zakończ skrypt, żeby nie wysyłać HTML.


**Błędne żądanie POST (porażka):**

1. Jeśli dane nie są liczbami, brakuje ich lub wykraczają poza limity (stan magazynowy).

2. Ustaw kod błędu HTTP 400 (Bad Request).

3. Przygotuj odpowiedni komunikat błędu tekstowego.

4. Zakończ walidację bez dotykania sesji (stary wybór w koszyku zostaje).

5. Wyświetl błąd obok formularza w wygenerowanym HTML.



## 3. Raport z testów aplikacji

**Filtr GET**

Wybór kategorii z listy poprawnie zmienia URL i filtruje katalog. Ręczne wpisanie w adresie nieznanej kategoriiresetuje filtr, pokazuje pełną listę i wyrzuca czerwony komunikat.


**Poprawny POST i odświeżenie**

Wybranie dostępnego produktu zapisuje go w koszyku na górze strony. W zakładce Network (Sieć) widać przekierowanie 303, a następnie GET 200. Dzięki temu odświeżenie strony (F5) nie wysyła ponownie formularza.


**Stan magazynowy**

Dla produktu ze stanem 1 próba wybrania 2 sztuk kończy się odrzuceniem żądania. Serwer zwraca kod HTTP 400 i blokuje zapis, informując o braku towaru.


**Błędne wartości POST**

Testowano ilości takie jak: 0, 6, 2.5, "2abc" oraz brak pola. Każda próba daje HTTP 400, wyświetla błąd i pozostawia w sesji poprzedni wybór. Filtr "FILTER_VALIDATE_INT" skutecznie ucina błędne dane.


**Odrębna sesja i tekst HTML**

Uruchomienie strony w oknie incognito tworzy nową sesję (koszyk jest pusty). Zastosowano funkcję "htmlspecialchars()", więc ewentualne tagi HTML w nazwie produktu (np. <b>) wyświetlają się jako zwykły tekst, chroniąc przed XSS.


**Strona po zmianie ścieżek**

Zmieniono układ folderów. Strona główna oraz podstrony w "html/" działają poprawnie. Style CSS, obrazki oraz skrypty z laboratorium 3 (animacje i AJAX) ładują się bez błędów dzięki aktualizacji prefiksów na "../".



## 4. Zdiagnozowane problemy

**Problem 1:**
Brak stylów CSS oraz niedziałające przyciski w menu na podstronach "produkt.html" i "kontakt.html".

**Rozwiązanie:**
Podstrony zostały przeniesione do nowego podfolderu "html/". Aby załadować skrypty i style z głównego katalogu, zaktualizowano w nich ścieżki poprzez dodanie "../" na początku (np. "../css/style.css").


**Problem 2:**
Błąd 404 (Not Found) podczas prób przechodzenia między podstronami a stroną główną.

**Rozwiązanie:**
Poprawiono literówki w linkach nawigacyjnych oraz zaktualizowano odnośniki w głównym pliku, dodając folder docelowy.