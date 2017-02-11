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
    #clientsList{
        max-height: 110px;
        border: 1px solid black;
        overflow-y: scroll;
        width: 80%;
        position: absolute;
        background-color: white;
        top: 40px;
        border-radius:5px;
    }
    #clients{
        position: relative;
        width: 80%;
    }

    .clientItem:hover{
        cursor:pointer;
        background-color: grey;
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
                    <input type="hidden" id="idEvent"/>
                    <label>
                        Client:
                    </label>
                    <div id="clients">
                        <input list="clientsList" type="text" id="clientsInput" autocomplete="off" />
                        <input type="hidden" id="idClient"/>
                        <ul id="clientsList" class="hide" ></ul>
                        <label for="clientInconnu"><input id="clientInconnu" type="checkbox"/>client non enregistré</label>
                        <input id="clientInconnuInput" class="hide" type="text" placeholder="nom + tel"/>
                    </div>
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
                            <option value="switch">permut. des roues</option>
                            <option value="decalaminage">décalaminage</option>
                            <option value="autres">autres</option>
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
        var client = <?= json_encode($client)?>;
    console.log(client);
        $('#calendar').fullCalendar({
            lang : 'fr',
            timezone: 'local',
            local: 'fr',
            minTime:'06:00:00',
            maxTime:'20:00:00',
            nowIndicator: true,
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
            eventClick:function(event){
                if(client['id'] == 0){
                    loadEvent(event);
                }else{
                    alert('Vous ne pouvez pas ajoutez de rdv à ce moment de la journée');
                }
            },
            dayClick:function(event){
                resetForm();
                $('#myModal').modal({keybord:false,backdrop:'static'});
                $('#dateRdv').val(moment(event._d).format('DD/MM/YYYY'));
                $('#heureRdv').val(moment(event._d).format('HH:mm'));
                if(client['id'] != 0){
                    $('#clientsInput').val(client['name']);
                    $('#idClient').val(client['id']);
                }
            }
        });

        $('#clientsInput').on('input',function(){
            $.ajax({
                url: getClients,
                data: {
                    client: $(this).val()
                },
                success:function(data){
                    $('#clientsList').removeClass('hide');
                    if($('#clientsInput').val()==''){
                        $('#clientsList').addClass('hide');
                    }
                    $('#clientsList').empty();

                    $.each(data,function(key,client){
                        $('#clientsList').append('<li class="clientItem" value="'+client.id+'">'+client.lastname+' '+client.firstname+'</li>');
                    });

                    if($(data).length < 1){
                        $('#clientsList').append('<li class="clientItem">0 resultats</li>');
                        $('#idClient').val('');
                    }else{
                        $('#clientsList li').first().focus();
                    }

                    $('.clientItem').on('click',function(){
                        $('#clientsInput').val($(this).text());
                        $('#idClient').val($(this).val());
                        $('#clientsList').addClass('hide');
                    });

                }
            });
        });
        $('#clientInconnu').on('click',function(){
            $('#clientInconnuInput').toggleClass('hide');
            $('#clientsInput').toggleClass('hide');
            if($(this).prop('checked')){
                $('#idClient').val('');
                $('#clientsInput').val('');
            }else{
                 $('#clientInconnuInput').val('');
            }

        });
        $('#addRdv').on('click',function(){
            if(verifForm()) {
                var data = {
                    user: $('#idClient').val(),
                    dateRdv: $('#dateRdv').val(),
                    heureRdv: $('#heureRdv').val(),
                    dureeRdv: $('#dureeRdv').val(),
                    typeRdv: $('#typeRdv').val(),
                    nbrPneu: $('#nbrPneu').val(),
                    acier: $('#acier').val(),
                    taille: $('#taille').val(),
                    remarque: $('#remarque').val(),
                    idEvent: $('#idEvent').val(),
                    inconnu: $('#clientInconnuInput').val()
                };
                $.ajax({
                    url: addRdv,
                    type: 'post',
                    data: data,
                    success: function () {
                        $('#calendar').fullCalendar('refetchEvents');
                        $('#myModal').modal('toggle');
                    }
                });
            }
        });

        function loadEvent(event){
            $.ajax({
                url:chargementEvent,
                type:'get',
                data:{
                    idEvent:event.idEvent
                },
                success:function(event){
                    resetForm();
                    $('#myModal').modal({keybord:false,backdrop:'static'});
                    $('#dateRdv').val(event.dateRdv);
                    $('#heureRdv').val(event.debut);
                    $('#dureeRdv').val(event.duree);
                    $('#typeRdv').val(event.livraison);
                    $('#nbrPneu').val(event.nbr_pneu);
                    $('#acier').val(event.acier);
                    $('#taille').val(event.pouce);
                    $('#remarque').val(event.remarque);
                    $('#idEvent').val(event.idEvent);
                    if(event.id_customer != ''){
                        $('#clientsInput').val(event.lastname+' '+event.firstname).removeClass('hide');
                        $('#idClient').val(event.id_customer);
                        $('#clientInconnuInput').val('').addClass('hide');
                        $('#clientInconnu').prop('checked',false);
                    }else{
                        $('#clientsInput').val('').addClass('hide');
                        $('#idClient').val('');
                        $('#clientInconnuInput').val(event.inconnu).removeClass('hide');
                        $('#clientInconnu').prop('checked',true);
                    }
                }
            });
        }
        function resetForm(){
            $('#clientsInput').val('').removeClass('hide');
            $('#remarque').val('');
            $('#idEvent').val('');
            $('#idClient').val('');
            $('#clientInconnu').prop('checked',false);
            $('#clientInconnuInput').val('').addClass('hide');

        }

        function verifForm(){

            if(!formatDate($('#dateRdv').val())){
                alert('La date entré n\'est pas au bon format. ex:24/02/2017');
                return false;
            }
            if(!formatTime($('#heureRdv').val())){
                alert('La date entré n\'est pas au bon format. ex:10:45');
                return false;
            }
            if($('#idClient').val()=='' && $('#clientInconnuInput').val()==''){
                alert('vous devez entrer un client');
                return false;
            }
            return true;
        }

        function formatDate(dateString){
            var patt = new RegExp("^([1-9]|0[1-9]|[1-2][0-9]|3[0-1])/([1-9]|0[1-9]|1[0-2])/([0-9]{4})$");
            var res = patt.test(dateString);
            return res;
        }

        function formatTime(timeString){
            var patt = new RegExp("^([1-9]|0[1-9]|1[0-9]|2[0-3]):([0-5][0-9])$");
            var res = patt.test(timeString);
            return res;
        }

    });
</script>
<?php $this->stop('main_content') ?>
