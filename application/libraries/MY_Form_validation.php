<?php

class MY_Form_validation extends CI_Form_validation
{
    public function load_config_rule($group = '')
    {
        if (!empty($group)) {
            $this->set_rules(
                isset($this->_config_rules[$group])
                ? $this->_config_rules[$group]
                : $this->_config_rules);
        }
    }

    public function unset_rule($name = '', $group = '')
    {
        $this->load_config_rule($group);
        if (count($this->_field_data) > 0) {
            unset($this->_field_data[$name]);
        }
    }
}
