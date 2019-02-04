<div class="row ribbon">
    <ol class="breadcrumb ">
        <span class="btn btn-outline btn-primary btnChico" data-action="refresh"><i class="fa fa-refresh"></i></span>
        
        <li>
            <a href="/">{{ trans('generic.index') }}</a>
        </li>
        @if (routeIndex($controller) != 'home')
            <li>
                <a href="/{{ controllerFromRoute() }} ">{{ trans('controllers.'.$controller) }}</a>
            </li>
        @endif
        
        @if ($action != 'index')
            <li class="active">
                <strong>{{ trans('generic.'.$action) }}</strong>
            </li>
        @endif
    </ol>
</div>
