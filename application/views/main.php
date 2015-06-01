<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
        <link rel="shortcut icon" href="/img/favicon.png" />
        
        <link href="http://code.jquery.com/ui/jquery-ui-git.css" rel="stylesheet" type="text/css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="/css/style.css" rel="stylesheet" type="text/css">
        
        <script src="http://code.jquery.com/jquery-2.1.4.min.js" type="text/javascript"></script>
        <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/js/script.js" type="text/javascript"></script>
        
	<title>Timetable - DMP</title>
</head>
<body>
    
    <div class="row">
        <p class="bg-primary welcome">
            <strong>Welcome to timetable / DMP</strong>
        </p>
    </div>
    
    <div class="row content">
        <div class="col-md-10 content-left">
            <?php
            if(isset($message)) {
                echo '<p class="bg-danger">'.$message.'</p>';
            }
            ?>
            <?php if(!empty($timetable)) { ?>
                <?php foreach($timetable as $dat => $td) { ?>
                <table class="table table-bordered">
                    <tr>
                        <th colspan="6" style="text-align: center;">
                            <h4><?php echo $dat; ?></h4>
                        </th>
                    </tr>
                    <tr>
                        <th class="success">Check in from IP</th>
                        <th class="info">Name</th>
                        <th class="info">Check in</th>
                        <th class="info">Check out</th>
                        <th class="info">Lunch</th>
                        <th class="info">Summary</th>
                    </tr>
                    <?php foreach($td as $tt) { ?>
                    <tr>
                        <td class="<?php if(!preg_match('/127\.0\.0\.1/', $tt->ip) && !preg_match('/192\.168/', $tt->ip) && !preg_match('/194\.44/', $tt->ip)) echo 'danger'; else echo 'success'; ?>"><?php echo $tt->ip; ?></td>
                        <td class="info"><strong><?php echo $users[$tt->user]->firstname; ?> <?php echo $users[$tt->user]->lastname; ?></strong></td>
                        <td class="info"><?php echo $tt->checkin; ?> <?php if(!empty($tt->reason_morning)) echo '<img src="/img/q.png" title="'.$tt->reason_morning.'" class="ic" data-toggle="tooltip" data-placement="top">'; ?></td>
                        <td class="info"><?php echo $tt->checkout; ?> <?php if(!empty($tt->reason_evening)) echo '<img src="/img/q.png" title="'.$tt->reason_evening.'" class="ic" data-toggle="tooltip" data-placement="top">'; ?></td>
                        <td class="info"><?php echo $tt->lunch; ?> minutes</td>
                        <td class="info"><strong><?php if(floor($tt->summary/60) > 0) echo floor($tt->summary/60); else echo '0'; ?> hour<?php if(floor($tt->summary/60) > 1) echo 's'; ?></strong></td>
                    </tr>
                    <?php } ?>
                </table>
                <?php } ?>
            <?php } else { ?>
            <p class="bg-danger">Time is empty for now.</p>
            <?php } ?>
        </div>
        <div class="col-md-2 content-right">
            <form action="" method="post" target="_top">
                <div>
                    <?php if(isset($remaining_time) && $remaining_time != '00:00:00') { ?>
                        <?php if($remaining_time > 0) { ?>
                        <h4 style="text-align:center;" id="remaining_time" class="time">Remaining time: <?php echo $remaining_time; ?></h4>
                        <?php } else { ?>
                        <h4 class="bg-success title_block" style="text-align:center;" id="remaining_time"><strong>You can go to home!</strong></h4>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="margin top middle">
                    <input type="button" class="btn btn-danger btn-lg hideblock" value="Refresh buttons" id="button_refresh_page">
                    <?php if(empty($current_day) || (isset($current_day['checkin']) && $current_day['checkin'] == '00:00:00')) { ?>
                    <input type="submit" class="btn btn-success btn-lg" name="timetable[checkin]" value="Check in" id="button_checkin">
                    <input type="hidden" name="timetable[reason_morning]" value="" id="reason_morning">
                    <?php } else { ?>
                        <?php if(empty($current_day) || (isset($current_day['checkout']) && $current_day['checkout'] == '00:00:00')) { ?>
                        <input type="submit" class="btn btn-danger btn-lg" name="timetable[checkout]" value="Check out" id="button_checkout">
                        <input type="hidden" name="timetable[reason_evening]" value="" id="reason_evening">
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="margin top middle">
                    <?php if(empty($current_day) || (isset($current_day['checkout']) && $current_day['checkout'] == '00:00:00')) { ?>
                        <?php if(empty($current_day) || (isset($current_day['lunch_start']) && $current_day['lunch_start'] == '00:00:00')) { ?>
                        <input type="submit" class="btn btn-success btn-lg" name="timetable[lunch_start]" value="Lunch start">
                        <?php } else { ?>
                            <?php if(empty($current_day) || (isset($current_day['lunch_stop']) && $current_day['lunch_stop'] == '00:00:00')) { ?>
                            <input type="submit" class="btn btn-danger btn-lg" name="timetable[lunch_stop]" value="Lunch stop">
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </div>
                <hr>
                <div class="margin top alot">
                    <p class="bg-warning title_block">
                        <strong>Show the history</strong>
                    </p>
                    <div class="form-group">
                        <select class="form-control" name="timetable[user]" id="user_select">
                            <option value="0">Choose user</option>
                            <?php
                            if(!empty($users)) {
                                foreach($users as $us) {
                                    if(isset($_COOKIE['user']) && $_COOKIE['user'] == $us->id) {
                                        $checked = ' selected';
                                    } else {
                                        $checked = '';
                                    }
                                    echo '<option value="'.$us->id.'"'.$checked.'>'.$us->firstname.' '.$us->lastname.'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" value="" placeholder="Date from ..." class="form-control" id="show_date_from">
                    </div>
                    <div class="form-group">
                        <input type="text" value="" placeholder="Date to ..." class="form-control" id="show_date_to">
                    </div>
                    <div class="form-group">
                        <input type="button" class="btn btn-default btn-lg" value="Show summary" id="show_summary">
                    </div>
                    <div class="margin top middle hideblock" id="range_result"></div>
                </div>
            </form>
        </div>
    </div>
    <?php if(isset($select_user) && $select_user == true) { ?>
    <div class="cat"></div>
    <div class="choose_user">
        <p class="bg-primary title_block">Who are you? Please select the user:</p>
        <div class="form-group">
            <select class="form-control" name="timetable[user]" id="first_user_selection">
                <?php
                if(!empty($users)) {
                    foreach($users as $us) {
                        echo '<option value="'.$us->id.'">'.$us->firstname.' '.$us->lastname.'</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <input type="button" id="first_user_button" value="Choose" class="btn btn-success">
        </div>
    </div>
    <?php } ?>

</body>
</html>