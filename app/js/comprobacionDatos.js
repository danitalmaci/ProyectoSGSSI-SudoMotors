(function(){
    //Indica cualquier error por formato no válido
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



    //COMPROBACIONES
    //Comprobar formato nombre (solo texto)
    function validName(s) {
        if (typeof s !== 'string') return false;
        s = s.trim();
        if (s.length === 0) return false;
        try {
            return (/^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s\-]+$/).test(s);
        } catch (e) {
            return false;
        }
    }

    //Comprobar formato dni (8 digitos y letra correcta)
    function validDni(dni) {
        if (typeof dni !== 'string') return false;
        const m = dni.trim().match(/^(\d{8})-?([A-Za-z])$/);
        if (!m) return false;
        const num = m[1];
        const letter = m[2].toUpperCase();
        return dniExpectedLetter(num) === letter;
    }
    
    //Comprobar formato dni letra
    function dniExpectedLetter(num) {
        const letters = "TRWAGMYFPDXBNJZSQVHLCKE";
        const n = Number(num) % 23;
        return letters.charAt(n);
    }
    
    //Comprobar formato telefono (9 digitos)
    function validPhone(phone) {
        return (/^\d{9}$/).test(String(phone).trim());
    }

    //Comprobar formato fecha (aaaa-mm-dd)
    function validDateYMD(d) {
        if (!(/^\d{4}-\d{2}-\d{2}$/).test(d)) return false;
        const parts = d.split('-').map(Number);
        const y = parts[0], m = parts[1], day = parts[2];
        const dt = new Date(y, m-1, day);
        return dt.getFullYear() === y && (dt.getMonth()+1) === m && dt.getDate() === day;
    }

    //Comprobar formato email (ejemplo@servidor.extension))
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

        if (name === 'name') {
            if (!validName(val)) { span.textContent = 'Nombre inválido: solo letras, espacios, guiones y apóstrofes.'; return false; }
            return true;
        }

        if (name === 'dni') {
            if (!validDni(val)) { span.textContent = 'DNI inválido. Formato: 11111111-Z.'; return false; }
            return true;
        }

        if (name === 'phone') {
            if (!validPhone(val)) { span.textContent = 'Teléfono inválido. Debe ser de 9 dígitos.'; return false; }
            return true;
        }

        if (name === 'birth') {
            if (!validDateYMD(val)) { span.textContent = 'Fecha inválida. Formato: aaaa-mm-dd.'; return false; }
            return true;
        }

        if (name === 'email') {
            if (!validEmail(val)) { span.textContent = 'Email inválido.Formato: ejemplo@servidor.extensión.'; return false; }
            return true;
        }

        return true;
    }


    //Asignar Listeners recorriendo todos los inputs del formulario
    function attachInputs(form) {
        const inputs = form.querySelectorAll('input[name="name"], input[name="dni"], input[name="phone"], input[name="birth"], input[name="email"]');
        inputs.forEach(inp => {
            if (!inp.placeholder) {
                if (inp.name === 'name') inp.placeholder = 'Ej: María Pérez';
                if (inp.name === 'dni')  inp.placeholder = '12345678-Z';
                if (inp.name === 'phone') inp.placeholder = '612345678';
                if (inp.name === 'birth') inp.placeholder = '1999-08-26';
                if (inp.name === 'email') inp.placeholder = 'ejemplo@servidor.ext';
            }
            inp.addEventListener('blur', () => validateField(inp));
            inp.addEventListener('input', () => {
                const span = inp.nextElementSibling;
                if (span && span.classList && span.classList.contains('field-error')) span.textContent = '';
            });
        });
    }

    //Asignar Listeners en funcion del nombre del formulario
    function attachForm(formId) {
        const form = document.getElementById(formId);
        if (!form) return;
        attachInputs(form);

        form.addEventListener('submit', function(evt) {
            let ok = true;
            const inputs = form.querySelectorAll('input[name="name"], input[name="dni"], input[name="phone"], input[name="birth"], input[name="email"]');
            inputs.forEach(i => { if (!validateField(i)) ok = false; });

            if (!ok) {
                evt.preventDefault();
                const firstErr = form.querySelector('.field-error:not(:empty)');
                if (firstErr) {
                    const before = firstErr.previousElementSibling;
                    if (before && before.tagName === 'INPUT') before.focus();
                }
                return false;
            }
            return true;
        });
    }

    //Se asignan los Listeners a los formularios que lo requieren
    attachForm('user_modify_form');
    attachForm('register_form');
    attachForm('login_form');

})();
