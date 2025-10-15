</div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Custom JS -->
<script>
    // Actualizar fecha y hora
    function actualizarFechaHora() {
        const ahora = new Date();
        const opciones = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        document.getElementById('fecha-hora').textContent = ahora.toLocaleDateString('es-MX', opciones);
    }
    
    // Actualizar cada segundo
    setInterval(actualizarFechaHora, 1000);
    actualizarFechaHora();

    // Inicializar DataTables
    $(document).ready(function() {
        $('.datatable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json'
            },
            pageLength: 25,
            responsive: true
        });

        // Inicializar Select2
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });

        // Auto-cerrar alertas después de 5 segundos
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
</script>

</body>
</html>
