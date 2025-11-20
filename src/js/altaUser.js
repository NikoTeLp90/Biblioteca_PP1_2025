
const registroUsuario = document.getElementById("altaUsuarioForm");
const repeatPass = document.getElementById("repeatPass");
const mensaje = document.getElementById("mensaje");

if (registroUsuario) {
    registroUsuario.addEventListener("submit", (e) => {
        e.preventDefault();

        // Leemos los valores actuales del formulario
        const nameRegistro = document.getElementById("nombre")?.value.trim() || "";
        const apellidoRegistro = document.getElementById("apellido")?.value.trim() || "";
        const dniregistro = document.getElementById("dni")?.value.trim() || "";
        const emailRegistro = document.getElementById("email")?.value.trim() || "";
        const cargoRegistro = document.getElementById("cargo")?.value || "";
        const passRegistro = document.getElementById("altaPassword")?.value || "";
        const pass2Registro = document.getElementById("altaPassword2")?.value || "";

        // Validación: las contraseñas deben coincidir
        if (passRegistro !== pass2Registro) {
            if (repeatPass) {
                repeatPass.textContent = "Las contraseñas no coinciden";
                repeatPass.classList.remove('text-success');
                repeatPass.classList.add('text-danger');
            }
            return; // no enviamos el formulario al servidor
        }

        // Si coinciden, limpiamos mensajes y enviamos el formulario al servidor para validación final en PHP
        if (repeatPass) {
            repeatPass.textContent = "";
        }

        // Enviar el formulario (envío normal, para que lo procese php/agregar_alumno.php)
        registroUsuario.submit();
    });
}
