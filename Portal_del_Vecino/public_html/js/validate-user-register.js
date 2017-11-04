function validatePassword(pid, cid){
    var password = document.getElementById(pid);
    var confirm_password = document.getElementById(cid);
    if(password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Las contraseñas no coinciden");
    } else {
        confirm_password.setCustomValidity('');
    }
}
password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;

function validateInputs(iid){
    var iTxt = document.getElementById(iid);

    if( /[^a-zA-Záéíóúñüàè\-\/]+$/.test(iTxt.value) ) {
        iTxt.setCustomValidity("No debe contener caracteres especiales");
    }
    else{
        iTxt.setCustomValidity("");
    }
     
}