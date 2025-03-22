<?php
include_once'../model/Examen.class.php';
include_once'../model/Eleve.class.php';

include_once'../model/Programation.class.php';

$exam = Examen::afficherOne($_GET['id_examen']);
$reds = Eleve::afficherCours();
$elev = Eleve::afficherCoursExpire($reds);
?>
<div class="col col-lg-12">
    <div class="panel-body" style="overflow: scroll;height: 700px;">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
            <div class="panel-header">
                <h4>Liste de Tous les élèves programmés à cet examen</h4>
                <div class="row">
                    <!-- <div class="col-lg-3">
                        <form method="post" action="../control/upload_csv.php" enctype="multipart/form-data">
                            <input type="file" name="file" required="" >
                            <input type="hidden" name="id_examen" value="<?=$_GET['id_examen']?>">
                            <input type="submit" name="submit" class="btn btn-primary" value="Charger">
                        </form>

                    </div>-->
                    <div class="col-lg-1"></div>

                    <div class="col-lg-8">
                        <div class="row">

                            <form role="form" action="../public/pdf/programdom.php">
                                <div class="form-group col-lg-3">
                                    <label>Véhicule :  <span style="color: red">*</span></label>
                                    <input class="form-control" type="text" name="vehicule"  />
                                </div>
                                <div class="form-group col-lg-3">
                                    <input type="hidden" name="id_examen" value="<?=$_GET['id_examen']?>">
                                    <button type="submit" class="btn btn-lg btn-warning">
                                        <span class="fa fa-print"></span>
                                        Imprimer
                                    </button>
                                </div>
                            </form>
                            <div>
                                <button type="submit" data-toggle="modal" data-target="#ajouter" class="btn btn-lg btn-primary">
                                    <span class="fa fa-pencil"></span>
                                    Ajouter
                                </button>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-responsive table-bordered table-hover">

            <thead>
            <tr>
                <th>N°</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Type Examen</th>
                <th>Date de naissance</th>
                <th>Lieu de naissance</th>
                <th>Agence</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $eleves = Examen::afficherParticipantProgram($_GET['id_examen']); $j=1; ?>
            <?php foreach ($eleves as $eleve) : ?>
                <tr>
                    <td align="center"><b><?=$j?></b></td>
                    <td align="center"><b><?=$eleve->nom ; ?></b></td>
                    <td align="center"><b><?=$eleve->prenom ; ?></b></td>
                    <td align="center"><b><?=$eleve->type ; ?></b></td>
                    <td align="center"><b><?= date("d-m-Y", strtotime($eleve->dob)) ; ?></b></td>
                    <td align="center"><b><?=$eleve->pob ; ?></b></td>
                    <td align="center"><?=$eleve->nom_agence ; ?></td>
                    <td>
                        <!-- Modal must dynam and script -->
<!--                        --><?php //if ($_SESSION['fonction'] == 'administrateur') {  ?>
                            <button title="Supprimer" type="button" class="btn btn-danger" data-toggle="modal" data-target="<?='#mod'.$eleve->id_eleve;?>">
                                <span class="fa fa-trash"></span>
                            </button>
<!--                        --><?php //} ?>

                        <!-- Modal -->
                        <div class="modal fade" id="<?='mod'.$eleve->id_eleve;?>" tabindex="-1" role="dialog"  aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" >
                                            Supprimer <b><?=$eleve->nom.' '.$eleve->prenom; ?></b>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" action="../control/del_eleve_program.php">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_program" value="<?=$eleve->id_program;?>">
                                            <input type="hidden" name="id_examen" value="<?=$eleve->id_examen;?>">
                                            <button class="btn btn-danger">
                                                <h3>
                                                    Voulez vous vraiment supprimer cet élève ?
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
                <?php $j++; endforeach; ?>

            <!-- Programation -->
            <?php $programs = Programation::afficher($_GET['id_examen']); ?>
            <?php foreach ($programs as $program) : ?>

                <tr>
                    <td align="center"><b><?=$j?></b></td>
                    <td align="center"><b><?=$program->nom ; ?></b></td>
                    <td align="center"><b><?=$program->prenom ; ?></b></td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center"><?=$program->agence ; ?></td>
                    <td>

                        <!-- Modal must dynam and script -->
                        <?php if ($_SESSION['fonction'] == 'administrateur') {  ?>
                            <button title="Supprimer" type="button" class="btn btn-danger" data-toggle="modal" data-target="<?='#mod'.$program->id_programation;?>">
                                <span class="fa fa-trash"></span>
                            </button>
                        <?php } ?>

                        <!-- Modal -->
                        <div class="modal fade" id="<?='mod'.$program->id_programation;?>" tabindex="-1" role="dialog"  aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" >
                                            Supprimer <b><?=$program->nom.' '.$program->prenom; ?></b>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" action="../control/del_programation.php">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_programation" value="<?=$program->id_programation;?>">
                                            <input type="hidden" name="id_examen" value="<?=$_GET['id_examen'];?>">
                                            <button class="btn btn-danger">
                                                <h3>
                                                    Voulez vous vraiment supprimer cet élève ?
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

                <?php $j++; endforeach; ?>


            </tbody>
        </table>
    </div>
</div>
<div id="ajouter" class="modal fade" role="dialog" >
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Choisir les élèves à insérer</h4>
                <h5 style="color: red;"> Cochez la case de l'élève à sélectionner </h5>
            </div>
            <?php
           
            ?>
            <form id="formExamen">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table" class="table table-striped table-bordered table-hover" id="tables-examen">
                            <thead class="title">
                            <tr>
                                <th>Nom </th>
                                <th>Prénoms </th>
                                <th>Date de Naissance</th>
                                <th>Lieu de Naissance</th>
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
                        <div class="modal-footer">
                            <input type="hidden" id="examen" value="<?= $_GET['id_examen'] ?>">
                            <button type="submit" class="btn btn-success">Valider</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                        </div>
                    </form>
                 </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
		var fonction = <?php echo json_encode($_SESSION['fonction']); ?>;
        //Get id on focus
        var data=[];
        $(document).on('focusout', '.check', function(){
            var id_eleve = $(this).attr("id");
            data.push({
                id:id_eleve,
            });
        });

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
			"pageLength":  10 // Définit le nombre d'éléments par page

        });


        //Submit form 
        $('#formExamen').submit(function () {

            var exam = $('#examen').val();
            $.post('../control/add_prog_eleve.php', {data:data,exam:exam}, function(response)
            {
                window.location.href = "index.php?page=program&id_examen="+exam;
            });

            return false;
        });

    });
</script>