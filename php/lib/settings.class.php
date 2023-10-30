<?php
class iS_General_Settings
{

    private $settings_section = "iservice_settings_section";
    private $iS_modules = array("Images", "File_Manager");

    private $config;


    public function __construct()
    {
        $this->config = new iS_General_Config();        

        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_menu', array($this, 'add_module_section'));

        new Setting_Checkbox("test_toggle", "Module setting", $this->settings_section, "module_settings_group");
        new Setting_Checkbox("test_toggle_2", "Module setting 2", $this->settings_section, "module_settings_group");

    }

    //settings page
    public function add_settings_page()
    {
        add_options_page('iService', 'iService', 'manage_options', 'iservice-settings', array($this, 'render_settings_page'));
    }

    public function render_settings_page()
    {
        ?>
        <div class="iService-backend-settings">
            <h1><img
                    src="<?= STYLESHEETURL . "/" . $this->config->get("modulName") . "/css/img/iService_Logo_round_black.png" ?>">iService
                settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('module_settings_group');
                do_settings_sections($this->settings_section);
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function add_module_section(){
        add_settings_section($this->settings_section, esc_html__("Module Settings", $this->config->get("modulName")), array($this, 'module_section_callback'), $this->settings_section);
    }

    //module activation section
    public function module_section_callback()
    {
        return "";
    }

}
