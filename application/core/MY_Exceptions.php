<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class MY_Exceptions extends CI_Exceptions
{
    /**
     * Constructor
     *
     */
    function __construct()
    {
        parent::__construct();
    }
    /**
     * Exception Logger
     *
     * This function logs PHP generated error messages
     *
     */
    function log_exception($severity, $message, $filepath, $line)
    {
      
        $severity = (!isset($this->levels[$severity])) ? $severity : $this->levels[$severity];
        $message = 'Severity: ' . $severity . ' –> ' . $message . ' ' . $filepath . ' ' . $line . ' [URI=' . $_SERVER['REQUEST_URI'] . ']';
        if (!empty($_POST)) {
            $message .= 'POST: ';
            foreach ($_POST as $key => $value) {
                $message .= $key . ' => ' . $value;
            }
        }
        log_message('error', $message, TRUE);
    }
}
// END Exceptions Class
/* End of file Exceptions.php */
/* Location: ./ci_app/core/Exceptions.php */