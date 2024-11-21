document.getElementById("usuario").onblur = validaUsuario;
document.getElementById("pwd").onblur = validaPassword;

function validaUsuario() {
let usuario = document.getElementById("usuario").value;
let input_usuario = document.getElementById("usuario");
let usuarioError = document.getElementById("error_usuario");

if(usuario === "" || usuario === null){
    usuarioError.textContent = "El usuario no puede ser nulo.";
    input_usuario.classList.add("error-border");
    return false;
} else {
    usuarioError.textContent = "";
    input_usuario.classList.remove("error-border");
    return true;
}
}

function validaPassword() {
let pwd = document.getElementById("pwd").value;
let input_pwd = document.getElementById("pwd");
let pwdError = document.getElementById("pwd_error");

if(pwd === "" || pwd === null){
    pwdError.textContent = "La contraseña es obligatoria.";
    input_pwd.classList.add("error-border");
    return false;
}  else {
    pwdError.textContent = "";
    input_pwd.classList.remove("error-border");
    return true;
}
}


