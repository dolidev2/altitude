<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Connexion</title>
    <!--Favicon-->
    <link rel="shortcut icon" type="image/x-icon" href="public/particles/logo.png">


    <link rel="stylesheet" type="text/css" href="public/sweat_allert/sweetalert.css" media="screen" />

    <!-- Bootstrap Core CSS -->
    <link href="public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="public/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="public/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="public/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Particle CSS -->
    <link href="public/particles/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="particles-js">   
    <div class="container">
        <div class="row"  >
            <div  class="col-md-4 col-md-offset-4"  >
                <div  class="login-panel panel panel-default" >
                    <div class="panel-heading">
                        <h3 class="panel-title">Connexion</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" id="formulaire">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Utilisateur" id="username" type="text" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Mot de passe" id="password" type="password" required>
                                </div>
                                <button type="submit" class="btn btn-block btn-primary">Se Connecter</button>
                            </fieldset>
                        </form>
                    </div>   <div id="comment"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="public/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="public/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="public/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="public/dist/js/sb-admin-2.js"></script>

    <!-- Sweat alert -->
    <script src="public/sweat_allert/sweetalert.min.js"></script>

    <!-- Particles -->
    <script src="public/particles/particles.min.js"></script>
    <script src="public/particles/app.js"></script>

 
  <script type="text/javascript">
  	// LOGIN FORM CONTROLE AJAX
  	

  	$('#formulaire').submit( function()
		{
			var username = $('#username').val();
  			var password = $('#password').val();

			$.post('control/login.php', {username:username, password:password}, function(response)
				{
					$('#comment').html(response);					
				});
            
			return false;

		});

  </script>  
</body>

</html>

