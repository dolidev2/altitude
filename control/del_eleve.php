<?php 
session_start();
	include_once '../model/Eleve.class.php';
	include_once '../model/Audit.class.php';

	if ( isset($_POST['eleve_id']) )

	{
        $eleve = Eleve::afficherOne($_POST['eleve_id']);
        $desc_audit = 'suppression de '.$eleve[0]->nom.' '.$eleve[0]->prenom.
            ' avec le matricule '.$eleve[0]->matricule;

        $data_audit = array(
            'desc' => $desc_audit,
            'action' => 'Suppression',
            'user' => $_SESSION['id']
        );
        Audit::register($data_audit);
		Eleve::supprimer($_POST['eleve_id']);

		header('location:../view/index.php?page=eleve');
	}
	else
	{
		echo $_POST['eleve_id'];
	}
 ?>