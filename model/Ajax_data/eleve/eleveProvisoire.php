<?php
include_once '../../Eleve.class.php';

$query = '';
$output = array();
$query .= "SELECT * FROM eleve e, retrait r, agence a WHERE e.id_eleve=r.eleve AND a.id_agence= e.agence ";
if(isset($_POST["search"]["value"]))
{
	$query .= ' AND nom LIKE "%'.$_POST["search"]["value"].'%" ';



}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY nom ASC ';
}

if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = Eleve::getPDO()->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();

foreach($result as $row)
{
	$sub_array = array();

	$sub_array[] = $row["nom"];
	$sub_array[] = $row["prenom"];
	$sub_array[] = date('d/m/Y',strtotime($row["dob"]));
	$sub_array[] = $row["pob"];
	$sub_array[] = $row["categorie"];
	$sub_array[] = $row["nom_agence"];

	$sub_array[] = '
	<button title="Supprimer" type="button" name="delete" id="'.$row["id_eleve"].'" class="btn btn-danger btn-sm delete_eleve " ><i class="glyphicon glyphicon glyphicon-trash"></i></button>
	<button title="Modifier" type="button" name="update" id="'.$row["id_eleve"].'" class="btn btn-primary btn-sm update_eleve "><i class="glyphicon glyphicon-pencil"></i></button>
	<button type="button" title="Examen"  name="examen" id="'.$row["id_eleve"].'" class="btn btn-success examen_eleve "><i class="glyphicon glyphicon-ok"></i></button>
	<button type="button" title="Paiement"  name="paiement" id="'.$row["id_eleve"].'" class="btn btn-warning paiement_eleve "><i class="glyphicon glyphicon-th-large"></i></button>
	<button type="button" title="Voir plus" name="voir_plus" id="'.$row["id_eleve"].'" class="btn btn-info detail_eleve "><i class="glyphicon glyphicon-eye-open"></i></button>
	';


	$data[] = $sub_array;
}
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	Eleve::get_total_all_records_provisoire(),
	"data"				=>	$data
);
echo json_encode($output);
?>