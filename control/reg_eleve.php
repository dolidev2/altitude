<?php
session_start();
	include_once '../model/Eleve.class.php';
	include_once '../model/Audit.class.php';

	if (
	    isset($_POST['nom']) AND isset($_POST['prenom'])
        AND isset($_POST['contact']) AND isset($_POST['profession'])
        AND isset($_POST['dob']) AND isset($_POST['pob'])
        AND isset($_POST['categorie']) AND isset($_POST['forfait'])
        AND isset($_POST['solde']) AND isset($_POST['sexe'])
        AND isset($_POST['adresse']) AND isset($_POST['agence']) )
	  {
	  	$nom = strip_tags(htmlspecialchars(trim($_POST['nom'])));
		$prenom = strip_tags(htmlspecialchars(trim($_POST['prenom'])));
		$contact = strip_tags(htmlspecialchars(trim($_POST['contact'])));
		$profession = strip_tags(htmlspecialchars(trim($_POST['profession'])));
		$dob = strip_tags(htmlspecialchars(trim($_POST['dob'])));
		$pob = strip_tags(htmlspecialchars(trim($_POST['pob'])));
		$categorie = strip_tags(htmlspecialchars(trim($_POST['categorie'])));
		$forfait = strip_tags(htmlspecialchars(trim($_POST['forfait'])));
		$solde = strip_tags(htmlspecialchars(trim($_POST['solde'])));
		$sexe = strip_tags(htmlspecialchars(trim($_POST['sexe'])));
		$adresse = strip_tags(htmlspecialchars(trim($_POST['adresse'])));
		$agence = strip_tags(htmlspecialchars(trim($_POST['agence'])));
		$recommandation = strip_tags(htmlspecialchars(trim($_POST['recommandation'])));
		if(!empty($_POST['montant'])){
            $montant =  (int) strip_tags(htmlspecialchars(trim($_POST['montant'])));
        }
		else{
		    $montant = 0;
        }

          if(isset($_POST['dor']) && !empty($_POST['dor'])){
              $dor = strip_tags(htmlspecialchars(trim($_POST['dor'])));
          }
          else{
              $dor = date('Y-m-d');
          }

		$statut = 1;

		//Generate matricule ID
		$y = date('Y');
		$nomb = Eleve::countFromYear();
		$matricule = $y.'LTD'.$nomb[0]->nombre;

		$data = array(
			'nom' => $nom,
			'prenom' => $prenom,
			'contact' => $contact,
			'profession' => $profession,
			'dob' => $dob,
			'pob' => $pob,
			'dor' => $dor,
			'categorie' => $categorie,
			'forfait' => $forfait,
			'solde' => $solde,
			'sexe' => $sexe,
			'adresse' => $adresse,
			'agence' => $agence,
			'matricule' => $matricule,
			'recommandation' => $recommandation,
			'montant' => $montant,
			'statut' => $statut);
          $desc_audit = $nom.' '.$prenom.' dont le matricule est '.$matricule.' a été ajouté';

          $data_audit = array(
              'desc' => $desc_audit,
              'action' => 'Ajout',
              'user' => $_SESSION['id']
          );
        Audit::register($data_audit);
		Eleve::register($data);

		echo '
		    <script language="javascript">
				swal("Réussi", "Elève ajouté avec succès", "success");
				window.location.href = "index.php?page=eleve";
			</script>';
	  }
	  else
	  {
	  	echo '
		     <script language="javascript">
				swal("Erreur!", "Données vides, veuillez remplir les champs !", "error");
			 </script>';
	  }



 ?>