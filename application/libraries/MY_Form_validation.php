<?php

/*
 * BadgeEntry
 *
 * Copyright (C) 2007 Scott Severance <http://badgeentry.sourceforge.net>
 * Copyright (C) 2013 Clive S. Woodhouse <http://www.clivewoodhouse.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA
 * 02111-1307, USA.
 *
 * Authors:
 *  Scott Severance <http://www.scottseverance.us>
 *  Clive S. Woodhouse <http://www.clivewoodhouse.com> 
 *
 */

class MY_Form_validation extends CI_Form_validation{

    var $CI; 
    var $_field_data           = array();
    var $_config_rules         = array();
    var $_error_array          = array();
    var $_error_messages       = array();
    var $_error_prefix         = '<p>';
    var $_error_suffix         = '</p>';
    var $error_string          = '';
    var $_safe_form_data       = FALSE;

	public function __construct($rules = array())
	{
		parent::__construct($rules);
		
		$this->set_custom_errors();
	}


	/**
     * Get the value from a form
     *
     * Permits you to repopulate a form field with the value it was submitted
     * with, or, if that value doesn't exist, with the default
     *
     * @access    public
     * @param    string    the field name
     * @param    string
     * @return    void
     */    
    function set_value($field = '', $default = '')
    {
        if ( ! isset($this->_field_data[$field]))
        {
            if( $this->CI->input->post($field)===FALSE)
            {
                return $default;
            } 
            else 
            {
                return $this->CI->input->post($field);
            }
        }
        
        return $this->_field_data[$field]['postdata'];
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Set Select
     *
     * Enables pull-down lists to be set to the value the user
     * selected in the event of an error
     *
     * @access    public
     * @param    string
     * @param    string
     * @return    string
     */    
    function set_select($field = '', $value = '', $default = FALSE)
    {        
        return $this->set_value_array($field, $value, ' selected="selected"', $default);
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Set Radio
     *
     * Enables radio buttons to be set to the value the user
     * selected in the event of an error
     *
     * @access    public
     * @param    string
     * @param    string
     * @return    string
     */    
    function set_radio($field = '', $value = '', $default = FALSE)
    {
        return $this->set_value_array($field, $value, ' selected="selected"', $default);
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Set Checkbox
     *
     * Enables checkboxes to be set to the value the user
     * selected in the event of an error
     *
     * @access    public
     * @param    string
     * @param    string
     * @return    string
     */    
    function set_checkbox($field = '', $value = '', $default = FALSE)
    {
        return $this->set_value_array($field, $value, ' checked="checked"', $default);
    }
    
    function set_value_array($field = '', $value = '', $default_value = '' ,$default = FALSE){
        if ( ! isset($this->_field_data[$field]) OR ! isset($this->_field_data[$field]['postdata']))
        {
            if( ! ($this->CI->input->post($field) === FALSE))
            {
                $field = $this->CI->input->post($field);
            } 
            else 
            {
                if ($default === TRUE AND count($this->_field_data) === 0)
                {
                    return $default_value;
                }
                return '';
            }
        }
        else
        {
        $field = $this->_field_data[$field]['postdata'];
        }
        
        if (is_array($field))
        {
            if ( ! in_array($value, $field))
            {
                return '';
            }
        }
        else
        {
            if (($field == '' OR $value == '') OR ($field != $value))
            {
                return '';
            }
        }
            
        return $default_value;
    }
    
	/**
	 * Map CodeIgniter validation rules to jQuery Validation rules.
	 *
	 * List of CodeIgniter Rules:
	 *		http://ellislab.com/codeigniter/user-guide/libraries/form_validation.html#rulereference
	 *
	 * List of jQuery Rules:
	 *		http://docs.jquery.com/Plugins/Validation#List_of_built-in_Validation_methods
	 *
	 * Info on saving codeigniter rules to config file:
	 * 		http://ellislab.com/codeigniter/user-guide/libraries/form_validation.html#savingtoconfig
	 */
	protected function jquery_rule_map()
	{
		$rules = array();
		
		// The array key is the CodeIgniter rule.  The array value is the corresponding jquery validation rule.
		$rules['required']		= 'required';
		$rules['min_length']	= 'minlength';
		$rules['max_length']	= 'maxlength';
		$rules['exact_length']	= 'exactlength';
		$rules['valid_email']	= 'email';
		$rules['valid_url']		= 'url';
		$rules['numeric']		= 'number';
		$rules['is_natural']	= 'digits';
		$rules['valid_phone']	= 'phoneUS';
		$rules['valid_zip']		= 'zipcode';
		
		return $rules;
	}
	
	/**
	 * Since we are adding custom validators, we have to specify error messages for each.
	 */
	protected function set_custom_errors()
	{
		$this->set_message('valid_phone', 'The %s field must contain a valid phone number.');
		$this->set_message('valid_zip', 'The %s field must contain a valid U.S. Postal Code.');
		$this->set_message('valid_url', 'The %s field must contain a valid URL.');
	}

function alpha_punc($str) {
        $pattern = '^[]a-z0-9 `~!@#$%^&*()_+=[{}\\|?;:\'",./-]+$';
        if(!stristr($pattern, $str) || strlen($str) === 0) return true;
        else {
            $this->CI->validation->set_message('alpha_punc','The %s field contains invalid characters');
            return false;
        }
    }
    
    function numeric_dash($str) {
        $pattern = '^[0-9-]+$';
        if(!stristr($pattern, $str) || strlen($str) === 0) return true;
        else {
            $this->CI->validation->set_message('numeric_dash','The %s field may only contain numbers and hyphens (-)');
            return false;
        }
    }
    
    function optional_min_length($str,$len) {
        if(strlen($str) == 0 || strlen($str) >= $len) return true;
        else {
            $this->CI->validation->set_message('optional_min_length',"The %s field must either be blank or contain at least $len characters");
            return false;
        }
    }
    
    function check_filesize($file, $max_size) {
    print_r($file);
        $this->set_message('check_filesize', "Invalid max filesize specified");
        
        // find max size
        if(preg_match('#^([0-9.,]+)[ ]*([KMG])#i', $max_size, $matches)) {
            $size = $matches[1];
            $unit = strtoupper($matches[2]);
            switch($unit) {
                case 'G': $size *= 1024;
                case 'M': $size *= 1024;
                case 'K':
                    $size *= 1024;
                    break;
                default: return false;
            }
        }
        else $size = $max_size;
        
        //check file size
        if(filesize($file) > $size) {
            $this->set_message("check_filesize", "The file you uploaded is too big. The maximum file size is $max_size ($size bytes)");
            return false;
        }
        
        return true;
    }
    
    function writable_directory($dirs) {
        foreach($dirs as $dir) {
            if(!is_writable($dir)) {
                exit("The directory $dir isn't writable. Please contact the administrator.");
                return false;
            }
        }
        return true;
    }
    
    function valid_time($time) {
        //
    }
    
    function valid_date($date) {
        if(!function_exists('iso_date')) $this->load->helper("time");
        $result = iso_date($date);
        if($result !== false) $result = true;
        $this->set_message("valid_date","Please specify a valid date. Examples: \"".date('Y-m-d').'" or "'.date("n/d").'"');
        return $result;
    }	
	
	/**
	 * Validate a U.S. Phone Number
	 */
	function valid_phone($str) 
	{
		return preg_match("/^\(?([0-9]{3})\)?[- ]?([0-9]{3})[- ]?([0-9]{4})$/", $str) ? TRUE : FALSE;
	}
	
	/**
	 * Validate a 5 digit U.S. Postal Code OR Zip+4.
	 */
	function valid_zip($str)
	{
		return preg_match('/^\d{5}(-\d{4})?$/', $str) ? TRUE : FALSE;
	}
	
	function valid_url($str)
	{
		return preg_match('/^(http|https):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}((:[0-9]{1,5})?\/.*)?$/i', $str) ? TRUE : FALSE;
	}

	public function get_rules($config_group)
	{
		if (array_key_exists($config_group, $this->_config_rules))
		{
			return $this->_config_rules[$config_group];	
		}
		else
		{
			return array();
		}	
	}
	
	/**
	 * Read the config and grab any fields that are required.
	 */
	public function get_required_fields($config_group)
	{
		$rules = $this->get_rules($config_group);
		
		$ruleset = array();
		
		$required = array();

		foreach($rules as $rule)
		{
			if (preg_match('/required/', $rule['rules']))
			{
				$required[] = $rule['field'];
			}
		}
		
		return $required;
	}
	
	/**
	 * Reads the form_validation config and converts CodeIgniter rules to jQuery rules.
	 * See $this->jquery_rule_map() for mapped rules.
	 */
	public function jquery_validate_rules($config_group)
	{
		$rules = $this->get_rules($config_group);
		$jq_rule_map = $this->jquery_rule_map();
		
		$jquery_rules = array();
		
		foreach($rules as $rule)
		{
			$field = $rule['field'];
			
			$rule_list = explode('|', $rule['rules']);

			foreach($rule_list as $item)
			{
				// Looking for rules like max_length[2] that accepts a name and a parameter.
				if (preg_match('/(.*)\[(.*)\]/', $item, $matches))
				{
					$rule_name = $matches[1];
					$rule_param = $matches[2];
					
					// See if this CodeIgniter rule matches one of our mapped jquery rules.
					if (array_key_exists($rule_name, $jq_rule_map))
					{
						$jq_rule_name = $jq_rule_map[$rule_name];
						
						// Use * to delimit the rule parameter. This will be converted to quotes later.
						$jq_rule_items[$field][$jq_rule_name] = '*' . $rule_param . '*';
					}
				}
				else
				{
					if (array_key_exists($item, $jq_rule_map))
					{
						$jq_rule_name = $jq_rule_map[$item];
						$jq_rule_items[$field][$jq_rule_name] = 'true';
					}
				}
			}
		}

		// JSON Encode the rule array and strip quotes. jquery validate doesn't like quoted identifiers.
		// But it DOES like quoted string values, so replace the * with quotes.
		$encoded = str_replace('*', '"', str_replace('"', '', json_encode($jq_rule_items, JSON_FORCE_OBJECT)));
		return $encoded;
	}	
	
	function get_error_array()
	{
		return $this->_error_array;
	}
}