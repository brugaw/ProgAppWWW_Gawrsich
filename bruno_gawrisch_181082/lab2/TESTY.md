# Raport z testów - Laboratorium 2

**Przeglądarka:** 

Opera GX 154.0.8037.99


## 1. Motyw i nawigacja
* **Oczekiwany wynik:**
Zmiana motywu utrzymuje się po odświeżeniu i zmianie podstrony; aria-pressed odpowiada stanowi.

* **Zaobserwowany wynik:** 
Przełączanie motywu oraz pamięć (localStorage) zadziałały od razu. Błąd wizualny: Przycisk zmiany motywu rozciągał się na całą szerokość ekranu. 

* **Przyczyna:**
Dziedziczył styl width: 100% z formularza.

* **Poprawka:**
Dodano regułę width: auto i margin-left: auto dla #przycisk-motywu w CSS.


## 2. Start trzy razy potem Stop i Start
* **Oczekiwany wynik:**
Działa jeden interwał; Stop zatrzymuje aktualizację, a wznowienie pokazuje aktualny czas.

* **Zaobserwowany wynik:**
Przyciski na początku nie reagowały na kliknięcie.

* **Przyczyna:**
Rozminięcie nazw atrybutów id w HTML z nazwami szukanymi w JavaScript.

* **Poprawka:**
Ujednolicono identyfikatory w HTML. Po poprawce wielokrotny Start poprawnie blokuje tworzenie nowych interwałów.


## 3. Fragment nazwy ze spacjami i inną wielkością liter
* **Oczekiwany wynik:**
Pasujące karty pozostają widoczne; licznik zgadza się z widokiem.

* **Zaobserwowany wynik:**
Wyszukiwarka początkowo nie działała.

* **Przyczyna:**
Złe ID pola w JS.

* **Poprawka:**
Poprawa ID na zgodne. Po poprawce filtracja działa prawidłowo (np. " tReK ").


## 4. Brak dopasowania i wyczyszczenie pola
* **Oczekiwany wynik:**
Pojawia się komunikat o braku wyników; wyczyszczenie przywraca trzy karty.

* **Zaobserwowany wynik:**
Po wpisaniu znaków bez sensu zniknęły wszystkie karty, a licznik pokazał "Brak wyników". Skasowanie tekstu przywróciło 3 karty.

* **Poprawka:**]
Brak.


## 5. Cena 1999 gr oraz ilość 3
* **Oczekiwany wynik:**
Dla roweru Trek (15999 PLN) i ilości 3, wynik to 47 997,00 zł.

* **Zaobserwowany wynik:**
Kalkulator przeliczył w groszach (1599900 * 3) i poprawnie wyświetlił wartość 47 997,00 zł nad podglądem.

* **Poprawka:**
Brak.


## 6. Ilość pusta, 0, 6 oraz 1,5
* **Oczekiwany wynik:**
Wycena nie pokazuje błędnej wartości; formularz nie przechodzi do poprawnego podsumowania.

* **Zaobserwowany wynik:**
Skrypt odrzucił błędne wartości. Wyświetlił się domyślny komunikat o konieczności podania danych. Podgląd nie został wyświetlony.

* **Poprawka:**
Brak.


## 7. Dziesięć spacji oraz tekst <b>Test</b>
* **Oczekiwany wynik:**
Same spacje są odrzucone; poprawna wiadomość ze znacznikami jest pokazana jako dosłowny tekst.

* **Zaobserwowany wynik:**
Po wpisaniu spacji formularz nie wysłał zapytania i pokazał komunikat o błędzie z użyciem metody focus(). Wpisanie :<b>Test</b>` (z odpowiednią długością) zostało wyświetlone dosłownie w podglądzie, nie jako pogrubiony tekst.

* **Poprawka:**
Brak.


## 8. Klawiatura, widoki i wyłączony JS
* **Oczekiwany wynik:**
Kontrolki działają klawiaturą przy 375 i 1280 px; bez JS katalog, treść i menu pozostają dostępne.

* **Zaobserwowany wynik:**
Na obu rozdzielczościach można przejść Tabulatorem po elementach. Po wyłączeniu JavaScriptu układ strony ładuje się poprawnie.

* **Poprawka:**
Brak.
