/* 
    Created on : May 27, 2015, 4:14:29 PM
    Author     : voronovich
*/

$(document).ready(function(){
    // Set date blocks
    $('#show_date_from, #show_date_to').datepicker({
        dateFormat: "yy-mm-dd"
    }).datepicker('setDate', new Date());
    
    // Event when someone change the date
    $('#show_date_from, #show_date_to').change(function(){
        $('#show_summary').click();
    });
    
    // Event when someone change the user
    $('#user_select').change(function(){
        $('#show_summary').click();
        $('#button_refresh_page').fadeIn(200);
    });
    
    // Reload event, for refreshing page
    $('#button_refresh_page').click(function(){
        location.reload();
    });
    
    // Event for showing the summary worked time
    $('#show_summary').click(function(){
        var user      = $('#user_select').val();
        var date_from = $('#show_date_from').val();
        var date_to   = $('#show_date_to').val();
        
        if(user > 0) {
            if(date_from.length && date_to.length) {
                $('#range_result').html('<div style="text-align:center;"><img src="/img/ajax-loader.gif"></div>');
                $.ajax({
                    type    : "POST",
                    url     : "/timetable_get_json",
                    data    : "show[user]="+user+"&show[date_from]="+date_from+"&show[date_to]="+date_to,
                    success : function(content) {
                        $('#range_result').fadeOut(0);
                        
                        if(!content.match(/\*/g)) {
                            var json_content = jQuery.parseJSON(content);
                            
                            $('#range_result').html('<ul><li class="sum_lunch">Sum lunch: </li> <li class="summary">Summary work: </li></ul>');
                            $('#range_result .sum_lunch').append("<strong>"+json_content.sum_lunch+"</strong> minutes");
                            $('#range_result .summary').append("<strong>"+json_content.summary+"</strong> hours");
                        } else {
                            $('#range_result').html(content);
                        }
                        
                        $('#range_result').fadeIn(0);
                    }
                });
            } else {
                $('#range_result').html("Please, choose the date range ...").fadeIn(0);
            }
        } else {
            $('#range_result').html("Please, choose the user!").fadeIn(0);
        }
    });
    
    // When page is ready, wait 500 MS and show the current time
    setTimeout(function(){
        $('#show_summary').click();
    }, 500);
    
    // Checkin reason
    $('#button_checkin').click(function(obj){
        var d = new Date();
        var h = d.getHours() - 1; // Ukraine time to SWISS
        
        if(h > 10 && $('#reason_morning').val().length == 0) {
            obj.preventDefault();
            var reason = window.prompt('Why you late?');
            
            if(reason) {
                $('#reason_morning').val(reason);
                $(this).click();
            }
        }
    });
    
    // Checkout reason
    $('#button_checkout').click(function(obj){
        if($('.time#remaining_time').length > 0 && $('#reason_evening').val().length == 0) {
            obj.preventDefault();
            var reason = window.prompt('Why you leaving early?');
            
            if(reason) {
                $('#reason_evening').val(reason);
                $(this).click();
            }
        } else {
            var sure = window.confirm('Are you sure? Do you want check out?');
            
            if(!sure) {
                obj.preventDefault();
            }
        }
    });
    
    // Show the reasons in the screen
    $('.ic').click(function(){
        var res = $(this).attr('title');
        alert(res);
    });
    
    // First choosing the user
    $('#first_user_button').click(function(){
        $('#first_user_button').attr('val', 'Please, wait ...');
        var selected = $('#first_user_selection').val();
        $.ajax({
            type:'POST',
            url:'/timetable_get_json',
            data:'set_user='+selected,
            success:function(){
                location.reload();
            }
        });
    });
});