(function(){
    // Indica cualquier error por formato no válido
    function getErrorSpan(input) {
        let span = input.nextElementSibling;
        if (!span || !span.classList || !span.classList.contains('field-error')) {
            span = document.createElement('span');
            span.className = 'field-error';
            span.style.color = 'red';
            span.style.display = 'block';
            span.style.fontSize = '0.9em';
            input.parentNode.insertBefore(span, input.nextSibling);
        }
        return span;
    }

    // COMPROBACIONES
    function validName(s) {
        if (typeof s !== 'string') return false;
        s = s.trim();
        if (s.length === 0) return false;
        return (/^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s\-]+$/).test(s);
    }

    function validDni(dni) {
        if (typeof dni !== 'string') return false;
        const m = dni.trim().match(/^(\d{8})-?([A-Za-z])$/);
        if (!m) return false;
        const num = m[1];
        const letter = m[2].toUpperCase();
        return dniExpectedLetter(num) === letter;
    }

    function dniExpectedLetter(num) {
        const letters = "TRWAGMYFPDXBNJZSQVHLCKE";
        return letters.charAt(Number(num) % 23);
    }

    function validPhone(phone) {
        return (/^\d{9}$/).test(String(phone).trim());
    }

    function validDateYMD(d) {
        if (!(/^\d{4}-\d{2}-\d{2}$/).test(d)) return false;
        const [y, m, day] = d.split('-').map(Number);
        const dt = new Date(y, m-1, day);
        return dt.getFullYear() === y && (dt.getMonth()+1) === m && dt.getDate() === day;
    }

    function validEmail(e) {
        if (typeof e !== 'string') return false;
        return (/^[^\s@]+@[^\s@]+\.[^\s@]+$/).test(e.trim());
    }

    //Comprobar datos en funcion del nombre del campo
    function validateField(input) {
        const name = input.getAttribute('name');
        const val = (input.value || '').trim();
        const span = getErrorSpan(input);
        span.textContent = '';

        if (name === 'nombre') {
            if (!validName(val)) {
                span.textContent = 'Nombre inválido: solo letras, espacios y guiones.';
                return false;
            }
            return true;
        }

        if (name === 'apellidos') {
            if (!validName(val)) {
                span.textContent = 'Apellidos inválidos: solo letras, espacios y guiones.';
                return false;
            }
            return true;
        }

        if (name === 'dni') {
            if (!validDni(val)) {
                span.textContent = 'DNI inválido. Formato: 11111111-Z.';
                return false;
            }
            return true;
        }

        if (name === 'telefono') {
            if (!validPhone(val)) {
                span.textContent = 'Teléfono inválido. Debe ser de 9 dígitos.';
                return false;
            }
            return true;
        }

        if (name === 'f_nacimiento') {
            if (!validDateYMD(val)) {
                span.textContent = 'Fecha inválida. Formato: aaaa-mm-dd.';
                return false;
            }
            return true;
        }

        if (name === 'email') {
            if (!validEmail(val)) {
                span.textContent = 'Email inválido. Formato: ejemplo@servidor.extensión.';
                return false;
            }
            return true;
        }

        // Si quieres validar usuario y contraseña:
        if (name === 'usuario') {
            if (val.length === 0) {
                span.textContent = 'El usuario no puede estar vacío.';
                return false;
            }
            return true;
        }

        if (name === 'contrasena') {
            if (val.length < 6) {
                span.textContent = 'La contraseña debe tener al menos 6 caracteres.';
                return false;
            }
            return true;
        }

        return true; // Para cualquier otro campo no definido
    }

    function enviarFormulario(formId) {
        const form = document.getElementById(formId);
        const inputs = form.querySelectorAll('input[name="nombre"], input[name="apellidos"], input[name="dni"], input[name="telefono"], input[name="f_nacimiento"], input[name="email"], input[name="usuario"], input[name="contrasena"]');
    
        let todoOk = true;

        inputs.forEach(input => {
            if (!validateField(input)) {
                todoOk = false;
            }
        });

        if (todoOk) {
            form.submit(); // Enviar el formulario al servidor
        } else {
            // Opcional: poner foco en el primer input con error
            const firstErr = form.querySelector('.field-error:not(:empty)');
            if (firstErr) {
                const before = firstErr.previousElementSibling;
                if (before && before.tagName === 'INPUT') before.focus();
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const botonModify = document.getElementById('user_modify_submit');
        if (botonModify) {
            botonModify.addEventListener('click', function() {
                enviarFormulario('user_modify_form');
            });
        }
        const botonRegister = document.getElementById('register_submit');
        if (botonRegister) {
            botonRegister.addEventListener('click', function() {
                enviarFormulario('register_form');
            });
        }
    });
})();
