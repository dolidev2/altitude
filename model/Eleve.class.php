<?php

include_once "Model.class.php";
include_once "Paiement.class.php";
include_once "Reinscription.php";

/**
 * Classe  Eleve.
 *
 * @version 1.0
 * @author zcorp & edotensei
 */

 class Eleve extends Model
 {

    /**AJouter un Elève avec toutes les infos
     * @param $data(array)
     */
    public static function register($data)
    {
        $image = '';
        $con = parent::getPDO();
        $ins = $con->prepare('INSERT INTO eleve VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $ins->execute(array(null, $data['nom'], $data['prenom'], $data['contact'],
            $data['profession'], $data['adresse'], $data['dob'], $data['sexe'],
            $data['dor'],$data['pob'], $data['categorie'], $data['solde'], $data['forfait'],
            $data['statut'],$data['recommandation'],$data['matricule'],$image,$data['agence'],$data['montant']));
    }

    public static function get_total_all_records()
    {
        $con = parent::getPDO();
        $statement = $con->prepare("SELECT * FROM eleve e INNER JOIN  agence a ON e.agence = a.id_agence WHERE  DATEDIFF(CURRENT_DATE, dor) < 250 ");
        $statement->execute();
        $result = $statement->fetchAll();
        return $statement->rowCount();
    }  
    
    public static function get_total_all_records_reinscrire()
    {
        $con = parent::getPDO();
        $statement = $con->prepare("SELECT * FROM eleve e INNER JOIN  agence a ON e.agence = a.id_agence 
                                    WHERE  DATEDIFF(CURRENT_DATE, dor) > 250 AND e.id_eleve NOT IN 
                                    (SELECT id_eleve FROM eleve e INNER JOIN  agence a ON e.agence = a.id_agence 
                                    WHERE  DATEDIFF(CURRENT_DATE, dor) < 250 ) ORDER BY dor DESC ");
        $statement->execute();
        $result = $statement->fetchAll();
        return $statement->rowCount();
    }

    public static function get_total_all_records_provisoire()
    {
        $con = parent::getPDO();
        $statement = $con->prepare("SELECT * FROM eleve e, retrait r, agence a WHERE e.id_eleve=r.eleve AND a.id_agence= e.agence ");
        $statement->execute();
        $result = $statement->fetchAll();
        return $statement->rowCount();
    }  

    /**Afficher Tous les  Elèves avec toutes les infos ordonnés par le nom
     *
     */
    public static function afficher()
    {
        $con = parent::getPDO();
        $ins = $con->query('SELECT * FROM eleve ORDER BY nom,prenom');
        $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');

        return $donne;
    }


    /*Afficher les 10 derniers Inscrits*/
    public static function afficher10dernier()
    {
        $con = parent::getPDO();
        $ins = $con->query('SELECT * FROM eleve WHERE statut=1 ORDER BY dor DESC LIMIT 10');
        $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');

        return $donne;
    }

    public static function afficherImpaye()
    {
        $con = parent::getPDO();
        $ins = $con->query('SELECT * FROM eleve WHERE statut=1 AND id_eleve NOT IN (SELECT p.eleve FROM eleve e, paiement p WHERE e.id_eleve = p.eleve) ORDER BY nom,prenom');
        $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');

        return $donne;
    }

    public static function afficherPaiement()
    {

        $con = parent::getPDO();
       $ins = $con->query('SELECT nom,prenom,id_eleve,SUM(somme)
            AS some, solde,categorie,contact, forfait
            FROM eleve e, paiement p
            WHERE e.id_eleve=p.eleve
            AND statut=1
            GROUP BY e.id_eleve ORDER BY e.nom,e.prenom');
        $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');
        return $donne;
    }

    public static function afficherInscrisPeriode($debut,$fin)
    {
        $con = parent::getPDO();
        $ins = $con->prepare('SELECT *
                FROM eleve
                WHERE dor BETWEEN ? AND ?');
            $ins->execute(array($debut,$fin));
            $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');
            return $donne;
    }


    public static function afficherSolde()
    {
        $con = parent::getPDO();
        $ins = $con->query('SELECT * from eleve e, paiement p where e.id_eleve=p.eleve and e.solde = (select sum(p.somme) from eleve e, paiement p where e.id_eleve=p.eleve)');
        $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');

        return $donne;
    }

    public static function afficherCours()
    {
        $con = parent::getPDO();
        $ins = $con->query('SELECT * FROM eleve e, agence a WHERE e.agence=a.id_agence AND statut=1 ORDER BY id_eleve DESC');
        $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');

//        $data = [];
//
//        foreach ($donne as $ad){
//            if($ad->solde != 0){
//                $paies = $con->query('SELECT sum(somme) as somme FROM paiement  WHERE eleve ="'.$ad->id_eleve.'"');
//                $paie = $paies->fetchAll(PDO::FETCH_CLASS, 'Paiement');
//
//                if($paie[0]->somme == $ad->solde){
//                    array_push($data,$ad);
//                }
//            }
//            else{
//                array_push($data,$ad);
//            }
//        }

        return $donne;
    }

    public static function afficherCoursAgence($agence)
    {
        $con = parent::getPDO();
        $ins = $con->query('SELECT * FROM eleve e, agence a WHERE e.agence=a.id_agence AND statut=1  AND a.id_agence="'.$agence.'" ORDER BY id_eleve DESC ');
        $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');

        $data = [];

//        foreach ($donne as $ad){
//            if($ad->solde != 0){
//                $paies = $con->query('SELECT sum(somme) as somme FROM paiement  WHERE eleve ="'.$ad->id_eleve.'"');
//                $paie = $paies->fetchAll(PDO::FETCH_CLASS, 'Paiement');
//
//                if($paie[0]->somme == $ad->solde){
//                    array_push($data,$ad);
//                }
//            }
//            else{
//                array_push($data,$ad);
//            }
//        }

        return $donne;
    }

    public static function afficherStatutAgence($agence)
    {
        $con = parent::getPDO();
        $ins = $con->query('SELECT * FROM eleve e, agence a, retrait r WHERE e.id_eleve = r.eleve and e.agence=a.id_agence AND a.id_agence="'.$agence.'" ORDER BY nom,prenom');
        $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');

        return $donne;
    }


     public static function UpdateDorr()
     {
         $con = parent::getPDO();
         $sql = "SELECT id_reinscription, createdAt, duree FROM reinscription"; // Remplacez par le nom de votre table
         $result = $con->query($sql);
         $result = $result->fetchAll(PDO::FETCH_CLASS, 'Reinscription');

         // Traitement des données
         if (count($result) > 0) {
             foreach ($result as $row) {
                 $id = $row->id_reinscription;
                 $createdAt = $row->createdAt;
                 $duree = $row->duree;

                 // Ajouter la durée (en mois) au champ createdAt
                 $newDorr = date('Y-m-d', strtotime("+$duree months", strtotime($createdAt)));

                 // Mettre à jour la valeur de 'dorr'
                 $updateSql = $con->prepare('UPDATE reinscription SET dorr=? WHERE id_reinscription=?');
                 if ($updateSql->execute(array($newDorr, $id)) == true) {
                     echo "Enregistrement ID $id mis à jour avec succès. Nouvelle date : $newDorr<br>";
                 } else {
                     echo "Erreur de mise à jour pour l'ID $id : " . $con->error . "<br>";
                 }
             }
         } else {
             echo "Aucune donnée trouvée dans la table.<br>";
         }
     }

    public static  function DelaiExpire($duree,$date)
    {

        $year_jour = (int) date('Y');
        $month_jour = (int) date('m');
        $day_jour = (int) date('d');
        $month = (int) date('m', strtotime($date));
        $year = (int) date('Y', strtotime($date));
        $day = (int) date('d', strtotime($date));

        $month +=  $duree;
        if( $month > 12)
        {
            $year += 1;
            $month -= 12;
        }
        $new_date = date('Y-m-d',strtotime($year.'-'.$month.'-'.$day));

        if($new_date < date('Y-m-d'))
        {
            return true;
        }
        else{
            return false;
        }

    }

     public static function afficherCoursExpire( $eleves )
     {
         $data_eleve=[];
         foreach ($eleves as $eleve){
            if( self::DelaiExpire(8,$eleve->dor) == false )
            {
                $item = array(
                'id_eleve' => $eleve->id_eleve,
                'matricule' => $eleve->matricule,
                'nom' => $eleve->nom,
                'prenom' => $eleve->prenom,
                'contact' => $eleve->contact,
                'profession' => $eleve->profession,
                'dob' => $eleve->dob,
                'pob' => $eleve->pob,
                'categorie' => $eleve->categorie,
                'agence' => $eleve->nom_agence,
                    'id'=> $eleve->id_eleve
                );
                array_push($data_eleve,$item);
            }
            else{
                $eleve_register = Reinscription::afficheOne($eleve->id_eleve);

                if(!empty($eleve_register[0]->id_reinscription) &&  self::DelaiExpire($eleve_register[0]->duree,$eleve_register[0]->dorr) == false  ){
                    $item = array(
                        'id_eleve' => $eleve->id_eleve,
                        'matricule' => $eleve->matricule,
                        'nom' => $eleve->nom,
                        'prenom' => $eleve->prenom,
                        'contact' => $eleve->contact,
                        'profession' => $eleve->profession,
                        'dob' => $eleve->dob,
                        'pob' => $eleve->pob,
                        'categorie' => $eleve->categorie,
                        'agence' => $eleve->nom_agence,
                        'id'=> $eleve->id_eleve
                    );

                    array_push($data_eleve,$item);
                }
            }
         }
          return $data_eleve;
     }

     public static function afficherCoursExpireReinscription( $eleves )
     {
         $con = parent::getPDO();
         $data_eleve=[];
         foreach ($eleves as $eleve){
             $eleve_register = Reinscription::afficheOne($eleve->id_eleve);
             if(!empty($eleve_register[0]->id_reinscription) &&  self::DelaiExpire($eleve_register[0]->duree,$eleve_register[0]->dorr) == true)
             {
                 $item = array(
                     'id_eleve' => $eleve->id_eleve,
                     'matricule' => $eleve->matricule,
                     'nom' => $eleve->nom,
                     'prenom' => $eleve->prenom,
                     'contact' => $eleve->contact,
                     'profession' => $eleve->profession,
                     'dob' => $eleve->dob,
                     'pob' => $eleve->pob,
                     'categorie' => $eleve->categorie,
                     'agence' => $eleve->nom_agence,
                     'id'=> $eleve->id_eleve
                 );
                 array_push($data_eleve,$item);


             }
             elseif(self::DelaiExpire(8,$eleve->dor) == true ){
                 $item = array(
                     'id_eleve' => $eleve->id_eleve,
                     'matricule' => $eleve->matricule,
                     'nom' => $eleve->nom,
                     'prenom' => $eleve->prenom,
                     'contact' => $eleve->contact,
                     'dob' => $eleve->dob,
                     'pob' => $eleve->pob,
                     'profession' => $eleve->profession,
                     'categorie' => $eleve->categorie,
                     'agence' => $eleve->nom_agence,
                 );
                 array_push($data_eleve,$item);
             }
         }
         return $data_eleve;
     }

     public static function afficherCoursOldExpire( $eleves )
     {
         $con = parent::getPDO();
         $data_eleve=[];
         foreach ($eleves as $eleve){
             if( self::DelaiExpire($eleve->duree,$eleve->dorr) == false  )
             {
                 $item = array(
                     'id_eleve' => $eleve->id_eleve,
                     'matricule' => $eleve->matricule,
                     'nom' => $eleve->nom,
                     'prenom' => $eleve->prenom,
                     'contact' => $eleve->contact,
                     'profession' => $eleve->profession,
                     'categorie' => $eleve->categorie,
                     'agence' => $eleve->agence,
                 );
                 array_push($data_eleve,$item);
             }
         }
         return $data_eleve;
     }

    public static function afficherStatut()
    {
        $con = parent::getPDO();
        $ins = $con->query('SELECT * FROM eleve e, retrait r,agence a WHERE e.agence=a.id_agence and e.id_eleve=r.eleve ORDER BY nom,prenom');
        $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');

        return $donne;
    }




    /*AFicher un élève*/
     public static function afficherOne($id)
     {
        $con = parent::getPDO();
        $ins = $con->query('SELECT * FROM eleve e, agence a WHERE e.agence=a.id_agence AND id_eleve="'.$id.'"');
        $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');

        return $donne;
     }

    public static function afficherOneExamenEleve($id_examen_eleve)
    {
        $con = parent::getPDO();
        $ins = $con->query('SELECT * FROM examen_eleve ex, eleve e, examen em WHERE e.id_eleve=ex.eleve AND em.id_examen=ex.examen AND  id_examen_eleve="'.$id_examen_eleve.'"');
        $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');

        return $donne;
    }

     /*AFicher Accueil Nombre élève*/
    public static function countAll()
    {
        $con = parent::getPDO();
        $ins = $con->query('SELECT COUNT(id_eleve) as nombre FROM eleve ');
        $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');
        return $donne;
    }

     public static function countFromYear()
     {
         $con = parent::getPDO();
         $y = date('Y');
         $dt_d = $y.'-01-01';
         $dt_f = $y.'-12-31';
         $ins = $con->prepare('SELECT COUNT(id_eleve) as nombre FROM eleve WHERE  dor between ? AND ?');
         $ins->execute(array($dt_d,$dt_f));
         $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');
         return $donne;
     }

    /*Afficher Accueil Nombre élève*/
    public static function countCours()
    {
        $con = parent::getPDO();
        $ins = $con->query('SELECT COUNT(id_eleve) as nombre FROM eleve WHERE statut=1 ');
        $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');
        return $donne;
    }   

    /*Afficher Accueil Nombre élève*/
    public static function countPermi()
    {
        $con = parent::getPDO();
        $ins = $con->query('SELECT COUNT(id_eleve) as nombre FROM eleve WHERE statut=0 ');
        $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');
        return $donne;
    }

    public static function permisProvisoire($eleve_id)
    {
        $type = "conduite";
        $resultat = "admis";
        $statut = 0;
        $con = parent::getPDO();
        $examens = $con->query('SELECT examen, resultat, type_examen FROM examen_eleve 
                            WHERE eleve="'.$eleve_id.'" AND resultat="'.$resultat.'"  AND type_examen="'.$type.'" ');
        $donne = $examens->fetchAll(PDO::FETCH_CLASS, 'Eleve');

        if(empty($donne))
        {
            $upEleve = $con->prepare('UPDATE eleve SET statut=? WHERE id_eleve=?');
            $upEleve->execute(array( $statut, $eleve_id ));
        }
     
        return $donne;
      }

    public static function ajouterPermis($data)
    {
        $con = parent::getPDO();
        $ins = $con->prepare('INSERT INTO retrait VALUES(?,?,?,?)');
        $ins->execute(array(null, $data['permis'], $data['date'], $data['eleve']));
    }

    public static function afficherPermis($eleve)
    {
        $con = parent::getPDO();
        $examens = $con->query('SELECT * FROM retrait WHERE eleve="'.$eleve.'" ');
        $donne = $examens->fetchAll(PDO::FETCH_CLASS, 'Eleve');

        return $donne;
    }

    public static function afficherPermisOne($retrait)
    {
        $con = parent::getPDO();
        $examens = $con->query('SELECT * FROM retrait WHERE id_retrait="'.$retrait.'" ');
        $donne = $examens->fetchAll(PDO::FETCH_CLASS, 'Eleve');

        return $donne;
    }

    public static function modifierPermis($data)
    {
        $con = parent::getPDO();
        $ins = $con->prepare('UPDATE retrait SET permis=? WHERE id_retrait=?');
        $ins->execute(array($data['permis'], $data['retrait'] ));
    }

    public static function supprimerPermis($retrait)
    {
        $con = parent::getPDO();
        $sup = $con->prepare('DELETE FROM retrait WHERE id_retrait=?');
        $sup->execute(array($retrait));
    }

    public static function dateDepotEleve($eleve)
     {
         $con = parent::getPDO();
         $ins = $con->query('SELECT * FROM eleve e, bordereau_eleve be, bordereau b 
                            WHERE e.id_eleve=be.eleve AND be.bordereau=b.id_bordereau AND e.id_eleve="'.$eleve.'" ');
         $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');
         return $donne;
     }
 
    /*
     * Fonction static Modification
     * @param array, $_POST
     */
    public static function modifier($data = array())
    {
        $con = parent::getPDO();
        $ins = $con->prepare('UPDATE eleve SET nom=?, prenom=?, contact=?,
                              profession=? , adresse=?, dob=?, pob=?, dor=?, sexe=?, categorie=?,
                              solde=?, forfait=?, statut=?, recommandation=?, agence=? WHERE id_eleve=?');
        $ins->execute(array($data['nom'], $data['prenom'], $data['contact'],
                            $data['profession'], $data['adresse'], $data['dob'], $data['pob'], $data['dor'],
                            $data['sexe'], $data['categorie'], $data['solde'],
                            $data['forfait'], $data['statut'], $data['recommandation'], $data['agence'], $data['id_eleve'] ));
    }

     public static function modifierPhoto($data = array())
     {
         $con = parent::getPDO();
         $ins = $con->prepare('UPDATE eleve SET image=? WHERE id_eleve=?');
         $ins->execute(array($data['image'], $data['id'] ));
     }



     public static function modifierSolde( $montant,$dor, $id)
     {
         $con = parent::getPDO();
         $ins = $con->prepare('UPDATE eleve SET 
                              solde=? , dor= ? WHERE id_eleve=?');
         $ins->execute(array($montant, $dor, $id ));
     }

    public static function afficherPaiementAgence($agence)
    {
        $con = parent::getPDO();
        $ins = $con->query('SELECT nom,prenom,id_eleve,SUM(somme)
            AS some, solde,categorie,contact, forfait
            FROM eleve e, paiement p, agence a
            WHERE e.id_eleve=p.eleve AND e.agence=a.id_agence AND a.id_agence= "'.$agence.'"
            AND statut=1 
            GROUP BY e.id_eleve ORDER BY e.nom,e.prenom');
        $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');
        return $donne;
    }

     public static function afficherInscrisAgencePeriode($agence,$debut,$fin)
     {
        $con = parent::getPDO();
        if($agence != ''){
            $ins = $con->prepare('SELECT *
                            FROM eleve e, agence a
                            WHERE e.agence=a.id_agence AND agence= ?
                            AND  dor BETWEEN ? AND ? ');
            $ins->execute(array( $agence, $debut, $fin));
            $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');
            return $donne;
        }else{
            $ins = $con->prepare('SELECT *
                FROM eleve e, agence a
                WHERE e.agence=a.id_agence AND dor BETWEEN ? AND ? ');
            $ins->execute(array( $debut, $fin));
            $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');
            return $donne;
         }
     }

     public static function afficherImpayeAgence($agence)
     {
        $con = parent::getPDO();
        $ins = $con->query('SELECT * FROM eleve e, agence a WHERE e.agence=a.id_agence AND a.id_agence="'.$agence.'" AND statut=1  AND visible = 1 AND id_eleve NOT IN (SELECT p.eleve FROM eleve e, paiement p WHERE e.id_eleve = p.eleve) ORDER BY nom,prenom');
        $donne = $ins->fetchAll(PDO::FETCH_CLASS, 'Eleve');

        return $donne;
     }

    public static function supprimer($id)
    {
        $con = parent::getPDO();

        $sup = $con->prepare('DELETE FROM paiement WHERE eleve=?');
        $sup->execute(array($id));

        $sup = $con->prepare('DELETE FROM dossier WHERE eleve=?');
        $sup->execute(array($id));

        $sup = $con->prepare('DELETE FROM examen_eleve WHERE eleve=?');
        $sup->execute(array($id));

        $sup = $con->prepare('DELETE FROM program WHERE eleve=?');
        $sup->execute(array($id));

        $sup = $con->prepare('DELETE FROM bordereau WHERE eleve=?');
        $sup->execute(array($id));
        $sup = $con->prepare('DELETE FROM examen_eleve WHERE eleve=?');
        $sup->execute(array($id));

        $sup = $con->prepare('DELETE FROM eleve WHERE id_eleve=?');
        $sup->execute(array($id));
    }

    public static function supprimerExamenEleve($id_examen_eleve)
    {
        $con = parent::getPDO();

        $sup = $con->prepare('DELETE FROM examen_eleve WHERE id_examen_eleve=?');
        $sup->execute(array($id_examen_eleve));
    }
 }