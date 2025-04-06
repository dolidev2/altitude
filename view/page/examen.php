<?php 
include_once '../model/Examen.class.php' ; 
include_once '../model/Eleve.class.php' ; 
include_once '../model/Agence.class.php' ;
$agences = Agence::afficherAgence();
$agenc = '';
if(isset($_GET['agence']))
{
    $ag = Agence::afficherAgenceOne($_GET['agence']); 
    $agenc = $ag[0]->nom_agence;
    $reds = Eleve::afficherCoursAgence($_GET['agence']); 
    $els = Eleve::afficherStatutAgence($_GET['agence']); 
}else{
    $reds = Eleve::afficherCours(); 
    $els = Eleve::afficherStatut(); 
}
$elev = Eleve::afficherCoursExpire($reds);
?>
<?php if($_SESSION['fonction'] == 'administrateur' || $_SESSION['fonction'] == 'manager'): ?>
<div class="row">
    <div class="col-lg-1">
        <label for="Agence">Agence</label> 
    </div>
    <div class="col-lg-5">
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
    <div class="col-lg-6">
        <label><?= $agenc ?></label> 
    </div>
</div>
<?php endif; ?>
<br>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-body">
            <ul class="nav nav-tabs">                
                <li><a href="#ajouter" data-toggle="tab"><h4>Ajouter</h4></a>
                </li>
                <li class="active"><a href="#liste_examen" data-toggle="tab"><h4>Consulter</h4></a>
                </li>
                <li><a href="#liste_attente" data-toggle="tab"><h4>Affecter</h4></a>
                </li>
                <li><a href="#liste_program" data-toggle="tab"><h4>Programmer</h4></a>
                </li>   
                <li><a href="#sitess" data-toggle="tab"><h4>Site</h4></a>
                </li>
            </ul>
            <div class="tab-content">
            	<!-- Tab Liste Users -->
                <div class="tab-pane fade " id="ajouter">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ajouter un Examen                            
                        </div>
                        <div class="panel-body">
                            <form role="form" id="formulaire_examen">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Date Examen</label>
                                        <input id="date" type="date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-3" id="sit_form">
                                    <div class="form-group">
                                        <label>Site</label>
                                        <select id="sit" class="form-control" required>
                                        <?php
                                            $sit = Examen::afficherSite();
                                            foreach ($sit as $st){
                                                ?>
                                                <option  value="<?php echo $st->id_site ; ?>"><?= $st->nom_site?></option>
                                                <?php
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3" >
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input id="desc_examen" type="text" class="form-control" placeholder="Ex: Permis C" >
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Type Examen</label>
                                        <select id="type_examen" class="form-control" required>
                                           <option  value="code">Code de Route</option>
                                           <option  value="circulation">Circulation</option>
                                        </select>
                                    </div>                                                             
                                    <div class="form-group">
                                        <button type="submit" class="btn-lg btn-primary">Ajouter</button>        
                                    </div>                         
                              </div>                                           
                            </form>                            
                        </div>
                    </div>                    
                </div> 

                <!-- Tab Liste Users -->
                <div class="tab-pane fade in active" id="liste_examen">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Listes tous les Examens                            
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li ><a href="#code" data-toggle="tab"><h4>Code</h4></a></li>
                                <?php
                                    $sites = Examen::afficherSite();
                                    $i=0;
                                    foreach ($sites as $site){
                                        if($i == 0){
                                            ?>
                                            <li class="active"><a href="#site" data-toggle="tab"><h4><?= $site->nom_site ?></h4></a></li>
                                            <?php
                                        }else{
                                        ?>
                                        <li><a href="#sites<?= $i ?>" data-toggle="tab"><h4><?= $site->nom_site ?></h4></a></li>
                                        <?php
                                        }
                                        $i++;
                                    }
                                ?>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade" id="code">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Liste des examens
                                        </div>
                                        <div class="panel-body">
                                            <table width="100%" class="table table-striped table-bordered table-hover" id="table-exam-code">
                                                <thead>
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Type Examen</th>
                                                    <th>Date Examen</th>
                                                    <th>Description</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $exams = Examen::afficherExamenCode(); $cpt=1;  $cpt_code = 10000; ?>
                                                <?php
                                                foreach ($exams as $exam) : ?>
                                                    <tr class="odd gradeX">
                                                        <td><?=$cpt; ?></td>
                                                        <td><?=$exam->type; ?></td>
                                                        <td><?= date("d/m/Y",strtotime($exam->date_examen)) ?></td>
                                                        <td><?= $exam->desc_examen ?></td>
                                                        <td class="center">
                                                            <a title="Détail" class="btn btn-primary" href="index.php?page=de_examen&id_examen=<?=$exam->id_examen;?>">
                                                                <span class="fa fa-table"></span>
                                                            </a>

                                                            <!-- MOD -->
                                                            <button title="Modifier" type="button" class="btn btn-success" data-toggle="modal" data-target="<?='#mod'.$cpt;?>">
                                                                <span class="fa fa-pencil"></span>
                                                            </button>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="<?='mod'.$cpt;?>" tabindex="-1" role="dialog" aria-labelledby="<?='#mod'.$cpt;?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="<?='#mod'.$cpt;?>">Modifications
                                                                            </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form method="post" action="../control/up_examen.php">
                                                                            <div class="modal-body">
                                                                                <input re type="hidden" name="id_examen" value="<?=$exam->id_examen;?>">
                                                                                <label>Date examen</label>
                                                                                <input class="form-control" type="date" name="date" value="<?=date("d/m/Y",strtotime($exam->date_examen))?>" required><br>
                                                                                <label>Examinateur </label>
                                                                                <input class="form-control" required type="text" name="examinateur" value="<?=$exam->examinateur;?>"><br>
                                                                                <label>Type </label>
                                                                                <select class="form-control" required name="type">
                                                                                    <option selected value="<?=$exam->type;?>"><?=$exam->type;?></option>
                                                                                    <option value="code">Code de route</option>
                                                                                    <option value="creanu">Crenau</option>
                                                                                    <option value="conduite">Conduite</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                                                <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- SUPP -->
                                                            <button title="Supprimer" type="button" class="btn btn-danger" data-toggle="modal" data-target="<?='#delete'.$cpt_code; ?>">
                                                                <span class="fa fa-trash"></span>
                                                            </button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="<?='delete'.$cpt_code;?>" tabindex="-1" role="dialog" aria-labelledby="<?='#delete'.$cpt_code;?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="<?='#delete'.$cpt_code;?>">Suppression
                                                                            </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form method="post" action="../control/del_examen.php">
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name="id_examen" value="<?=$exam->id_examen;?>">
                                                                                <button class="btn btn-danger">
                                                                                    <h3>
                                                                                        Voulez vous vraiment supprimer cet examen ?
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
                                                    <?php $cpt++; $cpt_code ++;?>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <!-- Tab Site-->
                                <?php
                                $i=0;
                                foreach ($sites as $site){
                                if($i == 0){
                                ?>
                                    <div class="tab-pane fade in active" id="site">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                Liste des examens
                                            </div>
                                            <div class="panel-body">
                                                <table width="100%" class="table table-striped table-bordered table-hover" id="table-exam-pl-<?= $i?>">
                                                    <thead>
                                                    <tr>
                                                        <th>N°</th>
                                                        <th>Type Examen</th>
                                                        <th>Date Examen</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $exams = Examen::afficherExamenSite($site->id_site); $j=1; ?>
                                                    <?php
                                                    foreach ($exams as $exam) : ?>
                                                        <tr class="odd gradeX">
                                                            <td><?=$j; ?></td>
                                                            <td><?=$exam->type; ?></td>
                                                            <td><?= date("d/m/Y",strtotime($exam->date_examen)) ?></td>
                                                            <td><?= $exam->desc_examen ?></td>
                                                            <td class="center">
                                                                <a title="Détail" class="btn btn-primary" href="index.php?page=de_examen&id_examen=<?=$exam->id_examen;?>">
                                                                    <span class="fa fa-table"></span>
                                                                </a>

                                                                <!-- MOD -->
                                                                <button title="Modifier" type="button" class="btn btn-success" data-toggle="modal" data-target="<?='#modifier'.$site->id_site.$j;?>">
                                                                    <span class="fa fa-pencil"></span>
                                                                </button>
                                                                <!-- Modal -->
                                                                <div class="modal fade" id="<?='modifier'.$site->id_site.$j;?>" tabindex="-1" role="dialog" aria-labelledby="<?='#modifier'.$site->id_site.$j;?>" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="<?='#modifier'.$site->id_site.$j;?>">Modifications
                                                                                </h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <form method="post" action="../control/up_examen.php">
                                                                                <div class="modal-body">
                                                                                    <input type="hidden" name="id_examen" value="<?=$exam->id_examen;?>">
                                                                                    <label>Date examen</label>
                                                                                    <input class="form-control" type="date" name="date" value="<?=date("d/m/Y",strtotime($exam->date_examen))?>" required><br>
                                                                                    <label>Examinateur </label>
                                                                                    <input class="form-control" required type="text" name="examinateur" value="<?=$exam->examinateur;?>"><br>
                                                                                    <label>Type </label>
                                                                                    <select class="form-control" required name="type">
                                                                                        <option selected value="<?=$exam->type;?>"><?=$exam->type;?></option>
                                                                                        <option value="code">Code de route</option>
                                                                                        <option value="creanu">Crenau</option>
                                                                                        <option value="conduite">Conduite</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                                                    <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- SUPP -->
                                                                <button title="Supprimer" type="button" class="btn btn-danger" data-toggle="modal" data-target="<?='#sup'.$site->id_site.$j;?>">
                                                                    <span class="fa fa-trash"></span>
                                                                </button>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="<?='sup'.$site->id_site.$j;?>" tabindex="-1" role="dialog" aria-labelledby="<?='#sup'.$site->id_site.$j;?>" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="<?='#sup'.$site->id_site.$j;?>">Suppression
                                                                                </h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <form method="post" action="../control/del_examen.php">
                                                                                <div class="modal-body">
                                                                                    <input type="hidden" name="id_examen" value="<?=$exam->id_examen;?>">
                                                                                    <button class="btn btn-danger">
                                                                                        <h3>
                                                                                            Voulez vous vraiment supprimer cet examen ?
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
                                                        <?php $j++; ?>
                                                    <?php endforeach; ?>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                <?php
                                        }else{
                                        ?>
                                    <div class="tab-pane fade" id="sites<?= $i ?>">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                              Liste des examens
                                            </div>
                                            <div class="panel-body">
                                                <table width="100%" class="table table-striped table-bordered table-hover" id="table-exam-pl-<?= $i?>">
                                                    <thead>
                                                    <tr>
                                                        <th>N°</th>
                                                        <th>Type Examen</th>
                                                        <th>Date Examen</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $exams = Examen::afficherExamenSite($site->id_site); $j=1; ?>
                                                    <?php foreach ($exams as $exam) : ?>
                                                        <tr class="odd gradeX">
                                                            <td><?=$j; ?></td>
                                                            <td><?=$exam->type; ?></td>
                                                            <td><?= date("d/m/Y",strtotime($exam->date_examen)) ?></td>
                                                            <td><?= $exam->desc_examen ?></td>
                                                            <td class="center">
                                                                <a title="Détail" class="btn btn-primary" href="index.php?page=de_examen&id_examen=<?=$exam->id_examen;?>">
                                                                    <span class="fa fa-table"></span>
                                                                </a>

                                                                <!-- MOD -->
                                                                <button title="Modifier" type="button" class="btn btn-success" data-toggle="modal" data-target="<?='#mod'.$site->nom_site.$j;?>">
                                                                    <span class="fa fa-pencil"></span>
                                                                </button>
                                                                <!-- Modal -->
                                                                <div class="modal fade" id="<?='mod'.$site->nom_site.$j;?>" tabindex="-1" role="dialog" aria-labelledby="<?='#mod'.$site->nom_site.$j;?>" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="<?='#mod'.$site->nom_site.$j;?>">Modifications
                                                                                </h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <form method="post" action="../control/up_examen.php">
                                                                                <div class="modal-body">
                                                                                    <input re type="hidden" name="id_examen" value="<?=$exam->id_examen;?>">
                                                                                    <label>Date examen</label>
                                                                                    <input class="form-control" type="date" name="date" value="<?=date("d/m/Y",strtotime($exam->date_examen))?>" required><br>
                                                                                    <label>Examinateur </label>
                                                                                    <input class="form-control" required type="text" name="examinateur" value="<?=$exam->examinateur;?>"><br>
                                                                                    <label>Type </label>
                                                                                    <select class="form-control" required name="type">
                                                                                        <option selected value="<?=$exam->type;?>"><?=$exam->type;?></option>
                                                                                        <option value="code">Code de route</option>
                                                                                        <option value="creanu">Crenau</option>
                                                                                        <option value="conduite">Conduite</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                                                    <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- SUPP -->
                                                                <button title="Supprimer" type="button" class="btn btn-danger" data-toggle="modal" data-target="<?='#sup'.$site->nom_site.$j;?>">
                                                                    <span class="fa fa-trash"></span>
                                                                </button>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="<?='sup'.$site->nom_site.$j;?>" tabindex="-1" role="dialog" aria-labelledby="<?='#sup'.$site->nom_site.$j;?>" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="<?='#sup'.$site->nom_site.$j;?>">Suppression
                                                                                </h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <form method="post" action="../control/del_examen.php">
                                                                                <div class="modal-body">
                                                                                    <input type="hidden" name="id_examen" value="<?=$exam->id_examen;?>">
                                                                                    <button class="btn btn-danger">
                                                                                        <h3>
                                                                                            Voulez vous vraiment supprimer cet examen ?
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
                                                        <?php $j++; ?>
                                                    <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                $i++;
                                }
                                ?>
                            </div>
                            </div>
                    </div>                    
                </div>

                <!-- Tab Liste Users -->
                <div class="tab-pane fade" id="liste_attente">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Elèves en attente pour examen
                        </div>
                        <div class="panel-body">
                        <div style="text-align:center;"> 
                            <button type="button" id="test-2" class="btn btn-danger" data-toggle="modal" data-target="#test">examen</button>
                        </div>
                            <table width="100%" class="table table-striped table-bordered table-hover" id="tables-examen">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prénoms</th>
                                        <th>Date de naissance</th>
                                        <th>Lieu de naissance</th>
                                        <th>Catégorie</th>
                                        <th>Agence</th>
                                        <th></th>                                       
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach ($elev as $ev){
                                        ?>
                                        <tr>
                                            <td><?= $ev['nom'] ?></td>
                                            <td><?= $ev['prenom'] ?></td>
                                            <td><?= date('d/m/Y',strtotime($ev['dob'])) ?></td>
                                            <td><?= $ev['pob'] ?></td>
                                            <td><?= $ev['categorie'] ?></td>
                                            <td><?= $ev['agence'] ?></td>
                                            <td><input type="checkbox" class="form-group check"	id="<?= $ev['id_eleve'] ?>"></td>
                                        </tr>
                                <?php
                                    }

                                ?>
                                                                 
                                </tbody>
                            </table>   
                            <!-- Modal -->
                            <div class="modal fade" id="test" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                                <div class="modal-body">
                                                    <form role="form" id="formAffecter">
                                                    <div class="form-group">
                                                        <label>Examen à Choisir</label>
                                                        <select id="examen" class="form-control" name="id_examen" required>                       
                                                            <?php 
                                                                $exams = Examen::afficherExamen();
                                                            ?>
                                                            <?php foreach ($exams as $exam) : ?>
                                                                <option></option>
                                                                <option  value="<?=$exam->id_examen?>">
                                                                    <?=$exam->type.' <=> '.date("d/m/Y",strtotime($exam->date_examen)).' <=> '.$exam->examinateur.' <=> '.$exam->desc_examen?>
                                                                </option>
                                                            <?php endforeach; ?>	

                                                        </select>
                                                    </div>                        
                                                </div>
                                                <div class="modal-footer">                           
                                                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                    <button type="submit" name="submit" class="btn btn-primary">Programmer</button>
                                                </div>                                                      
                                            </form>
                                        </div>
                                        </div>
                                    </div>                         
                                </div>
                            </div>                    
                        </div>

                <!-- Tab Liste Users -->
                <div class="tab-pane fade" id="liste_program">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Programme des examens à faire
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li ><a href="#codes" data-toggle="tab"><h4>Code</h4></a></li>
                                <?php

                                $sites = Examen::afficherSite();
                                $i=0;
                                foreach ($sites as $site){
                                    if($i == 0){
                                        ?>
                                        <li class="active"><a href="#sitee" data-toggle="tab"><h4><?= $site->nom_site ?></h4></a></li>
                                        <?php
                                    }else{
                                        ?>
                                        <li><a href="#sitess<?= $i ?>" data-toggle="tab"><h4><?= $site->nom_site ?></h4></a></li>
                                        <?php
                                    }
                                    $i++;
                                }
                                ?>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade" id="codes">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Liste des examens
                                        </div>
                                        <div class="panel-body">
                                            <table width="100%" class="table table-striped table-bordered table-hover" id="table-exam-codes">
                                                <thead>
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Type Examen</th>
                                                    <th>Date Examen</th>
                                                    <th>Description</th>
                                                    <th>Nombre de participants</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $exams = Examen::afficherExamenCode(); $j=1; ?>
                                                <?php
                                                foreach ($exams as $exam) : ?>
                                                    <tr class="odd gradeX">
                                                        <td><?=$j; ?></td>
                                                        <td><?=$exam->type; ?></td>
                                                        <td><?= date("d/m/Y",strtotime($exam->date_examen)) ?></td>
                                                        <td><?= $exam->desc_examen ?></td>
                                                        <td>
                                                            <?php
                                                            $part = Examen::afficherProgram($exam->id_examen);
                                                            echo $part[0]->nombre;
                                                            ?>
                                                        </td>
                                                        <td class="center">
                                                            <a title="Détail" class="btn btn-primary" href="index.php?page=program&id_examen=<?=$exam->id_examen;?>">
                                                                <span class="fa fa-pencil"></span>
                                                            </a>

                                                            <a title="Résultat" class="btn btn-success" href="index.php?page=resultat&id_examen=<?=$exam->id_examen;?>">
                                                                <span class="fa fa-table"></span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $j++; ?>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <!-- Tab Site-->
                                <?php
                                $i=0;
                                foreach ($sites as $site){
                                    if($i == 0){
                                        ?>
                                        <div class="tab-pane fade in active" id="sitee">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    Liste des examens
                                                </div>
                                                <div class="panel-body">
                                                    <table width="100%" class="table table-striped table-bordered table-hover" id="table-exam-pls-<?= $i?>">
                                                        <thead>
                                                        <tr>
                                                            <th>N°</th>
                                                            <th>Type Examen</th>
                                                            <th>Date Examen</th>
                                                            <th>Description</th>
                                                            <th>Nombre de participant</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $exams = Examen::afficherExamenSite($site->id_site); $j=1; ?>
                                                        <?php
                                                        foreach ($exams as $exam) : ?>
                                                            <tr class="odd gradeX">
                                                                <td><?=$j; ?></td>
                                                                <td><?=$exam->type; ?></td>
                                                                <td><?= date("d/m/Y",strtotime($exam->date_examen)) ?></td>
                                                                <td><?= $exam->desc_examen ?></td>
                                                                <td>
                                                                    <?php
                                                                    $part = Examen::afficherProgram($exam->id_examen);
                                                                    echo $part[0]->nombre;
                                                                    ?>
                                                                </td>
                                                                <td class="center">
                                                                    <a title="Détail" class="btn btn-primary" href="index.php?page=program&id_examen=<?=$exam->id_examen;?>">
                                                                        <span class="fa fa-pencil"></span>
                                                                    </a>

                                                                    <a title="Résultat" class="btn btn-success" href="index.php?page=resultat&id_examen=<?=$exam->id_examen;?>">
                                                                        <span class="fa fa-table"></span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php $j++; ?>
                                                        <?php endforeach; ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }else{
                                        ?>
                                        <div class="tab-pane fade" id="sitess<?= $i ?>">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    Liste des examens
                                                </div>
                                                <div class="panel-body">
                                                    <table width="100%" class="table table-striped table-bordered table-hover" id="table-exam-pls-<?= $i?>">
                                                        <thead>
                                                        <tr>
                                                            <th>N°</th>
                                                            <th>Type Examen</th>
                                                            <th>Date Examen</th>
                                                            <th>Description</th>
                                                            <th>Nombre de participants</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $exams = Examen::afficherExamenSite($site->id_site); $j=1; ?>
                                                        <?php foreach ($exams as $exam) : ?>
                                                            <tr class="odd gradeX">
                                                                <td><?=$j; ?></td>
                                                                <td><?=$exam->type; ?></td>
                                                                <td><?= date("d/m/Y",strtotime($exam->date_examen)) ?></td>
                                                                <td><?= $exam->desc_examen ?></td>
                                                                <td>
                                                                    <?php
                                                                    $part = Examen::afficherProgram($exam->id_examen);
                                                                    echo $part[0]->nombre;
                                                                    ?>
                                                                </td>
                                                                <td class="center">
                                                                    <a title="Détail" class="btn btn-primary" href="index.php?page=program&id_examen=<?=$exam->id_examen;?>">
                                                                        <span class="fa fa-pencil"></span>
                                                                    </a>

                                                                    <a title="Résultat" class="btn btn-success" href="index.php?page=resultat&id_examen=<?=$exam->id_examen;?>">
                                                                        <span class="fa fa-table"></span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php $j++; ?>
                                                        <?php endforeach; ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    $i++;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Liste Users -->
                <div class="tab-pane fade" id="liste_terminer">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Tous les Elève qui ont terminé leur examen                            
                        </div>
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="table-exam-ter">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Nom</th>
                                        <th>Prénoms</th>
                                        <th>Contact</th>                                        
                                        <th>Catégorie</th>                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($els as $el) : ?>
                                    <tr class="odd gradeX">
                                        <td><?=$k; ?></td>
                                        <td><?=$el->nom; ?></td>
                                        <td><?=$el->prenom; ?></td>
                                        <td><?=$el->contact; ?></td>                                        
                                        <td><?=$el->categorie; ?></td>                                       
                                        <td class="center">                                    
                                            <a title="Détail" class="btn btn-primary" href="index.php?page=eleve_examen&id_eleve=<?=$el->id_eleve ; ?>">
                                              <span class="fa fa-pencil"></span>
                                            </a>
                                        </td>                                        
                                    </tr>
                                    <?php $k++; ?> 
                                    <?php endforeach; ?>                                      
                                </tbody>
                            </table>                            
                        </div>
                    </div>                    
                </div>

                <!-- Tab Liste Users -->
                <div class="tab-pane fade " id="sitess">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ajouter un site
                        </div>
                        <div class="panel-body">
                            <form role="form" id="formulaire_site">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Nom</label>
                                        <input id="site" type="text" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn-lg btn-primary">Ajouter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>            
        </div>        
    </div>    
</div>
<div id="comment"></div>

<script type="text/javascript">

    $(document).ready(function () {
		var fonction = <?php echo json_encode($_SESSION['fonction']); ?>;

        var dataTables = $('#tables-examen').DataTable({
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
			"info":( fonction === 'administrateur') ? true : false, // Désactive l'affichage du nombre d'éléments
			"lengthChange": ( fonction === 'administrateur') ? true : false, // Désactive la pagination
			"pageLength": ( fonction === 'administrateur') ? 10 : 50, // Définit le nombre d'éléments par page
        });

        var table_exam_codes = $('#table-exam-codes').DataTable({
            "responsive":true,
            "paging":true,
        });

        var table_exam_pl_0= $('#table-exam-pl-0').DataTable({
            "responsive":true,
            "paging":true,
        });
        var table_exam_pl_1= $('#table-exam-pl-1').DataTable({
            "responsive":true,
            "paging":true,
        });
        var table_exam_pl_2= $('#table-exam-pl-2').DataTable({
            "responsive":true,
            "paging":true,
        });
        var table_exam_pl_3= $('#table-exam-pl-3').DataTable({
            "responsive":true,
            "paging":true,
        });

        var table_exam_pls_0= $('#table-exam-pls-0').DataTable({
            "responsive":true,
            "paging":true,
        });
        var table_exam_pls_1= $('#table-exam-pls-1').DataTable({
            "responsive":true,
            "paging":true,
        });
        var table_exam_pls_2= $('#table-exam-pls-2').DataTable({
            "responsive":true,
            "paging":true,
        });
        var table_exam_pls_3= $('#table-exam-pls-3').DataTable({
            "responsive":true,
            "paging":true,
        });
        var table_exam_code = $('#table-exam-code').DataTable({
            "responsive":true,
            "paging":true,
        });

        $('#agence_select').change(function () {
           window.location.href="index.php?page=examen&agence="+$(this).val();
        });

        $('#sit_form').hide();
        $('#type_examen').change(function(){
            if ($(this).val() == "code" )
                $('#sit_form').hide();
            else
                $('#sit_form').show();
        });

        //Get id on focus
        var data=[];
        $(document).on('focusout', '.check', function(){
            var id_eleve = $(this).attr("id");
            data.push({
                id:id_eleve,
            });
        });

        //Affecter les eleves
        $('#formAffecter').submit(function () {

            var id = $('#examen').val();
            $.post('../control/program_exam.php', {data:data,id:id}, function(response)
            {
                window.location.href = "index.php?page=examen";
            });

            return false;
        })

        // Save User
        $('#formulaire_examen').submit( function()
        {

			var $form = $(this);
			if ($form.data('submitting')) return false;
			$form.data('submitting', true);
			$form.find('button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Envoi...');

			var date = $('#date').val();
            var sites = $('#sit').val();
            var desc_examen = $('#desc_examen').val();
            var examinateur = '';
            var type_examen = $('#type_examen').val();

            $.post('../control/reg_examen.php', {date:date,examinateur:examinateur,type:type_examen,sites:sites,desc_examen:desc_examen}, function(response)
            {
                $('#comment').html(response);
                window.location.href = "index.php?page=examen";
            }).always(function() {
				$form.data('submitting', false);
				$form.find('button[type="submit"]').prop('disabled', false).html('Ajouter');
			});
            return false;
        });

        $('#formulaire_site').submit( function()
        {
			var $form = $(this);
			if ($form.data('submitting')) return false;
			$form.data('submitting', true);
			$form.find('button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Envoi...');

			var nom = $('#site').val();

            $.post('../control/reg_site.php', {nom:nom}, function(response)
            {
                $('#comment').html(response);
             	location.reload();
            }).always(function() {
				$form.data('submitting', false);
				$form.find('button[type="submit"]').prop('disabled', false).html('Ajouter');
			});
            return false;
        });
    });


</script>

