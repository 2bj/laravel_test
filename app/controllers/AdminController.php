<?php

class AdminController extends BaseController {

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

	public function loginForm() {
        if(Auth::check()) {
            return View::make('layout', array( View::make( 'admin.welcome'), 'activeMenu' => 'admin'));
        }

        $email = Input::get('email', null);

        return View::make('layout', array( View::make( 'forms.adminlogin', array('email'=>$email) ), 'activeMenu' => 'admin'));

	}

    public function loginProcess(){
        if(Request::method() == 'POST'){
            if(Auth::attempt(array('email' => Input::get('email', null), 'password' => Input::get('password', null)), true)){
            }
        }

        return Redirect::to('/backend/form');
    }

    public function loguotProcess(){
        Auth::logout();
        return Redirect::to('/backend/form');
    }

    public function emailProcess(){
        if(!Auth::check()) { return Redirect::to('/backend/user/logout'); }

        if(Request::method() == "POST"){

            $email = Input::get("email", null);

            if($email === null) {} else {
                $emailR = TSetup::where("name", "=", "email")->take(1)->get()->first();
                if(!$emailR) {
                    # create
                    DB::table("setup")->insert(array("name" => "email", "value" => $email));
                } else {
                    # update
                    DB::table("setup")->where("name", "=", "email")->update(array('value' => $email));
                }

                Session::flash('successUpdate', true);
            }
        }

        $email = TSetup::where("name", "=", "email")->take(1)->get()->first();
        if($email) { $email = $email->value; }

        return View::make('layout', array( View::make( 'admin.email', array('email' => $email) ), 'activeMenu' => 'admin'));
    }

    public function viewForm($id){
        if(!Auth::check()) { return Redirect::to('/backend/user/logout'); }

        $model = WorkSheets::find($id);

        return View::make('layout', array( View::make( 'admin.viewform', array('model' => $model) ), 'activeMenu' => 'admin'));
    }

    public function editForm($id){
        if(!Auth::check()) { return Redirect::to('/backend/user/logout'); }

        $model = WorkSheets::find($id);

        $validator = null;

        if(Request::method() == 'POST'){
            $validator = Validator::make(Input::all(), WorkSheets::$rules);
            if(!$validator->fails()){
                $model->last_name       = Input::get('last_name');
                $model->first_name      = Input::get('first_name');
                $model->middle_name = Input::get('middle_name');
                $model->birthday = Input::get('birthday');
                $model->email = Input::get('email');
                $model->city = Input::get('city');
                if($model->save()){
                    Session::flash('message', "Запись успешно обновлена.");
                } else {
                    Session::flash('message', "Запись не обновлена, поскльку при обновлении произошли ошибки.");
                }

                return Redirect::to('/backend/form/' . $id . '/edit')
                    ->withErrors($validator);
            }
        }




        return View::make('layout', array(
                View::make( 'admin.editform', array('model' => $model) )->withErrors($validator)
            , 'activeMenu' => 'admin')
        );

    }

    public function deleteForm($id){
        if(!Auth::check()) { return Redirect::to('/backend/user/logout'); }
        $model = WorkSheets::find($id);
        $model->delete();

        Session::flash('message', 'Запись удалена');

        return Redirect::to('/backend/form/list');

    }

    public function listForm(){
        if(!Auth::check()) { return Redirect::to('/backend/user/logout'); }
        $list = WorkSheets::orderBy('id', 'desc')->get()->all();

        return View::make('layout', array( View::make( 'admin.listform', array('list' => $list) ), 'activeMenu' => 'admin'));
    }

    public function checkOn(){
        if(!Auth::check()) { return Redirect::to('/backend/user/logout'); }
        $ret = array('error' => 100, 'message'=>'Не найдена запись');
        $model = WorkSheets::find(Input::get('id'));
        if($model){
            $ret = array('error' => 0, 'message'=>'Не удалось обновить запись');
            $model->checked = 1;
            if($model->save()){ $ret = array('error' => 0, 'message'=>'Запись обновлена'); }

        }

        echo json_encode($ret);
        die();
    }
}
