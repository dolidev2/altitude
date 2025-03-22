<?php

require '../../dompdf/vendor/autoload.php';
include_once("../../model/Bordereau.class.php");
include_once("../../model/Eleve.class.php");

$depot = Bordereau::afficherBoredereauParticipant($_GET['bordereau']);

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->set_option('isHtml5ParserEnabled', true);

$data = [];

foreach ($depot as $dt) {
    $item = array(
        'nom'=> $dt->nom,
        'prenom'=> $dt->prenom,
        'dob'=> $dt->dob,
        'pob'=> $dt->pob,
        'categorie'=> $dt->categorie,
    );
    array_push($data, $item);
}
//Tri et organise le tableau par ordre croissant insensible à la case
asort($data);

ob_start();
?>
    <div class="container">
        <img  src="head.jpg" width="100 %" >
        <h2 class="title1">Bordereau de dépôt</h2>
        <br>
        <p class="dt">Date de dépôt: <?= date("d/m/Y",strtotime($depot[0]->date_depot)) ?></p>
        <table class="table">
            <thead class="title">
            <tr>
                <th>N°</th>
                <th>Nom et Prénoms</th>
                <th>Date et Lieu de Naissance</th>
                <th>Catégorie</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $j=1;
            foreach ($data as $dt){
                ?>
                <tr>
                    <td class="num"><?= $j ?></td>
                    <td class="info"><?= $dt['nom'].' '. $dt['prenom'] ?></td>
                    <td class="info"><?= date("d/m/Y",strtotime($dt['dob'])).' à '.$dt['pob']; ?></td>
                    <td class="info"><?= $dt['categorie'] ?></td>
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
        .space{
            padding-left: 150px;
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
$dompdf->stream("Bordereau_depot.pdf",array('Attachment'=>0));
