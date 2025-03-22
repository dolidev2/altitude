<?php
session_start();
include_once '../model/Reinscription.php';
include_once '../model/Audit.class.php';
include_once '../model/Eleve.class.php';
include_once '../config/config.php';


if(!empty($_POST['duree']))
{
    $duree = strip_tags(htmlspecialchars(trim($_POST['duree'])));
    $eleve = strip_tags(htmlspecialchars(trim($_POST['eleve'])));
    $solde = strip_tags(htmlspecialchars(trim($_POST['penalite'])));

    $datetmp = date('Y-m-d H:i:s');

    //Update dor and solde of student
    $eleveData = Eleve::afficherOne($eleve);
    $dateReinscrire =date('Y-m-d', strtotime("+$duree months", strtotime(date('Y-m-d'))));;
   // $tmp_duree = $config['DUREE'] -$duree;
    $som =  $eleveData[0]->solde +  $solde;
    $dor_update = date_create(date("Y-m-d"));
    $dor_update = date_sub($dor_update,date_interval_create_from_date_string("$duree months"));
    $dor_update = date_format($dor_update,"Y-m-d");

    Eleve::modifierSolde($som, $dor_update, $eleve);
    //End Update

    $data = array(
        'eleve' => $eleve,
        'date' => $dateReinscrire,
        'solde' => $solde,
        'duree' => $duree,
        'datetmp' => $datetmp
    );

    $desc_audit = $eleveData[0]->nom.' '.$eleveData[0]->prenom.' dont le matricule est '.$eleveData[0]->matricule.' a été réinscri';

    $data_audit = array(
        'desc' => $desc_audit,
        'action' => 'Ajout',
        'user' => $_SESSION['id']
    );
    Audit::register($data_audit);
    Reinscription::register($data);
    header('location:../view/index.php?page=eleve');
    echo '
		    <script language="javascript">
				swal("Réussi", "Elève ajouté avec succès", "success");
				window.location.href = "index.php?page=eleve";
			</script>';
}
else
{
    header('location:../view/index.php?page=eleve');
    echo '
		     <script language="javascript">
				swal("Erreur!", "Données vides, veuillez remplir les champs !", "error");
				window.location.href = "index.php?page=eleve";
			 </script>';

}

