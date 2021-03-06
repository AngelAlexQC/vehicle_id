<?php

return [
    'common' => [
        'actions' => 'Acciones',
        'create' => 'Crear',
        'edit' => 'Editar',
        'update' => 'Actualizar',
        'search' => 'Buscar...',
        'back' => 'Volver al listado',
        'are_you_sure' => 'Estás seguro?',
        'no_items_found' => 'No se encontraron registros',
        'created' => 'Creado con éxito',
        'saved' => 'Guardado con éxito',
        'removed' => 'Borrado con éxito',
    ],

    'conductores' => [
        'name' => 'Conductores',
        'index_title' => 'Lista de Conductores',
        'create_title' => 'Crear Conductor',
        'edit_title' => 'Editar Conductor',
        'show_title' => 'Mostrar Conductor',
        'inputs' => [
            'dni' => 'Cédula',
            'name' => 'Nombres',
            'surname' => 'Apellidos',
            'email' => 'Correo Electrónico',
            'phone' => 'Teléfono',
        ],
    ],

    'usuarios' => [
        'name' => 'Usuarios',
        'index_title' => 'Lista de Usuarios',
        'create_title' => 'Crear Usuario',
        'edit_title' => 'Editar Usuario',
        'show_title' => 'Mostrar Usuario',
        'inputs' => [
            'dni' => 'Cédula',
            'name' => 'Nombre',
            'email' => 'Correo Electrónico',
            'password' => 'Contraseña',
        ],
    ],

    'veh_culos' => [
        'name' => 'Vehículos',
        'index_title' => 'Lista de Vehículos',
        'create_title' => 'Crear Vehículo',
        'edit_title' => 'Editar Vehículo',
        'show_title' => 'Mostrar Vehículo',
        'inputs' => [
            'owner_id' => 'Propietario',
            'brand' => 'Marca',
            'model' => 'Model',
            'plate' => 'Placa',
            'registration' => 'Matrícula',
        ],
    ],

    'parqueaderos' => [
        'name' => 'Parqueaderos',
        'index_title' => 'Lista de Parqueaderos',
        'create_title' => 'Crear Parqueadero',
        'edit_title' => 'Editar Parqueadero',
        'show_title' => 'Mostrar Parqueadero',
        'inputs' => [
            'tag' => 'Etiqueta',
            'location' => 'Ubicación',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Listado de Roles',
        'create_title' => 'Crear Rol',
        'edit_title' => 'Editar Rol',
        'show_title' => 'Mostrar Rol',
        'inputs' => [
            'name' => 'Nombre',
        ],
    ],

    'permissions' => [
        'name' => 'Permisos',
        'index_title' => 'Lista de permisos',
        'create_title' => 'Crear Permiso',
        'edit_title' => 'Editar Permiso',
        'show_title' => 'Mostrar Permiso',
        'inputs' => [
            'name' => 'Nombre',
        ],
    ],
];
