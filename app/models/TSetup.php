<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use LaravelBook\Ardent\Ardent;

class TSetup extends Ardent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'setup';

    /**
     * Правила проверки Ardent
     */
    public static $rules = array(
        'name' => 'required|unique',
        'value' => 'required',
    );

    protected $fillable = array('name', 'value');
}
