<?php

require '../../dompdf/vendor/autoload.php';
include_once("../../model/Paiement.class.php");
include_once("../../model/Eleve.class.php");

$recu = Paiement::afficherEleve($_GET['id_paiement']);
$eleve = Eleve::afficherOne($recu[0]->eleve);

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->set_option('isHtml5ParserEnabled', true);
ob_start();
?>

    <div class="container">
        <img  src="head.jpg" width="100 %" >
        <h2 class="title1">Reçu de Paiement de :  <?= $recu[0]->type ?></h2>
        <p>Reçu de : <?= $recu[0]->nom.' '.$recu[0]->prenom ?> <span class="center">Solde: <?=$eleve[0]->solde ?></span> <span class="right">Catégorie : <?= $recu[0]->categorie ?></span></p>
        <p>N° Reçu : <?= $recu[0]->numero ?> <span class="right">Réliquat :  <?= $_GET['r']?></span></p>
        <br>
       <table class="table">
            <thead class="title">
            <tr>
                <th>N° Reçu</th>
                <th>Date de Paiement</th>
                <th>Somme versée</th>
                <th>Désignation</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $hists = Paiement::afficher($_GET['id_eleve']);
            foreach ($hists as $hist)
            {?>
                <tr>
                    <td class="num"><?= $hist->numero ?></td>
                    <td class="info"><?= date('d/m/Y',strtotime($hist->date_paiement))  ?></td>
                    <td class="info somme"><?= $hist->somme ?></td>
                    <td class="info"><?= $hist->type ?></td>
                </tr>
                <?php
             }
            ?>
            </tbody>
        </table>
        <br>
        <span class="valid">*Validité de l'inscription 08 mois à compter du <?=date('d/m/Y',strtotime( $eleve[0]->dor)) ?></span>
        <br>
        <p class="frais">*NB: Les frais versés sont non remboursables.</p>
        <p>Ouagadougou, le <?= date('d/m/Y')?> <span class="right">Caisse</span></p>
        <br>
        <br>
        <p>------------------------------------------------------------------------------------------------------------------------------------</p>
    </div>


    <style>
        .frais{
            color:red;
            font-size: 10;
        }
        .valid{
            font-size: 10;
        }
        .center {
            padding-left: 125px;
        }
        .title{
            text-align: center;
            font-weight:bold;
            font-size: 16px;
        }
        .title1{
            text-align: center;
            font-weight:bold;
            text-transform: capitalize;
            text-transform: uppercase;
            font-size: 18px;
            border: 1 px solid black;
        }
        .info{
            text-transform: uppercase;
            text-align: left;
            font-size: 14px;
            padding-left: 5px;
        }
        p{
            font-weight: bold;
            padding-bottom: -13px;
        }

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
        .right{
            float: right;
            margin-right: 150px;
        }
        .somme{
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
$dompdf->stream("Recu.pdf",array('Attachment'=>0));
