# DTCmpServerSide

Un componente avanzado para DataTable que simplifica la gestión de consultas SQL dinámicas en modo ServerSide.

## Descripción

Permite añadir valores estáticos útiles sin necesidad de crear archivos adicionales de control.

## Características Principales

* Consultas SQL dinámicas
* Integración nativa con DataTables
* Procesamiento del lado del servidor
* Flexibilidad de adaptación a diferentes casos de uso

## Estructura del Proyecto

```tree
DTCmpServerSide/
│
├── src/
│   ├── js/
│   │   ├── index.js         # Script principal de JavaScript
│   │   └── DTCmpserverSide.js # Procesamiento del lado del servidor
│   │
│   └── php/
│       └── dataTableServer.php # Manejo de datos del servidor
│
├── index.php                # Punto de entrada principal
└── package-lock.json        # Gestión de dependencias
```

## Tecnologías

### Tecnologías Utilizadas

* PHP
* JavaScript
* jQuery
* DataTables
* Bootstrap 5
* Font Awesome

### Atribución y Derechos de Autor

* **DataTables**: Una biblioteca de tablas interactivas para jQuery. 
  * Derechos de autor © SpryMedia Ltd.
  * Licencia: MIT License
  * Sitio web: [https://datatables.net/](https://datatables.net/)

#### Nota Legal

Este proyecto es una implementación personalizada de **DataTables** que utiliza tecnologías web estándar. La función `tablaDinamica` es una extensión construida específicamente sobre DataTables, reconociendo y respetando su trabajo original.

Todos los derechos de autor de las bibliotecas utilizadas pertenecen a sus respectivos propietarios.

## Instalación

1. Clonar el repositorio
2. Instalar dependencias: `npm install`
3. Configurar conexión de base de datos en archivos PHP

## Uso de `tablaDinamica`

`tablaDinamica` es una función personalizada que envuelve DataTables con funcionalidades avanzadas de procesamiento del lado del servidor.

### Parámetros Principales

#### Primer Parámetro (Objeto de Configuración)

| Propiedad | Tipo | Descripción | Ejemplo |
|-----------|------|-------------|--------|
| `titulo` | `string` | Título de la tabla para exportaciones | `'Ciudades'` |
| `elemento` | `string` | Selector CSS del elemento de la tabla | `'#example'` |
| `consulta` | `object` | Configuración de consulta SQL dinámica con las siguientes propiedades: | `{ from: 'tabla', tabla: 'tabla_base', where: 'condición', order: 'ORDER BY campo' }` |
| &nbsp;&nbsp;&nbsp;&nbsp;`from` | `string` | Definición completa de la consulta FROM, incluyendo subconsultas | `'ciudad, (SELECT estado FROM estados AS e WHERE e.id_estado = c.id_estado) AS estado'` |
| &nbsp;&nbsp;&nbsp;&nbsp;`tabla` | `string` | Tabla base de la consulta | `'ciudades AS c'` |
| &nbsp;&nbsp;&nbsp;&nbsp;`where` | `string` | Condición de filtrado (opcional) | `'id_estado = 1'` |
| &nbsp;&nbsp;&nbsp;&nbsp;`order` | `string` | Configuración de ordenamiento | `'ORDER BY {order}'` |
| `caracter` | `boolean` | Habilitar procesamiento de caracteres | `true` |
| `funcionMaster` | `object` | Configuración de filtros y transformaciones avanzadas | `{ campo: [valorfiltrar, campoFiltrar, campoSelect, tablaFiltrar, separador] }` |
| `columnas` | `array` | Columnas a incluir en la consulta, con soporte para `ns` (Not Search) | `['ciudad', 'estado:ns']` |

#### Segundo Parámetro: Configuración de DataTables

Este objeto permite configurar directamente las opciones nativas de DataTables, proporcionando total flexibilidad en la personalización de la tabla.

| Propiedad | Tipo | Descripción | Ejemplo |
|-----------|------|-------------|--------|
| `columns` | `array` | Definición de columnas de DataTables, permite transformaciones y renderizado personalizado | `[{ data: 'ciudad' }, { data: 'estado' }, { data: function(row) { return `<button>Acciones</button>`; } }]` |
| `*` | `any` | Cualquier opción nativa de DataTables | `{ responsive: true, scrollY: 1200, lengthMenu: [10, 20, 50, 100] }` |

#### Nota Importante

El primer parámetro se enfoca en la generación y procesamiento de datos en el lado del servidor, mientras que el segundo parámetro permite personalizar completamente la presentación y comportamiento de la tabla utilizando las opciones nativas de DataTables.

### Ejemplo Completo

```javascript
// Ejemplo de configuración detallada de tablaDinamica
tablaOne = tablaDinamica({
    titulo: 'Ciudades y Estados',
    elemento: '#example',
    caracter: true,
    consulta: {
        // Consulta con subconsulta para obtener el nombre del estado
        from: 'ciudad, (SELECT estado FROM estados AS e WHERE e.id_estado = c.id_estado) AS estado',
        tabla: 'ciudades AS c',
        where: '', // Sin filtro adicional
        order: 'ORDER BY {order}' // Ordenamiento dinámico
    },
    funcionMaster: {
        // Ejemplo de transformación de datos (comentado en el código original)
        // estado: ['{estado}', 'ID', 'NOMBRE_USUARIO', 'usuarios', '||']
    },
    columnas: [
        'ciudad', // Columna normal
        'estado:ns' // Columna con Not Search (ns) para evitar búsquedas
    ]
}, {
    columns: [
        { data: 'ciudad' },
        { data: 'estado' },
        { 
            data: function(row) {
                return `<button>Acciones</button>`;
            }
        }
    ]
});
```

### Características Adicionales

* Procesamiento del lado del servidor
* Exportación a múltiples formatos (Excel, PDF, CSV)
* Filtrado y ordenamiento dinámico
* Menú de configuración de columnas
* Soporte para consultas SQL personalizadas

## Contribuciones

Las contribuciones son bienvenidas. Por favor, sigue estos pasos:

1. Hacer fork del repositorio
2. Crear rama de características
3. Commit de cambios
4. Push a la rama
5. Crear Pull Request

## Licencia

[Especificar licencia]

## Contacto

[Información de contacto]
