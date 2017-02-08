/**
 * Created by PhpStorm.
 * User: aubrion
 * Date: 01/10/16
 * Time: 11:09
 */
<?php $this->layout('layout', ['title' => 'Nouveau client']) ?>

<?php $this->start('flash')?>
<?php
    if(isset($flash)){
        foreach($flash['success'] as $flash){
            echo '<p class="alert alert-success flash">'.$flash.'</p>';
        }
        foreach($flash['danger'] as $flash){
            echo '<p class="alert alert-danger flash">'.$flash.'</p>';
        }
    }
    ?>
<?php $this->stop('flash')?>

<?php $this->start('main_content') ?>
    <form method="POST" action="#">
        <input id="redirectionInput" type="hidden" placeholder="nom" name="redirection" value="auto"/>
        <input type="text" placeholder="nom" name="lastname" value="<?php if(isset($customer) && !empty($errors)){echo $customer['lastname'];} ?>" required />
        <input type ="text" placeholder="prénom" name="firstname" value="<?php if(isset($customer) && !empty($errors)){echo $customer['firstname'];} ?>" required />
        <input type="text" placeholder="adresse" name="adress" value="<?php if(isset($customer) && !empty($errors)){echo $customer['adress'];} ?>"required/>
        <input type="text" placeholder="code postal" name="zipcode" value="<?php if(isset($customer) && !empty($errors)){echo $customer['zipcode'];} ?>" maxlength="5" required/>
        <div class="selectDivision">
            <select name="idCity" id="citySelect" required ></select>
        </diV>
        <!--<input type="text" placeholder="city" name="city" value="<?php if(isset($customer) && !empty($errors)){echo $customer['city'];} ?>" required />-->
        <input type="email" placeholder="email" name="email" value="<?php if(isset($customer) && !empty($errors)){echo $customer['email'];} ?>"/>
        <input type="tel" placeholder="téléphone" name="phone" value="<?php if(isset($customer) && !empty($errors)){echo $customer['phone'];} ?>" required/>
        <button id="addClient" type="submit" name="addCustomer" class="btn btn-success btn-small">Ajouter</button>
    </form>
    <?php
        if(empty($errors) && isset($customer)){
            ?><p class="alert alert-success">nouveau client ajouté</p><?php
        }else{
            foreach ($errors as $error => $post){
                ?>
                <p class="alert alert-danger"><?= $post ?></p>
                <?php
            }
        }
    ?>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Redirection</h4>
                </div>
                <div class="modal-body">
                    <button type="button" data-action="auto" class=" action btn btn-default btn-info btn-large" data-dismiss="modal"><i class="fa fa-car" aria-hidden="true"></i> Ajouter une auto</button>
                    <button type="button" data-action="calendar" class=" action btn btn-default btn-success" data-dismiss="modal"><i class="fa fa-calendar" aria-hidden="true"></i> Prendre un rdv</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(function(){
        $('#addClient').on('click',function(event){
            event.preventDefault();
            $('#myModal').modal({keybord:false,backdrop:'static'});
            $('.action').off('click');
            $('.action').on('click',function(){
                $('#redirectionInput').val($(this).data('action'));
                $('form').submit();
            });
        })
    });
</script>
<?php $this->stop('main_content') ?>