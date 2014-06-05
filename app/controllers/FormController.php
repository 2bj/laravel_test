<?php
use Gregwar\Captcha\CaptchaBuilder;

class FormController extends BaseController {
	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showForm() {

        $model = new WorkSheets();

        if(Request::method() == 'POST' || Request::ajax()){
            $inputs = Input::only(array('last_name', 'first_name','middle_name','birthday','email','city'));
            $model = new WorkSheets($inputs);

            if($model->validate()){
                # проверяем дополнительные параметры

                if (Request::ajax()) {
                    $ret = array('error' => 0, 'message' => 'Данные прошли проверку (кроме картинки)');

                    echo json_encode($ret);
                    die();
                }

                if(Input::get('captcha') != Session::get('captcha_phrase')){ $model->errors()->add('captcha', 'Не верно введены символы с картинки.'); }

                if(!isset($_FILES['photo']['size']) || $_FILES['photo']['size'] < 0){
                    $model->errors()->add('photo', 'Не добавлена ваша фотография.');
                } elseif (!in_array($_FILES['photo']['type'], array('image/png', 'image/jpeg'))) {
                    $model->errors()->add('photo', 'Фотография может быть только jpg или png.');
                } else {
                    # проверяем картинку на правильность типа и размера
                    $pic = Image::make($_FILES['photo']['tmp_name']);
                    if((450 > $pic->height() || $pic->height() > 2500 ) || (450 > $pic->width() || $pic->width() > 2500 )) {
                        $model->errors()->add('photo', 'Каждая сторона фотографии должна быть более 450 и менее 2500 точек.');
                    } else {
                        $picNameData = pathinfo($_FILES['photo']['name']);
                    }
                }

                 if(!$model->errors()->all()) {
                    # если проверку прошло и каптча верная, то сохраняем
                    if($model->save()){

                        # и сохраняем картинку ((!) сделал не по ТЗ, поскольку более уникальным будет взять ID записи в качестве имени картинки),
                        # но если делать по ТЗ, то имя картинки вычислял бы следущим образом
                        # $model->photo_file_name = md5(rand(999,9999999).time())

                        $fileNameToSave = dechex($model->id).".".strtolower($picNameData['extension']);

                        if($pic->save(Config::get('settings.photo_a_path').DIRECTORY_SEPARATOR.$fileNameToSave)){
                            $model->photo_file_name = $fileNameToSave;
                            $model->save();
                        }

                        # отправляем админу уведомление
                        $adminEmail = DB::select("SELECT * FROM `setup` WHERE `name` = 'email' LIMIT 1");
                        if(isset($adminEmail[0]) && !empty($adminEmail[0]->value)){
                            Mailman::make('emails.new_form', array('model' => $model))->setCss('/zurb.css')->from($adminEmail[0]->value)->to($adminEmail[0]->value)->subject('Новая анкета на сайте')->send();
                        }


                        Session::flash('successAddRecord', true);
                        return Redirect::to('/form');
                    }
                }
            } else {
                if (Request::ajax()) {

                    $errorListHTML = '<div class="alert alert-danger">Ошибки заполнения формы<ul>';
                    foreach($model->errors()->all() as $error){
                        $errorListHTML .= '<li>'.$error.'</li>';
                    }
                    $errorListHTML .= '</ul></div>';

                    $ret = array('error' => 100, 'message' => 'Данные НЕ прошли проверку.', 'error_list' => $errorListHTML);

                    echo json_encode($ret);
                    die();
                }
            }
        }

        # список стран
        $_TMP = Countries::orderBy('name', 'asc')->get()->all();
        if( is_array($_TMP) && count($_TMP) > 0 ){
            foreach($_TMP as $item){
                $countries['items'][$item->id] = $item->name;
            }
        }
        $countries['selected'] = Input::get('country', null);

        # список городов, если выбрана страна
        $cities = array('items' => null, 'selected' => null);
        if( $countries['selected'] ) {
            $_TMP = Cities::where("country_id", "=", $countries['selected'])->orderBy('name', 'asc')->get()->all();
            if( is_array($_TMP) && count($_TMP) > 0 ){
                foreach($_TMP as $item){
                    $cities['items'][$item->id] = $item->name;
                }

                $cities['selected'] = Input::get('city', null);
            }
        }

        $captchaBuilder = new CaptchaBuilder;
        $captchaBuilder->build();
        Session::put("captcha_phrase", $captchaBuilder->getPhrase());

		return View::make('layout', array( View::make('forms.form', array('model'=>$model, 'countries' => $countries, 'cities' => $cities, 'captchaBuilder'=>$captchaBuilder)), 'activeMenu' => 'form') );
	}


    public function getCities(){
        $json = array('error' => 10);
        if($country = Input::get('country', false)){
            $_TMP = Cities::where("country_id", "=", $country)->orderBy('name', 'asc')->get()->all();

            if( is_array($_TMP) && count($_TMP) > 0 ){
                foreach($_TMP as $item){
                    $json['data'][$item->id] = array('id'=>$item->id, 'value'=>$item->name);
                }
                $json['error'] = 0;
            }
        }

        echo json_encode($json);
        die();

    }

    public function getCaptcha(){

        die();
    }

}
