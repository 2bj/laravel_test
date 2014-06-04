@section('content')

    <?php
        foreach($list as $item){

        }
    ?>

@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-list"></span> Список анкет
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <?php
                            foreach($list as $item){
                                ?>
                                <li class="list-group-item">
                                    <label for="checkbox"><a href="/backend/form/<?php echo $item->id; ?>"><?php echo $item->first_name.' '.$item->middle_name.' '.$item->last_name; ?> <small>(<?php echo $item->email; ?>)</small></a></label>
                                    <div class="pull-right action-buttons">
                                        <a href="/backend/form/<?php echo $item->id; ?>/edit"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <a href="/backend/form/<?php echo $item->id; ?>/delete" class="trash"><span class="glyphicon glyphicon-trash"></span></a>
                                        @if ($item->checked == 1)
                                        <span class="glyphicon glyphicon-ok"></span>
                                        @else
                                        <a href="javascript:void(0);" class="flag" data-id="<?php echo $item->id; ?>"><span class="glyphicon glyphicon-flag"></span></a>
                                        @endif

                                    </div>
                                </li>
                            <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $("ul.list-group a.trash").on('click', function(){
            if(!confirm('Удалить?')){
                return false;
            }
        });

        $("ul.list-group a.flag").on('click', function(){
            var o = this;
            $.ajax({
                url: '/backend/form/checkOn',
                dataType: 'json',
                type: 'POST',
                'data': {id: $(this).data('id')},
                error: function() {
                    alert('Не удалось связаться с сервером');
                },
                success: function(ret){
                    if(ret.error == 0){
                        $(o).replaceWith('<span class="glyphicon glyphicon-ok"></span>');
                    } else {
                        alert(ret.message);
                    }
                }
            });
        });
    });

</script>

@stop