<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timetable_get_json extends CI_Controller {
    public function index() {
        $d = array();
        
        $nothing_found = '* Nothing found...';
        $fill_data = '* Please, fill all inputs ...';
        
        if(isset($_POST['set_user'])) {
            setcookie('user', $_POST['set_user']);
        }
        
        if(isset($_POST['show']) && !empty($_POST['show'])) {
            sleep(1); // For understanding what block has benn changed
            $show = $_POST['show'];
            setcookie('user', $show['user']);
            $timetables = $this->db->where('date >=', $show['date_from'])->where('date <=', $show['date_to'])->where('user', $show['user'])->get('timetable');
            
            if($timetables->num_rows()) {
                $result = array('sum_lunch' => 0, 'summary' => 0);
                
                foreach($timetables->result() as $tt) {
                    $calculate = $this->timetable_model->calculate_timatable($tt);
                    $result['sum_lunch'] += floor($calculate['lunch']/60) > 0 ? floor($calculate['lunch']/60) : 0;
                    $result['summary'] += round($calculate['summary']/60/60, 1) > 0 ? round($calculate['summary']/60/60, 1) : 0;
                }
                if($result['sum_lunch'] || $result['summary']) {
                    $result = json_encode($result);
                } else {
                    $result = $nothing_found;
                }
                die($result);
            } else {
                die($nothing_found);
            }
        } else {
            die($fill_data);
        }
    }
}
