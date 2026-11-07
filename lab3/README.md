# Dokumentacja projektu - Lab 3 jQuery i AJAX


## 1. Instrukcja uruchomienia projektu

Projekt korzysta z zapytań do serwera PHP, dlatego nie można go odpalić lokalnie z dysku ani przez Live Server. Wymagane jest środowisko XAMPP.

1. Skopiuj cały folder z projektem i wklej go do katalogu "htdocs" w miejscu instalacji XAMPP (domyślnie "C:\xampp\htdocs").

2. Otwórz panel XAMPP i uruchom moduł apache.

3. Wejdź w przeglądarce pod adres: "http://localhost/lab3/".

4. Gotowe. Wszystkie testy (w tym komunikacja AJAX) muszą być wykonywane pod tym adresem.



## 2. Użyta wersja jQuery

W projekcie wykorzystano lokalnie podpiętą bibliotekę jQuery w wersji 4.0.0 (plik "vendor/jquery-4.0.0.min.js")

Zastosowano pełną, zminifikowaną wersję biblioteki. Wersja "slim" została odrzucona, ponieważ nie zawiera modułu efektów (wymaganego do animacji) oraz modułu AJAX (niezbędnego do połączenia z plikiem PHP).



## 3. Pseudokody (Logika JS)

**Animacja A -Kliknięcie i przełączanie stanu:**

1. Odczytaj zmienną stanu powiększenia obiektu.

2. Złap kliknięcie przycisku.

3. Jeśli jest powiększony: zmień stan na "false", popraw atrybut "aria-pressed", zatrzymaj kolejkę animacji i pomniejsz go do 160x90 px.

4. Jeśli nie jest powiększony: zmień stan na "true", popraw "aria-pressed", zatrzymaj kolejkę i powiększ go do 240x130 px.


**Animacja B -Hover i Focus:**

1. Utwórz zmienne logiczne dla stanu najechania myszą i stanu focus z klawiatury.

2. Nasłuchuj zdarzeń "mouseenter", "mouseleave", "focus" i "blur", odpowiednio aktualizując zmienne.

3. Jeśli mysz jest na obiekcie lub obiekt ma focus klawiatury: zatrzymaj kolejkę i powiększ go do 220x120 px.

4. W przeciwnym razie: zatrzymaj kolejkę i przywróć wymiary domyślne 160x90 px.


**Animacja C -Kroki z limitem do 5:**

1. Zdefiniuj licznik kroków (startowo na 0).

2. Po kliknięciu sprawdź zabezpieczenia: jeśli obiekt aktualnie się animuje lub licznik dobił do 5 – przerwij kod.

3. Podbij licznik o 1.

4. Wylicz nową szerokość (baza 160 + kroki * 20) i wysokość (baza 90 + kroki * 10).

5. Zaktualizuj licznik widoczny na przycisku i w polu ze statusem dla czytników.

6. Zatrzymaj kolejkę i animuj do wyliczonych wymiarów.


**Komunikacja z serwerem PHP -AJAX:**

1. Po kliknięciu przypnij do przycisku atrybut "disabled", żeby zablokować kolejne kliknięcia, i wyświetl komunikat o ładowaniu.

2. Wyślij zapytanie GET do pliku status.php z nałożonym limitem czasu.

3. Jeśli status to 200 OK (.done): wpisz do pola tekstowego odpowiedź serwera.

4. Jeśli jest błąd (.fail): wpisz do pola powód awarii.

5. Zawsze po zakończeniu zapytania (.always): odblokuj przycisk, zdejmując atrybut "disabled".




## 4. Raport z testów aplikacji

**Szybkie klikanie A**

Klikanie 10 razy z rzędu nie powoduje błędu powtarzania animacji w pętli. Użycie metody stop(true, false) przed każdą funkcją animującą poprawnie czyści pamięć i przerywa ruch w trakcie.


**Obsługa myszy i klawiatury B**

Zmiana rozmiaru zachodzi płynnie i nie resetuje się błędnie, gdy ruszamy myszką podczas zaznaczenia z klawiatury. Zapewnia to rozdzielenie stanów hover i focus w logice.


**Blokady kliknięć (C)**

Element powiększa się poprawnie, a wymiary zatrzymują się równo po 5 krokach na 260x140 px. Zastosowano filtr .is(":animated"), więc szybkie wielokrotne kliknięcie nie nabija fałszywie licznika.

**Wsparcie dla "prefers-reduced-motion"**

Test wykonano po włączeniu w systemie opcji ograniczenia ruchu (ułatwienia dostępu). Kod odczytuje ten stan i wymusza w jQuery opcję $.fx.off = true. Zmiany wymiarów następują zgodnie z wytycznymi w trybie natychmiastowym, co chroni użytkowników wrażliwych na animacje.



## 5. Zdiagnozowane problemy (Troubleshooting)

* **Problem 1:**
Zapytanie ajax wyrzucało na stronie surowy kod skryptu: "<?php header(...)" zamiast poprawnego wyniku.

* **Rozwiązanie:**
Środowisko było błędne, strona została uruchomiona poprzez wcześniejszy "localhost:8000", który nie przetwarza plików PHP. Uruchomienie projektu przez serwer Apache w środowisku XAMPP rozwiązało problem.

* **Problem 2:**
Zła logika wyliczania wymiarów obiektu C. Przycisk rósł na szerokość, ale skokowo malał na wysokość przy pierwszym kliknięciu.

* **Rozwiązanie:**
Skorygowano bazową wartość wysokości w algorytmie poprawną bazową wysokością.
