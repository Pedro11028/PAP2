function criarCookie(valorCookie) {
    var hoje = new Date();
    var tempo = hoje.getTime();
    var expirarCookie = tempo + 9000*1000; // 9000*1000= duas horas e meia
    hoje.setTime(expirarCookie);
  
    document.cookie = "escolherTipoQuestao= "+valorCookie+';expires='+hoje.toUTCString()+"; secure=true"+';path=/';
}

if (document.cookie.indexOf('escolherTipoQuestao') > -1 ) {
    location.href="InserirDadosQuizz.php";
}