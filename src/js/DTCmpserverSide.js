function tablaDinamica(option, params = {}) {
    option.columnasData = params.columns;
    let tablaObjeto = $(option.elemento).DataTable({
        "bProcessing": true,
        "serverSide": true,
        "ajax": {
            url: `./src/php/dataTableServer.php`,
            type: "POST",
            data: {
                option: option,
                key: "unLock"
            },
            dataSrc: function (json) {
                return json.data;
            },
            beforeSend: function () {
                $(`${option.elemento}_processing`).hide();
            },
            error: function () {
                console.log("Ah ocurrido un error.");
            }
        },
        filter: true,
        ordering: true,
        deferRender: true,
        scrollY: 1200,
        scrollCollapse: true,
        processing: true,
        lengthMenu: [10, 20, 50, 100, 200, 500],
        responsive: true,
        responsivePriority: 1,
        // dom: 'B<"modifyPosition2"fr>t<"modifyPosition1"p>',
        // dom: 'Bfrt<"modifyPosition1"ip>',
        dom: 'Bfrtip',
        buttons: [{
            extend: 'collection',
            text: '<i class="fa fa-cog" aria-hidden="true"></i>',
            className: 'btn btn-primary',
            buttons: [{
                extend: 'print',
                text: 'Imprimir',
                title: option.titulo,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'copy',
                text: 'Copiar',
                title: option.titulo,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                text: 'Excel',
                title: option.titulo,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csv',
                text: 'CSV',
                title: option.titulo,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                text: 'PDF',
                title: option.titulo,
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pageLength'
            },
            {
                extend: 'colvis',
                text: 'Modificar Columnas'
            }
            ]
        }],
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "searchPlaceholder": "Ingresa el texto a buscar",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            buttons: {
                pageLength: {
                    _: "Mostrando %d <br> Elementos",
                    '-1': "Ver Todo"
                }
            }
        },
        ...params
    });
    return tablaObjeto;
}