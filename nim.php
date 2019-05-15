<?php
   session_start();
   
   if( !isset( $_SESSION['lastP'] ) ) {
  		$_SESSION['lastP'] = -1;
   }
	if( !isset( $_SESSION['lastT'] ) ) {
  		$_SESSION['lastT'] = 0;
   }
	if( !isset( $_SESSION['kontrola'] ) ) {
  		$_SESSION['kontrola'] = -1;
   }
?>


<?php 
$celkem = 0;
$odebrane = 0;
$chyba = 1;
$vypis = 0;
$GLOBALS['prohra'] = 0;



function tah($celkem){
		$zbytek = $celkem % 4;
		
		
		if($celkem == 2){
			return 1;
		}
		if($celkem == 3){
			return 2;
		}
		if($zbytek == 0){
			return 3;
		}
		if($celkem == 1){
			$GLOBALS['prohra'] = 1;
			return 1;
		}
		if($zbytek == 1){
			if($_SESSION["lastP"] == $celkem){
				return $_SESSION["lastT"];
			}
			$a = rand(1,3);
			$_SESSION["lastT"] = $a;
			return $a;
			
		}
		if($celkem != 3 && $celkem != 2)
		{
		return $zbytek - 1;
		}
	
}

if(isset($_GET['cl']) == true && is_numeric($_GET['cl']) == true ){
	if($_GET['cl'] >= 0){
	$celkem = $_GET['cl'];
	if($celkem > 0){
		$odebrane = tah($celkem);	
	}
	}
	else{
		echo 'Chyba vstupu!';
		$celkem = 0;
		$vypis = 0;
		$odebrane = 0;
		$chyba = 1;
	}
	if($_SESSION['kontrola'] == -1){
		$_SESSION['kontrola'] = 1;
		$_SESSION['lastP'] = -1;
	}
	else{
		$_SESSION['lastP'] = $celkem;
		$vypis = ($celkem - 3) - $odebrane;
		$celkem = $celkem - $odebrane;
	}
	$chyba = 0;

}




?>


<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>NIM</title>
	<link rel="stylesheet" href="style.css" type="text/css">
</head>


<body>
<h1>NIM</h1>
<p>Hráč střídavě s počítačem odebírá 1-3 sirky v každém tahu. Kdo odebere poslední, prohrál.</p>

<div class="center">
<?php 
if($celkem != 0)
{
	if($celkem >= 3){		
	echo '<a href="?cl=';echo $celkem-1;echo '" class="zapalka"><img src="pic/zapalka.png" class="zapalka"></a>';
	echo '<a href="?cl=';echo $celkem-2;echo '" class="zapalka"><img src="pic/zapalka.png" class="zapalka"></a>';	
	echo '<a href="?cl=';echo $celkem-3;echo '" class="zapalka"><img src="pic/zapalka.png" class="zapalka"></a>';
	}
	if($celkem == 2 ){		
	echo '<a href="?cl=';echo $celkem-1;echo '" class="zapalka"><img src="pic/zapalka.png" class="zapalka"></a>';
	echo '<a href="?cl=';echo $celkem-2;echo '" class="zapalka"><img src="pic/zapalka.png" class="zapalka"></a>';	
	}
	if($celkem == 1){		
	echo '<a href="?cl=';echo $celkem-1;echo '" class="zapalka"><img src="pic/zapalka.png" class="zapalka"></a>';	
	}
}
else{
	echo '<form>';
	echo '<input type = "number" name="cl">';
	echo '</form>';
	$_SESSION['lastP'] = -1;
}
if($_SESSION['lastP'] == -1){
	$odebrane = 0;
	$vypis = $celkem - 3;
}
	?>	 	
<?php 
for($i = 1; $i <= $vypis; $i++){
	echo '<img src="pic/zapalka.png" class="zapalka">';	
	
}
for($c = 1; $c <= $odebrane; $c++){
	echo '<img src="pic/zapalka.png" class="zapalka odebrana">';
}
	?>		

</div>
<?php 


if($celkem == 0 && $GLOBALS['prohra'] == 1 && $chyba == 0){
	echo '<p>Konec hry. Vyhrává hráč!<br></p>';
	$_SESSION['kontrola'] = -1;
}
if($celkem == 0 && $GLOBALS['prohra'] == 0 && $chyba == 0){
	echo '<p>Konec hry. Vyhrává BOT!<br></p>';
	$_SESSION['kontrola'] = -1;
}
?>
</body>
</html>
