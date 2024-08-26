<?php 
    $defaultColsConfig = <<<EOL
        { "width": "0px", "targets": -1 },
        { "orderable": false, "targets": -1 },
    EOL;
?>
<script>
    $(function () {
        $("#<?php echo $tableID ?>").DataTable({
            "info": true,
            "paging": true,
            "ordering": true,
            "searching": true,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 10,
            "lengthChange": false,
            "buttons": [
                { extend: 'excel',  text: 'Excel'},
                { extend: 'pdf',    text: 'PDF'},
                { extend: 'print',  text: 'Imprimir'},
                { extend: 'colvis', text: 'Columnas'}
            ],
            "columnDefs": [
                <?php if (isset($tableColsConfig)): ?>
                    <?php echo $tableColsConfig; ?>
                <?php else: ?>
                    <?php echo $defaultColsConfig; ?>
                <?php endif; ?>
            ],
            "language": {
                "paginate": {
                    "previous": "‹",
                    "next":     "›",
                    "first":    "«",
                    "last":     "»"
                },
                "search": "Buscar:",
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)"
            }
        }).buttons().container().appendTo('#<?php echo $tableID ?>_wrapper .col-md-6:eq(0)');
    });
</script>
