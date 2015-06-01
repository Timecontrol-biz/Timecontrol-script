<?php
class Timetable_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    public function get_timetable($date='', $limit='') {
        if(empty($date)) {
            $date = date('Y-m-d');
        }
        if(empty($limit)) {
            $limit = 1000;
        }
        $this->db;
        
        if($date) {
            $this->db->like('date', $date)->order_by('date', 'desc')->limit($limit);
        }
        
        $timetable = $this->db->get('timetable');
        $timetable_list = array();
        
        if($timetable->result()) {
            foreach($timetable->result() as $tt) {
                $timetable_list[$tt->date][$tt->id] = $tt;
                $calculate = $this->calculate_timatable($tt);
                $timetable_list[$tt->date][$tt->id]->lunch = intval($calculate['lunch']/60) > 0 ? intval($calculate['lunch']/60) : 0;
                $timetable_list[$tt->date][$tt->id]->summary = intval($calculate['summary']/60) > 0 ? intval($calculate['summary']/60) : 0;
                $timetable_list[$tt->date][$tt->id]->reason_morning = $tt->reason_morning;
                $timetable_list[$tt->date][$tt->id]->reason_evening = $tt->reason_evening;
            }
        }
        
        return $timetable_list;
    }
    public function calculate_timatable($tt=array()) {
        $checkin = new DateTime($tt->checkin);
        $checkout = new DateTime($tt->checkout);
        $lunch_start = new DateTime($tt->lunch_start);
        $lunch_stop = new DateTime($tt->lunch_stop);

        $lunch = $tt->lunch_start != '00:00:00' && $tt->lunch_stop != '00:00:00' ? intval(($lunch_stop->getTimestamp() - $lunch_start->getTimestamp())) : 0;
        if($lunch < 0) {
            $lunch = 0;
        }

        $summary = $tt->checkin != '00:00:00' && $tt->checkout != '00:00:00' ? $checkout->getTimestamp() - $checkin->getTimestamp() - $lunch : 0;
        if($summary < 0) {
            $summary = 0;
        }
        
        return array('lunch' => $lunch, 'summary' => $summary);
    }
    public function remaining_time($checkin='00:00:00', $checkout='00:00:00', $lunch=0) {
        $result = '00:00:00';
        
        if($checkin != '00:00:00' && $checkout == '00:00:00') {
            $obj_checkin = new DateTime($checkin); // Date when came
            $obj_checkout = $obj_checkin->getTimestamp() + (3600 * 7); // Checkin + 7 hours
            $result = $obj_checkout - time() + $lunch; // checkin+8h - checkin
            
            if($result > 0) {
                $result = date('H:i:s', $result); // if res is okay, show date remaining
            }
        }
        return $result;
    }
    public function create_timetable() {
        
    }
    public function delete_timetable() {
        
    }
    public function update_timetable() {
        
    }
}