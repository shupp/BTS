<?php
/**
 * BTS - Bill's Template System
 * 
 * A very simple Smarty-like template sytem
 * 
 * @package BTS
 * @version 0.5
 * @copyright 2006-2007 Bill Shupp
 * @author Bill Shupp <hostmaster@shupp.org> 
 * @license GPL 2.0  {@link http://www.gnu.org/licenses/gpl.txt}
 */
/**
 * bts 
 * 
 * @package BTS
 * @version 0.5
 * @copyright 2006-2007 Bill Shupp
 * @author Bill Shupp <hostmaster@shupp.org> 
 * @license GPL 2.0  {@link http://www.gnu.org/licenses/gpl.txt}
 */
class BTS {
    /**
     * var_array 
     * 
     * @var array
     * @access public
     */
    var $var_array = array();
    /**
     * bts Constructor
     * 
     * Setup
     * 
     * @access public
     * @return void
     */
    function bts() {
        if (!defined(BTS_TEMPLATE_DIR)) 
            define(BTS_TEMPLATE_DIR, './templates/');
        $this->var_array['php_self'] = $_SERVER['PHP_SELF'];
    }
    /**
     * assign 
     * 
     * Assign a variable to $var_array
     * 
     * @param mixed $name 
     * @param mixed $value 
     * @access public
     * @return void
     */
    function assign($name, $value) {
        $this->var_array[$name] = $value;
    }
    /**
     * get_contents 
     * 
     * return the parsed PHP contents of a file
     * 
     * @param mixed $file 
     * @access public
     * @return $contents
     */
    function get_contents($file) {
        $full_path = BTS_TEMPLATE_DIR.'/'.$file;
        if (!is_readable($full_path)) {
            die("BTS Error: Could not retrieve $full_path");
        } else {
            // Get contents and parse PHP
            foreach($this->var_array as $key => $val) {
                $$key = $val;
            }
            ob_start();
            include ($full_path);
            $buffer = ob_get_contents();
            ob_end_clean();
            return $buffer;
        }
    }
    /**
     * parse 
     * 
     * Parse template data
     * 
     * @param mixed $data 
     * @access protected
     * @return $data
     */
    protected function parse($data) {
        // Replace Tags
        foreach($this->var_array as $key => $value) {
            if (is_array($value)) {
                $data = eregi_replace("{[$]*".trim($key) ."}", 'Array', $data);
                foreach($value as $ar_key => $ar_val) {
                    $data = eregi_replace("{[$]*".trim($key) .".".trim($ar_key) ."}", trim($ar_val), $data);
                }
            } else {
                $data = eregi_replace("{[$]*".trim($key) ."}", trim($value), $data);
            }
        }
        return $data;
    }
    /**
     * display 
     * 
     * Output data using print() if second argument is 0.
     * Otherwise, return the data to the caller
     * 
     * @param mixed $file 
     * @param int $return 
     * @access public
     * @return void
     */
    function display($file, $return = 0) {
        $data = $this->get_contents($file);
        $data = $this->parse($data);
        if ($return == 1) return $data;
        print ($data);
    }
    /**
     * bts_selectoptions 
     * 
     * Determinte which option is selected in an array, output
     * as an <option> list
     * @param mixed $opt_array 
     * @param mixed $selected_option 
     * @access public
     * @return void
     */
    function bts_selectoptions($opt_array, $selected_option) {
        $out = '';
        foreach($opt_array as $key => $val) {
            $selected = '';
            if ($val == $selected_option) {
                $selected = ' selected';
            }
            $out.= "<option$selected>$val\n";
        }
        return $out;
    }
    /**
     * cycle 
     * 
     * Simple function for cycling items like bgcolor in a foreach loop
     * Derived from the Smarty Plugin by Monte Ohrt
     * 
     * @param mixed $values 
     * @param string $name 
     * @access public
     * @return void
     */
    function cycle($values, $name = 'default') {
        static $cycle_vars;
        if (isset($cycle_vars[$name]['values']) && $cycle_vars[$name]['values'] != $values) {
            $cycle_vars[$name]['index'] = 0;
        }
        $cycle_vars[$name]['values'] = $values;
        $cycle_array = explode(',', $cycle_vars[$name]['values']);
        if (!isset($cycle_vars[$name]['index'])) {
            $cycle_vars[$name]['index'] = 0;
        }
        $retval = $cycle_array[$cycle_vars[$name]['index']];
        if ($cycle_vars[$name]['index'] >= count($cycle_array) -1) {
            $cycle_vars[$name]['index'] = 0;
        } else {
            $cycle_vars[$name]['index']++;
        }
        return $retval;
    }
}
?>
