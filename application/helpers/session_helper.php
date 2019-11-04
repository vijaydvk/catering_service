<?php
    //Function returns the CI instance
    //================================
    //Usage:
    //================================
    //ci_instance()->uri->segment(3);
    //================================
    //Replaces:
    //================================
    //$ci =& get_instance();
    //================================
    if(!function_exists('ci_instance')) {
        function ci_instance() {
            return get_instance();
        }
    }

    if(!function_exists('check_sessions')) {
        function check_sessions($session_name) {
            if(is_array($session_name)) {
                foreach($session_name as $s) {
                    a($s);
                }
            } else {
                a($session_name);
            }
        }
    }
    
    if(!function_exists('a')) {
        function a($session_name) {
            if(ci_instance()->session->userdata($session_name)) {
                return true;
            } else {
                redirect('/');
            }
        }
    }

/* End of file session_helper.php */
/* Location: /application/helpers/session_helper.php */