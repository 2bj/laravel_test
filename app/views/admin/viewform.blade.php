@section('content')

<p><a href="/backend/form/list">Список анкет</a></p>

<h1>{{ $model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name }}</h1>

<div class="jumbotron text-center">
    <p>
        <strong>Фамилия:</strong> {{ $model->last_name }}<br>
        <strong>Имя:</strong> {{ $model->first_name }}<br>
        <strong>Отчество:</strong> {{ $model->middle_name }}<br>
        <strong>Электроная почта:</strong> {{ $model->email }}<br>
        <strong>День рождения:</strong> {{ date("Y-m-d", strtotime($model->birthday)) }}<br>
        <?php $cityM = Cities::find($model->id); ?>
        <strong>Город:</strong> {{ $cityM->name  }}<br>
        <?php $countryM = Countries::find($cityM->country_id); ?>
        <strong>Страна:</strong> {{ $countryM->name }}<br>
    </p>
</div>
@stop