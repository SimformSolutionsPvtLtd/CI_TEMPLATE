<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions {

    function __construct()
    {
        parent::__construct();
    }

    function log_exception($severity, $message, $filepath, $line)

    {   
        if (ENVIRONMENT === 'development') {
            $ci =& get_instance();

            $ci->load->library('email');
            $ci->email->from('ronak.k@simform.in', 'Ronak');
            $ci->email->to('ronak.k@simform.in');
            //$ci->email->cc('another@another-example.com');
            //$ci->email->bcc('them@their-example.com');
            $ci->email->subject('error');
            $ci->email->message('Severity: '.$severity.'  --> '.$message. ' '.$filepath.' '.$line);
            $ci->email->send();
        }


        parent::log_exception($severity, $message, $filepath, $line);
    }

}
?>