<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Personne extends Model
{
    //
	public $erreurs;
	
    public static $regles = [
    		'nom' => 'required',
    		'dateNaissance' => 'required|date_format:Y-m-d|after:01-01-1901',
    		'telephone' => array('regex:/^(\d{3})-(\d{3})-(\d{4})/')
    ];
    
    public function validate()
    {
    	$v = Validator::make($this->attributes, static::$regles);
    	if ($v->passes()) return true;
    	$this->erreurs = $v->messages();
    	return false;
    }
}
