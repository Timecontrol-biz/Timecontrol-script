<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    public function index() {
        $d = array();
        
        if(isset($_POST['timetable']) && !empty($_POST['timetable'])) {
            $ip = $_SERVER['REMOTE_ADDR'];

            /*
            if(!preg_match('/127\.0\.0\.1/', $ip) && !preg_match('/192\.168/', $ip) && !preg_match('/194\.44/', $ip)) { // 194.44 OFFICE
                die('<strong>Please, open this page from office!</strong>');
            }
             *
             */
            
            $timetable = $_POST['timetable'];
            
            if($timetable['user']) {
                $test_day = $this->db->where('date', date('Y-m-d'))->where('user', $timetable['user'])->get('timetable')->num_rows();
                
                if(!$test_day) {
                    $this->db->insert('timetable', array('date' => date('Y-m-d'), 'user' => $timetable['user']));
                }
                $update = array();
                
                if(isset($timetable['checkin'])) {
                    $update['ip'] = $ip;
                    $update['checkin'] = date('H:i:s');
                    
                    if(!empty($timetable['reason_morning'])) {
                        $update['reason_morning'] = strip_tags(trim($timetable['reason_morning']));
                    }
                } else if(isset($timetable['checkout'])) {
                    $update['checkout'] = date('H:i:s');
                    $tt = $this->db->where('user', $timetable['user'])->where('date', date('Y-m-d'))->get('timetable')->row();
                    
                    if(!empty($tt)) {
                        $calculate = $this->timetable_model->calculate_timatable($tt);
                        $update['summary'] = intval($calculate['summary']/60) > 0 ? intval($calculate['summary']/60) : 0;
                    } else {
                        $update['summary'] = 0;
                    }
                    
                    if(!empty($timetable['reason_evening'])) {
                        $update['reason_evening'] = strip_tags(trim($timetable['reason_evening']));
                    }
                } else if(isset($timetable['lunch_start'])) {
                    $update['lunch_start'] = date('H:i:s');
                } else if(isset($timetable['lunch_stop'])) {
                    $update['lunch_stop'] = date('H:i:s');
                }
                $this->db->where('user', $timetable['user'])->where('date', date('Y-m-d'))->update('timetable', $update);
                setcookie('user', $timetable['user']);
            } else {
                $d['message'] = '* Please, choose the user!';
            }
        }

        $d['users'] = $this->user_model->get_users();
        $d['timetable'] = $this->timetable_model->get_timetable(date('Y-m'));
        
        if(isset($_COOKIE['user'])) {
            $user = $_COOKIE['user'];
            $current_day = $this->db->where('user', $user)->where('date', date('Y-m-d'))->get('timetable')->row();
            $d['current_day'] = (array) $current_day;
            
            if(!empty($current_day)) {
                $calculate = $this->timetable_model->calculate_timatable($current_day);
                $d['remaining_time'] = $this->timetable_model->remaining_time($current_day->checkin, $current_day->checkout, $calculate['lunch']);
            } else {
                $d['remaining_time'] = 0;
            }
        } else {
            $d['select_user'] = true;
        }
        
        $this->load->view('main', $d);
    }
}
