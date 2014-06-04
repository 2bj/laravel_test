@section('content')

<p><a href="/backend/form/list">Список анкет</a></p>

@if (Session::has('message'))
<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<h1>Редактирование<br> {{ $model->last_name . ' ' .$model->first_name . ' ' . $model->middle_name }}</h1>

@if (is_array($errors->all()) && count($errors->all()) > 0)
<div class="alert alert-danger">Ошибки<br>
    {{ HTML::ul($errors->all()) }}
</div>
@endif

<!-- if there are creation errors, they will show here -->

{{ Form::model($model, array('method' => 'POST')) }}

<div class="form-group">
    {{ Form::label('last_name', 'Фамилия') }}
    {{ Form::text('last_name', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('first_name', 'Имя') }}
    {{ Form::text('first_name', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('middle_name', 'Отчество') }}
    {{ Form::text('middle_name', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('birthday', 'Дата рождения') }}
    {{ Form::text('birthday', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    {{ Form::label('email', 'Электронная почта') }}
    {{ Form::text('email', null, array('class' => 'form-control')) }}
</div>

<div class="form-group">
    <?php
    $countries = Countries::orderBy("name", "asc")->get()->all();
    $aCountries = array();
    foreach($countries as $country){
        $aCountries[$country->id] = $country->name;
    }
    $cityM = Cities::find($model->city);
    ?>
    {{ Form::label('country', 'Страна') }}
    <br>
    {{ Form::select('country', $aCountries, $cityM->country_id, array('class' => 'form-control')) }}
</div>


<div class="form-group">
    <?php
    $cities = Cities::where("country_id", "=", $cityM->country_id)->orderBy("name", "asc")->get()->all();
    $aCities = array();
    foreach($cities as $city){
        $aCities[$city->id] = $city->name;
    }
    ?>
    {{ Form::label('city', 'Город') }}
    {{ Form::select('city', $aCities, $model->city, array('class' => 'form-control')) }}
</div>




{{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}


<script language="javascript">
    $(function(){
        $('[name=country]').on('change',function(){
            $.ajax({
                'url' : '/getCities',
                'dataType' : 'json',
                'type' : 'get',
                'data' : {country : $('[name=country] option:selected').attr('value')},
                'success' : function(ret){
                    /* соберем options */
                    if(ret.error == 0) {
                        $('[name=city]').prop('disabled', false);
                        $('[name=city]').html('');

                        $.each(ret.data, function(index, value){
                            $('[name=city]')
                                .append($("<option></option>")
                                    .attr("value",value.id)
                                    .text(value.value));
                        });

                        /* $('[name=city]').json(ret.data); */
                    } else {
                        alert("Ошибка получения списка городов с сервера. (" + ret.error + ")")
                    }
                },
                'error' : function(){ alert('Ошибка обращения к сереверу за списком городов.'); }
            });

        });
    });
</script>
@stop