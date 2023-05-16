function criarCookie(valorCookie) {
    var hoje = new Date();
    var tempo = hoje.getTime();
    var expirarCookie = tempo + 3600000;       
    hoje.setTime(expirarCookie);
  
    document.cookie = "escolherTipoQuizz= "+valorCookie+';expires='+hoje.toUTCString()+"; secure=true"+';path=/';
}

if (document.cookie.indexOf('escolherTipoQuizz') > -1 ) {
    location.href="InserirDadosQuizz.php";
}