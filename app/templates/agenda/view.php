<?php
/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 10/12/16
 * Time: 14:26
 */
?>

<?php $this->layout('layout', ['title' => 'Agenda']) ?>
<?php $this->start('main_content') ?>
<style>

    body {
        margin: 40px 10px;
        padding: 0;
        font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
        font-size: 14px;
    }

    #calendar {
        max-width: 900px;
        margin: 0 auto;
    }

</style>
<div id='calendar'></div>
<script type="text/javascript" >
    $(function(){
        $('#calendar').fullCalendar({
            lang : 'fr',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'
            },
            defaultDate: '2016-12-12',
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: function(start, end, timezone, callback) {
                $.ajax({
                    url: eventLoad,
                    dataType: 'json',
                    data: {
                        // our hypothetical feed requires UNIX timestamps
                        start: start.unix(),
                        end: end.unix()
                    },
                    success: function(events) {
                        callback(events.events);
                       console.log(events);
                    }
                });
            },
        });
        $('.fc-button').on('click',function(){
            $('#calendar').fullCalendar( 'refetchEvents');
        });
    });
</script>
<?php $this->stop('main_content') ?>
