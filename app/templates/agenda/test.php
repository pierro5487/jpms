<?php $this->layout('layout', ['title' => 'Agenda']) ?>
<?php $this->start('main_content') ?>
<?php
if(isset($_GET["lundi"])) // Une semaine précise est demandée
{
    $ts = $_GET["lundi"];
}
else //On prendra la semaine d'aujourd'hui
{
    $day = (date('w') - 1); //Jour dans la semaine... Lundi = 0
    $diff = $day * 86400; //Différence en secondes par rapport au lundi
    $ts = (mktime() - $diff); //On récupère le TimeStamp du lundi
    //$ts = mktime();
}

//Initialisation des variables
$week = date('W', $ts); //Semaine en cours
$avant = $ts - 604800; //TimeStamp Lundi précédant
$apres = $ts + 604800; //TimeStamp Lundi suivant

?>

<table align="center" border="1" width="420px">
    <tr>
        <td align="center" width="14%"><b>Lun</b></td>
        <td align="center" width="14%"><b>Mar</b></td>
        <td align="center" width="14%"><b>Mer</b></td>
        <td align="center" width="14%"><b>Jeu</b></td>
        <td align="center" width="14%"><b>Ven</b></td>
        <td align="center" width="14%"><b>Sam</b></td>
        <td align="center"><b>Dim</b></td>
    </tr>
    <tr>
        <?
        for($i=1;$i<8;$i++) //Pour chaque jour de la semaine... Lundi = 1
        {
            if( ($i == date('w')) && ($week == date('W')) ) //Il s'agit d'aujourd'hui!
            {
                ?>
                <td align="center" style="background-color:#FFFF00;" onMouseUp="actionDate('<?echo date('d M Y', $ts);?>', event)">
                    <?echo date('d M Y', $ts);?>
                </td>
                <?
            }
            else
            {
                ?>
                <td align="center" style="background-color:#FFFFFF;" onMouseUp="actionDate('<?echo date('d M Y', $ts);?>', event)">
                    <?echo date('d M Y', $ts);?>
                </td>
                <?
            }
            $ts += 86400; //On passe au jour suivant
        }
        ?>
    </tr>
</table>
<div align="center">
    <a href="./semaine.php?lundi=<?echo $avant;?>"><<</a>&nbsp;Semaine&nbsp;<?echo $week;?>&nbsp;<a href="./semaine.php?lundi=<?echo $apres;?>">>></a>
</div><script type="text/javascript">
    var msg = ""; //Initialisation de la variable "msg"

    function actionDate(time, e) //Action appelée lorsqu'on clique sur une date.
    {
        if( (!document.all && e.which == 3) || (document.all && event.button == 2)) //Clic avec le bouton droit (la gestion est différente d'un navigateur à un autre)
        {
            msg = "Clic droit: " + time;
        }
        else //Clic avec le bouton gauche
        {
            msg = "Clic gauche: " + time;
        }
        alert(msg);
        //return(true); //Non utilisé ici... Syntaxiquement correct
    }

    function no_menu() //Fonction qui désactive le menu du clic droit :)
    {
        return(false);
    }
    document.oncontextmenu = no_menu; // On appele la fonction "no_menu" si le menu du clic droit est appelé
</script>
<?php $this->stop('main_content') ?>