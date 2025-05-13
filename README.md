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
|-----------|------|-------------|---------|
| `titulo` | `string` | Título de la tabla para exportaciones | `'Ciudades'` |
| `elemento` | `string` | Selector CSS del elemento de la tabla | `'#example'` |
| `consulta` | `object` | Configuración de consulta SQL dinámica | `{ from: 'tabla', where: 'condición' }` |
| `caracter` | `boolean` | Habilitar procesamiento de caracteres | `true` |
| `funcionMaster` | `object` | Configuración de filtros y transformaciones | `{ campo: [params] }` |
| `columnas` | `array` | Columnas a incluir en la consulta | `['campo1', 'campo2']` |

#### Segundo Parámetro (Configuración de Columnas)

| Propiedad | Tipo | Descripción | Ejemplo |
|-----------|------|-------------|---------|
| `columns` | `array` | Definición de columnas de DataTables | `[{ data: 'ciudad' }, { data: 'estado' }]` |

### Ejemplo Completo

```javascript
tablaOne = tablaDinamica({
    titulo: 'Ciudades',
    elemento: '#example',
    caracter: true,
    consulta: {
        from: 'ciudades c, estados e',
        where: 'c.id_estado = e.id_estado'
    },
    funcionMaster: {
        estado: ['{estado}', 'ID', 'NOMBRE', 'estados', '||']
    },
    columnas: ['ciudad', 'estado']
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
