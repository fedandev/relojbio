<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Lista de advertencias</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <table class="footable table table-stripped toggle-arrow-tiny" data-filter=#filter data-page="true">
                <thead>
                <tr>
                    <th>Empleado con faltas/llegadas tarde</th>
                    <th data-hide="all"></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        $grouped = $advertencias->groupBy(1);
                        $grouped->toArray();
                    ?>
                    @foreach($grouped as $group)
                        <tr class="footable-even">
                            <td>{{ $group[0][1] }}</td>
                            <td>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Empleado</th>
                                            <th>Día/Hora</th>
                                            <th>Tipo</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($group as $advertencia)
                                                <tr>
                                                    <td>{{ $advertencia[1] }}</td>
                                                    <td>{{ $advertencia[0] }}</td>
                                                    @if($advertencia[2] == "Falta")
                                                        <td><span class="label label-danger">{{ $advertencia[2] }} </span></td>
                                                    @elseif($advertencia[2] == "Llegada Tarde")
                                                        <td><span class="label label-warning">{{ $advertencia[2] }} </span></td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <!--<tr>
                        <td>Federico</td>
                        <td>19/11/2018</td>
                        <td><span class="label label-warning">Llegada tarde</span> </td>
                        <td><small>Pendiente...</small> </td>
                        <td>
                            <a class="btn btn-xs btn-outline btn-primary" href="{{ route('autorizacions.create') }}">
                                <i class="fa fa-check"></i> 
                            </a>
                            <a class="btn btn-xs btn-outline btn-danger" href="{{ route('autorizacions.create') }}">
                                <i class="fa fa-times"></i> 
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Federico</td>
                        <td>18/11/2018</td>
                        <td><span class="label label-info">Horas Extras</span> </td>
                        <td><small>Pendiente...</small> </td>
                        <td>
                            <a class="btn btn-xs btn-outline btn-primary" href="{{ route('autorizacions.create') }}">
                                <i class="fa fa-check"></i> 
                            </a>
                            <a class="btn btn-xs btn-outline btn-danger" href="{{ route('autorizacions.create') }}">
                                <i class="fa fa-times"></i> 
                            </a>
                        </td>
                    </tr>-->
                </tbody>
            </table>
        </div>
    </div>
</div>