# sklep rowerowy - Lab 2



## Instrukcja uruchomienia



**Aby projekt zadziałał poprawnie i ładował zasoby przy użyciu ścieżek względnych, należy go uruchomić przez lokalny serwer HTTP.**

1. Otwórz terminal wewnątrz folderu "lab2/"

2. Uruchom serwer testowy dla Pythona 3 poleceniem:



python -m http.server 8000



3. Otwórz przeglądarkę i wejdź pod adres:



http://localhost:8000/



## Opis przepływu danych

* **Zdarzenie:**
Użytkownik wybiera produkt i wpisuje ilość.

* **Dane wejściowe:**
Skrypt pobiera id z pola produktu oraz ilość. Ilość konwertowana jest z typu tekstowego na typ Number.

* **Obliczenie:**
Funkcja mnoży cenę bazową w groszach przez ilość sztuk, sprawdzając, czy wartość mieści się w dopuszczalnych limitach (od 1 do 5).

* **Zmiana DOM:**
Na podstawie wyniku obliczeń użyto "textContent" do bezpiecznej aktualizacji akapitu nad podglądem. Po poprawnym zdarzeniu "submit" i zablokowaniu domyślnej wysyłki, skrypt zdejmuje atrybut "hidden" z sekcji i wstrzykuje wycenę.



## Źródła grafik

Grafiki rowerów zostały w całości wygenerowane w ChatGPT.

