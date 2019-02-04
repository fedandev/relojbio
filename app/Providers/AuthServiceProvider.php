<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Illuminate\Support\Facades\DB;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
		
		 \App\Models\Audit::class => \App\Policies\AuditPolicy::class,
    	 \App\Models\Archivo::class => \App\Policies\ArchivoPolicy::class,
    	 \App\Models\Autorizacion::class => \App\Policies\AutorizacionPolicy::class,
		 \App\Models\Ajuste::class => \App\Policies\AjustePolicy::class,
		 
		 \App\Models\Dispositivo::class => \App\Policies\DispositivoPolicy::class,
		 
		 \App\Models\Conversacion::class => \App\Policies\ConversacionPolicy::class,
		 
		 \App\Models\Empleado::class => \App\Policies\EmpleadoPolicy::class,
		 \App\Models\Empresa::class => \App\Policies\EmpresaPolicy::class,
		 
		 \App\Models\Feriado::class => \App\Policies\FeriadoPolicy::class,
		 
		 \App\Models\HorarioRotativo::class => \App\Policies\HorarioRotativoPolicy::class,
		 \App\Models\Horario::class => \App\Policies\HorarioPolicy::class,
		 \App\Models\HorarioSemanal::class => \App\Policies\HorarioSemanalPolicy::class,
		 
		 \App\Models\Licencia::class => \App\Policies\LicenciaPolicy::class,
		 \App\Models\Log::class => \App\Policies\LogPolicy::class,
		 \App\Models\LibreDetalle::class => \App\Policies\LibreDetallePolicy::class,
		 \App\Models\LicenciaDetalle::class => \App\Policies\LicenciaDetallePolicy::class,
		  
		 \App\Models\Mensaje::class => \App\Policies\MensajePolicy::class,
		 \App\Models\Modulo::class => \App\Policies\ModuloPolicy::class,
		 \App\Models\Menu::class => \App\Policies\MenuPolicy::class,
		 
		
		 \App\Models\Oficina::class => \App\Policies\OficinaPolicy::class,
		 
		 \App\Models\Permiso::class => \App\Policies\PermisoPolicy::class,
		 \App\Models\Perfil::class => \App\Policies\PerfilPolicy::class,
		 
		 \App\Models\Sucursal::class => \App\Policies\SucursalPolicy::class,
		 \App\Models\Sesion::class => \App\Policies\SesionPolicy::class,
		
		 \App\Models\TipoLicencia::class => \App\Policies\TipoLicenciaPolicy::class,
		 \App\Models\TipoEmpleado::class => \App\Policies\TipoEmpleadoPolicy::class,
		 \App\Models\TipoHorario::class => \App\Policies\TipoHorarioPolicy::class,
		 \App\Models\TipoLibre::class => \App\Policies\TipoLibrePolicy::class,
		
		 \App\Models\Turno::class => \App\Policies\TurnoPolicy::class,
		 \App\Models\Trabaja::class => \App\Policies\TrabajaPolicy::class,
		 
		 \App\Models\Reporte::class => \App\Policies\ReportePolicy::class,
		 \App\Models\Registro::class => \App\Policies\RegistroPolicy::class,
		 
		
		 
		 
		
		 
		
		
		 
   //     'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view-report', function ($user, $controller) {
        	debug_to_console('gate:'. $controller);
        	$permiso = 4; // show 
        	return menuHabilitado( $controller, $permiso );
        	
	    });
    }
}
