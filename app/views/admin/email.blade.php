@section('content')

<div class="container">
    <?php     if(Session::has('successUpdate')) { ?>
    <div class="col-sm-11 col-md-11">
        <div class="alert alert-success">
            <p>Почта успешно обновлена.</p>
        </div>
    </div>
<?php } ?>
    <div class="row">
        <h2>Смена электронной почты для уведомлений</h2>

        <hr />

        <div class="row">
            <div class="col-sm-8">
                <form role="form" method="post">
                    <div class="form-group float-label-control">
                        <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="электронная почта">
                    </div>

                    <div class="col-sm-12 controls">
                        <button type="submit" class="btn btn-success">Сохранить</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

@stop