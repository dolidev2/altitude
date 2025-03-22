<?php

require '../../dompdf/vendor/autoload.php';
include_once "../../model/Examen.class.php";
include_once "../../model/Eleve.class.php";
include_once'../../model/Programation.class.php';

$Examens = Examen::afficherParticipantResultat($_GET['id_examen']);

$infos = Examen::afficherExamenOne($_GET['id_examen']);

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->set_option('isHtml5ParserEnabled', true);

//Fusion des deux tableaux Examen et Program
$merge_program = $Examens;
//Concatenation des deux tableaux dans un nouveau tableau to_short
$to_short = [];
for ($n=0; $n < count($merge_program); $n++) {
    $to_short += [ $merge_program[$n]->dob.'*'.$merge_program[$n]->pob.'*'.$merge_program[$n]->categorie => $merge_program[$n]->nom.'*'.$merge_program[$n]->prenom.'*'.$merge_program[$n]->resultat.'*'.$merge_program[$n]->type_examen];
}
//Tri et organise le tableau par ordre croissant insensible à la case
natcasesort($to_short);

ob_start();
?>
    <head>
        <!--Favicon-->
        <link rel="shortcut icon" type="image/x-icon" href="../particles/logo.PNG">
    </head>
    <div class="container">
        <img  src="head.jpg" width="100 %" >
        <h2 class="title1">Résultat de l'examen de <?= $infos[0]->type ?></h2>

        <p class="dt">Date examen: <?= date("d/m/Y",strtotime($infos[0]->date_examen)) ?></p>
        <table class="table table-responsive">
            <thead class="title">
            <tr>
                <th>N°</th>
                <th>Nom et Prénoms</th>
                <th>Date et Lieu de Naissance</th>
                <th>Catégorie</th>
                <th>Résultat</th>
                <th>Examen</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $j=1;
            foreach ($to_short as $key => $value){
                ?>
                <tr>
                    <td class="num"><?= $j ?></td>
                    <td class="info"><?php echo explode('*', $value)[0].' '.explode('*', $value)[1] ; ?></td>
                    <td class="info"><?php echo date("d/m/Y",strtotime(explode('*', $key)[0])).' à '.explode('*', $key)[1]; ?></td>
                    <td class="info"><?php echo explode('*', $key)[2]; ?></td>
                    <td class="info"><?php echo explode('*', $value)[2]; ?></td>
                    <td style="text-align:center"><?php echo explode('*', $value)[3]; ?></td>
                </tr>
                <?php
                $j++;
            }
            ?>
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-offset-9">
                <p class="sign">Le Directeur</p>
            </div>
        </div>
		<div class="footer">
			<img  src="foot.jpg" width="100 %" >
		</div>
    </div>

    <style>
		.footer {
			width: 100%;
			text-align: center;
			position: fixed;
			height: 50px;
			bottom: 0px;
		}
        .title{
            text-align: center;
            font-weight:bold;
            font-size: 16px;
        }
        .title1{
            text-align: center;
            text-decoration: underline;
            font-weight:bold;
            text-transform: capitalize;
            text-transform: uppercase;
            font-size: 18px;
        }
        .info{
            text-transform: uppercase;
            text-align: left;
            font-size: 16px;
            padding-left: 5px;
        }
        p{
            font-weight: bold;
        }
        .sign{
            text-decoration: underline;
            text-align: right;
            margin-right: 100px;

        }
        table{
            width: 100%;
        }
        th{
            text-align: center;
        }

        table,th, td {
            border: 1px solid black;
            border-collapse: collapse;

        }
        .num{
            text-align: center;
        }
        .space{
            padding-left: 150px;
        }
        .footer{
            position: fixed;
            bottom: -40px;
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;
            text-decoration: underline;
        }
    </style>
<?php
$html = ob_get_clean();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("Programmation.pdf",array('Attachment'=>0));
