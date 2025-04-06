<?php include_once '../model/User.class.php' ; ?>

<div class="row">
    <div class="panel panel-default">
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li ><a href="#ajouter" data-toggle="tab"><h4>Ajouter</h4></a>
                </li>
                <li class="active"><a href="#liste" data-toggle="tab"><h4>Liste</h4></a>
                </li>                                                
            </ul>
            <div class="tab-content">
                <!-- Tab Ajouter user -->
                <div class="tab-pane fade" id="ajouter">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ajouter un nouvel utilisateur
                        </div>
                        <div class="panel-body">
                            <form role="form" id="formulaire_save">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Nom</label>
                                        <input id="nom_save" type="text" class="form-control" placeholder="Nom" required>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label>Prénom</label>
                                        <input id="prenom_save" type="text" class="form-control" placeholder="Prénom" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Nom Utilisateur</label>
                                        <input id="username_save" type="text" class="form-control" placeholder="Nom utilisateur" required>
                                        
                                    </div>      
                                </div>

                                <div class="col-lg-4">                    
                                    <div class="form-group">
                                        <label>Mot de passe</label>
                                        <input id="password_save" type="password" class="form-control" placeholder="Mot de passe" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Répéter le mot de passe</label>
                                        <input id="rpassword_save" type="password" class="form-control" placeholder="Répéter" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Fonction</label>
                                        <select id="fonction_save" class="form-control" required>
                                           <option value="secretaire">secretaire</option>
                                           <option value="manager">gérant</option>
											<option value="administrateur">administrateur</option>
                                        </select>
                                    </div>           

                                </div> 
                                <div class="col-lg-4"><br><br><br><br><br>
                                    <div class="form-group">
                                        <button type="submit" class="btn-lg btn-primary">Ajouter</button>        
                                    </div>        
                                </div>            
                            </form>
                            
                        </div>
                    </div>
                    
                </div>
                <!-- Tab Liste Users -->
                <div class="tab-pane fade in active" id="liste">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Tous les Utilisateur
                        </div>
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Nom</th>
                                        <th>Prénoms</th>
                                        <th>Username</th>
                                        <th>Fonction</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $users = User::afficher(); $i=1; ?>
                                    <?php foreach ($users as $user) : ?>
                                    <tr class="odd gradeX">
                                        <td><?=$i; ?></td>
                                        <td><?=$user->nom_user; ?></td>
                                        <td><?=$user->prenom_user; ?></td>
                                        <td><?=$user->username; ?></td>
                                        <td><?=$user->fonction; ?></td>
                                        <td class="center">
                                            <!-- Modal must dynam and script -->
                                            <button title="Supprimer" type="button" class="btn btn-danger" data-toggle="modal" data-target="<?='#mod'.$i;?>">
                                              <span class="fa fa-trash"></span>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="<?='mod'.$i;?>" tabindex="-1" role="dialog" aria-labelledby="<?='#mod'.$i;?>" aria-hidden="true">
                                              <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="<?='#mod'.$i;?>">
                                                      Supprimer <b><?=$user->nom_user.' '.$user->prenom_user.' '.$user->id_user; ?></b>
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <form method="post" action="../control/del_user.php">
                                                      <div class="modal-body">                           
                                                        <input type="hidden" name="id_user" value="<?=$user->id_user;?>">
                                                        <button class="btn btn-danger">
                                                        <h3>
                                                            Voulez vous vraiment supprimer cet utilisateur ?                                                 
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
                                            <a title="Détail" class="btn btn-primary" href="index.php?page=de_utilisateur&id_user=<?=$user->id_user;?>">
                                              <span class="fa fa-table"></span>
                                            </a>
                                        </td>                                        
                                    </tr>
                                    <?php $i++; ?> 
                                    <?php endforeach; ?>                                      
                                </tbody>
                            </table>                            
                        </div>
                    </div>                    
                </div>               
            </div>            
        </div>        
    </div>    
</div>
<div id="comment"></div>

<script type="text/javascript">
    // Save User 
    $('#formulaire_save').submit( function()
        {
			var $form = $(this);
			if ($form.data('submitting')) return false;
			$form.data('submitting', true);
			$form.find('button[type="submit"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Envoi...');


			var nom = $('#nom_save').val();
              var prenom = $('#prenom_save').val();
              var username = $('#username_save').val();
              var fonction = $('#fonction_save').val();
              var password = $('#password_save').val();
              var rpassword = $('#rpassword_save').val();
              if (password === rpassword) 
              {
                $.post('../control/reg_user.php', {nom:nom,prenom:prenom,username:username,fonction:fonction,password:password}, function(response)
                {
                    $('#nom_save').val('');
                    $('#prenom_save').val('');
                    $('#username_save').val('');                    
                    $('#password_save').val('');
                    $('#rpassword_save').val('');

                    $('#comment').html(response);

                }).always(function() {
					$form.data('submitting', false);
					$form.find('button[type="submit"]').prop('disabled', false).html('Ajouter');
				});

              }
              else
              {
                swal("Erreur!", "Les Mots de passe ne correspondent pas !", "error");
                //alert('Les mots de passe ne correspondent pas !!!');
              }    

           return false;         

        });

</script>

<!-- <script type="text/javascript">
    // Update User 
    $('#formulaire_up').submit( function()
        {
          var nom = $('#nom_up').val();
          var prenom = $('#prenom_up').val();
          var username = $('#username_up').val();
          var fonction = $('#fonction_up').val();              
          var id = $('#id_user_up').val();
            $.post('../control/up_user.php', {nom:nom,prenom:prenom,username:username,fonction:fonction,id:id}, function(response)
            {
                window.location.href = "index.php?page=utilisateur";
                $('.comment_up').html(response);
            });                 

           return false;         

        });

</script> -->