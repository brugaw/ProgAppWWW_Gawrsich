function initMotyw(){
    let przycisk = document.getElementById("przycisk-motywu");
    if (!przycisk) return;
    
    let motyw = localStorage.getItem("motyw");
    if (!motyw) {motyw = "light"};

    document.documentElement.setAttribute("data-theme", motyw);

    if (motyw == "dark") {
        przycisk.setAttribute("aria-pressed", "true");
    } else {
        przycisk.setAttribute("aria-pressed", "false");
    }

    przycisk.addEventListener("click", function() {
        let obecnyMotyw = document.documentElement.getAttribute("data-theme");
        
        if (obecnyMotyw === "light") {
            document.documentElement.setAttribute("data-theme", "dark");
            przycisk.setAttribute("aria-pressed", "true");
            localStorage.setItem("motyw", "dark");
        } else {
            document.documentElement.setAttribute("data-theme", "light");
            przycisk.setAttribute("aria-pressed", "false");
            localStorage.setItem("motyw", "light");
        }
    });
}

function initZegar(){
    let wyswietlacz = document.getElementById("wyswietlacz-zegara");
    if(!wyswietlacz) return;

    let zegStart = document.getElementById("zegar-start");
    let zegStop = document.getElementById("zegar-stop");
    let interwal = null

    let opcje = {
                    year: "numeric",
                    month: "2-digit",
                    day: "2-digit",
                    hour: "2-digit",
                    minute: "2-digit",
                    second: "2-digit",
                    hour12: false
                };
    let formatCzasu = new Intl.DateTimeFormat("pl-PL", opcje);
                
    function aktualizuj() {
        wyswietlacz.textContent = formatCzasu.format(new Date());
    }
   
    aktualizuj();
    interwal = setInterval(aktualizuj, 1000);

    zegStart.addEventListener("click", function(){
        if(!interwal) {
            aktualizuj();
            interwal = setInterval(aktualizuj, 1000)
        }
    });

    zegStop.addEventListener("click", function(){
            clearInterval(interwal);
            interwal = null;
        });
}

function initWyszukiwarka(){
    let pole = document.getElementById("szukaj");
    if(!pole) return;

    let licznik = document.getElementById("licznik")

    pole.addEventListener("input", function() {
        let wpisane = pole.value.trim().toLowerCase();
        let karty = document.querySelectorAll(".katalog article");
        let ile = 0;

        karty.forEach(function(karta){
            let nazwa = karta.querySelector("h3").textContent.toLowerCase();

            if (nazwa.includes(wpisane)) {
                karta.hidden = false;
                ile++;
            }else{
                karta.hidden = true;
            }
        });

        if(ile == 0){
            licznik.textContent = "Brak wyników";
        } else {
            licznik.textContent = `Znaleziono ${ile} wyników`;
        }
    });
}
    

function initFormularz (){
    let formularz = document.querySelector("form");
    if(!formularz) return;

    let poleProdukt = document.getElementById("produkt");
    let poleilosc = document.getElementById("ilosc");
    let poleWiadomosc = document.getElementById("wiadomosc");

    let infoWycena = document.getElementById("info-wycena");
    let podglad = document.getElementById("podglad");
    let bladWiad = document.getElementById("blad-wiad");

    let baza = [
        { id: "trek-slash-8", nazwa: "Trek", cenaGrosze: 1599900 },
        { id: "canyon-spectral-29", nazwa: "Canyon", cenaGrosze: 1764900 },
        { id: "santa-cruz-nomad", nazwa: "Santa Cruz", cenaGrosze: 1949900 }
    ];

    let formatCeny = new Intl.NumberFormat("pl-PL", { style: "currency", currency: "PLN" });

    function mnozenie(cena, sztuki){return cena * sztuki;}

    function sprawdzCene() {
        podglad.hidden = true;
        bladWiad.hidden = true;

        let idWybrane = poleProdukt.value;
        let ilosc = Number(poleilosc.value);

        let wybranyRower = null;
        for (let i = 0; i < baza.length; i++) {
            if (baza[i].id === idWybrane) {
                wybranyRower = baza[i];
            }
        }


        if (wybranyRower == null || isNaN(ilosc) || !Number.isInteger(ilosc) || ilosc < 1 || ilosc > 5) {
            infoWycena.textContent = "Podaj poprawny produkt i ilość (1-5), aby zobaczyć wycenę.";
            return null;
        }

        let sumaGrosze = mnozenie(wybranyRower.cenaGrosze, ilosc);
        infoWycena.textContent = "Szacowana wartość: " + formatCeny.format(sumaGrosze / 100);
        
        return { rower: wybranyRower.nazwa, cenaTotal: sumaGrosze, ilosc: ilosc };
    }

    poleProdukt.addEventListener("change", sprawdzCene);
    poleilosc.addEventListener("input", sprawdzCene);

    formularz.addEventListener("submit", function(e) {
        e.preventDefault(); // SUPER WAŻNE: zatrzymuje przeładowanie strony po kliknięciu

        let tekst = poleWiadomosc.value.trim();
        let dane = sprawdzCene();

        if (tekst.length < 10) {
            bladWiad.textContent = "Wiadomość musi mieć minimum 10 znaków.";
            bladWiad.hidden = false;
            poleWiadomosc.focus();
            return;
        }

        if (dane != null) {
            document.getElementById("p-rower").textContent = dane.rower;
            document.getElementById("p-ilosc").textContent = dane.ilosc;
            document.getElementById("p-cena").textContent = formatCeny.format(dane.cenaTotal / 100);
            document.getElementById("p-tresc").textContent = tekst;
            
            podglad.hidden = false; 
        }
    });
}

initMotyw();
initZegar();
initWyszukiwarka();
initFormularz();