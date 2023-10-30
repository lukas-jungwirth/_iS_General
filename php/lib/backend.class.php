<?php

class iS_General_Backend
{
	private $config = null;

	public function __construct()
	{
		$this->config = new iS_General_Config();

		add_action("admin_enqueue_scripts", array($this, "be_enqueue_scripts"));
		wp_enqueue_style("iS_General_backend_css", STYLESHEETURL . "/" . $this->config->get("modulName") . "/css/backend.min.css", array(), 1.1);

		$this->register_divi_module();
	} // __construct()


	private function register_divi_module()
	{
		function DS_iS_General_Divi_Modules()
		{
			if (class_exists("ET_Builder_Module")) {
				$config = iS_General_Config::get_instance();
				$dir = STYLESHEETDIR . "/" . $config->get("modulName") . "/divi/";
				if (is_array(scandir($dir))) {
					$modules = array_diff(scandir($dir), array('..', '.'));

					foreach ($modules as $module) {
						include($dir . $module);
					}
				}

			}
		} // DS_iS_General_Divi_Modules()

		function Prep_DS_iS_General_Divi_Modules()
		{
			global $pagenow;

			$is_admin = is_admin();
			$action_hook = $is_admin ? "wp_loaded" : "wp";
			$required_admin_pages = array("edit.php", "post.php", "post-new.php", "admin.php", "customize.php", "edit-tags.php", "admin-ajax.php", "export.php"); // list of admin pages where we need to load builder files
			$specific_filter_pages = array("edit.php", "admin.php", "edit-tags.php");
			$is_edit_library_page = "edit.php" === $pagenow && isset($_GET["post_type"]) && "et_pb_layout" === $_GET["post_type"];
			$is_role_editor_page = "admin.php" === $pagenow && isset($_GET["page"]) && "et_divi_role_editor" === $_GET["page"];
			$is_import_page = "admin.php" === $pagenow && isset($_GET["import"]) && "wordpress" === $_GET["import"];
			$is_edit_layout_category_page = "edit-tags.php" === $pagenow && isset($_GET["taxonomy"]) && "layout_category" === $_GET["taxonomy"];

			if (!$is_admin || ($is_admin && in_array($pagenow, $required_admin_pages) && (!in_array($pagenow, $specific_filter_pages) || $is_edit_library_page || $is_role_editor_page || $is_edit_layout_category_page || $is_import_page))) {
				add_action($action_hook, "DS_iS_General_Divi_Modules", 9999);
			}
		} // Prep_DS_iS_General_Divi_Modules()

		Prep_DS_iS_General_Divi_Modules();
	} // register_divi_module()

	function be_enqueue_scripts()
	{
		wp_enqueue_style("iS_General_backend_css", STYLESHEETURL . "/" . $this->config->get("modulName") . "/css/backend.min.css", array(), time());
	} // be_enqueue_scripts
} // iS_General_Backend()