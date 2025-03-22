<?php include_once '../model/Eleve.class.php' ; ?>
<div class="row">
	<?php if($_SESSION['fonction'] == 'administrateur' || $_SESSION['fonction'] == 'manager'): ?>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-group fa-5x"></i>
                    </div>
                    <?php
                        $all = Eleve::countAll();
                        $cours = Eleve::countCours();
                        $permi = Eleve::countPermi();
                     ?>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$all[0]->nombre ; ?></div>
                        <div>Elèves</div>
                    </div>
                </div>
            </div>
            <a href="index.php?page=eleve">
                <div class="panel-footer">
                    <span class="pull-left">Voir Détails</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$cours[0]->nombre ; ?></div>
                        <div>En cours</div>
                    </div>
                </div>
            </div>
            <a href="index.php?page=eleve">
                <div class="panel-footer">
                    <span class="pull-left">Voir Détails</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
	<?php endif; ?>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-support fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=$permi[0]->nombre ; ?></div>
                        <div>Permis Obtenu</div>
                    </div>
                </div>
            </div>
            <a href="index.php?page=eleve">
                <div class="panel-footer">
                    <span class="pull-left">Voir Détails</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-clock-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?=date('H:i') ; ?></div>
                        <div><?=date('d-m-Y') ; ?></div>
                    </div>
                </div>
            </div>
            <a href="index.php">
                <div class="panel-footer">
                    <span class="pull-left">Actualiser</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- DATA TABLES -->
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                10 derniers inscrits
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom</th>
                            <th>Prénoms</th>
                            <th>Contact</th>
                            <th>Forfait</th>
                            <th>Catégorie</th>
                            <th>Profession</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php $pupil = Eleve::afficher10dernier(); ?>
                <?php foreach ($pupil as $pup) : ?>
                        <tr class="odd gradeX">
                            <td><?=$pup->matricule; ?></td>
                            <td><?=$pup->nom; ?></td>
                            <td><?=$pup->prenom; ?></td>
                            <td><?=$pup->contact; ?></td>
                            <td><?=$pup->forfait; ?></td>
                            <td><?=$pup->categorie; ?></td>
                            <td><?=$pup->profession; ?></td>
                            <td class="center">                                    
                                <a title="Détail" class="btn btn-primary" href="index.php?page=de_eleve&id_eleve=<?=$pup->id_eleve;?>">
                                  <span class="fa fa-pencil"></span>
                                </a>
                            </td>                                        
                        </tr>
                        <?php endforeach; ?>                                      
                    </tbody>
                </table>                           
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->