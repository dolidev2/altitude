<?php include_once '../model/Eleve.class.php' ;
include_once '../model/Bordereau.class.php' ;
include_once '../model/Agence.class.php' ;

$agences = Agence::afficherAgence();
$agenc = '';
$agenceId = '';
if(isset($_GET['agence'])){
    $ag = Agence::afficherAgenceOne($_GET['agence']);
    $agenc = $ag[0]->nom_agence;
    $agenceId =$_GET['agence'];
    $eleves = Eleve::afficherCoursAgence($_GET['agence']);

    $elevePermis = Eleve::afficherStatutAgence($_GET['agence']); $i=1;
    $depotUrl = "index.php?page=bordereau&agence=".$_GET['agence']."&date_depot=";
    $urlListeSimple = '../public/pdf/elevedom.php?ind=cours&agence='.$_GET['agence'];
    $urlListeSolde= '../public/pdf/paiementdom.php?ind=solde&agence='.$_GET['agence'];
    $urlListeRedevable= '../public/pdf/paiementdom.php?ind=redevable&agence='.$_GET['agence'];
    $urlListeImpaye= '../public/pdf/paiementdom.php?ind=impaye&agence='.$_GET['agence'];
    $urlListePermis= '../public/pdf/elevedom.php?ind=permis&agence='.$_GET['agence'];
}
else{

    $eleves = Eleve::afficherCours(); $i=1;
    $elevePermis = Eleve::afficherStatut(); $i=1; 
    $depotUrl = "index.php?page=bordereau&date_depot=";
    $urlListeSimple = '../public/pdf/elevedom.php?ind=cours';
    $urlListeSolde= '../public/pdf/paiementdom.php?ind=solde';
    $urlListeRedevable= '../public/pdf/paiementdom.php?ind=redevable';
    $urlListeImpaye= '../public/pdf/paiementdom.php?ind=impaye';
    $urlListePermis= '../public/pdf/elevedom.php?ind=permis';
}

$depot = Bordereau::displayBordereauDepotOne();
$elev = Eleve::afficherCoursExpire($eleves);
$elevR = Eleve::afficherCoursExpireReinscription($eleves);

?>
<div class="row">
<?php
    if($_SESSION['fonction'] == 'administrateur' || $_SESSION['fonction'] == 'manager'):
?>
    <form action="../control/agence_inscris_periode.php" method="POST">
        <div class="col-lg-1">
            <label for="Agence">Agence</label> 
        </div>
        <div class="col-lg-3">
            <select id="agence_select" class="form-control">
                <option value="">----------------</option>
                <?php 
                    foreach($agences as $agence){
                    ?>
                        <option value="<?= $agence->id_agence ?>"><?= $agence->nom_agence ?></option>
                    <?php
                    }
                ?>
            </select>
        </div>
        <div class="col-lg-2">
            <label><?= $agenc ?></label> 
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-5">
                    <label for="Agence">Date de début</label> 
                    <input type="hidden" value="<?= $agenceId ?>" name="agence_inscris" >
                    <input type="date" name="dt_debut" class="form-control" require>
                </div>
                <div class="col-lg-5">
                    <label for="Agence">Date de fin</label> 
                    <input type="date" name="dt_fin"  class="form-control" require>
                </div>
                <div>
                <div class="col-lg-2">
                    <button type="submit" class="btn btn-primary">
                        Valider
                    </button>
                </div>
                </div>
            </div>
        </div>
    </form>

	<?php
	endif;
