<?php

require '../../dompdf/vendor/autoload.php';
include_once "../../model/Examen.class.php";
include_once "../../model/Eleve.class.php";
$examens = Examen::afficherParticipantExamenOne($_GET['id_examen']);

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->set_option('isHtml5ParserEnabled', true);
ob_start();
?>

    <div class="container">
        <img  src="head.jpg" width="100 %" >
        <h2 class="title1">Examen de <?= $examens[0]->type ?></h2>
        <br>
        <br>
        <p class="dt">Date: <?= date("d/m/Y",strtotime($examens[0]->date_examen)) ?></p>
        <table class="table">
            <thead class="title">
            <tr>
                <th>N°</th>
                <th>Nom et Prénoms</th>
                <th>Date et Lieu de Naissance</th>
                <th>Catégorie</th>
                <th>Résultat</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $j=1;
            foreach ($examens as $exam)
            {?>
                <tr>
                    <td class="num"><?= $j ?></td>
                    <td class="info"><?php echo $exam->nom.' '.$exam->prenom ; ?></td>
                    <td class="info"><?php echo date("d/m/Y",strtotime($exam->dob)).' à '.$exam->pob; ?></td>
                    <td class="info"><?php echo $exam->categorie; ?></td>
                    <td class="info"><?php echo $exam->resultat; ?></td>
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
            font-size: 14px;
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
    </style>


<?php
$html = ob_get_clean();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("Examen.pdf",array('Attachment'=>0));
