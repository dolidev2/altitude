<?php 
    include_once'../model/Eleve.class.php'; 
    $eleve = Eleve::afficherOne($_GET['id_eleve']);
 ?>
<div class="col col-lg-6">
	<button class="btn btn-lg btn-primary"><?=$eleve[0]->nom.' '.$eleve[0]->prenom?></button>
    <a href="../public/pdf/carte.php?id=<?=$_GET['id_eleve']?>" target="_blank">
        <button class="btn btn-success" >Carte Conduite</button>
    </a>

	<div class="panel-body" style="overflow: scroll;height: 600px;"> 
		<table width="100%" class="table table-striped table-bordered table-hover" id="table_id">
		    <thead>
		        <tr>
		            <th> INFORMATION SUR L'ELEVE </th>
		            <th>VALEUR DE L'INFORMATION</th>
		        </tr>
		    </thead>
		    <tbody>
		      <tr>
		        <td align="right"><u><b>Matricule :</b></u></td>
		        <td><?=$eleve[0]->matricule?></td>
		      </tr> <tr>
		        <td align="right"><u><b>Nom :</b></u></td>
		        <td><?=$eleve[0]->nom?></td>
		      </tr>
		      <tr>
		        <td align="right"><u><b>Prénom :</b></u></td>
		        <td><?=$eleve[0]->prenom?></td>
		      </tr>
		      <tr>
		        <td align="right"><u><b>Contact :</b></u></td>
		        <td><?=$eleve[0]->contact?></td>
		      </tr>
		      <tr>
		        <td align="right"><u><b>Profession :</b></u></td>
		        <td><?=$eleve[0]->profession?></td>
		      </tr>
		      <tr>
		        <td align="right"><u><b>Agence :</b></u></td>
		        <td><?=$eleve[0]->nom_agence?></td>
		      </tr>
              <tr>
		        <td align="right"><u><b>Adresse :</b></u></td>
		        <td><?=$eleve[0]->adresse?></td>
		      </tr>
		      <tr>
		        <td align="right"><u><b>Date de naissance :</b></u></td>
		        <td><?= date('d/m/Y',strtotime($eleve[0]->dob)); ?></td>
		      </tr>
		      <tr>
		        <td align="right"><u><b>Lieu de naissance :</b></u></td>
		        <td><?=$eleve[0]->pob?></td>
		      </tr>
		      <tr>
		        <td align="right"><u><b>Sexe :</b></u></td>
		        <td><?=$eleve[0]->sexe?></td>
		      </tr>
		      <tr>
		        <td align="right"><u><b>Date d'Inscription :</b></u></td>
		        <td><?= date("d/m/Y",strtotime($eleve[0]->dor))?></td>
		      </tr>
		      <tr>
		        <td align="right"><u><b>Catégorie :</b></u></td>
		        <td><?=$eleve[0]->categorie?></td>
		      </tr>
		      <tr>
		        <td align="right"><u><b>Solde :</b></u></td>
		        <td><?=$eleve[0]->solde?></td>
		      </tr>
		      <tr>
		        <td align="right"><u><b>Forfait :</b></u></td>
		        <td><?=$eleve[0]->forfait?></td>
		      </tr>
              <tr>
		        <td align="right"><u><b>Recommandation :</b></u></td>
		        <td><?=$eleve[0]->recommandation?></td>
		      </tr>
		      <tr>
		        <td align="right"><u><b>Statut :</b></u></td>
		        <td>
		        	<?php
		        	     if ($eleve[0]->statut == 1) 
		        	     {
		        	     	echo '<span class="btn btn-success"><i class="fa fa-check"></i></span>';
		        	     }
		        	     else
		        	     {
		        	     	echo '<span class="btn btn-danger"><i class="fa fa-times"></i></span>';
		        	     }
		        	 ?>
		        </td>
		      </tr>		   
		    </tbody>
		</table>
	</div>	
</div>

<?php 
	include_once'../model/Paiement.class.php';
	$paiement = Paiement::afficher($eleve[0]->id_eleve);
	$total = Paiement::afficherTotalOne($eleve[0]->id_eleve);
	$som = $total[0]->total;
	if ($som == NULL) 
	{
		$som = 0;		
	}
	else
	{
		$som = floatval($som);
	}
	

 ?>

 <!-- Type Hidden for form use -->
<input type="hidden" id="solde" value="<?=$eleve[0]->solde?>">
<input type="hidden" id="id_eleve" value="<?=$eleve[0]->id_eleve?>">
<input type="hidden" id="total" value="<?=$som?>">

