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

## Uso en Proyectos Personales

### Componentes Esenciales

Para implementar `tablaDinamica` en tu propio proyecto, necesitarás los siguientes archivos:

1. **Archivos JavaScript**:
   - `DTCmpserverSide.js`: Contiene la implementación principal de la función `tablaDinamica`
   - `index.js`: Ejemplo de inicialización y uso de la función

2. **Archivos PHP**:
   - `dataTableServer.php`: Maneja el procesamiento del lado del servidor para las consultas SQL

### Dependencias Requeridas

* jQuery (3.x o superior)
* DataTables (1.10.x o superior)
* Bootstrap (opcional, para estilos)

### Pasos de Implementación

1. **Incluir Dependencias**:
   ```html
   <!-- CSS -->
   <link rel="stylesheet" href="path/to/datatables.min.css">
   <link rel="stylesheet" href="path/to/bootstrap.min.css">

   <!-- JavaScript -->
   <script src="path/to/jquery.min.js"></script>
   <script src="path/to/datatables.min.js"></script>
   <script src="path/to/DTCmpserverSide.js"></script>
   ```

2. **Configurar Tabla HTML**:
   ```html
   <table id="miTabla" class="table">
       <thead>
           <tr>
               <th>Columna 1</th>
               <th>Columna 2</th>
           </tr>
       </thead>
   </table>
   ```

3. **Inicializar tablaDinamica**:
   ```javascript
   let miTabla = tablaDinamica({
       titulo: 'Mi Tabla Dinámica',
       elemento: '#miTabla',
       consulta: {
           from: 'mi_tabla',
           tabla: 'mi_tabla',
           where: '', // Condiciones de filtro
           order: 'ORDER BY {order}'
       },
       columnas: ['columna1', 'columna2']
   }, {
       columns: [
           { data: 'columna1' },
           { data: 'columna2' }
       ]
   });
   ```

### Consideraciones Importantes

* **Personalización**: Adapta `dataTableServer.php` para conectarse a tu base de datos
* **Seguridad**: Implementa validaciones y filtros en el lado del servidor
* **Rendimiento**: Optimiza las consultas SQL para tablas grandes

### Nota

Este proyecto es un ejemplo de implementación. Los archivos clave (`DTCmpserverSide.js` y `dataTableServer.php`) pueden reutilizarse directamente en otros proyectos, adaptándolos a tus necesidades específicas.

## Contacto

[Información de contacto]
