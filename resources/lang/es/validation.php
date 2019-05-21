<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute debe ser aceptado.',
    'active_url'           => ':attribute no es una URL válida.',
    'after'                => ':attribute debe ser posterior que :date.',
    'after_or_equal'       => ':attribute debe ser posterior o igual que :date.',
    'alpha'                => ':attribute solo puede contener letras.',
    'alpha_dash'           => ':attribute solo puede contener letras, numeros, y guiones.',
    'alpha_num'            => ':attribute solo puede contener letras y numeros.',
    'array'                => ':attribute debe ser un array.',
    'before'               => ':attribute debe ser anterior que :date.',
    'before_or_equal'      => ':attribute debe ser anterior o igual que :date.',
    'between'              => [
        'numeric' => ':attribute debe estar entre :min y :max.',
        'file'    => ':attribute debe estar entre :min y :max kilobytes.',
        'string'  => ':attribute debe estar entre :min y :max caracteres.',
        'array'   => ':attribute debe tener entre :min y :max items.',
    ],
    'boolean'              => ':attribute debe ser verdadero o falso.',
    'confirmed'            => ':attribute la confirmación no coincide.',
    'date'                 => ':attribute no es una fecha válida.',
    'date_format'          => ':attribute no coincide con el formato :format.',
    'different'            => ':attribute y :other deben ser diferentes.',
    'digits'               => ':attribute debe ser de :digits digitos.',
    'digits_between'       => ':attribute debe estar entre :min y :max digitos.',
    'dimensions'           => ':attribute tiene dimensiones de imagen no válidas.',
    'distinct'             => ':attribute tiene un valor duplicado.',
    'email'                => ':attribute debe ser una dirección de correo electrónico válida.',
    'exists'               => ':attribute no es válido.',
    'file'                 => ':attribute debe ser un archivo.',
    'filled'               => ':attribute debe tener un valor.',
    'image'                => ':attribute debe ser una imagen.',
    'in'                   => ':attribute no es válido.',
    'in_array'             => ':attribute no existe en :other.',
    'integer'              => ':attribute debe ser un entero.',
    'ip'                   => ':attribute debe ser una dirección IP válida.',
    'ipv4'                 => ':attribute debe ser una dirección IPv4 válida.',
    'ipv6'                 => ':attribute debe ser una dirección IPv6 válida.',
    'json'                 => ':attribute debe ser una cadena JSON válida.',
    'max'                  => [
        'numeric' => ':attribute no puede ser mayor que :max.',
        'file'    => ':attribute no puede ser mayor que :max kilobytes.',
        'string'  => ':attribute no puede ser mayor que :max caracteres.',
        'array'   => ':attribute no puede tener mas de :max items.',
    ],
    'mimes'                => ':attribute debe ser un archivo de tipo: :values.',
    'mimetypes'            => ':attribute debe ser un archivo de tipo: :values.',
    'min'                  => [
        'numeric' => ':attribute al menos debe ser :min.',
        'file'    => ':attribute al menos debe ser de :min kilobytes.',
        'string'  => ':attribute al menos debe ser de :min caracteres.',
        'array'   => ':attribute must have at least :min items.',
    ],
    'not_in'               => ':attribute no es válido.',
    'numeric'              => ':attribute debe ser un numero.',
    'present'              => ':attribute debe estar presente.',
    'regex'                => ':attribute no tiene un formato válido.',
    'required'             => ':attribute es requerido.',
    'required_if'          => ':attribute es requerido cuando :other es :value.',
    'required_unless'      => ':attribute es requerido a menos que :other este en :values.',
    'required_with'        => ':attribute es requerido cuando :values esta presente.',
    'required_with_all'    => ':attribute es requerido cuando :values esta presente.',
    'required_without'     => ':attribute es requerido cuando :values no esta presente.',
    'required_without_all' => ':attribute es requerido cuando ninguno de :values están presentes.',
    'same'                 => ':attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => ':attribute debe ser de :size.',
        'file'    => ':attribute debe ser de :size kilobytes.',
        'string'  => ':attribute debe ser de :size characters.',
        'array'   => ':attribute debe contener :size items.',
    ],
    'string'               => ':attribute debe ser una cadena de caracteres.',
    'timezone'             => ':attribute debe ser una zona válida.',
    'unique'               => ':attribute ya está en uso.',
    'uploaded'             => ':attribute error al cargar.',
    'url'                  => ':attribute no tiene un formato válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention 'attribute.rule' to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of 'email'. This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
            'ajuste_nombre' => 'Nombre',
            'ajuste_valor' => 'Valor',
            'empleado_cedula' => 'Cedula',
            'empleado_codigo'  => 'Código', 
            'empleado_nombre'  => 'Nombre',
            'empleado_apellido'  => 'Apellido',
            'empleado_correo'  => 'Correo',
            'empleado_telefono'  => 'Teléfono',
            'empleado_fingreso'  => 'Fecha Ingreso',
            'fk_tipoempleado_id'  => 'Tipo Empleado',
            'fk_oficina_id' => 'Oficina',
            'id' => 'ID',
            'ajuste_nombre' => 'Nombre',
            'ajuste_valor' => 'Valor',
            'ajuste_descripcion' => 'Descripción',
            'dispositivo_nombre' => 'Nombre',
            'dispositivo_serial' => 'Serial',
            'dispositivo_modelo' => 'Modelo',
            'dispositivo_ip' => 'IP',
            'dispositivo_puerto' => 'Puerto',
            'dispositivo_usuario' => 'Usuario',
            'dispositivo_password' => 'Password',
            'empresa_nombre' => 'Nombre',
            'empresa_telefono' => 'Telefono',
            'empresa_ingreso' => 'Fecha Ingreso',
            'feriado_nombre' => 'Nombre',
            'feriado_coeficiente' => 'Coeficiente',
            'feriado_minimo' => 'Mínimo',
            'feriado_fecha' => 'Fecha',
            'horario_nombre' => 'Nombre',
            'horario_entrada' => 'Hora Entrada',
            'horario_salida' => 'Hora Salida',
            'horario_comienzobrake' => 'Inicio brake',
            'horario_finbrake' => 'Fin brake',
            'horario_tiempotarde' => 'Tolerancia llegada tarde',
            'horario_salidaantes' => 'Tolerancia salida antes',
            'horariorotativo_nombre' => 'Nombre',
            'horariorotativo_diacomienzo' => 'Día comienzo',
            'horariorotativo_diastrabajo' => 'Días del trabajo',
            'horariorotativo_diaslibres' => 'Días libre',
            'horariosemanal_nombre' => 'Nombre',
            'horariosemanal_horas' => 'Horas a realizar',
            'licencia_anio' => 'Año',
            'licencia_cantidad' => 'Cantidad de días de licencia disponible',
            'licencia_observaciones' => 'Observaciones',
            'fk_tipolicencia_id' => 'Tipo Licencia',
            'menu_padre_id' => 'Menu Padre',
            'menu_descripcion' => 'Descripcion Menu',
            'menu_posicion' => 'Posicioón del Menu',
            'menu_habilitado' => 'Habilitado',
            'menu_url' => 'URL',
            'menu_icono' => 'Icono',
            'menu_formulario' => 'Formulario',
            'modulo_nombre' => 'Nombre',
            'modulo_descripcion' => 'Descripción',
            'v_menus' => 'Menus',
            'oficina_nombre' => 'Nombre',
            'oficina_descripcion' => 'Descripción',
            'oficina_codigo' => 'Código',
            'oficina_estado' => 'Estado',
            'fk_dispositivo_id' => 'Dispositivo',
            'fk_sucursal_id' => 'Sucursal',
            'perfil_nombre' => 'Nombre',
            'perfil_descripcion' => 'Descripcion',
            'v_modulos' => 'Modulos',
            'v_permisos' => 'Permisos',
            'permiso_nombre' => 'Nombre',
            'permiso_habilita' => 'Permiso',
            'registro_hora' => 'Hora',
            'registro_fecha' => 'Fecha',
            'registro_tipomarca' => 'Tipo Marca',
            'registro_comentarios' => 'Comentarios',
            'registro_registrado' => 'Registrado',
            'registro_tipo' => 'Marca',
            'fk_empleado_cedula' => 'Cedula',
            'sucursal_nombre' => 'Nombre',
            'sucursal_descripcion' => 'Descripción',
            'tipoempleado_nombre' => 'Nombre',
            'tipoempleado_descripcion' => 'Descripcion',
            'fk_tipohorario_id' => 'Tipo Horario',
            'tipohorario_nombre' => 'Nombre',
            'tipohorario_descripcion' => 'Descripción',
            'tipolicencia_nombre' => 'Nombre',
            'tipolicencia_descripcion' => 'Descripción',
            'trabaja_fechainicio' => 'Fecha inicio',
            'trabaja_fechafin' => 'Fecha fin',
            'fk_horariorotativo_id' => 'Horario Rotativo',
            'fk_turno_id' => 'Turno Fijo',
            'fk_horariosemanal_id' => 'Horario Semanal',
            'fk_empresa_id' => 'Empresa',
            'fk_empleado_id' => 'Empleado',
            'turno_nombre' => 'Nombre',
            'turno_lunes' => 'Lunes',
            'turno_martes' => 'Martes',
            'turno_miercoles' => 'Miercoles',
            'turno_jueves' => 'Jueves',
            'turno_viernes' => 'Viernes',
            'turno_sabado' => 'Sabado',
            'turno_domingo' => 'Domingo',
            'fk_horario_id' => 'Horario',
            'nombre' => 'Nombre',
            'estado' => 'Estado',
            'observaciones' => 'Observaciones',
            'email' => 'Email',
            'password' => 'Password',
            'created' => 'Creado',
            'updated' => 'Modificado',
            'deleted' => 'Eliminado',
            'empresa_estado' => 'Estado',
            'fk_tipo_libre_id' => 'Tipo de libre',
            'fecha_desde' => 'Fecha inicio',
            'fecha_hasta' => 'Fecha fin'
    ],

];
