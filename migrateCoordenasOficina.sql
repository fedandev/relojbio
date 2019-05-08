AddEmpleadoToUsers: alter table `users` add `fk_empleado_cedula` varchar(191) null
AddEmpleadoToUsers: alter table `users` add constraint `users_fk_empleado_cedula_foreign` foreign key (`fk_empleado_cedula`) references `empleados` (`empleado_cedula`)
AddLaboraleToFeriados: alter table `feriados` add `feriado_laborable` varchar(191) not null default '0'
AddCoordenadasToOficinas: alter table `oficinas` add `oficina_latitud` varchar(191) null, add `oficina_longitud` varchar(191) null
