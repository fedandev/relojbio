AddEmpleadoToUsers: alter table `users` add `fk_empleado_cedula` varchar(191) unsigned null
AddEmpleadoToUsers: alter table `users` add constraint `users_fk_empleado_cedula_foreign` foreign key (`fk_empleado_cedula`) references `empleados` (`empleado_cedula`)
