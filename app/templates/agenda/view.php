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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Ajout rdv</h4>
            </div>
            <div class="modal-body">
                <form>
                    <label>
                        Client:
                    </label>
                    <input list="clientsList" type="text" id="clientsInput"/>
                    <datalist id="clientsList"></datalist>
                    <label>
                        date Rdv:
                    </label>
                    <input type="text" id="dateRdv"/>
                    <input type="hidden" id="dateRdvHidden"/>
                    <label>
                        heure Rdv:
                    </label>
                    <input type="time" id="heureRdv"/>
                    <label>
                        duree Rdv:
                    </label>
                    <div class="selectDivision">
                        <select id="dureeRdv">
                            <option value="30">00H30</option>
                            <option value="45">00H45</option>
                            <option value="60" selected >01H00</option>
                            <option value="75">01H15</option>
                            <option value="90">01H30</option>
                            <option value="105">01H45</option>
                            <option value="120">02H00</option>
                        </select>
                    </diV>
                    <label>
                        type Rdv :
                    </label>
                    <div class="selectDivision">
                        <select id="typeRdv">
                            <option value="livre">montage pneus livrés à l'atelier</option>
                            <option value="non_livre">montage pneus ramenés par client</option>
                            <option value="switch">switching des roues</option>
                            <option value="decalaminage">décalaminage</option>
                        </select>
                    </diV>
                    <label>
                        Nbr pneu :
                    </label>
                    <div class="selectDivision">
                        <select id="nbrPneu">
                            <option value="2">2</option>
                            <option value="4">4</option>
                            <option value="6">6</option>
                            <option value="8">8</option>
                            <option value="10">10</option>
                        </select>
                    </diV>
                    <label>
                        Acier :
                    </label>
                    <div class="selectDivision">
                        <select id="acier">
                            <option value="Alu">Alu</option>
                            <option value="Tole">Tôle</option>
                        </select>
                    </diV>
                    <label>
                        Taille :
                    </label>
                    <div class="selectDivision">
                        <select id="taille">
                            <option value="13">13"</option>
                            <option value="14">14"</option>
                            <option value="15">15"</option>
                            <option value="16">16"</option>
                            <option value="17">17"</option>
                            <option value="18">18"</option>
                            <option value="19">19"</option>
                            <option value="20">20"</option>
                        </select>
                    </diV>
                    <label>
                        Remarque :
                    </label>
                    <input type="text" id="remarque"/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="addRdv">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
<div id='calendar'></div>
<script type="text/javascript" >
    $(function(){
        $('#calendar').fullCalendar({
            lang : 'fr',
            timezone: 'local',
            local: 'fr',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'agendaWeek,agendaDay,listWeek'
            },
            defaultView:'agendaWeek',
            eventDurationEditable: false,
            /*businessHours: [
                {
                    dow: [ 1, 2, 3 ],
                    start: '08:00',
                    end: '18:00'
                },
                {
                    dow: [ 4, 5 ],
                    start: '10:00',
                    end: '16:00'
                }
            ],*/
            navLinks: true, // can click day/week names to navigate views
            editable: false,
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
                        callback(events);
                    }
                });
            },
            eventClick:function(){
                alert('oui');
            },
            dayClick:function(event){
                $('#myModal').modal({keybord:false,backdrop:'static'});
                console.log(event);
                $('#dateRdv').val(moment(event._d).format('DD/MM/YYYY'));
                $('#heureRdv').val(moment(event._d).format('HH:mm'));
            }
        });

        $('#clientsInput').on('input',function(){
            $.ajax({
                url: getClients,
                data: {
                    client: $(this).val()
                },
                success:function(data){
                    $('#clientsList').empty();
                    $.each(data,function(key,client){
                        $('#clientsList').append('<option value="'+client.lastname+' '+client.firstname+'" class="dataListItem" data-id_user="'+client.id+'" >');
                    });

                }
            });
        });


        $('#addRdv').on('click',function(){
             var data ={
                user : $('#clientsInput').val(),
                 dateRdv : $('#dateRdv').val(),
                 heureRdv : $('#heureRdv').val(),
                 dureeRdv : $('#dureeRdv').val(),
                 typeRdv : $('#typeRdv').val(),
                 nbrPneu : $('#nbrPneu').val(),
                 acier : $('#acier').val(),
                 taille : $('#taille').val(),
                 remarque: $('#remarque').val(),
            };
            console.log(addRdv);
            $.ajax({
                url: addRdv,
                type:'post',
                data: data,
                success:function(){
                    $('#calendar').fullCalendar( 'refetchEvents' );
                    $('#myModal').modal('toggle');
                }
            });
        });

    });
</script>
<?php $this->stop('main_content') ?>
