<?php include_once '../model/Caisse.class.php' ;
 include_once '../model/Versement.class.php' ;
 include_once '../model/Audit.class.php' ;

 $caisses = Caisse::afficherAll();
 ?>

<div class="row">
    <div class="panel panel-default">
        <div class="panel-body">
            <ul class="nav nav-tabs">                
                <li class="active"><a href="#liste" data-toggle="tab"><h4>Entrées & Sorties</h4></a>
                </li>
				<?php if($_SESSION['fonction'] == 'administrateur' || $_SESSION['fonction'] == 'manager'): ?>
                <li><a href="#recette" data-toggle="tab"><h4>Clôturer</h4></a>
                </li>
				<?php endif; ?>
                <li><a href="#compte" data-toggle="tab"><h4>Versement</h4></a>
                </li>
                <li><a href="#fond" data-toggle="tab"><h4>Fond de caisse</h4></a>
                </li>
            </ul>
                <div class="tab-content">

                <!-- Tab Liste E/S -->
                <div class="tab-pane fade in active" id="liste">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Listes des Toutes les Entrées et Sorties  
                            <button title="Ajouter" data-toggle="modal" data-target="#ajouter" class="btn btn-primary">Nouveau</button>         
                            <button title="Ajouter_btn" data-toggle="modal" data-target="#ajouter_btn" class="btn btn-warning">Reccette</button>                                                     
                        </div>                        
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="table_caisse">
                                <thead>
                                    <tr>
                                        <!-- <th>N°</th> -->
                                        <th>Date </th>   
                                        <th>Libellé</th>
                                        <th>Type</th>
                                        <th>Somme</th>                           
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach ($caisses as $ev){
                                        ?>
                                        <tr>
                                            <td><?= date('d/m/Y',strtotime($ev->date)) ?></td>
                                            <td><?= $ev->desc_caisse ?></td>
                                            <td><?php
                                                if ($ev->type == 'sortie') {
                                                    ?>
                                                    <button class="btn btn-danger">Dépense</button>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <button class="btn btn-success">Recette</button>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td><?= $ev->somme ?></td>
                                            <td>
                                            <?php
                                                if ($_SESSION['fonction'] == 'administrateur') {
                                            ?>
                                                <a title="Modifier" class="btn btn-primary" href="index.php?page=up_caisse&id_caisse='.<?= $ev->id_caisse?>.'">
                                                <span class="fa fa-pencil"></span>
                                                </a>

                                                <button title="Supprimer" type="button" class="btn btn-danger" data-toggle="modal" data-target="#mod'.<?= $ev->id_caisse?>].'">
                                                <span class="fa fa-trash"></span>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="#mod'.<?= $ev->id_caisse?>.'" tabindex="-1" role="dialog" aria-labelledby="#mod'.<?= $ev->id_caisse?>.'" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="#mod'.<?= $ev->id_caisse?>.'">
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form method="post" action="../control/del_caisse.php">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_caisse" value="'.<?= $ev->id_caisse?>.'">
                                                                <button class="btn btn-danger">
                                                                    <h3>
                                                                        Voulez vous vraiment supprimer ?
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
                                                    <?php
                                                }
                                            ?>
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

                <!-- Tab Cloturer -->
                <div class="tab-pane fade" id="recette">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Cloturation de la caisse
                            <button title="Date" data-toggle="modal" data-target="#date" class="btn btn-warning">Choisir une date</button>
                        </div>
                        <div class="panel-body">
                          <div class="row">
                              <div class="col-lg-4">
                                  <h4>Cloture Journalière</h4>
                                  <a href="../public/pdf/caisse_journalier.php?date=<?= date('Y-m-d') ; ?>" target="_blank">
                                      <button title="Détail" class="btn btn-primary">Détail</button>
                                  </a>
                              </div>
                              <div class="col-lg-4">
                                  <h4>Cloture Mensuelle</h4>
                                  <a href="../public/pdf/caisse_mensuelle.php?date=<?= date('Y-m-d')?>" target="_blank">
                                      <button title="Détail" class="btn btn-primary">Détail</button>
                                  </a>
                              </div>
                              <div class="col-lg-4">
                                  <h4>Cloture Mensuelle Fond de caisse</h4>
                                  <a href="../public/pdf/fond_caisse.php?date=<?= date('Y-m-d')?>" target="_blank">
                                      <button title="Détail" class="btn btn-primary">Détail</button>
                                  </a>
                              </div>
                              <div class="col-lg-4">
                                  <h4>Cloture Annuelle</h4>
                                  <a href="../public/pdf/caisse_annuelle.php?date=<?= date('Y-m-d')?>" target="_blank">
                                      <button title="Détail" class="btn btn-primary">Détail</button>
                                  </a>
                              </div>
                          </div>
                        </div>
                    </div>                    
                </div>
                    <!-- Tab Versement -->
                    <div class="tab-pane fade" id="compte">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Listes des transactions sur un compte
                                <button title="versement" data-toggle="modal" data-target="#versement" class="btn btn-primary">Nouveau</button>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                Versement mensuelle
                                <button title="versement" data-toggle="modal" data-target="#mensuelle" class="btn btn-success">Imprimer</button>
                            </div>
                            <div class="panel-body">
                              <!--Insert the table here-->

                                <table width="100%" class="table table-striped table-bordered table-hover" id="">
                                    <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Somme</th>
                                        <th>Description</th>
                                        <th>Compte</th>
                                        <th>Mode transaction</th>
                                        <th>Date </th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $versement = Versement::read(); $i=1; ?>
                                    <?php foreach ($versement as $vs) : ?>
                                        <tr class="odd gradeX">
                                            <td><?=$i; ?></td>
                                            <td><?=$vs->somme; ?></td>
                                            <td><?=$vs->desc_ver; ?></td>
                                            <td><?=$vs->banque; ?></td>
                                            <td><?=$vs->mode; ?></td>
                                            <td><?=date('d/m/Y',strtotime($vs->date)); ?></td>
                                            <td class="center">
                                                <?php if ($_SESSION['fonction'] == 'administrateur' || $_SESSION['fonction'] == 'manager'): ?>
                                                <a title="Modifier" class="btn btn-primary" href="index.php?page=de_versement&id_versement=<?= $vs->id_ver ?>">
                                                    <span class="fa fa-pencil"></span>
                                                </a>
                                                    <button title="Supprimer" type="button" class="btn btn-danger" data-toggle="modal" data-target="<?='#modal_ver'.$i?>">
                                                        <span class="fa fa-trash"></span>
                                                    </button>
                                                <?php endif; ?>
                                                <!-- Modal -->
                                                <div class="modal fade" id="<?='modal_ver'.$i;?>" tabindex="-1" role="dialog" aria-labelledby="<?='#modal_ver'.$i;?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="<?='#modal_ver'.$i;?>">
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form method="post" action="../control/del_versement.php">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="id_ver" value="<?=$vs->id_ver?>">
                                                                    <button class="btn btn-danger">
                                                                        <h3>
                                                                            Voulez vous vraiment supprimer cette Transaction ?
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
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="fond">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Cloture du fond de la caisse
                                <button title="Ajouter" data-toggle="modal" data-target="#ajouter_btn" class="btn btn-success">Ajouter</button>     
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <ul class="nav nav-tabs">                
                                        <li class="active"><a href="#fond_ajouter" data-toggle="tab"><h4>Imprimer</h4></a></li>
                                        <li><a href="#fond_consulter" data-toggle="tab"><h4>Consulter</h4></a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <!-- Ajouter fond decaisse-->
                                        <div class="tab-pane fade in active" id="fond_ajouter">
                                            <div class="panel panel-default">
                                                <form method="post" action="../public/pdf/fond_caisse.php">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                        <div class="col-6">
                                                            <label>Date de debut</label>
                                                            <input type="date" name="dt_debut" class="form-control">
                                                        </div>  
                                                        <div class="col-6">
                                                            <label>Date de fin</label>
                                                            <input type="date" name="dt_fin" class="form-control">
                                                        </div>
                                                        </div>
                                            
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="submit" class="btn btn-primary">Valider</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Consulter fond de caisse -->
                                        <div class="tab-pane fade" id="fond_consulter">
                                            <div class="panel panel-default">
                                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                    <thead>
                                                        <tr>
                                                            <td>Date</td>
                                                            <td>Somme</td>
                                                            <td>Action</td>
                                                        </tr>  
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $recettes = Caisse::afficherRecette();
                                                            foreach( $recettes as $recette)
                                                            {
                                                                ?>
                                                                <tr>
                                                                    <td><?= date("d/m/Y",strtotime($recette->date_recette))  ?></td>
                                                                    <td><?= $recette->somme_recette ?></td>
                                                                    <td>
                                                                        <?php if ($_SESSION['fonction'] == 'administrateur') {  ?>
                                                                        <a title="Modifier" class="btn btn-primary" href="index.php?page=recette_modifier&recette=<?= $recette->id_recette ?>">
                                                                            <span class="fa fa-pencil"></span>
                                                                        </a>
                                                                            <button title="Supprimer" type="button" class="btn btn-danger" data-toggle="modal" data-target="<?='#modal_fond'.$recette->id_recette?>">
                                                                                <span class="fa fa-trash"></span>
                                                                            </button>
                                                                        <?php } ?>
                                                                        <!-- Modal -->
                                                                        <div class="modal fade" id="<?='modal_fond'.$recette->id_recette;?>" tabindex="-1" role="dialog" aria-labelledby="<?='#modal_fond'.$recette->id_recette;?>" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="<?='#modal_fond'.$recette->id_recette;?>">
                                                                                        </h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <form method="post" action="../control/del_recette.php">
                                                                                        <div class="modal-body">
                                                                                            <input type="hidden" name="recette_sup" value="<?= $recette->id_recette; ?>">
                                                                                            <button class="btn btn-danger">
                                                                                                <h3>
                                                                                                    Voulez vous vraiment supprimer cette Recette ?
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
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>        
    </div>    
</div> 


<div id="ajouter" class="modal fade" role="dialog" > 
    <div class="modal-dialog modal-lg">
                <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enregistrement d'une Entrée ou Sortie d'argent</h4>
                <h5 style="color: red;"> Les informations suivies d'un astérix (*) sont obligatoires </h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form role="form" action="../control/reg_caisse.php" method="POST">   

                    <div class="form-group col-lg-4">
                        <label>Date de Transaction  : </label>
                        <input class="form-control" type="date" name="date"/>
                    </div> 
                    <div class="form-group col-lg-4">
                        <label>Libelle :  <span style="color: red">*</span></label>
                        <input class="form-control" type="text" name="desc" placeholder="Description" required />
                    </div>
                         <div class="form-group col-lg-4">
                           <label>Type de Transaction: <span style="color: red">*</span></label>
                           <div>
                                <select class="form-control" name="type"  required >
                                      <option value="entre" selected>Entrée d'argent</option>  
                                      <option value="sortie" >Sortie d'argent</option>
                                         
                               </select>
                           </div>
                         </div>

                         <div class="form-group col-lg-4">
                             <label>Montant :  <span style="color: red">*</span></label>
                             <input class="form-control" type="number" name="somme" required />
                        </div>
                       <div class="modal-footer">
                            <input type="submit" class="btn btn-success"  name="submit" value="Valider"/>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>   
                       </div>                                      
                    </form>
                </div>
            </div>               
        </div>
    </div>
</div>


<div id="ajouter_btn" class="modal fade" role="dialog" > 
    <div class="modal-dialog modal-lg">
                <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enregistrement de la recette du jour</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form role="form" action="../control/reg_recette.php" method="POST">   
                    <div class="form-group col-lg-4">
                        <label>Date  : </label>
                        <input class="form-control" type="date" name="date"/>
                    </div> 
                    <div class="form-group col-lg-4">
                        <label>Montant :  <span style="color: red">*</span></label>
                        <input class="form-control" type="number" name="somme" required />
                    </div>
                       <div class="modal-footer">
                            <input type="submit" class="btn btn-success"  name="submit" value="Valider"/>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>   
                       </div>                                      
                    </form>
                </div>
            </div>               
        </div>
    </div>
</div>

<div id="versement" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enregistrement d'un versement</h4>
                <h5 style="color: red;"> Les informations suivies d'un astérix (*) sont obligatoires </h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form role="form" action="../control/reg_versement.php" method="POST">
                        <div class="form-group col-lg-4">
                            <label>La Somme :  <span style="color: red">*</span></label>
                            <input class="form-control" type="number" name="somme" required />
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Description :  <span style="color: red">*</span></label>
                            <input class="form-control" type="text" name="desc" placeholder="Description" required />
                        </div>

                        <div class="form-group col-lg-4">
                            <label>Mode Transaction :  <span style="color: red">*</span></label>
                            <div>
                                <select class="form-control" name="mode" required >
                                    <option value="ESPECE" selected>ESPECE</option>
                                    <option value="CHEQUE" >CHEQUE</option>
                                    <option value="AUTRE" >AUTRE</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Date de Transaction  : </label>
                            <input class="form-control" type="date" name="date"/>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Banque :  <span style="color: red">*</span></label>
                            <div>
                                <select class="form-control" name="compte" required >
                                    <option value="BSIC" selected>SGB</option>
                                    <option value="CORIS">CORIS BANK</option>
                                    <option value="BOA">BOA</option>
                                    <option value="UBA">UBA</option>
                                    <option value="ACEP">ECOBANK</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-success"  name="submit" value="Valider"/>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="date" class="modal fade" role="dialog" > 
    <div class="modal-dialog modal-lg">
                <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Voir les Entrée ou Sortie d'argent suivant la date </h4>                
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="form_date_cloture" action="../control/caisse_cloture.php" method="GET">
                         <div class="form-group col-lg-4">
                           <label>Choisir une date : <span style="color: red">*</span></label>
                           <input class="form-control" type="date" name="date" required />
                         </div>               
                       
                       <div class="modal-footer">
                            <input type="submit" class="btn btn-success" value="Valider"/>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>   
                       </div>                                      
                    </form>
                    <div class="comment"></div>
                </div>
            </div>               
        </div>
    </div>
</div>


<div id="mensuelle" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Choisir une date contenant le mois souhaité  </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form id="form_date_cloture" action="../public/pdf/versement.php" method="GET">
                        <div class="form-group col-lg-4">
                            <label>Choisir une date : <span style="color: red">*</span></label>
                            <input class="form-control" type="date" name="date" required />
                        </div>

                        <div class="modal-footer">
                            <input type="submit" class="btn btn-success" value="Valider"/>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</div>
<div id="comment"></div>
<script type="text/javascript">
    $(document).ready(function () {

        var dataTable = $('#table_caisse').DataTable({
            "responsive":true,
            "paging":true,
            "order":[[0.'desc']],
        });
    });

</script>