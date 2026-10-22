Laboratorium 1

Przeglądarka:
Opera GX 153.0.8010.55

1. Struktura i walidacja

Oczekiwany wynik: 0 błędów w walidatorze i logiczny układ nagłówków bez CSS.

Walidator W3C nie wykazał błędów dla plików index.html, produkt.html i kontakt.html. Po wyłączeniu stylów treść układa się prawidłowo od nagłówka h1 w dół.

2. Widoki responsywne

Oczekiwany wynik: Zmiana z 1 na 3 kolumny przy 768px i zdjęcia nie wychodzące za ekran.

Przejście przez granicę 768 px poprawnie zmienia układ CSS Grid z 1 na 3 kolumny. Obrazy zachowują proporcje i mieszczą się w kontenerach.

3. Obsługa klawiatury

Oczekiwany wynik: Płynne poruszanie się Tabem po elementach i widoczny obrys.

Interaktywne elementy otrzymują wyraźny obrys (focus). Linki można aktywować klawiszem Enter. Etykiety <label> prawidłowo przekazują kursor do powiązanych z nimi pól <input> i select>.

4. Walidacja formularza

Próba wysłania pustego formularza, maila bez "@", ilości "0" lub "6" oraz 5-znakowej wiadomości zatrzymała wysyłkę z odpowiednim komunikatem przeglądarki. Po podaniu poprawnych danych URL zawierał cztery parametry z odpowiednimi wartościami.

5. Eksperyment

Oczekiwany wynik: Pole będzie działać, ale jego wartość nie wyśle się w adresie URL.

Po usunięciu name="email" i wysłaniu, w URL pojawiły się inne pola, ale maila zabrakło.

id łączy pole z etykietą <label>, ale name jest kluczem, który wysyła dane do serwera. Po teście przywróciłem name.