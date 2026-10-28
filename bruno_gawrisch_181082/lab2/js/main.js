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
    // if(!wyswietlacz) return;

    let btnStart = document.getElementById("zegar-start");
    let btnStop = document.getElementById("zegar-stop");
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
}

function initWyszukiwarka(){

}

function initFormularz (){

}

initMotyw();
initZegar();
initWyszukiwarka();
initFormularz();
