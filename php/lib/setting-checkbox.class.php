<?php
class Setting_Checkbox{

    private $id;
    private $label;
    private $section;
    private $group;


    public function __construct($id, $label, $section, $group) {
        $this->id = $id;
        $this->label = $label;
        $this->section = $section;
        $this->group = $group;

        add_action('admin_init', array($this, 'initialize_checkbox'));

    }

    public function initialize_checkbox() {
        add_settings_field($this->id, $this->label, array($this, 'checkbox_callback'), $this->section, $this->section);
        register_setting($this->group, $this->id, array($this, 'sanitize_toggle_option'));
    }

    public function get_val() {
        return get_option($this->id, 0);
    }

    public function checkbox_callback() {
        $option = $this->get_val();
        echo '<input type="checkbox" id="'.$this->id.'" name="' . $this->id . '" value="1" ' . checked(1, $option, false) . ' />';
    }
    

    public function sanitize_toggle_option($input) {
        return (isset($input) && $input == 1) ? 1 : 0;
    }
    
}