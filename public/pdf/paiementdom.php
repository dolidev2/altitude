<?php

require '../../dompdf/vendor/autoload.php';
include_once("../../model/Eleve.class.php");
include_once("../../model/Paiement.class.php");
include_once("../../model/Eleve.class.php");

if ($_GET['ind'] == 'impaye')
{
    if(isset($_GET['agence']))
        $eleves = Eleve::afficherImpayeAgence($_GET['agence']);
    else
        $eleves = Eleve::afficherImpaye();
    $acc = 'impayés';
}
elseif ($_GET['ind'] == 'redevable')
{
    if(isset($_GET['agence']))
        $eleves = Eleve::afficherPaiementAgence($_GET['agence']);
    else
        $eleves = Eleve::afficherPaiement();
    $acc = 'redevables';
}
else
{
    if(isset($_GET['agence']))
        $eleves = Eleve::afficherPaiementAgence($_GET['agence']);
    else
        $eleves = Eleve::afficherPaiement();
    $acc = 'à jour';
}
// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->set_option('isHtml5ParserEnabled', true);
ob_start();
?>

    <div class="container">
        <img  src="head.jpg" width="100 %" >
        <?php
            if($_GET['ind'] == 'impaye'){
                ?>
                <p><?= date('d/m/Y  H:i:s') ?></p>
                <h2 class="title1">Liste des élèves :  <?= $acc ?></h2>
                <?php
            }
            elseif($_GET['ind'] == 'solde'){
                ?>
                <p><?= date('d/m/Y  H:i:s') ?></p>
                <h2 class="title1">Liste des élèves :  <?= $acc ?></h2>
                <?php
            }
            else{
                ?>
                <p><?= date('d/m/Y  H:i:s') ?></p>
                <h2 class="title1">Liste des élèves :  <?= $acc ?></h2>
                <?php
            }
        ?>
        <br>
        <table class="table">
            <thead class="title">
            <tr>
                <th>N°</th>
                <th>Nom</th>
                <th>Prénoms</th>
                <th>Catégorie</th>
                <th>Forfait</th>
                <th>Solde</th>
                <th>Payé</th>
                <th>Réliquat</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if($_GET['ind'] == "redevable"){
                $j=1;
                foreach ($eleves as $eleve)
                {
                    if(($eleve->solde-$eleve->some) != 0){
                    ?>
                    <tr>
                        <td class="num"><?= $j ?></td>
                        <td class="info"><?= $eleve->nom  ?></td>
                        <td class="info"><?= $eleve->prenom ?></td>
                        <td class="info"><?= $eleve->categorie ?></td>
                        <td class="info"><?= $eleve->forfait ?></td>
                        <td class="info"><?= $eleve->solde ?></td>
                        <td class="info"><?= $eleve->some ?></td>
                        <td class="info"><?= ($eleve->solde-$eleve->some) ?></td>
                    </tr>
                    <?php
                    $j++;
                }
                }
            }
            elseif($_GET['ind'] == "solde") {
                 $j=1;
                 foreach ($eleves as $eleve)
                     if(($eleve->solde-$eleve->some) == "0"){
                     {?>
                         <tr>
                             <td class="num"><?= $j ?></td>
                             <td class="info"><?= $eleve->nom  ?></td>
                             <td class="info"><?= $eleve->prenom ?></td>
                             <td class="info"><?= $eleve->categorie ?></td>
                             <td class="info"><?= $eleve->forfait ?></td>
                             <td class="info"><?= $eleve->solde ?></td>
                             <td class="info"><?= $eleve->some ?></td>
                             <td class="info"><?= ($eleve->solde-$eleve->some) ?></td>
                         </tr>
                         <?php
                         $j++;
                     }
             }
            }elseif($_GET['ind'] == "impaye"){
                $j=1;

                foreach ($eleves as $eleve)
                {
                    ?>
                    <tr>
                        <td class="num"><?= $j ?></td>
                        <td class="info"><?= $eleve->nom  ?></td>
                        <td class="info"><?= $eleve->prenom ?></td>
                        <td class="info"><?= $eleve->categorie ?></td>
                        <td class="info"><?= $eleve->forfait ?></td>
                        <td class="info"><?= $eleve->solde ?></td>
                        <td class="info">0</td>
                        <td class="info">0</td>
                    </tr>
                    <?php
                    $j++;
              }
            }
            ?>
            </tbody>
        </table>

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