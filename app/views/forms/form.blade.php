@section('content')
<div class="container">
@if (Session::has('successAddRecord'))
        <div class="col-sm-11 col-md-11">
            <div class="alert alert-success">
                <strong>Спасибо за регистрацию</strong>
                <hr class="message-inner-separator">
                <p>
                    Ваша анкета сохранена в нашей базе. После проверки модератором, она станет доступна.</p>
            </div>
        </div>
@else
    <?php if(is_array($model->errors()->all()) && count($model->errors()->all()) > 0){
                    echo '<div class="alert alert-danger">Ошибки заполнения формы<ul>';
                    foreach($model->errors()->all() as $error){
                        echo '<li>'.$error.'</li>';
                    }
                echo '</ul></div>';
            ?>
    <?php }    ?>
    <div class="row">
        <div class="col-md-11">
            <div class="well well-sm">
                <?php echo Form::model($model, array('class' => 'form-horizontal', 'enctype'=>'multipart/form-data'));?>

                <fieldset>
                    <legend class="text-center">Заполните форму</legend>

                    <div class="form-group">
                        {{ Form::label('last_name', 'Фамилия', array("class"=>"col-md-4 control-label")) }}
                        <div class="col-md-7">
                            {{ Form::text('last_name', $model->last_name, array('placeholder'=>'Фамилия', 'class'=>'form-control')) }}
                            <?php /* <input id="name" name="name" type="text" placeholder="Фамилия" class="form-control"> */ ?>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('first_name', 'Имя', array("class"=>"col-md-4 control-label")) }}
                        <div class="col-md-7">
                            {{ Form::text('first_name', $model->first_name, array('placeholder'=>'Имя', 'class'=>'form-control')) }}
                            <?php /* <input id="name" name="name" type="text" placeholder="Фамилия" class="form-control"> */ ?>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('middle_name', 'Отчество', array("class"=>"col-md-4 control-label")) }}
                        <div class="col-md-7">
                            {{ Form::text('middle_name', $model->middle_name, array('placeholder'=>'Отчество', 'class'=>'form-control')) }}
                            <?php /* <input id="name" name="name" type="text" placeholder="Фамилия" class="form-control"> */ ?>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('birthday', 'Дата рождения', array("class"=>"col-md-4 control-label")) }}
                        <div class="col-md-7">
                            {{ Form::text('birthday', $model->birthday, array('placeholder'=>'Дата рождения', 'class'=>'form-control')) }}
                            <?php /* <input id="name" name="name" type="text" placeholder="Фамилия" class="form-control"> */ ?>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('email', 'Электронная почта', array("class"=>"col-md-4 control-label")) }}
                        <div class="col-md-7">
                            {{ Form::text('email', $model->email, array('placeholder'=>'Электронная почта', 'class'=>'form-control')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="email">Страна</label>
                        <div class="col-md-7">
                            {{ Form::select('country', $countries['items'], $countries['selected'], array('class'=>'form-control')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="email">Город</label>
                        <div class="col-md-7">
                            <?php
                            if(is_array($cities['items'])) {
                                ?>
                                {{ Form::select('city', $cities['items'], $cities['selected'], array('class'=>'form-control')) }}
                                <?php
                            } else {
                                ?>
                                {{ Form::select('city', array(), null, array('class'=>'form-control', 'disabled' => true)) }}
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('captcha', 'Введите символы с картинки', array("class"=>"col-md-4 control-label")) }}
                        <div class="col-md-7">
                            {{ Form::text('captcha', null, array('placeholder'=>'Введите символы с картинки', 'class'=>'form-control', 'autocomplete' =>'off')) }}
                            <img src="<?php echo $captchaBuilder->inline(); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('photo', 'Фотография', array("class"=>"col-md-4 control-label")) }}
                        <div class="col-md-7" style="padding-top: 7px;">
                            {{ Form::file('photo', array('class'=>'')) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-11 text-right">
                            {{ Form::submit('Сохранить', array('class' => 'btn btn-primary btn-lg')); }}
                        </div>
                    </div>

                </fieldset>

                <?php echo Form::close(); ?>
            </div>
        </div>
    </div>

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
@endif
</div>
@stop