<div class="col col-lg-6">
	<div class="row">
		<div id="form_payer" class="panel-body" style="overflow: scroll;height: 350px;">
			<div class="panel-header">
				<h4>Effectuer Paiement</h4>
			</div>
			<?php if ($som == $eleve[0]->solde) { ?>
			 
			<button class="btn btn-lg btn-block btn-primary">Soldé</button>         
		       
            <?php }else { ?>
			<form role="form" id="formulaire_payer">
		        <div class="form-group">
		            <label>Somme</label>
		            <input id="somme_pai" type="number" class="form-control" required>
		        </div>
		        <div class="form-group">
		            <label>Type de Paiement</label>
		            <input id="type_pai" type="text" class="form-control" required>
		        </div>		        
		        <div class="form-group">		            
		            <input type="submit" class="form-control btn btn-success" value="Payer" required>
		        </div>		        
			</form>	
		   <?php } ?>

		</div>	<div id="comment"></div>

	</div>
	<div class="row">
	<div class="panel-body" style="overflow: scroll;height: 300px;"> 
		<table width="100%" class="table table-striped table-bordered table-hover" id="table_id">
			<div class="panel-header">
				<h4>Historique Paiement</h4>Reste à Payer
				<button class="btn btn-primary">
					<?php 
				 		$rel = ($eleve[0]->solde - $som);
				 		echo $rel;
				 	?>
				 </button><br>
			</div>
		    <thead>
		        <tr>
		            <th>N°</th>
		            <th>Somme</th>
		            <th>Date</th>
		            <th>Type</th>
		            <th>Action</th>
		        </tr>
		    </thead>
		    <tbody>
		    <?php $i=1; foreach ($paiement as $paie): ?>	
		      <tr>
		        <td align="center"><u><b><?=$paie->numero?></b></u></td>
		        <td align="center"><u><b><?=$paie->somme?></b></u></td>
		        <td align="center"><u><b><?=$paie->date_paiement?></b></u></td>
		        <td align="center"><u><b><?=$paie->type?></b></u></td>
		        <td>
                    <?php
                        if($_SESSION['fonction'] == 'administrateur' || $_SESSION['fonction'] == 'manager'):
                    ?>
		        	<span data-toggle="modal" data-target="<?='#mod'.$i;?>" title="Modifier" class="btn btn-primary">
		        		<i class="fa fa-pencil"></i>
		        	</span>
                    <?php  endif; ?>
		        	<!-- Modal -->
                    <div class="modal fade" id="<?='mod'.$i;?>" tabindex="-1" role="dialog" aria-labelledby="<?='#mod'.$i;?>" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="<?='#mod'.$i;?>">
                              Modifier Paiment</b>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
	                          <form method="post" action="../control/up_paiement.php">
	                          	<div class="form-group">
						            <label>Numéro Reçu</label>
						            <input readonly id="numero_pai" type="text" name="numero_pai" class="form-control" value="<?=$paie->numero ?>">
						        </div>
	                          	<div class="form-group">
						            <label>Date Paiement</label>
						            <input id="date_pai" type="date" name="date_paiement" class="form-control" value="<?=$paie->date_paiement?>">
						        </div>
						        <div class="form-group">
						            <label>Somme</label>
						            <input id="somme_pai" type="number" name="somme" class="form-control" value="<?=$paie->somme?>">
						        </div>
						        <div class="form-group">
						            <label>Type de Paiement</label>
						            <input id="type_pai" type="text" name="type" class="form-control" value="<?=$paie->type?>">
						        </div>	
						        <input type="hidden" name="id" value="<?=$eleve[0]->id_eleve?>">
						        <input type="hidden" name="id_paiement" value="<?=$paie->id_paiement?>">	        
						        <div class="form-group">		            
						            <input type="submit" class="form-control btn btn-primary" value="Modifier" required>
						        </div>
	                          </form>
	                        </div>  
                        </div>
                      </div>
                    </div>

                    <!-- Modal must dynam and script --> 
                    <?php if ($_SESSION['fonction'] == 'administrateur' || $_SESSION['fonction'] == 'manager'):  ?>
                    <button data-toggle="modal" data-target="<?='#sup'.$i;?>" class="btn btn-danger" title="Supprimer">
                    	<i class="fa fa-trash"></i>                    	
                    </button>
                    <?php endif; ?>

                    <!-- Modal -->
                    <div class="modal fade" id="<?='sup'.$i;?>" tabindex="-1" role="dialog" aria-labelledby="<?='#sup'.$i;?>" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="<?='#sup'.$i;?>">
                              Supprimer
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>                          
                              <div class="modal-body">                        
                                <button class="btn btn-danger">
                                <h3>
                                    Voulez vous vraiment supprimer ce réçu ?                                                 
                                </h3>
                                </button>                                      
                              </div>
                              <div class="modal-footer">                           
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">NON</button>
                                <a class="btn btn-primary" href="../control/del_paiement.php?id_paiement=<?=$paie->id_paiement;?>&id_eleve=<?=$eleve[0]->id_eleve?>">
			                        OUI
			                    </a>
                              </div>                  
                        </div>
                      </div>
                    </div>
		        	
		        	<a href="../public/pdf/recudom.php?r=<?=$rel?>&id_paiement=<?=$paie->id_paiement?>&id_eleve=<?=$eleve[0]->id_eleve?>" target="_blank" title="Imprimer" class="btn btn-warning">
		        		<i class="fa fa-print"></i>
		        	</a>		        			        	
		        </td>		        		        
		      </tr>
		    <?php $i++; endforeach; ?>  
		      
		      	   
		    </tbody>
		</table>
	</div>
		
	</div>
</div>


<script type="text/javascript">
    // Save User 
    $('#formulaire_payer').submit( function()
        {
              var somme = $('#somme_pai').val();
              var type = $('#type_pai').val();
              var id = $('#id_eleve').val(); 
              var solde =  $('#solde').val();              
              var total =  $('#total').val(); 

              if (parseFloat(parseFloat(total) + parseFloat(somme)) <= solde ) 
              {
              	$.post('../control/reg_paiement.php', {somme:somme,type:type,id:id}, function(response)
                {
                  $('#comment').html(response);
                     window.location.href="index.php?page=de_eleve&id_eleve="+id;
                });               
              }
              else
              {
              	swal("Erreur!", "Le total payé est supérieur au forfait !", "error");
              }                   
               
              
           return false;         

        });

</script>