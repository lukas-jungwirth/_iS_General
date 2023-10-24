<?php
class iS_General_Config extends iS_Module_Config
{
	private static $instance;

	private function __clone(){}

	public static function get_instance()
	{
		if (!iS_General_Config::$instance instanceof self) {
			iS_General_Config::$instance = new self();
		}
		return iS_General_Config::$instance;
	} // get_instance()

	public function __construct()
	{
		$this->set("modulName", "iS_General");
		$this->set("customPrefix", "iS_");
	} // __construct()
} // iS_General_Config()