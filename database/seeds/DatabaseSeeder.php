<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
		$this->call(EstadisticaEmpleadosTableSeeder::class);
		$this->call(EstadisticasTableSeeder::class);
		$this->call(LibreDetallesTableSeeder::class);
		$this->call(TipoLibresTableSeeder::class);
		$this->call(LicenciaDetallesTableSeeder::class);
		$this->call(AuditsTableSeeder::class);
		$this->call(AuditoriumsTableSeeder::class);
		$this->call(TrabajasTableSeeder::class);
		$this->call(HorarioRotativosTableSeeder::class);
		$this->call(TurnosTableSeeder::class);
		$this->call(HorarioSemanalsTableSeeder::class);
		$this->call(RegistrosTableSeeder::class);
		$this->call(DispositivosTableSeeder::class);
		$this->call(OficinasTableSeeder::class);
		$this->call(SucursalsTableSeeder::class);
		$this->call(EmpresasTableSeeder::class);
		$this->call(TipoLicenciumsTableSeeder::class);
		$this->call(TipoEmpleadosTableSeeder::class);
		$this->call(TipoHorariosTableSeeder::class);
		$this->call(ArchivosTableSeeder::class);
		$this->call(ReportesTableSeeder::class);
		$this->call(MensajesTableSeeder::class);
		$this->call(ConversacionsTableSeeder::class);
		$this->call(FeriadosTableSeeder::class);
		$this->call(AutorizacionsTableSeeder::class);
		$this->call(AjustesTableSeeder::class);
		$this->call(LogsTableSeeder::class);
		$this->call(SesionsTableSeeder::class);
		$this->call(PermisosTableSeeder::class);
		$this->call(PerfilesTableSeeder::class);
		$this->call(ModulosTableSeeder::class);
		$this->call(MenusTableSeeder::class);
    }
}
