<?php
/**
 * BTS2 - Bill's Template System for PHP 5
 * 
 * A very simple Smarty-like template sytem
 * 
 * PHP Version 5
 * 
 * @category  HTML
 * @package   BTS2
 * @author    Bill Shupp <hostmaster@shupp.org> 
 * @copyright 2006-2008 Bill Shupp
 * @license   GPL 2.0  {@link http://www.gnu.org/licenses/gpl.txt}
 * @link      http://shupp.org/bts
 */

require_once 'BTS2/Exception.php';

/**
 * BTS2 
 * 
 * @category  HTML
 * @package   BTS2
 * @author    Bill Shupp <hostmaster@shupp.org> 
 * @copyright 2006-2008 Bill Shupp
 * @license   GPL 2.0  {@link http://www.gnu.org/licenses/gpl.txt}
 * @link      http://shupp.org/bts
 */
class BTS2
{
    /**
     * data 
     * 
     * Where all data is stored
     * 
     * @var array
     * @access public
     */
    protected $data = array();

    /**
     * templateDir 
     * 
     * Location of template directory
     * 
     * @var string
     * @access protected
     */
    protected $templateDir = null;

    /**
     * __constructor
     * 
     * Setup
     * 
     * @param string $templateDir Teamplates directory
     * 
     * @access public
     * @return void
     */
    public function __construct($templateDir = './templates')
    {
        $this->templateDir      = $templateDir;
        $this->data['php_self'] = $_SERVER['PHP_SELF'];
    }

    /**
     * __set 
     * 
     * @param mixed $key data array key
     * @param mixed $val data array value
     * 
     * @access public
     * @return void
     */
    public function __set($key, $val)
    {
        $this->data[$key] = $val;
    }

    /**
     * __get 
     * 
     * @param mixed $key data array key
     * 
     * @access public
     * @return void
     */
    public function __get($key)
    {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
        return null;
    }

    /**
     * assign 
     * 
     * Assign a variable to $data
     * 
     * @param mixed $name  variable name
     * @param mixed $value variable value
     * 
     * @access public
     * @return void
     */
    public function assign($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * getContents 
     * 
     * return the parsed PHP contents of a file
     * 
     * @param string $file filename
     * 
     * @access protected
     * @throws BTS2_Exception if $file is not readable
     * @return string
     */
    protected function getContents($file)
    {
        $path = $this->templateDir . DIRECTORY_SEPARATOR . $file;
        if (!is_readable($path)) {
            throw new BTS2_Exception("BTS2 Error: Could not retrieve $path");
        } else {
            // Get contents and parse PHP
            foreach ($this->data as $key => $val) {
                $$key = $val;
            }
            ob_start();
            include $path;
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
     * @param mixed $data contents to parse
     * 
     * @protected
     * @return $data
     */
    protected function parse($data)
    {
        // Replace Tags
        foreach ($this->data as $key => $value) {
            if (is_array($value)) {
                $re   = '/{[$]*' . trim($key) . '}/i';
                $data = preg_replace($re, 'Array', $data);
                foreach ($value as $ar_key => $ar_val) {
                    $re   = '/{[$]*' . trim($key) . '.' . trim($ar_key) . '}/i';
                    $data = preg_replace($re, trim($ar_val), $data);
                }
            } else {
                $re   = '/{[$]*' . trim($key) .'}/i';
                $data = preg_replace($re, trim($value), $data);
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
     * @param mixed $file   filename
     * @param bool  $return whether to return rather than display
     * 
     * @access public
     * @throws BTS2_Exception bubbles up from $this->getContents()
     * @return mixed string $data or void
     */
    public function display($file, $return = false)
    {
        $data = $this->getContents($file);
        $data = $this->parse($data);
        if ($return == true) {
            return $data;
        }
        print ($data);
    }

    /**
     * selectOptions 
     * 
     * Determinte which option is selected in an array, output
     * as an <option> list
     * 
     * @param mixed $opts        options array
     * @param mixed $selectedOpt selected option
     * 
     * @access public
     * @return void
     */
    public function selectOptions($opts, $selectedOpt)
    {
        $out = '';
        foreach ($opts as $key => $val) {
            $selected = '';
            if ($val == $selectedOpt) {
                $selected = ' selected';
            }
            $out .= "<option$selected>$val\n";
        }
        return $out;
    }

    /**
     * cycle 
     * 
     * Simple function for cycling items like bgcolor in a foreach loop
     * Derived from the Smarty Plugin by Monte Ohrt
     * 
     * @param mixed  $values bgcolor values
     * @param string $name   name
     * 
     * @access public
     * @return void
     */
    public function cycle($values, $name = 'default')
    {
        static $cycleVars;
        if (isset($cycleVars[$name]['values']) 
            && $cycleVars[$name]['values'] != $values) {
            $cycleVars[$name]['index'] = 0;
        }
        $cycleVars[$name]['values'] = $values;

        $cycleArray = explode(',', $cycleVars[$name]['values']);
        if (!isset($cycleVars[$name]['index'])) {
            $cycleVars[$name]['index'] = 0;
        }
        $retval = $cycleArray[$cycleVars[$name]['index']];
        if ($cycleVars[$name]['index'] >= count($cycleArray) -1) {
            $cycleVars[$name]['index'] = 0;
        } else {
            $cycleVars[$name]['index']++;
        }
        return $retval;
    }
}
?>
