@extends('layouts.app')

@section('content')

<?php 
use App\Models\Empresa;
use App\Models\Sucursal;
use App\Models\Oficina;
use App\Models\Empleado;
use App\Models\Registro;

$faker = Faker\Factory::create();

// Faker creador de Empresas
/*for($i=0; $i<11; $i++){
    $empresa = new Empresa();
    $empresa->empresa_nombre = $faker->company;
    $empresa->empresa_telefono = $faker->phoneNumber;
    $empresa->empresa_estado = "Alta";
    $empresa->empresa_ingreso = $faker->date($format = 'Y-m-d', $max = 'now');
    $empresa->save();
}*/

//Faker Creador de Sucursales
/*for($i=0; $i<11; $i++){
    $sucursal = new Sucursal();
    $sucursal->sucursal_nombre = $faker->catchPhrase;
    $sucursal->sucursal_descripcion = $faker->realText($maxNbChars = 30, $indexSize = 2);
    $sucursal->fk_empresa_id = rand ( 2 , 26 ); //id minimo y maximo de los registros de la empresa
    $sucursal->save();
}*/

//Faker Creador de Oficinas
/*for($i=0; $i<11; $i++){
    $oficina = new Oficina();
    $oficina->oficina_nombre = $faker->catchPhrase;
    $oficina->oficina_descripcion = $faker->realText($maxNbChars = 30, $indexSize = 2);
    $oficina->oficina_codigo = $faker->numberBetween($min = 1000, $max = 9000);
    $oficina->oficina_estado = "1";
    $oficina->fk_sucursal_id = rand ( 1 , 14 ); //id minimo y maximo de los registros de la empresa
    $oficina->fk_dispositivo_id = "2";
    $oficina->save();
}*/

//Faker Creador de Empleados
/*for($i=0; $i<21; $i++){
    $empleado = new Empleado();
    $empleado->empleado_cedula = $faker->randomNumber($nbDigits = NULL, $strict = false);
    $empleado->empleado_codigo = $faker->numberBetween($min = 1000, $max = 5000);
    $empleado->empleado_nombre = $faker->firstName;
    $empleado->empleado_apellido = $faker->lastName;
    $empleado->empleado_correo = $faker->freeEmail;
    $empleado->empleado_telefono = $faker->tollFreePhoneNumber;
    $empleado->empleado_fingreso = $faker->date($format = 'Y-m-d', $max = 'now');
    $empleado->fk_tipoempleado_id = "1";
    $empleado->fk_oficina_id = rand ( 3 , 16 ); //id minimo y maximo de los registros de la empresa
    $empleado->save();
}*/

?>
@endsection