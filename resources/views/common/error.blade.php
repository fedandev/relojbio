@if (count($errors) > 0)
    <div class="alert alert-danger">
        <p>Hubo algunos problemas con los siguientes datos: </p></br>
        <ul>
            @foreach ($errors->all() as $error)
                <p><i class="glyphicon glyphicon-remove"></i> {{ $error }}</p>
            @endforeach
        </ul>
    </div>
@endif