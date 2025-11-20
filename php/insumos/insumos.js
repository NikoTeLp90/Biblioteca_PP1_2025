document.addEventListener('DOMContentLoaded', function() {
    const inputBuscar = document.getElementById('inputBuscar');
    const tabla = document.getElementById('insumosTable');
    
    if (inputBuscar && tabla) {
        inputBuscar.addEventListener('input', function() {
            const textoBusqueda = this.value.toLowerCase().trim();
            const filas = tabla.querySelectorAll('tbody tr');
            
            filas.forEach(function(fila) {
                const nombre = fila.cells[1] ? fila.cells[1].textContent.toLowerCase() : '';
                if (nombre.includes(textoBusqueda)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    }
    
    // Limpiar formulario del modal al cerrarlo y regenerar inputs
    const modalNuevoInsumo = document.getElementById('modalNuevoInsumo');
    if (modalNuevoInsumo) {
        modalNuevoInsumo.addEventListener('hidden.bs.modal', function() {
            const form = document.getElementById('registroInsumo');
            const cantidadInput = document.getElementById('cantidad');
            if (form) {
                form.reset();
                // Resetear cantidad a 1 y regenerar inputs
                if (cantidadInput) {
                    cantidadInput.value = 1;
                    // Llamar a la función global si existe
                    if (typeof generarInputsInsumos === 'function') {
                        generarInputsInsumos();
                    }
                }
            }
        });
    }
    
    // Limpiar formulario del modal de edición al cerrarlo
    const modalEditarInsumo = document.getElementById('modalEditarInsumo');
    if (modalEditarInsumo) {
        modalEditarInsumo.addEventListener('hidden.bs.modal', function() {
            const form = document.getElementById('formEditarInsumo');
            if (form) {
                form.reset();
            }
        });
    }
});

