<?php
class iS_General extends iS_Module
{
	protected $config = null;

	public function _init() {

		$this->config = iS_General_Config::get_instance();

		$user_mail = wp_get_current_user()->user_email;
		if ( strpos( $user_mail, 'iservice.at' ) !== false ) {
			new iS_General_Settings();
		}
		
		new iS_General_Backend();
		new iS_General_Copyright();

	} // _init()
	
} // iS_Skeleton()