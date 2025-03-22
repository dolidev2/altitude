<?php
require '../../dompdf/vendor/autoload.php';
include_once("../../model/Eleve.class.php");

$ind = $_GET['ind'];
if ($ind == 'cours')
{
    if(isset($_GET['agence']))
        $eleves = Eleve::afficherCoursAgence($_GET['agence']);
    else
        $eleves = Eleve::afficherCours();
  
    $acc = 'en cours';
}
else
{
    if(isset($_GET['agence']))
        $eleves = Eleve::afficherStatutAgence($_GET['agence']);
    else
        $eleves = Eleve::afficherStatut();

    $acc = 'permis provisoire';
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
        <h2 class="title1">Liste des élèves  <?= $acc ?></h2>
        <br>
        <br>
        <table class="table">
            <thead class="title">
            <tr>
                <th>N°</th>
                <th>Nom</th>
                <th>Prénoms</th>
                <th>Profession</th>
                <th>Catégorie</th>
                <th>Contact</th>
                <th>Adresse</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $j=1;
            foreach ($eleves as $eleve)
            {?>
                <tr>
                    <td class="num"><?= $j ?></td>
                    <td class="info"><?= $eleve->nom  ?></td>
                    <td class="info"><?= $eleve->prenom ?></td>
                    <td class="info"><?= $eleve->profession ?></td>
                    <td class="info"><?= $eleve->categorie ?></td>
                    <td class="info"><?= $eleve->contact ?></td>
                    <td class="info"><?= $eleve->adresse ?></td>
                </tr>
                <?php
                $j++;
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
