<?php

require '../../dompdf/vendor/autoload.php';
include_once("../../model/Caisse.class.php");

$date_debut = $_POST['dt_debut'];
$date_fin = $_POST['dt_fin'];

$soldes = Caisse::readMonthFondCaisse($date_debut,$date_fin);

setlocale(LC_TIME, 'french');

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->set_option('isHtml5ParserEnabled', true);
ob_start();
?>
<div class="container">
    <img  src="head.jpg" width="100 %" >
    <h2 class="title1">Clôture de la caisse du  <?= date("d/m/Y",strtotime($date_debut)) ?> au <?= date("d/m/Y",strtotime($date_fin)) ?>  </h2>
    
    <h4 class="title">Récapitualtif</h4>
    <table class="table">
        <thead class="title">
        <tr>
            <th>Date</th>
            <th>Libelle</th>
            <th>Recette</th>
            <th>Dépense</th>
            <th>Solde</th>
        </tr>
        </thead>
        <tbody>
            <?php
            $titre="Clôture de la caisse du ".date("d/m/Y",strtotime($date_debut)).' au '. date("d/m/Y",strtotime($date_debut));
            $entre = 0;
            $sortie = 0; 
            $solde = 0;
            $cpt = 1;
            foreach($soldes[1] as $sol)
            {
                $entre = 0;
                $sortie = 0; 
                if($cpt == 1)
                {
                    ?>
                    <tr>
                        <td>
                            <?php 
                                  if( isset($soldes[0][0]->somme_recette) && !empty($soldes[0][0]->somme_recette))
                                    echo date("d/m/Y", strtotime($soldes[0][0]->date_recette));
                                  else
                                    echo '-------------------';
                            ?>
                        </td>
                        <td colspan="3">fond de caisse</td>
                        <td>
                            <?php
                                if( isset($soldes[0][0]->somme_recette) && !empty($soldes[0][0]->somme_recette))
                                    echo $soldes[0][0]->somme_recette;
                                else
                                    echo 0;
                            ?>
                        </td>
                    </tr>
                    <?php
                    if(!empty($sol['caisse'])){ 
                    foreach($sol['caisse'] as $so){  
                    ?>
                    <tr>
                        <td><?= date("d/m/Y", strtotime($so->date)) ?></td>
                        <td><?=$so->desc_caisse  ?></td>
                        <?php  
                        if($so->type == "entre"){
                            $entre = $entre + $so->somme ;
                            ?>
                                <td><?= $so->somme ?></td>
                                <td></td>
                            <?php
                        }elseif($so->type == "sortie"){
                            $sortie = $sortie + $so->somme ;
                            ?>
                            <td></td>
                            <td><?= $so->somme ?></td>
                        <?php
                        }
                        ?>
                        <td></td>
                    </tr>
                    <?php
                        }
                    }
                    if( isset($soldes[0][0]->somme_recette) && !empty($soldes[0][0]->somme_recette))
                        $solde  = $solde + $entre - $sortie + $soldes[0][0]->somme_recette;
                    else
                        $solde  = $solde + $entre - $sortie ;
                    if(!empty($sol['caisse'])){ 
                    ?>
                    <tr>
                        <td colspan="4">fond de caisse</td>
                        <td><?= $solde ?></td>
                    </tr>
                    <?php
                    }
                }else{
                    if(!empty($sol['caisse'])){ 
                        foreach($sol['caisse'] as $so){  
                        ?>
                        <tr>
                            <td><?= date("d/m/Y", strtotime($so->date)) ?></td>
                            <td><?=$so->desc_caisse  ?></td>
                            <?php  
                            if($so->type == "entre"){
                                $entre = $entre + $so->somme ;
                                ?>
                                    <td><?= $so->somme ?></td>
                                    <td></td>
                                <?php
                            }elseif($so->type == "sortie"){
                                $sortie = $sortie + $so->somme ;
                                ?>
                                <td></td>
                                <td><?= $so->somme ?></td>
                            <?php
                            }
                            ?>
                            <td></td>
                        </tr>
    
                        <?php
                            }
                        }
                        $solde  = $solde + $entre - $sortie;
                        if(!empty($sol['caisse'])){ 
                        ?>
                        <tr>
                            <td colspan="4">fond de caisse</td>
                            <td><?= $solde ?></td>
                        </tr>
                        <?php
                        }
                }
                   $cpt++; 
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
        .sign{
            text-decoration: underline;
            text-align: right;
            margin-right: 100px;
        }
        .som{

            text-align: center;
            font-weight:bold;
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

   
 