?>
</div>
<br>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li ><a href="#ajouter" data-toggle="tab"><h4>Ajouter</h4></a>
                </li>
                <li class="active"><a href="#liste" data-toggle="tab"><h4>Consulter</h4></a>
                </li>
                <li><a href="#listeP" data-toggle="tab"><h4>Provisoire</h4></a>
                </li>
                <li><a href="#listedepot" data-toggle="tab"><h4>Dépôt</h4></a>
                </li>
                <?php if($_SESSION['fonction'] == "administrateur" || $_SESSION['fonction'] == "manager"): ?>
                    <li><a href="#inscription" data-toggle="tab"><h4>Réinscription</h4></a></li>
                <?php  endif; ?>
            </ul>
            <div class="tab-content">
                <!-- Tab Ajouter user -->
                <div class="tab-pane fade" id="ajouter">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ajouter un nouvel élève
                        </div>
                        <div class="panel-body">
                            <form role="form" id="formulaire_save">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Nom</label>
                                        <input id="nom_save" type="text" class="form-control" placeholder="Nom" required>

                                    </div>
                                    <div class="form-group">
                                        <label>Prénom</label>
                                        <input id="prenom_save" type="text" class="form-control" placeholder="Prénom" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Contact</label>
                                        <input id="contact_save" type="text" class="form-control" placeholder="Numéro" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Profession</label>
                                        <input id="profession_save" type="text" class="form-control" placeholder="Profession" >
                                    </div>
                                    <div class="form-group">
                                        <label>Adresse</label>
                                        <input id="adresse_save" type="text" class="form-control" placeholder="Adresse" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Date de Naissance</label>
                                        <input id="dob_save" type="date" class="form-control" >
                                    </div>
                                    <div class="form-group">
                                        <label>Lieu de Naissance</label>
                                        <input id="pob_save" type="text" class="form-control" >
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Catégorie Permis</label>
                                        <select id="categorie_save" class="form-control" required>
                                           <option  value="A">A</option>
                                           <option  value="B">B</option>
                                           <option  value="C">C</option>
                                           <option selected value="D">D</option>
                                           <option  value="E">E</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Forfait</label>
                                        <select id="forfait_save" class="form-control" required>
                                           <option selected  value="normal">Tarif Normal</option>
                                           <option  value="special">Tarif Spécial</option>
                                           <option  value="accelere">Tarif accéléré</option>
                                           <option  value="promo">Tarif Promo</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Solde Forfait</label>
                                        <input id="solde_save" type="number" class="form-control" placeholder="Solde du forfait" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Sexe</label>
                                        <select id="sexe_save" class="form-control" required>
                                           <option selected value="masculin">masculin</option>
                                           <option value="feminin">feminin</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Recommandation</label>
                                        <input id="recommandation" type="text" class="form-control" placeholder="Recommandation pour l'inscription">
                                    </div>
                                    <div class="form-group">
                                        <label>Agence</label>
                                        <select id="agence" class="form-control" required>
                                            <?php
                                                foreach($agences as $agence){
                                                    ?>
                                                    <option value="<?= $agence->id_agence ?>"><?= $agence->nom_agence ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Frais de dossier</label>
                                        <input id="dossier" type="checkbox" >
                                    </div>
                                    <div class="form-group">
                                        <label>Montant des frais de dossier</label>
                                        <input id="montant" type="number" class="form-control"  >
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn-lg btn-primary">Ajouter</button>
                                    </div>
                              </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- Tab Liste Student -->
                <div class="tab-pane fade in active" id="liste">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Tous les élèves en cours
							<?php if($_SESSION['fonction'] == 'administrateur' || $_SESSION['fonction'] == 'manager'): ?>
                            <a href="<?= $urlListeSimple ?>" target="_blank" class="btn btn-primary">Imprimer Liste Simple</a>
                            <a href="<?= $urlListeSolde ?>" target="_blank" class="btn btn-success">Scolarité Soldés</a>
                            <a href="<?= $urlListeRedevable ?>" target="_blank" class="btn btn-warning">Scolarité Redevables</a>
                            <a href="<?= $urlListeImpaye ?>" target="_blank" class="btn btn-danger">Scolarité Impayés</a>
                            <button title="Impression" type="button" class="btn btn-info" data-toggle="modal" data-target="#print_agence">
                                <span class="fa fa-file-pdf-o"></span>
                            </button>
							<?php endif; ?>
                        </div>

                        <div class="panel-body">
                          <div style="text-align:center;">
                              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bordereau">bordereau</button>
                          </div>
                          <!-- Modal Bordereau -->
                          <div class="modal fade" id="bordereau" tabindex="-1" role="dialog" aria-labelledby="#bordereau" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="#bordereau">
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <form role="form" id="formBordereau">
                                        <div class="modal-body">
                                            <div class="col-6">
                                                <label>Date de dépôt : </label>
                                                <input type="date" id="date_depot" class="form-control">
                                            </div>
                                            <div class="col-6">
                                                <label>Description : </label>
                                                <input type="text" id="desc_depot" class="form-control" placeholder="Ex: dépôt permis C">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                        <button type="submit" name="submit" class="btn btn-primary">Enrégistrer</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                            <!--end Modal Bordereau  -->

                            <!-- Modal Impression-->
                            <div class="modal fade" id="print_agence" tabindex="-1" role="dialog" aria-labelledby="#print_agence" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="#print_agence">Liste des Élève</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="g" action="../public/pdf/paiement_periode.php">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label>Date de debut</label>
                                                        <input type="date" name="debut" class="form-control">
                                                    </div>  
                                                    <div class="col-6">
                                                        <label>Date de fin</label>
                                                        <input type="date" name="fin" class="form-control">
                                                        <input type="hidden" name="agence" value="<?= $_GET['agence'] ?>" class="form-control">
                                                    </div>
                                                </div>
                                    
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="submit" class="btn btn-primary">Valider</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal Impression-->

                            <table class="table table-striped table-bordered table-hover" id="course_table">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prénoms</th>
                                        <th>Matricule</th>
                                        <th>Profession</th>
                                        <th>Catégorie</th>
                                        <th>Agence</th>
                                        <th></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach ($elev as $ev){
                                        ?>
                                        <tr>
                                            <td><?= $ev['nom'] ?></td>
                                            <td><?= $ev['prenom'] ?></td>
                                            <td><?= $ev['matricule'] ?></td>
                                            <td><?= $ev['profession'] ?></td>
                                            <td><?= $ev['categorie'] ?></td>
                                            <td><?= $ev['agence'] ?></td>
                                            <td>
                                                <input type="checkbox" class="form-group check"	id="<?= $ev['id_eleve'] ?>" >
                                            </td>
                                            <td>
										<?php if($_SESSION['fonction'] == 'administrateur' || $_SESSION['fonction'] == 'manager'): ?>
                                                <button title="Supprimer" type="button" name="delete" id="<?= $ev['id_eleve'] ?>" class="btn btn-danger btn-sm delete_eleve " ><i class="glyphicon glyphicon glyphicon-trash"></i></button>
                                                <button title="Modifier" type="button" name="update" id="<?= $ev['id_eleve'] ?>" class="btn btn-primary btn-sm update_eleve "><i class="glyphicon glyphicon-pencil"></i></button>
                                            <?php endif; ?>
												<button type="button" title="Examen"  name="examen" id="'<?= $ev['id_eleve'] ?>" class="btn btn-success examen_eleve "><i class="glyphicon glyphicon-ok"></i></button>
                                                <button type="button" title="Paiement"  name="paiement" id="<?= $ev['id_eleve'] ?>" class="btn btn-warning paiement_eleve "><i class="glyphicon glyphicon-th-large"></i></button>
                                                <button type="button" title="Voir plus" name="voir_plus" id="<?= $ev['id_eleve'] ?>" class="btn btn-info detail_eleve "><i class="glyphicon glyphicon-eye-open"></i></button>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Tab Liste Permis Provisoire -->
                <div class="tab-pane fade" id="listeP">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Les élèves qui ont obtenu le permis provisoire
                            <a href="../public/pdf/elevedom.php?ind=permis" target="_blank" class="btn btn-warning">Imprimer</a>
                        </div>
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="table_provisoire">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prénoms</th>
                                        <th>Date de naissance</th>
                                        <th>Lieu de naissance</th>
                                        <th>Catégorie</th>
                                        <th>Agence</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($elevePermis as $ev){
                                    ?>
                                    <tr>
                                        <td><?= $ev->nom ?></td>
                                        <td><?= $ev->prenom ?></td>
                                        <td><?= date('d/m/Y',strtotime($ev->dob)) ?></td>
                                        <td><?= $ev->pob ?></td>
                                        <td><?= $ev->categorie ?></td>
                                        <td><?= $ev->nom_agence ?></td>
                                        <td>
										<?php if($_SESSION['fonction'] == 'administrateur' || $_SESSION['fonction'] == 'manager'): ?>
                                            <button title="Supprimer" type="button" name="delete" id="<?= $ev->id_eleve ?>" class="btn btn-danger btn-sm delete_eleve " ><i class="glyphicon glyphicon glyphicon-trash"></i></button>
                                            <button title="Modifier" type="button" name="update" id="<?= $ev->id_eleve ?>" class="btn btn-primary btn-sm update_eleve "><i class="glyphicon glyphicon-pencil"></i></button>
                                        <?php endif; ?>
											<button type="button" title="Reinscrire"  name="examen" id="<?= $ev->id_eleve ?>" class="btn btn-success inscription_eleve "><i class="glyphicon glyphicon-ok"></i></button>
                                            <button type="button" title="Paiement"  name="paiement" id="<?= $ev->id_eleve ?>" class="btn btn-warning paiement_eleve "><i class="glyphicon glyphicon-th-large"></i></button>
                                            <button type="button" title="Voir plus" name="voir_plus" id="<?= $ev->id_eleve ?>" class="btn btn-info detail_eleve "><i class="glyphicon glyphicon-eye-open"></i></button>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                 <!-- Tab Liste Date de Dépôt -->
                 <div class="tab-pane fade" id="listedepot">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Liste des dépôts
                        </div>
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="table-depot">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Date de dépôt</th>
                                        <th>Description</th>
                                        <th>Nombre de participants</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $i=1;
                                    $depot = Bordereau::displayBordereauDepotOne();
                                    foreach($depot as $dt){
                                      $part = Bordereau::displayParticipantDepot($dt->id_bordereau);
                                      ?>
                                      <tr>
                                      <td><?= $i ?></td>
                                      <td><?= date('d/m/Y',strtotime( $dt->date_depot )) ?></td>
                                      <td><?=$dt->desc_bordereau ?></td>
                                      <td><?= $part[0]->participant ?></td>
                                      <td>
                                            <a title="Détail" class="btn btn-primary" href="index.php?page=bordereau&bordereau=<?= $dt->id_bordereau ?>">
                                              <span class="fa fa-table"></span>
                                            </a>
											<?php if($_SESSION['fonction'] == 'administrateur' || $_SESSION['fonction'] == 'manager'): ?>
                                            <button title="Supprimer" type="button" class="btn btn-danger" data-toggle="modal" data-target="<?='#depot'.$i;?>">
                                                <span class="fa fa-trash"></span>
                                            </button>
											<?php endif; ?>
                                            <!-- Modal -->
                                            <div class="modal fade" id="<?='depot'.$i;?>" tabindex="-1" role="dialog" aria-labelledby="<?='#depot'.$i;?>" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="<?='#mod2'.$i;?>">
                                                      Supprimer cette date de dépôt <b><?= date('d/m/Y',strtotime( $dt->date_depot )).' '.$dt->desc_bordereau ?></b>
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <form method="post" action="../control/del_bordereau_depot.php">
                                                      <div class="modal-body">
                                                        <input type="hidden" name="id_depot" value="<?= $dt->id_bordereau ?>">
                                                        <button class="btn btn-danger">
                                                        <h3>
                                                            Voulez vous supprimer cette date de dépôt ?
                                                        </h3>
                                                        </button>
                                                      </div>
                                                      <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NON</button>
                                                        <button type="submit" name="submit" class="btn btn-primary">OUI</button>
                                                      </div>
                                                  </form>
                                                </div>
                                              </div>
                                            </div>
                                        </td>
                                    </tr>
                                      <?php
                                      $i++;
                                    }
                                  ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <!-- Tab Réinscription -->
            <div class="tab-pane fade" id="inscription">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Liste des élèves à réinscrire
                    </div>
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="tables-reinscrire">
                            <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénoms</th>
                                <th>Lieu de Naissance</th>
                                <th>Date de Naissance</th>
                                <th>Catégorie</th>
                                <th>Agence</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($elevR as $ev){
                                    ?>
                                    <tr>
                                        <td><?= $ev['nom'] ?></td>
                                        <td><?= $ev['prenom'] ?></td>
                                        <td><?= date('d/m/Y',strtotime($ev['dob'])) ?></td>
                                        <td><?= $ev['pob'] ?></td>
                                        <td><?= $ev['categorie'] ?></td>
                                        <td><?= $ev['agence'] ?></td>
                                        <td>
                                            <button title="Supprimer" type="button" name="delete" id="<?= $ev['id_eleve'] ?>" class="btn btn-danger btn-sm delete_eleve " ><i class="glyphicon glyphicon glyphicon-trash"></i></button>
                                            <button title="Modifier" type="button" name="update" id="<?= $ev['id_eleve'] ?>" class="btn btn-primary btn-sm update_eleve "><i class="glyphicon glyphicon-pencil"></i></button>
                                            <button type="button" title="Reinscrire"  name="examen" id="<?= $ev['id_eleve'] ?>" class="btn btn-success inscription_eleve "><i class="glyphicon glyphicon-ok"></i></button>
                                            <button type="button" title="Paiement"  name="paiement" id="<?= $ev['id_eleve'] ?>" class="btn btn-warning paiement_eleve "><i class="glyphicon glyphicon-th-large"></i></button>
                                            <button type="button" title="Voir plus" name="voir_plus" id="<?= $ev['id_eleve'] ?>" class="btn btn-info detail_eleve "><i class="glyphicon glyphicon-eye-open"></i></button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal Reinscrire -->
            <div class="modal fade" id="reinscrire_eleve" tabindex="-1" role="dialog" aria-labelledby="reinscrire_eleve" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                             
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="../control/register_eleve.php">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">Durée de la réinscription</label>
                                    <input type="text" name="duree" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Pénalité de la réinscription</label>
                                    <input type="number" name="penalite" class="form-control">
                                </div>
                                <input type="hidden" id="eleve_id_reinscrire" name="eleve" value="">

                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <button type="submit" name="submit" class="btn btn-primary">Réinscrire</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Modal Reinscrire-->
            </div>
        </div>
    </div>
</div>
<div id="comment"></div>

<script type="text/javascript">

    $(document).ready(function () {
		var fonction = <?php echo json_encode($_SESSION['fonction']); ?>;

        var dataTable = $('#course_table').DataTable({
            "responsive":true,
            "paging": true,
			language: {
				url: '../public/vendor/datatables/js/language.json',
				"paginate": {
					"previous": "<",
					"next": ">",
					"first": "",
					"last": ""
				}
			},
			"info":( fonction === 'administrateur' || fonction === 'manager') ? true : false, // Désactive l'affichage du nombre d'éléments
			"lengthChange": ( fonction === 'administrateur' || fonction === 'manager') ? true : false, // Désactive la pagination
			"pageLength": ( fonction === 'administrateur' || fonction === 'manager') ? 10 : 50, // Définit le nombre d'éléments par page
        });

        var dataTable_provisoire = $('#table_provisoire').DataTable({
            "responsive":true,
            "paging":true,
			language: {
				url: '../public/vendor/datatables/js/language.json',
				"paginate": {
					"previous": "<",
					"next": ">",
					"first": "",
					"last": ""
				}
			},
			"info":( fonction === 'administrateur' || fonction === 'manager') ? true : false, // Désactive l'affichage du nombre d'éléments
			"lengthChange": ( fonction === 'administrateur' || fonction === 'manager') ? true : false, // Désactive la pagination
			"pageLength": ( fonction === 'administrateur' || fonction === 'manager') ? 10 : 50, // Définit le nombre d'éléments par page
        });

        var table_depot = $('#table-depot').DataTable({
            "responsive":true,
            "paging":true,
            order: [[1, 'desc']],
			language: {
				url: '../public/vendor/datatables/js/language.json',
				"paginate": {
					"previous": "<",
					"next": ">",
					"first": "",
					"last": ""
				}
			},
			"info":( fonction === 'administrateur' || fonction === 'manager') ? true : false, // Désactive l'affichage du nombre d'éléments
			"lengthChange": ( fonction === 'administrateur' || fonction === 'manager') ? true : false, // Désactive la pagination
			"pageLength": ( fonction === 'administrateur' || fonction === 'manager') ? 10 : 50, // Définit le nombre d'éléments par page

        });

        var dataTables = $('#tables-reinscrire').DataTable({
            "responsive":true,
            "paging":true,
			language: {
				url: '../public/vendor/datatables/js/language.json',
				"paginate": {
					"previous": "<",
					"next": ">",
					"first": "",
					"last": ""
				}
			},
			"info":( fonction === 'administrateur' || fonction === 'manager') ? true : false, // Désactive l'affichage du nombre d'éléments
			"lengthChange": ( fonction === 'administrateur' || fonction === 'manager') ? true : false, // Désactive la pagination
			"pageLength": ( fonction === 'administrateur' || fonction === 'manager') ? 10 : 50, // Définit le nombre d'éléments par page
        });

        $(document).on('click', '.inscription_eleve', function(){
            $('#reinscrire_eleve').modal('show');
            var eleve_id = $(this).attr("id");
            $('#eleve_id_reinscrire').val(eleve_id);
      
        });

        $('#agence_select').change(function () {
           window.location.href="index.php?page=eleve&agence="+$(this).val();
        });

        $('#montant').hide();
        $('#dossier').change(function () {
            if( $('#dossier').is(':checked'))
            {
                $('#montant').show();
            }
            else{
                $('#montant').hide();
            }
        });


        //Submit form Boredereau
        $('#formBordereau').submit(function () {
			var $form = $(this);
			if ($form.data('submitting')) return false;
			$form.data('submitting', true);
			$form.find('button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Envoi...');

			var depot = $('#date_depot').val();
            var desc_depot = $('#desc_depot').val();
            $.post('../control/bordereau.php', {data:data,depot:depot,desc_depot:desc_depot}, function(response)
            {
              location.reload();
			}).always(function() {
				$form.data('submitting', false);
				$form.find('button[type="submit"]').prop('disabled', false).html('Ajouter');
			});

            return false;
        });
        // Save User
        $('#formulaire_save').submit( function()
        {
			var $form = $(this);
			if ($form.data('submitting')) return false;
			$form.data('submitting', true);
			$form.find('button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Envoi...');

            var nom = $('#nom_save').val();
            var prenom = $('#prenom_save').val();
            var contact = $('#contact_save').val();
            var profession = $('#profession_save').val();
            var adresse = $('#adresse_save').val();
            var dob = $('#dob_save').val();
            var pob = $('#pob_save').val();
            var categorie = $('#categorie_save').val();
            var forfait = $('#forfait_save').val();
            var solde = $('#solde_save').val();
            var sexe = $('#sexe_save').val();
            var recommandation = $('#recommandation').val();
            var agence = $('#agence').val();
            var montant = '';
            if( $('#dossier').is(':checked'))
            {
                montant = $('#montant').val();
            }

            $.post('../control/reg_eleve.php', {nom:nom,prenom:prenom,contact:contact,profession:profession,adresse:adresse,dob:dob,pob:pob,categorie:categorie,
                forfait:forfait,solde:solde,sexe:sexe,recommandation:recommandation,agence:agence,montant:montant}, function(response)
            {
                $('#comment').html(response);
			}).always(function() {
			$form.data('submitting', false);
			$form.find('button[type="submit"]').prop('disabled', false).html('Ajouter');
		});

            return false;

        });

        $(document).on('click', '.delete_eleve', function(){
        var eleve_id = $(this).attr("id");
            if (confirm("Êtes vous sûr de vouloir supprimer cet élève?")){
                $.ajax({
                url:"../control/del_eleve.php",
                method:"POST",
                data:{eleve_id:eleve_id},
                success:function(data)
                {
					location.reload();
                }
            });
              
            } else {
                return false;
            }
            });

         
        $(document).on('click', '.update_eleve', function(){
            var id_eleve = $(this).attr("id");
            window.location.href = "index.php?page=up_eleve&id_eleve="+id_eleve;
        });
        
        $(document).on('click', '.examen_eleve', function(){
            var id_eleve = $(this).attr("id");
            window.location.href = "index.php?page=eleve_examen&id_eleve="+id_eleve;
        });  
        
        $(document).on('click', '.detail_eleve', function(){
            var id_eleve = $(this).attr("id");
            window.location.href = "index.php?page=eleve_detail&id_eleve="+id_eleve;
        });  
        
        $(document).on('click', '.paiement_eleve', function(){
            var id_eleve = $(this).attr("id");
            window.location.href = "index.php?page=de_eleve&id_eleve="+id_eleve;
        });

        var data=[];
        $(document).on('focusout', '.check', function(){
            var id_eleve = $(this).attr("id");
            data.push({
                id:id_eleve,
            });
        });
    });
</script>