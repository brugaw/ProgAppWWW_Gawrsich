$(function (){
    $.fx.off = window.matchMedia("(prefers-reduced-motion: reduce)").matches;


    let powiekszonyA = false;
    let czasAnimacji = 300;

    $("#animacja-1").on("click", function() {
        if (powiekszonyA ===false) {
            powiekszonyA = true;
            $(this).attr("aria-pressed", "true");
            $(this).stop(true, false).animate({width: 240, height: 130}, czasAnimacji);
        } else {
            powiekszonyA = false;
            $(this).attr("aria-pressed", "false");
            $(this).stop(true, false).animate({width: 160, height: 90}, czasAnimacji);
        }
    });

    let czyHover = false;
    let czyFocus = false;

    $("#animacja-2").on("mouseenter mouseleave focus blur", function(e) {
        if (e.type === "mouseenter") {czyHover = true;}
        if (e.type === "mouseleave") {czyHover = false;}
        if (e.type === "focus") {czyFocus = true;}
        if (e.type === "blur") {czyFocus = false;}

        if (czyHover === true || czyFocus === true){
            $(this).stop(true, false).animate({width: 220, height: 120},  czasAnimacji);
        } else {
            $(this).stop(true, false).animate({width: 160, height: 90},  czasAnimacji);
        }
    });

    let licznikKlikaniaC = 0;

    $("#animacja-3").on("click", function() {
        if ($(this).is(":animated") || licznikKlikaniaC >= 5) {return};

        licznikKlikaniaC++;

        let nowaSzerokosc = 160 + (licznikKlikaniaC * 20);
        let nowaWysokosc = 90 + (licznikKlikaniaC * 10);

        $(this).text("C: krok " + (licznikKlikaniaC) + "/5");
        $("#status-krokow").text("kroki obiektu C: " + licznikKlikaniaC + "/5");
        $(this).animate({width: nowaSzerokosc, height: nowaWysokosc}, czasAnimacji);
    });

    $("#btn-reset").on("click", function(){
        const wymiary = {width: 160, height: 90};
        
        powiekszonyA = false;
        $("#animacja-1").stop(true, false).attr("aria-pressed", "false").css(wymiary);

        licznikKlikaniaC = 0;
        $("#animacja-3").stop(true, false).text("C: krok").css(wymiary);

        $("#status-krokow").text("kroki obiektu C: 0/5");
    });

    $("#btn-ajax").on("click", function (){
        $("#btn-ajax").prop("disabled", true);
        $("#status-ajax").text("Ładowanie");

        $.ajax({url:"status.php",
                method:"GET",
                dataType:"text",
                timeout:5000
        }).done(function(odpowiedz){
            $("#status-ajax").text("Odpowiedz serwera: "+odpowiedz);
        }).fail(function(textStatus){
            $("#status-ajax").text("Błąd połączenia: "+textStatus);
        }).always(function(){
            $("#btn-ajax").prop("disabled", false);
        });
    })
});