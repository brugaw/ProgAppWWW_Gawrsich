function initMotyw(){
    const przycisk = document.getElementById("przycisk-motywu");
    if (!przycisk) return;
    
    let obecnyMotyw = localStorage.getItem("motyw");
    if (!obecnyMotyw) {obecnyMotyw = "light"};

    document.documentElement.setAttribute("data-theme", obecnyMotyw);

    if (obecnyMotyw == "dark") {
        przycisk.setAttribute("aria-pressed", "true");
    } else {
        przycisk.setAttribute("aria-pressed", "false");
    }

    przycisk.addEventListener('click', function() {
        let obecnyMotyw = document.documentElement.getAttribute('data-theme');
        
        if (obecnyMotyw === 'light') {
            document.documentElement.setAttribute('data-theme', 'dark');
            przycisk.setAttribute('aria-pressed', 'true');
            localStorage.setItem('motyw', 'dark');
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
            przycisk.setAttribute('aria-pressed', 'false');
            localStorage.setItem('motyw', 'light');
        }
    });
}

function initZegar(){

}

function initWyszukiwarka(){

}

function initFormularz (){

}

initMotyw();
initZegar();
initWyszukiwarka();
initFormularz();
