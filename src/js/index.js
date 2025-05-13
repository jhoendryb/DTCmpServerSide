$(function () {
    tablaOne = tablaDinamica({
        titulo: "Ciudades",
        elemento: "#example",
        caracter: true,
        ...(JSON.parse(atob(datatableDinamico))),
    }, {
        columns: [
            {
                "data": "ciudad",
            },
            {
                "data": "estado",
            },
            {
                "data": function (row, data) {
                    let btn;
                    if (row) {
                        const dataAtrib = "prueba";
                        btn = ` 
                                <div class="btn-group btn-group-sm">
                                    <a href="#" class="btn btn-info d-flex justify-content-center align-items-center" onclick="eventos(this)" ${dataAtrib}><i class="fa fa-eye"></i></a>
                                </div>
                            `;
                    }
                    return btn;
                },
            }
        ],
    });
});