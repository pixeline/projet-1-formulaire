<?php 
//$message = $_GET['send'];
//$lastName = $_GET['lastName'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Hackers Poullette, thank you</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>

<div class="container-fluid">
	<div class="container">
		<!-- Fin de ROW bootstrap -->

	    <div class="row">

		    <main class="main-container">
		    	<div class="col-md-6">

			    	<div class="left-main">
			    		<h1>Hackers Poulette </h1> <h2> Technical support</h2>
			    		<a href="#"> <img class="logo" src="assets/img/logo.png" alt="Logo Hackers poulette"/></a>
			    		<p  class="how">Thank you for your request </p>	
				    </div>
			    </div>
			    <div class="col-md-6">
			    	<div class="form-container">
				    	<!--Debut de formulaire - partie 1-->
				    	<h1>Thank you for your request <?php echo $lastName; ?></h1>
				    	<h2>We will reply as soon as possible</h2>
				    	<p>Your message :</p>
						<?php //echo $message; ?>

						
					</div><!-- Fin de form-container -->
				</div><!-- Fin de col 9 md BOOTSTRAP-->
			</main><!-- fin de main -->
		</div><!-- Fin de ROW bootstrap -->
	</div><!-- Fin de container -->
</div><!--Fin de container fluid BOOTSTRAP -->
</body>
</html>
