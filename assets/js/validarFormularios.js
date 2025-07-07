function validarFormulario(formulario, validarNombre = false) {
    let valid = true;

    const datos = {
        email: formulario.email.value.trim(),
        password: formulario.password.value.trim()
    };

    if (validarNombre) {
        datos.name = formulario.name.value.trim();
    }

    const errorEmail = formulario.querySelector("#errorEmail");
    const errorPassword = formulario.querySelector("#errorPassword");
    const errorName = formulario.querySelector("#errorName");

    // Limpiar errores previos
    errorEmail.innerHTML = "";
    errorPassword.innerHTML = "";
    if (validarNombre) errorName.innerHTML = "";

    // Validar nombre (si aplica)
    if (validarNombre) {
        const erroresNombre = validarNombreFunc(datos.name);
    
        if (erroresNombre !== true && erroresNombre !== false) {
            valid = false;
            errorName.innerHTML = `<p style="color: #be5f1f;">${erroresNombre.join("<br>")}</p>`;
        }
    }

    // Validar email
    const erroresEmail = validarEmail(datos.email);
    
    if (erroresEmail !== true && erroresEmail !== false) {
        valid = false;
        errorEmail.innerHTML = `<p style="color: #be5f1f;">${erroresEmail.join("<br>")}</p>`;
    }

    // Validar contraseña
    const erroresPassword = validarPassword(datos.password);
    if (erroresPassword !== true && erroresPassword !== false) {
        valid = false;
        errorPassword.innerHTML = `<p style="color: #be5f1f;">${erroresPassword.join("<br>")}</p>`;
    }

    return valid;
}

// Función de validación de nombre
function validarNombreFunc(name) {
    const expreReguName = /^[a-zA-Z0-9_\s-]+$/;
    let errores = [];
    if (!name) {
        errores.push("El campo <strong>Nombre</strong> es obligatorio.");
    } else {
        if (!expreReguName.test(name)) {
            errores.push("El campo <strong>Nombre</strong> solo permite letras, números y guiones.");
        }
        if (name.length < 3) {
            errores.push("El campo <strong>Nombre</strong> debe contener mínimo 3 caracteres.");
        }
        if (name.length > 99) {
            errores.push("El campo <strong>Nombre</strong> debe contener máximo 99 caracteres.");
        }
    }
    if (errores.length > 0) {
        return errores;
    }else{
        return true;
    }
}

// Función de validación de email
function validarEmail(email) {
    const expreReguEmail = /^(?!.*\.\.)[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    let errores = [];

    if (!email) {
        errores.push("El campo <strong>Correo electrónico</strong> es obligatorio.");
    } else if (!expreReguEmail.test(email)) {
        errores.push("Debe ser un formato de <strong>Correo electrónico</strong> válido.");
    }

    if (errores.length > 0) {
        return errores;
    }else{
        return false;
    }
}

// Función de validación de contraseña
function validarPassword(password) {
    const expreReguPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    let errores = [];

    if (!password) {
        errores.push("El campo <strong>Contraseña</strong> es obligatorio.");
    } else {
        if (!expreReguPassword.test(password)) {
            errores.push("El campo <strong>Contraseña</strong> debe tener al menos una mayúscula, una minúscula, un número y un caracter especial.");
        }
        if (password.length < 8) {
            errores.push("El campo <strong>Contraseña</strong> debe contener mínimo 8 caracteres.");
        }
    }

    if (errores.length > 0) {
        return errores;
    }else{
        return false;
    }
}

formularioRegistro = document.getElementById("formRegistro");
formularioLogin = document.getElementById("formLogin");
formularioCambiarPassword = document.getElementById("formChangePassword")

if (formularioRegistro) {
    formularioRegistro.addEventListener("submit", function (e) {
        if (!validarFormulario(this, true)) {
            e.preventDefault(); // Evita el envío si hay errores
        }
    });
}

if (formularioLogin) {
    formularioLogin.addEventListener("submit", function (e) {
        if (!validarFormulario(this, false)) { // False porque este formulario no validamos nombre
            e.preventDefault(); // Evita el envío si hay errores
        }
    });
}

if (formularioCambiarPassword) {
    formularioCambiarPassword.addEventListener("submit", function (e) {
        if (!validarFormulario(this, false)) { // False porque este formulario no validamos nombre
            e.preventDefault(); // Evita el envío si hay errores
        }
    });
}