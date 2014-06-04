<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use LaravelBook\Ardent\Ardent;

class WorkSheets extends Ardent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'worksheets';

    /**
     * Правила проверки Ardent
     */
    public static $rules = array(
        'last_name' => 'required',
        'first_name' => 'required',
        'birthday' => 'required',
        'email' => 'required|email',
        'city' => 'required',
    );

    protected $fillable = array('last_name', 'first_name', 'middle_name', 'birthday', 'email', 'city');

    public $timestamps = false;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
//	protected $hidden = array('password', 'remember_token');

}
