document.getElementById("nombre_usuario").onblur = validaUsername;
document.getElementById("nombre_completo").onblur = validaNombreCompleto;
document.getElementById("password_usuario").onblur = validaPassword;
document.getElementById("email_usuario").onblur = validaEmail;
document.getElementById("telf_usuario").onblur = validaTelefono;
document.getElementById("dni_usuario").onblur = validaDNI;
document.getElementById("rol_usuario").onblur = validaRol;
document.getElementById("insertForm").onsubmit = validaForm;

function validaUsername() {
    let username = document.getElementById("nombre_usuario").value;
    let inputUsername = document.getElementById("nombre_usuario");
    let errorUsername = document.getElementById("error_username");

    if (username === "" || username === null) {
        errorUsername.textContent = "Debe ingresar un nombre de usuario.";
        inputUsername.classList.add("error-border");
        return false;
    } else {
        errorUsername.textContent = "";
        inputUsername.classList.remove("error-border");
        return true;
    }
}

function validaNombreCompleto() {
    let nombreCompleto = document.getElementById("nombre_completo").value;
    let inputNombreCompleto = document.getElementById("nombre_completo");
    let errorNombreCompleto = document.getElementById("error_name");

    if (nombreCompleto === "" || nombreCompleto === null) {
        errorNombreCompleto.textContent = "Debe ingresar el nombre completo.";
        inputNombreCompleto.classList.add("error-border");
        return false;
    } else {
        errorNombreCompleto.textContent = "";
        inputNombreCompleto.classList.remove("error-border");
        return true;
    }
}

function validaPassword() {
    let password = document.getElementById("password_usuario").value;
    let inputPassword = document.getElementById("password_usuario");
    let errorPassword = document.getElementById("error_pwd");

    if (password === "" || password === null) {
        errorPassword.textContent = "Debe ingresar una contraseña.";
        inputPassword.classList.add("error-border");
        return false;
    } else {
        errorPassword.textContent = "";
        inputPassword.classList.remove("error-border");
        return true;
    }
}

function validaEmail() {
    let email = document.getElementById("email_usuario").value;
    let inputEmail = document.getElementById("email_usuario");
    let errorEmail = document.getElementById("error_email");

    if (email === "" || email === null) {
        errorEmail.textContent = "Debe ingresar un email válido.";
        inputEmail.classList.add("error-border");
        return false;
    } else {
        errorEmail.textContent = "";
        inputEmail.classList.remove("error-border");
        return true;
    }
}

function validaTelefono() {
    let telefono = document.getElementById("telf_usuario").value;
    let inputTelefono = document.getElementById("telf_usuario");
    let errorTelefono = document.getElementById("error_telf");

    if (telefono === "" || telefono === null) {
        errorTelefono.textContent = "Debe ingresar un número de teléfono.";
        inputTelefono.classList.add("error-border");
        return false;
    } else {
        errorTelefono.textContent = "";
        inputTelefono.classList.remove("error-border");
        return true;
    }
}

function validaDNI() {
    let dni = document.getElementById("dni_usuario").value;
    let inputDNI = document.getElementById("dni_usuario");
    let errorDNI = document.getElementById("error_dni");

    if (dni === "" || dni === null) {
        errorDNI.textContent = "Debe ingresar un DNI válido.";
        inputDNI.classList.add("error-border");
        return false;
    } else {
        errorDNI.textContent = "";
        inputDNI.classList.remove("error-border");
        return true;
    }
}

function validaRol() {
    let rol = document.getElementById("rol_usuario").value;
    let inputRol = document.getElementById("rol_usuario");
    let errorRol = document.getElementById("error_rol");

    if (rol === "" || rol === null) {
        errorRol.textContent = "Debe seleccionar un rol.";
        inputRol.classList.add("error-border");
        return false;
    } else {
        errorRol.textContent = "";
        inputRol.classList.remove("error-border");
        return true;
    }
}

function validaForm(event) {
    event.preventDefault();

    if (
        validaUsername() &&
        validaNombreCompleto() &&
        validaPassword() &&
        validaEmail() &&
        validaTelefono() &&
        validaDNI() &&
        validaRol()
    ) {
        document.getElementById("insertForm").submit();
    } else {
        console.log("Faltan campos por completar correctamente.");
    }
}