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

        if(Request::method() == 'POST'){
            $inputs = Input::only(array('last_name', 'first_name','middle_name','birthday','email','city'));
            $model = new WorkSheets($inputs);

            if($model->validate()){
                if(Input::get('captcha') != Session::get('captcha_phrase')){
                    $model->errors()->add('captcha', 'Не верно введены символы с картинки');
                } else {
                    # если проверку прошло и каптча верная, то сохраняем
                    if($model->save()){
                        Session::flash('successAddRecord', true);
                        return Redirect::to('/form');
                    }
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
