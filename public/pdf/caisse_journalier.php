<?php

require '../../dompdf/vendor/autoload.php';
include_once("../../model/Caisse.class.php");

$date = $_GET['date'];

$depEntre = Caisse::readDayEntryCaisse($date);
$depSortie = Caisse::readDaySortyCaisse($date);


// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->set_option('isHtml5ParserEnabled', true);
ob_start();
?>

    <div class="container">
        <img  src="head.jpg" width="100 %" >
        <h2 class="title1">Clôture journalière <?= date("d/m/Y",strtotime($date))  ?></h2>

        <h4 class="title">Liste des entrées du jour</h4>
        <table class="table">
            <thead class="title">
            <tr>
                <th>N°</th>
                <th>Description</th>
                <th>Somme</th>
                <th>Compte</th>
                <th>Reste à Payer</th>
                <th>Mode Transaction</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $titre = 'Clôture journalière '. $date ;
            $j=1;
            $som=0;
            foreach ($depEntre as $dep)
            {?>
                <tr>
                    <td class="num"><?= $j ?></td>
                    <td class="info"><?= $dep->desc_caisse  ?></td>
                    <td class="info"><?= $dep->somme ?></td>
                    <td class="info"><?= $dep->compte ?></td>
                    <td class="info">
                        <?php if($dep->eleve!= '0'){
                            $solde = Caisse::Solde($dep->eleve);
                            echo $solde;
                        } else{
                            echo "";
                        }?>
                    </td>
                    <td class="info"><?= $dep->mode ?></td>
                </tr>
                <?php
                $som = $som + $dep->somme;
                $j++;
            }
            ?>
            <tr>
                <td colspan="2" class="title">Total</td>
                <td colspan="4" class="title"><?= $som ?></td>
            </tr>
            </tbody>
        </table>
        <br>
        <h4 class="title">Liste des sorties du jour</h4>
        <table class="table">
            <thead class="title">
            <tr>
                <th>N°</th>
                <th>Description</th>
                <th>Somme</th>
                <th>Compte</th>
                <th>Mode Transaction</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $j=1;
            $som1=0;
            foreach ($depSortie as $dep)
            {?>
                <tr>
                    <td class="num"><?= $j ?></td>
                    <td class="info"><?= $dep->desc_caisse  ?></td>
                    <td class="info"><?= $dep->somme ?></td>
                    <td class="info"><?= $dep->compte ?></td>
                    <td class="info"><?= $dep->mode ?></td>
                </tr>
                <?php
                $som1 = $som1 + $dep->somme;
                $j++;
            }
            ?>
            <tr>
                <td colspan="2" class="title">Total</td>
                <td colspan="3" class="title"><?= $som1 ?></td>
            </tr>
            </tbody>
        </table>
        <br>
        <h2 class="title1">Bilan du Jour</h2>
        <table class="table">
            <tr>
                <th>ENTREE</th>
                <th>SORTIE</th>
                <th>TOTAL</th>
            </tr>
            <tr>
                <td class="som"><?= $som ?></td>
                <td class="som"><?= $som1 ?></td>
                <td class="som"><?= ($som-$som1) ?></td>
            </tr>

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
        .sign{
            text-decoration: underline;
            text-align: right;
            margin-right: 100px;
        }
        .som {
            text-align: center;
            font-weight: bold;
            font-size: 20px;
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

    </style>


<?php
$html = ob_get_clean();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream(" $titre.pdf",array('Attachment'=>0));
