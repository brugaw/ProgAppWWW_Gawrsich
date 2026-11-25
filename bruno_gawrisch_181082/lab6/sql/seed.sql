USE moja_strona;

INSERT INTO page_list (alias, page_title, page_content, status) VALUES
('glowna', 'Strona Główna', '
<section class="katalog">
    <h2>Katalog rowerow gorskich</h2>

    <article class="karta">
        <h3><a href="index.php?idp=produkt">Santa Cruz</a></h3>
        <img src="img/Santa_Cruz.png" alt="ciemno-fioletowy rower typu full przednia oraz tylnia amortyzacja" width="1536" height="1024">
        <p>Agresywny rower enduro o dużym skoku zawieszenia na najtrudniejsze górskie zjazdy.</p>
        <p><strong> Cena: 19 499 PLN</strong></p>
    </article>

    <article class="karta produktu">
        <h3><a href="index.php?idp=produkt">Trek</a></h3>
        <img src="img/Trek.png" alt="ciemno-zielony rower typu hardtail mtb z przednia amortyzacja" width="1312" height="1199">
        <p>Wszechstronny rower ścieżkowy łączący lekkie podjeżdżanie z pewnością na zjazdach.</p>
        <p><strong> Cena: 15 999 PLN</strong></p>
    </article>

    <article class="karta produktu">
        <h3><a href="index.php?idp=produkt">Canyon</a></h3>
        <img src="img/Canyon.png" alt="szary rower typu full przednia oraz tylnia amortyzacja" width="1536" height="1024">
        <p>Karbonowa maszyna allmountain gotowa na bikeparki, dropy i strome sekcje skalne jak i na spokojne długie trasy.</p>
        <p><strong> Cena: 17 649 PLN</strong></p>
    </article>
</section>

<p class="czas">
    <span id="wyswietlacz-zegara">Aktualizacja czasu...</span>
    <button type="button" id="zegar-start" aria-pressed="true">Start zegara</button>
    <button type="button" id="zegar-stop" aria-pressed="false">Stop zegara</button>
</p>

<section class="karta">
    <h2>Animacje</h2>
    <p class="przyciski-animacji">
        <button type="button" id="animacja-1" class="btn-anim" aria-pressed="false">A: kliknij</button>
        <button type="button" id="animacja-2" class="btn-anim" aria-pressed="false">B: najedz</button>
        <button type="button" id="animacja-3" class="btn-anim" aria-pressed="false">C: krok</button>
    </p>
    <p role="status" id="status-krokow"> kroki obiektu C: 0/</p>
    <button type="button" id="btn-reset">resetuj A i C</button>

    <hr>
    <h3>Komunikacja z serwerem PHP</h3>
    <button type="button" id="btn-ajax">Sprawdź</button>
    <p role="status" id="status-ajax">Oczekuje na rządanie</p>
</section>
', 1),

('produkt', 'Produkt', '
    <article class="karta">
            <h2><a href="index.php?idp=produkt">Santa Cruz</a></h2>
            <img src="img/Santa_Cruz.png" alt="ciemno-fioletowy rower typu full przednia oraz tylnia amortyzacja" width="1536" height="1024">
            <p>
                Rower <strong> Santa Cruz</strong> został zaprojektowany z myślą o 
                <em>ekstremalnych trasach zjazdowych</em> oraz zawodach enduro. Wytrzymała rama i nowoczesna geometria zapewniają pełną kontrolę przy dużych prędkościach.
            </p>
            <p><strong> Cena: 19 499 PLN</strong></p>

    <h3>Główne cechy roweru</h3>
    <ul>
        <li>Aluminiowa rama z wewnętrznym prowadzeniem linek.</li>
        <li>Zawieszenie FOX o skoku 170 mm z przodu i 160 mm z tyłu.</li>
        <li>Napęd 1x12 SRAM GX Eagle zapewniający szeroki zakres przełożeń.</li>
        <li>Hydrauliczne hamulce gwarantujące pewne hamowanie.</li>
    </ul>

    <table>
        <caption>Specyfikacja techniczna roweru Santa Cruz</caption>
        <thead>
        <tr>
            <th scope="col">Parametr</th>
            <th scope="col">Wartość</th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td>Rozmiar kół</td>
            <td>29 cali</td>
        </tr>
        <tr>
            <td>Skok zawieszenia (przód / tył)</td>
            <td>170 mm / 160 mm</td>
        </tr>
        <tr>
            <td>Waga roweru</td>
            <td>15,4 kg</td>
        </tr>
        <tr>
            <td>Materiał ramy</td>
            <td>Aluminium</td>
        </tr>
        </tbody>
    </table>

    <p><a href="index.php?idp=kontakt">Zapytaj o produkt</a></p>
    </article>
', 1),

('kontakt', 'Kontakt', '
    <section class="karta">
        <h2>Formularz zapytania o produkt</h2>
        <p>Podgląd lokalny. Formularz nie wysyła wiadomości.</p>

        <form method="get">
            <label for="email">Twój adres e-mail (wymagane, format nazwa@domena.pl):</label>
            <input type="email" id="email" name="email" required>

            <label for="produkt">Wybierz model roweru (wymagane):</label>
            <select id="produkt" name="produkt" required>
                <option value="">Wybierz produkt</option>
                <option value="trek-slash-8">Trek</option>
                <option value="canyon-spectral-29">Canyon</option>
                <option value="santa-cruz-nomad">Santa Cruz</option>
            </select>

            <label for="ilosc">Liczba sztuk (wymagane, od 1 do 5):</label>
            <input type="number" id="ilosc" name="ilosc" min="1" max="5" step="1" required>

            <label for="wiadomosc">Wiadomość (wymagane, od 10 do 500 znaków):</label>
            <p id="blad-wiad" hidden></p>
            <textarea id="wiadomosc" name="wiadomosc" minlength="10" maxlength="500" rows="4" required></textarea>

            <button type="submit">Sprawdź zapytanie</button>
        </form>
        
        <p id="info-wycena">Wprowadź dane, a wyświetli się tu łaczna wartość</p>
        <section id="podglad" hidden>
            <h3>Twoje zapytanie:</h3>
            <p>Rower: <span id="p-rower"></span></p>
            <p>Sztuk: <span id="p-ilosc"></span></p>
            <p>Do zapłaty: <span id="p-cena"></span></p>
            <p>Treść: <span id="p-tresc"></span></p>
        </section>
    </section>
', 1),

('filmy', 'Filmy', '
    <h2>Materiały wideo - Rowery Górskie</h2>

    <article style="margin-bottom: 30px;">
        <h3>przykładowy proces składania roweru</h3>
        <iframe 
            src="https://www.youtube.com/embed/X_5om8O9iu8?si=oHt_G5JxkccsQUCv" 
            title="Film przedstawiający przykładowy proces składania roweru SantaCruz od podstaw" 
            style="width: 100%; aspect-ratio: 16/9; min-height: 200px; border: none;" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
        </iframe>
        <p><a href="https://youtu.be/X_5om8O9iu8?si=BXSKcsPCYcGdI7b-" target="_blank" rel="noopener">Obejrzyj materiał bezpośrednio w serwisie YouTube</a></p>
    </article>

    <article style="margin-bottom: 30px;">
        <h3>Taka tam "przejażdżka"</h3>
        <iframe 
            src="https://www.youtube.com/embed/oQDLAoPs-as?si=aOj1xIAhW0zyM9Ls" 
            title="Prezentacja i test porównawczy rowerów marki Trek" 
            style="width: 100%; aspect-ratio: 16/9; min-height: 200px; border: none;" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
        </iframe>
        <p><a href="https://youtu.be/oQDLAoPs-as?si=aOj1xIAhW0zyM9Ls" target="_blank" rel="noopener">Obejrzyj materiał bezpośrednio w serwisie YouTube</a></p>
    </article>

    <article style="margin-bottom: 30px;">
        <h3>klasyczny "aerodynamiczny"</h3>
        <iframe 
            src="https://www.youtube.com/embed/ubeq-8I0mlM?si=kZiiqlsuHwjuDCVB"
            title="Test karbonowej maszyny all-mountain od firmy Canyon" 
            style="width: 100%; aspect-ratio: 16/9; min-height: 200px; border: none;" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
        </iframe>
        <p><a href="https://www.youtube.com/watch?v=ubeq-8I0mlM" target="_blank" rel="noopener">Obejrzyj materiał bezpośrednio w serwisie YouTube</a></p>
    </article>
', 1),

('szkic-test', 'Szkic roboczy', '
<p>Ten wpis jest szkicem i nie powinien być widoczny w menu</p>
', 0);
