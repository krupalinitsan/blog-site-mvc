<?php 
session_start();
class Controller
{
	public function model($model){
		require_once './app/models/'.$model.'.php';
		return new $model();
	}
	public function view($view, $data = [])
	{
		// Make the $data array accessible in the included file
		extract($data);
		include_once 'app/views/' . $view . '.php';
	}
}