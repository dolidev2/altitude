<?php 
    session_start(); 
?>
<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Altitude Auto Ecole</title>
    <!--Favicon-->
    <link rel="shortcut icon" type="image/x-icon" href="../public/particles/favicon.png">

    <!-- Bootstrap Core CSS -->
    <link href="../public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Sweat alert -->
    <link rel="stylesheet" type="text/css" href="../public/sweat_allert/sweetalert.css" media="screen" />

    <!-- DataTables CSS -->
    <link href="../public/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../public/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../public/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../public/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="../public/vendor/jquery/jquery.js"></script> 

    <!-- Morris Charts CSS -->
    <link href="../public/vendor/morrisjs/morris.css" rel="stylesheet">    

    <!-- Custom Fonts -->
    <link href="../public/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="../public/vendor/jquery/jquery.dataTables.min.css">
    
    <script src="../public/vendor/jquery/jquery-1.12.4.js"></script>
 
</head>

<body>

    <?php        

    /* Le page demandée si il n'ya pas de get , envoie home.php*/
    $page = isset($_GET['page']) ? $_GET['page'] : 'accueil';


    ob_start();

    /* INCLUSION DES PAGES  */

    switch ($page) {
        case 'home':
            require_once 'page/accueil.php';
            break;

        case 'eleve':
            require_once 'page/eleve.php';
            break;

        case 'de_eleve':
            require_once 'page/de_eleve.php';
            break;

        case 'up_eleve':
            require_once 'page/up_eleve.php';
            break;

        case 'up_caisse':
            require_once 'page/up_caisse.php';
            break;

        case 'dossier':
            require_once 'page/dossier.php';
            break;

        case 'examen':
            require_once 'page/examen.php';
            break;

        case 'caisse':
            require_once 'page/caisse.php';
            break;

        case 'cl_caisse':
            require_once 'page/cloture.php';
            break;

        case 'de_examen':
            require_once 'page/de_examen.php';
            break;
            
       case 'program':
            require_once 'page/program.php';
            break;

       case 'de_caisse':
            require_once 'page/de_caisse.php';
            break;

        case 'de_versement':
            require_once 'page/versement.php';
            break;

        case 'eleve_examen':
            require_once 'page/eleve_examen.php';
            break;

        case 'paiement':
            require_once 'page/paiement.php';
            break;        

        case 'statistique':
            require_once 'page/statistique.php';
            break;

        case 'utilisateur':
            require_once 'page/utilisateur.php';
            break;

        case 'de_utilisateur':
            require_once 'page/de_utilisateur.php';
            break;       

        case 'configuration':
            require_once 'page/configuration.php';
            break;

        case 'bordereau':
            require_once 'page/bordereau.php';
            break;

        case 'historique':
            require_once 'page/historique.php';
            break;

        case 'ajouter':
        require_once 'page/ajouter_eleve.php';
        break;

        case 'resultat':
            require_once 'page/resultat.php';
            break;
            
        case 'eleve_detail':
            require_once 'page/eleve_detail.php';
            break;

        case 'examen_modifier':
            require_once 'page/examen_modifier.php';
            break;        

        case 'recette_modifier':
                require_once 'page/recette_modifier.php';
                break;
        
        case 'ajax':
                require_once '../model/Ajax/eleve/tableEleveReinscrire.php';
                break;
        default:
            require_once 'page/accueil.php';
            break;
    }


    $contenu = ob_get_clean();

    /*INCLUSION DES FICHIERS GLOBALS*/

    include_once '../config/config.php';

    ?>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top nav-fixed"  role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><?=$config['NOM'];?></a>
                <a class="navbar-brand" href="#"><?=$config['NUMERO'];?></a>
                <a class="navbar-brand" href="#"><?=$config['LOCATION'];?></a>
                <a class="navbar-brand" href="#"><?=$config['EMAIL'];?></a>             
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">           
            
               
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="index.php?page=de_utilisateur&id_user=<?=$_SESSION['id'];?>">
                                <i class="fa fa-user fa-fw"></i>
                                <?=$_SESSION['nom'].' '.$_SESSION['prenom'];?>
                            </a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i>Utilisateurs </a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="../control/logout.php"><i class="fa fa-sign-out fa-fw"></i> Se Déconnecter</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.php">
                                <i class="fa fa-home fa-fw"></i>
                                Accueil
                            </a>
                        </li>
                        <li>
                            <a href="index.php?page=eleve">
                               <i class="fa fa-bar-chart-o fa-fw"></i>
                               Elèves
                            </a>
                            
                        </li>
                        <!-- <li>
                            <a href="index.php?page=paiement">
                                <i class="fa fa-table fa-fw"></i> Paiement</a>
                        </li> -->                        
                        <li>
                            <a href="index.php?page=examen">
                                <i class="fa fa-wrench fa-fw"></i> Examens</a>
                            
                        </li>
                        <li>
                            <a href="index.php?page=caisse">
                                <i class="fa fa-money fa-fw"></i> Caisse</a>

                        </li>
						<?php if ($_SESSION['fonction'] == 'administrateur' || $_SESSION['fonction'] == 'manager'):  ?>
							<li>
                            <a href="index.php?page=historique">
                                <i class="fa fa-files-o fa-fw"></i> Historique</a>
                        	</li>
                            <li>
                                <a href="index.php?page=utilisateur">
                                    <i class="fa fa-sitemap fa-fw"></i> Utilisateur</a>
                            </li>
                    <?php endif; ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
    </nav>  
    <div id="page-wrapper">
        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"> <?=$page;?> </h1>
                </div>
                <!-- /.col-lg-12 -->
        </div>

        <div class="row"> <?=$contenu;?> </div>
    </div>    

    <!-- Sweetalert -->
    <script src="../public/sweat_allert/sweetalert.min.js"></script>    

    <!-- Bootstrap Core JavaScript -->
    <script src="../public/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../public/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../public/dist/js/sb-admin-2.js"></script>

    <!-- Sweat alert -->
    <script src="../public/sweat_allert/sweetalert.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../public/vendor/raphael/raphael.min.js"></script>
    <script src="../public/vendor/morrisjs/morris.min.js"></script>
    <script src="../public/data/morris-data.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../public/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../public/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../public/vendor/datatables-responsive/dataTables.responsive.js"></script>
    
    <script>



    </script>       
</body>
</html>

