$(function(){
    /*zone de recherche clients*/
    $('#customerSearch').on('keyup',function(){
        var search = $('#customerSearch').val();
        $.ajax({
            url : ajaxCustomerSearch, // La ressource ciblée
            type : 'GET',
            data : 'search=' + search,
            dataType : 'html',// Le type de données à recevoir, ici, du HTML.
            success : function(customerList, statut){
                customerList = JSON.parse(customerList);
                $('.item').css('display','none');
                for(var i=0;i<customerList.length;i++){
                    $('#customer' + customerList[i].id).css('display','table-row');
                };
            },
        });
    });

    /*zone de recherche auto*/
    $('#carSearch').on('keyup',function(){
        var search = $('#carSearch').val();
        $.ajax({
            url : ajaxCarSearch, // La ressource ciblée
            type : 'GET',
            data : 'search=' + search,
            dataType : 'html',// Le type de données à recevoir, ici, du HTML.
            success : function(carList, statut){
                carList = JSON.parse(carList);
                $('tr').css('display','none');
                for(var i=0;i<carList.length;i++){
                    $('#car' + carList[i].id).css('display','table-row');
                };
            },
        });
    });

    /*evenement selecteur marque et model auto*/
    var brandSelect = $('#brandSelect');
    var modelSelect = $('#modelSelect');
    brandSelect.on('change',function(){
        var idBrandSelected = brandSelect.val();
        $.ajax({
            url : ajaxBrandSelect, // La ressource ciblée
            type : 'GET',
            data : 'idBrand=' + idBrandSelected,
            dataType : 'html',// Le type de données à recevoir, ici, du HTML.
            success : function(modelList, statut){
                modelList = JSON.parse(modelList);
                modelSelect.find('option').remove();
                modelSelect.append('<option class="selectDefault" value="no">Modèle</option>');
                for(var i=0;i<modelList.length;i++){
                    var newOption = '<option value="'+modelList[i].id+'">'+modelList[i].name+'</option>';
                    modelSelect.append(newOption);
                };
            },
        });
    });

    /*evenement selecteur marque et model auto*/
    var ownerSelectForBill = $('#ownerSelectForBill');
    var carsSelectForBill = $('#carsSelectForBill');
    ownerSelectForBill.on('change',function(){
        var idOwnerSelectForBill = ownerSelectForBill.val();
        $.ajax({
            url : ajaxOwnerSelect, // La ressource ciblée
            type : 'GET',
            data : 'idOwner=' + idOwnerSelectForBill,
            dataType : 'html',// Le type de données à recevoir, ici, du HTML.
            success : function(carsList, statut){
                carsList = JSON.parse(carsList);
                carsSelectForBill.find('option').remove();
                carsSelectForBill.append('<option class="selectDefault" value="no">Auto</option>');
                for(var i=0;i<carsList.length;i++){
                    var newOption = '<option value="'+carsList[i].id+'">'+carsList[i].name+' '+carsList[i].matricule+'</option>';
                    carsSelectForBill.append(newOption);
                };
                carsSelectForBill.append('<option value="5">Non renseigné</option>');
            },
        });
    });

    /*evenement ajout de la liste de categorie de  service dans la facture*/
    var addServiceForBill= $('#addServiceForBill');
    addServiceForBill.on('click',function(){
        var newDiv = $('<div id="serviceContainer"><div><a id="closeServiceContainer" href="#">x</a><select id="serviceCategorySelect"></select></div></div>');
        $('body').append(newDiv);
        /*ajout evenment close*/
        $('#closeServiceContainer').on('click',function(){$('#serviceContainer').remove()});
        var categorySelect = $('#serviceCategorySelect');
        /*on récupère la liste de categorie de services*/
        $.ajax({
            url : ajaxServiceCategorySelect, // La ressource ciblée
            type : 'GET',
            dataType : 'html',// Le type de données à recevoir, ici, du HTML.
            success : function(categoryList, statut){
                categoryList = JSON.parse(categoryList);
                categorySelect.append('<option class="selectDefault" value="no">Categories</option>');
                for(var i=0;i<categoryList.length;i++){
                    var newOption = '<option value="'+categoryList[i].id+'">'+categoryList[i].name+'</option>';
                    categorySelect.append(newOption);
                };
            },
        });
        $('body').append(newDiv);

        /*evenement selecteur categorie de service*/
        categorySelect.on('change',function(){
            var idcategorySelected = categorySelect.val();
            categorySelect.remove();


            /*-------service montage-------------*/
            /*
            /*------------------------------------*/
            var serviceContainer = $('#serviceContainer div');
            if(idcategorySelected==1) {
                serviceContainer.append('<h2>Choix de la taille de jante:</h2>');
                for (var i = 13; i < 23; i++) {
                    serviceContainer.append('<div class="sizeChoice"><label for="size' + i + '">' + i + '</label></label><input type="radio" name="size" id="size' + i + '"/></div>');
                }

                /*--ajoute un evenement */
                $('input[type=radio]').on('change',function(){
                    var size = $(this).attr('id');
                    size= size.replace('size','');
                    serviceContainer.find('select').remove();
                    serviceContainer.find('h3').remove();
                    serviceContainer.append('<h3>Choix type de services:</h3>');
                    $.ajax({
                        url : ajaxSizeSelect, // La ressource ciblée
                        type : 'GET',
                        data : 'size=' + size,
                        dataType : 'html',// Le type de données à recevoir, ici, du HTML.
                        success : function(servicesList, statut){
                            servicesList = JSON.parse(servicesList);
                            serviceContainer.append('<select id="serviceSelect"></select>');
                            for(var i=0;i<servicesList.length;i++){
                                var newOption = '<option value="'+servicesList[i].id+'">';
                                if(servicesList[i].switching==1){
                                    newOption += 'Permutation roue';
                                }
                                else if(servicesList[i].puncture_av==1){
                                    newOption += 'Crevaison/pause champignon';
                                }
                                else if(servicesList[i].puncture_ar==1){
                                    newOption += 'Crevaison/pause mèche';
                                }
                                else{
                                    if(servicesList[i].mounting==1){
                                        newOption += 'Montage ';
                                    }
                                    if(servicesList[i].balancing==1){
                                        newOption += 'Equilibrage ';
                                    }
                                    if(servicesList[i].valve==1){
                                        newOption += 'Valve ';
                                    }
                                    if(servicesList[i].size !='0'){
                                        newOption += servicesList[i].size+'" ';
                                    }
                                    if(servicesList[i].alu==1){
                                        newOption += 'Alu ';
                                    }else{
                                        newOption += 'Tôle ';
                                    }
                                    if(servicesList[i].runflat==1){
                                        newOption += 'Runflat ';
                                    }
                                    if(servicesList[i].truck==1){
                                        newOption += 'Camionnette ';
                                    }
                                }
                                newOption += '</option>';
                                var serviceSelect = $('#serviceSelect');
                                serviceSelect.append(newOption);
                            };
                            /* réinitialise au cas où un second choix serait fait sur le select categorie*/
                            $('#nbrOfService').remove();
                            serviceContainer.find('button').remove();
                            serviceContainer.find('#checkbox').remove();
                            serviceContainer.append('<h3>Choix du nombre de jante:</h3>');
                            serviceContainer.append('<select id="nbrOfService"></select>');
                            for(var i=1;i<11;i++){
                                newOption = '<option value="'+i+'">'+i+'</option>';
                                var nbrOfServiceSelect =$('#nbrOfService');
                                nbrOfServiceSelect.append(newOption);
                            }
                            serviceContainer.append('<h3>Choix de la position du montage:(optionnel)</h3>');
                            serviceContainer.append('<select id="mountingPosition"><option value="no">Non défini</option><option value="AV">AV</option><option value="AR">AR</option></select>');

                            serviceContainer.append('<h3>recyclage pneu</h3>');
                            serviceContainer.append('<div id="checkbox"><label>Oui</label><input id="recyclage" type="checkbox"/></div>');

                            serviceContainer.append('<button type="button">Ajouter</button>');
                            var serviceChoiceValided =serviceContainer.find('button');
                            serviceChoiceValided.on('click',function(){
                                var idService =serviceSelect.val();
                                var nbrService= nbrOfServiceSelect.val();
                                var positionService = $('#mountingPosition').val();
                                var recyclage = '0';
                                if($('#recyclage').is(':checked')){
                                    recyclage = '1';
                                }
                                $('#serviceContainer').remove();
                                for(var i=0;i<servicesList.length;i++){
                                    if(servicesList[i].id == idService){
                                        var totalRecyclage=0;
                                        var newRow = '<tr><td>';
                                        if(servicesList[i].switching==1){
                                            newRow += 'Permutation roue';
                                        }else if(servicesList[i].puncture_av==1){
                                            newRow += 'Crevaison/pause champignon';
                                        }
                                        else if(servicesList[i].puncture_ar==1){
                                            newRow += 'Crevaison/pause mèche';
                                        }else{
                                            if(servicesList[i].mounting==1){
                                                newRow += 'Montage ';
                                            }
                                            if(servicesList[i].balancing==1){
                                                newRow += 'Equilibrage ';
                                            }
                                            if(servicesList[i].valve==1){
                                                newRow += 'Valve ';
                                            }
                                            if(servicesList[i].mounting==1 && servicesList[i].balancing==1){
                                                newRow += servicesList[i].size+'" ';
                                            }
                                            if(servicesList[i].alu==1){
                                                newRow += 'Alu ';
                                            }else{
                                                newRow += 'Tôle ';
                                            }
                                            if(servicesList[i].runflat==1){
                                                newRow += 'Runflat ';
                                            }
                                            if(servicesList[i].truck==1){
                                                newRow += 'Camionnette ';
                                            }
                                            if(positionService !='no'){
                                                newRow += positionService;
                                            }
                                            if(recyclage=='1'){
                                                newRow += ' + recyclage';
                                                var totalRecyclage=2*nbrService;
                                            }

                                        }
                                        newRow += '</td><td>'+nbrService+'</td><td>'+servicesList[i].price+'</td><td>'+(servicesList[i].price*nbrService+totalRecyclage)+'</td></tr>';
                                        $('tbody').append(newRow);
                                        var total=parseInt($('tfoot td:last-of-type').html());
                                        $('tfoot td:last-of-type').html(total+(servicesList[i].price*nbrService+totalRecyclage));
                                        $('input[name=total]').val(total+(servicesList[i].price*nbrService+totalRecyclage));
                                        var services =$('input[name=services]').val();
                                        $('input[name=services]').val(services+idService+','+nbrService+','+positionService+','+recyclage+';');
                                    }
                                }
                            });
                        },
                    });
                });
            }
            /*-------service montage-------------*/
            /*
             /*------------------------------------*/
            if(idcategorySelected==4) {
                serviceContainer.append('<p>Ajouter un décalaminage moteur</p><button id="addDMotorService">Ajouter</button>');
                $('#addDMotorService').on('click',function(){
                    var numberServices = parseInt($('input[name=dMotorServices]').val())+1;
                    $('input[name=dMotorServices]').val(numberServices);
                    var newRow = '<tr><td>Décalaminage moteur à l\'hydrogène</td><td>1</td><td></td><td>65</td></tr>';
                    $('tbody').append(newRow);
                    var total=parseInt($('tfoot td:last-of-type').html());
                    $('tfoot td:last-of-type').html(total+65);
                    $('input[name=total]').val(total+65);

                    $('#serviceContainer').remove();
                });
            }
            /*-------service autres-------------*/
            /*             
             /*------------------------------------*/
             if(idcategorySelected==5) {
                serviceContainer.append('<h3>Choix type de services:</h3>');
                    $.ajax({
                        url : ajaxOthersService, // La ressource ciblée
                        type : 'GET',
                        dataType : 'html',// Le type de données à recevoir, ici, du HTML.
                        success : function(servicesList, statut){
                            servicesList = JSON.parse(servicesList);
                            serviceContainer.append('<select id="otherServicesSelect"></select>');
                            for(var i=0;i<servicesList.length;i++){
                                $('#otherServicesSelect').append('<option value="'+servicesList[i].id+'">'+servicesList[i].name+'</option>')
                            }
                            serviceContainer.append('<h2>Choix de la quantité:</h2>');
                            var quantitySelect ='<select name="quantitySelect">';
                                for(var i=1;i<26;i++){
                                    quantitySelect += '<option value="'+i+'">'+i+'</option>';
                                }
                            quantitySelect +='</select>';
                            serviceContainer.append(quantitySelect);
                            serviceContainer.append('<button id="addOtherService">Ok</button>');
                            $('#addOtherService').on('click',function(){
                                var serviceSelected = $('#otherServicesSelect').val();
                                var quantitySelect = $('select[name=quantitySelect]').val();
                                for(var i=0;i<servicesList.length;i++){
                                    if(servicesList[i].id == serviceSelected){
                                        var newRow = '<tr><td>'+servicesList[i].name+'</td><td>'+quantitySelect+'</td><td>'+servicesList[i].price+'</td><td>'+servicesList[i].price*quantitySelect+'</td></tr>';
                                        $('tbody').append(newRow);
                                        var total = parseFloat($('tfoot td:last-of-type').html());
                                        $('tfoot td:last-of-type').html(total+servicesList[i].price*quantitySelect);
                                        $('input[name=total]').val(total+servicesList[i].price*quantitySelect);
                                        var servicesPerso =$('input[name=otherServices]').val();
                                        $('input[name=otherServices]').val(servicesPerso+serviceSelected+','+quantitySelect+';');
                                        $('#serviceContainer').remove();
                                   }
                                }   
                            });
                        },
                    });
            }
            /*-------service personnalisé-------------*/
            /*              non terminée
             /*------------------------------------*/
            if(idcategorySelected==6) {
                serviceContainer.append('<h2>Entrer un service personnalisé:</h2>');
                serviceContainer.append('<input name="servicePerso" type="text" placeholder="Service" maxlength="50"/>');
                serviceContainer.append('<h2>Choix de la quantité:</h2>');
                var quantitySelect ='<select name="quantitySelect">';
                    for(var i=1;i<26;i++){
                        quantitySelect += '<option value="'+i+'">'+i+'</option>';
                    }
                quantitySelect +='</select>';
                serviceContainer.append(quantitySelect);
                serviceContainer.append('<h2>Choix du prix unitaire:</h2>');
                serviceContainer.append('<input id="priceServicePerso" type="number" step="0.5" placeholder="prix unitaire"/>');
                serviceContainer.append('<button id="addServicePerso">Ok</button>');
                $('#addServicePerso').on('click',function(){
                    var servicePerso = $('input[name=servicePerso]').val();
                    servicePerso =servicePerso.replace(',',' ');
                    servicePerso =servicePerso.replace(';',' ');
                    var quantityServicePerso = $('select[name=quantitySelect]').val();
                    var priceServicePerso = $('#priceServicePerso').val();
                    if(servicePerso==""){
                        alert('veuillez entrer un nom de service');
                    }else if(priceServicePerso ==""){
                        alert('veuillez entrer un prix');
                    }else{
                        var newRow = '<tr><td>'+servicePerso+'</td><td>'+quantityServicePerso+'</td><td>'+priceServicePerso+'</td><td>'+quantityServicePerso*priceServicePerso+'</td></tr>';
                        $('tbody').append(newRow);
                        var total=parseInt($('tfoot td:last-of-type').html());
                        $('tfoot td:last-of-type').html(total+quantityServicePerso*priceServicePerso);
                        $('input[name=total]').val(total+quantityServicePerso*priceServicePerso);

                        var servicesPerso =$('input[name=persoServices]').val();
                        $('input[name=persoServices]').val(servicesPerso+servicePerso+','+quantityServicePerso+','+priceServicePerso+';');
                        
                        $('#serviceContainer').remove();
                    }  
                });
            }
            /*service   ???*/
        });
    });

    /*------------reset du tableau de services---------*/
    $('#resetTable').on('click',function(){
        $('tbody tr').remove();
        $('input[type=hidden]').val('');
        $('tfoot td:last-of-type').html(0);
    });

    $('button[name=sendBill]').on('click',function(event){
        /*on fait les verifications ici*/
        var errors=[];
        if($('#ownerSelectForBill').val()=='no'){
            errors.push('veuillez selectionner un client');
        }
        if($('#carsSelectForBill').val()=='no'){
            errors.push('veuillez selectionner une auto');
        }
        if($('input[name=mileage]').val()==''){
            errors.push('veuillez entrer un kilométrage');
        }
        if($('input[name=services]').val()=='' && $('input[name=dMotorServices]').val()== 0 && $('input[name=otherServices]').val()=="" && $('input[name=persoServices]').val()==""){
            errors.push('veuillez selectionner un service');
        }
        if(errors.length > 0){
            event.preventDefault();
            alert(errors[0]);
        }
    });
    /*---paiement---------*/
    $('#payConfirm').on('click',function(){
        var payement = $('#takePayementSelect').val();
        $('#takePayement').remove();
        var idBill =$('#billInfo p:first-child').html().replace('n°Facture: FA','');
        $.ajax({
            url : ajaxPayement, // La ressource ciblée
            type : 'GET',
            data : 'idBill=' + idBill+'&pay='+payement,
        });
        if(payement=='es'){
            $('#billPayement tr:nth-child(2) td:nth-child(2)').html('Réglé en espèce');
        }else if(payement=='cb'){
            $('#billPayement tr:nth-child(2) td:nth-child(2)').html('Réglé par carte bancaire');
        }else if(payement=='ch'){
            $('#billPayement tr:nth-child(2) td:nth-child(2)').html('Réglé par chèque');
        }

    });
    /*---paiement facture groupé-------*/
    $('#BillGroupPayConfirm').on('click',function(){
        var payement = $('#takePayementSelect').val();
        $('#takePayement').remove();
        var idsBill =$('.idBillClass');
        idsBill.each(function(){
            var idBill = $(this).html();
            $.ajax({
                url : ajaxGroupPayement, // La ressource ciblée
                type : 'GET',
                data : 'idBill=' + idBill+'&pay='+payement,
            });
        });
        var idBillGroup=$('#billInfo p:first-child').html().replace('n°Facture: FC','');
        console.log(idBillGroup);
        $.ajax({
            url : ajaxBillGroupPayement, // La ressource ciblée
            type : 'GET',
            data : 'idBillGroup=' + idBillGroup,
        });
        if(payement=='es'){
            $('#billPayement tr:nth-child(2) td:nth-child(2)').html('Réglé en espèce');
        }else if(payement=='cb'){
            $('#billPayement tr:nth-child(2) td:nth-child(2)').html('Réglé par carte bancaire');
        }else if(payement=='ch'){
            $('#billPayement tr:nth-child(2) td:nth-child(2)').html('Réglé par chèque');
        }
    });
    /*---impression facture---*/
    $('#print').on('click',function(){
        $('header').remove();
        $('footer').remove();
        $('#takePayement').remove();
        $('.container').css('width','100%');
        $('section').css('border','none');
        $('#print').remove();
        var idBill =$('#billInfo p:first-child').html().replace('n°Facture: FA','');
        window.print();
        $.ajax({
            url : ajaxNumberPrinting, // La ressource ciblée
            type : 'GET',
            data : 'idBill=' + idBill,
        });
        location.reload();
    });
    /*---impression facture groupé---*/
    $('#printBillGroup').on('click',function(){
        alert('oui');
        $('header').remove();
        $('footer').remove();
        $('#takePayement').remove();
        $('.container').css('width','100%');
        $('section').css('border','none');
        $('#printBillGroup').remove();
        var idBillGroup =$('#billInfo p:first-child').html().replace('n°Facture: FC','');
        window.print();
        $.ajax({
            url : ajaxBillGroupNumberPrinting, // La ressource ciblée
            type : 'GET',
            data : 'idBillGroup=' + idBillGroup,
        });
        location.reload();
    });

    /*----gestion menu navigation -----*/
    $('.menu-primaire li').on('mouseover',function(){
        $(this).find('.menu-secondaire').css('display','block');
        $(this).on('mouseout',function(){
            $(this).find('.menu-secondaire').css('display','none');
        });
    });

    /*---------création d'une facture groupé------*/
    $('#MakeBillsGroup').on('click',function(){
        if(confirm('voulez vous vraiment faire un groupement de ces factures ?')){
            var idCustomer = $('#idCustomer').html();
            console.log(idCustomer);
            $.ajax({
                url : ajaxCreateBillsGroup, // La ressource ciblée
                type : 'GET',
                data : 'idCustomer=' + idCustomer,
                dataType : 'html',// Le type de données à recevoir, ici, du HTML.
                success:function(){
                     location.reload();
                },
            });
           /* location.reload();*/
        }
    });

    /*---------supression facture--------------*/
    $('.deleteBill').on('click',function(){
        alert('Désolé pas encore eut le temps de finir... faite une liste des factures a supprimer');
    });

    /*------autocomplete zipcode-----*/
    var zipcodeInput =$('input[name=zipcode]');
    zipcodeInput.on('keyup',function(event){
        if(zipcodeInput.val().length==5){
            var zipcode = zipcodeInput.val();
             $.ajax({
                url : ajaxCityList, // La ressource ciblée
                type : 'GET',
                data : 'zipcode=' + zipcode,
                dataType : 'html',// Le type de données à recevoir, ici, du HTML.
                success:function(cityList){
                    cityList = JSON.parse(cityList);
                    $('#citySelect').find('option').remove();
                     for(var i=0;i<cityList.length;i++){
                        $('#citySelect').append('<option value="'+cityList[i].id+'">'+cityList[i].VILLE+'</option>');
                     }
                     $('#citySelect').focus();
                },
            });
        }
    });
});