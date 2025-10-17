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
    function validMatricula(s) {
        if (typeof s !== 'string') return false;
        s = s.trim();
        if (s.length === 0) return false;
        return (/^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s\-]+$/).test(s);
    }
    
    function validMarca(s) {
        if (typeof s !== 'string') return false;
        s = s.trim();
        if (s.length === 0) return false;
        return (/^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s\-]+$/).test(s);
    }
    
    function validModelo(s) {
        if (typeof s !== 'string') return false;
        s = s.trim();
        if (s.length === 0) return false;
        return (/^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s\-]+$/).test(s);
    }

	function validAno(ano) {
		return (/^\d{4}$/).test(String(ano).trim());
	}

    function validKms(kms) {
        return (/^\d+$/).test(String(kms).trim());
    }

    //Comprobar datos en funcion del nombre del campo
    function validateField(input) {
        const name = input.getAttribute('name');
        const val = (input.value || '').trim();
        const span = getErrorSpan(input);
        span.textContent = '';

        if (name === 'matricula') {
            // Convertir a mayúsculas
            input.value = val.toUpperCase();
            return true; // No hay más validación
        }

        if (name === 'ano') {
            if (!validAno(val)) {
                span.textContent = 'El año debe ser un número de 4 digitos.';
                return false;
            }
            return true;
        }

        if (name === 'kms') {
            if (!validKms(val)) {
                span.textContent = 'Los kilómetros deben ser un número.';
                return false;
            }
            return true;
        }

        return true; // Para cualquier otro campo no definido
    }

    function enviarFormulario(formId) {
        const form = document.getElementById(formId);
        const inputs = form.querySelectorAll('input[name="matricula"], input[name="marca"], input[name="modelo"], input[name="ano"], input[name="kms"]');
    
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
        const botonModify = document.getElementById('item_modify_submit');
        if (botonModify) {
            botonModify.addEventListener('click', function() {
                enviarFormulario('item_modify_form');
            });
        }
        const botonRegister = document.getElementById('item_add_submit');
        if (botonRegister) {
            botonRegister.addEventListener('click', function() {
                enviarFormulario('item_add_form');
            });
        }
    });
})();
