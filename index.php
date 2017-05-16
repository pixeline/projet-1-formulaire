<?php

$options = array(
    'name' 			=> FILTER_SANITIZE_STRING,
    'lastName' 			=> FILTER_SANITIZE_STRING,
    'mail' 			=> FILTER_VALIDATE_EMAIL,
    'gender' 			=> FILTER_SANITIZE_STRING,
    'country' 			=> FILTER_SANITIZE_STRING,
    'subject' 			=> FILTER_SANITIZE_STRING,
    'message' 			=> FILTER_SANITIZE_STRING,
);

$messageError			= array();    	
$valueError			= array();
$nbError 			= 0;



if (isset($_POST['submit'])) 
{ 

	$result = filter_input_array(INPUT_POST, $options);


	if ($result != null) 
	{

	    foreach($options as $key => $value) 
	    { //Parcourir tous les champs voulus.
	    	$result[$key] = trim($result[$key]); // On enlève les espaces avant et après la réponse.

	        if(empty($result[$key])) //Si le champ est vide.
	        { 	
	            $messageError[$key] = "The field $key is empty.";
	            $nbError++;
	        }

	        elseif ($result[$key] === false) //S'il n'est pas valide.
	        { 
	            $messageError[$key] = "Your $key not corrrect.";
	            $valueError[$key] = $value; 
	            $nbError++;
	        }

	        elseif ($key == "name" OR $key == "lastName") // Si le prénom et nom contiennent des chiffres
	        {
	        	if(preg_match('#[0-9]#', $result[$key]))
			{
				 $messageError[$key] = "Numbers are not allowed in this field.";
				 $nbError++;
			}

			elseif(preg_match('#[/!/^/&/€/$/§/?/_/*/;/:/,]#', $result[$key])) // Si un des caractères se trouve dans la chaine = error.
			{
				$messageError[$key] = "For this field, only alphabetic letters are allowed";
				$nbError++;
			}		

			else // si non, on remplace les douples espaces et ont me chaques 1ere lettee de chaque en majuscule puisque nom...
			{	
				$result[$key] = str_replace("  ", " ", $result[$key]);
				$result[$key] = ucwords(strtolower($result[$key])); 
			} 
	        }
	        elseif ($key =="message")// On verif si le message n'est pas trop court 
	        {
	        	if(strlen($result["message"]) <= 30) 
	        	{
	        		$messageError["message"] = "Your message is too short ! ";
				   	$nbError++;
	        	}
	        }


	   }

	 

	if($nbError == 0) 
	{
        	//print_r($result);
        	$send 	 = 	"<p> Name 		 : " . $result["name"] . "<p>";
        	$send 	.=	"<p> Last Name   : " . $result["lastName"] . "</p>";
        	$send 	.=	"<p> Email 		 : " . $result["mail"] . "</p>";
        	$send 	.=	"<p> Country 	 : " . $result["country"] . "</p>";
        	$send 	.=  "<p> Subject     : " . $result["subject"] . "</p>";
        	$send 	.= 	"<p> Message 	 : " . $result["message"] . "</p>";

        	mail("ludovic.paho@gmail.com", $result["subject"], $send);
        	$host  	= $_SERVER['HTTP_HOST'];
			$uri   	= rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			header("Location: http://$host$uri/merci.php");
			exit; 
 
    	}
    	else 
    	{
    		//print_r($messageError);
    	}


}


else
{
	$messageError['emptyerror'] = 'You have not filled in anything.';
}

	
	
}



?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Hackers Poullette</title>
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
			    		<p class="how">How can we help you ?</p>
				    	<p>How can we improve your experience</p>	
						
				 </div>
			 </div>
			 <div class="col-md-6">
			 	<div class="form-container">
			    	<h1>Contact</h1>
			    	<!--Debut de formulaire - partie 1-->


						<form method="post" action="#" id="form1">
							<fieldset>
								<p>Fields with an * are mandatory.</p>
								

								<div class="form-group"><label for="name"> Your Name * </label><span class="msgError"><?php if (isset($_POST['submit']) && isset($messageError['name'])) {echo  " ". $messageError['name']; } ?></span>
								<input class='form-control <?php if (!empty($messageError["name"])){ echo "error";} ?>' type="text" name="name" id="name" value='<?php if (isset($result["name"])){ echo $result["name"];} ?>' maxlength="30" />
								</div>	

					
								<div class="form-group"><label for="lastName"> Last Name * </label><span class="msgError"><?php if (isset($_POST['submit']) && isset($messageError['lastName'])) {echo  " ". $messageError['lastName']; } ?></span>
								<input class='form-control <?php if (!empty($messageError["lastName"])){ echo "error";} ?>' type="text" value='<?php if (isset($result["lastName"])){ echo $result["lastName"];} ?>' name="lastName" id="lastName" maxlength="30" />
								</div>

								<div class="form-group"><label for="mail"> Email * </label> <span class="msgError"><?php if (isset($_POST['submit']) && isset($messageError['mail'])) {echo  " ". $messageError['mail']; } ?></span>
								<input class='form-control <?php if (!empty($messageError["mail"])){ echo "error";} ?>' type="email" name="mail" value='<?php if (isset($result["mail"])){ echo $result["mail"];} ?>' id="mail" />
								</div>


					 				
					 			<div><label> Country *</label></div>						
								<div><select name="country" class="form-control">	


									<?php 

											if (isset($_POST['submit']))
											{
												echo '<option value="'. $result["country"] .'" selected="selected">'. $result["country"] .'</option>';
											}
											else 
											{
												echo '<option value="Belgium" selected="selected">Belgium</option>';
											}

									 ?>
									  	<option value="Afganistan">Afghanistan</option>
										<option value="Albania">Albania</option>
										<option value="Algeria">Algeria</option>
										<option value="American Samoa">American Samoa</option>
										<option value="Andorra">Andorra</option>
										<option value="Angola">Angola</option>
										<option value="Anguilla">Anguilla</option>
										<option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
										<option value="Argentina">Argentina</option>
										<option value="Armenia">Armenia</option>
										<option value="Aruba">Aruba</option>
										<option value="Australia">Australia</option>
										<option value="Austria">Austria</option>
										<option value="Azerbaijan">Azerbaijan</option>
										<option value="Bahamas">Bahamas</option>
										<option value="Bahrain">Bahrain</option>
										<option value="Bangladesh">Bangladesh</option>
										<option value="Barbados">Barbados</option>
										<option value="Belarus">Belarus</option>
										<option value="Belgium">Belgium</option>
										<option value="Belize">Belize</option>
										<option value="Benin">Benin</option>
										<option value="Bermuda">Bermuda</option>
										<option value="Bhutan">Bhutan</option>
										<option value="Bolivia">Bolivia</option>
										<option value="Bonaire">Bonaire</option>
										<option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
										<option value="Botswana">Botswana</option>
										<option value="Brazil">Brazil</option>
										<option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
										<option value="Brunei">Brunei</option>
										<option value="Bulgaria">Bulgaria</option>
										<option value="Burkina Faso">Burkina Faso</option>
										<option value="Burundi">Burundi</option>
										<option value="Cambodia">Cambodia</option>
										<option value="Cameroon">Cameroon</option>
										<option value="Canada">Canada</option>
										<option value="Canary Islands">Canary Islands</option>
										<option value="Cape Verde">Cape Verde</option>
										<option value="Cayman Islands">Cayman Islands</option>
										<option value="Central African Republic">Central African Republic</option>
										<option value="Chad">Chad</option>
										<option value="Channel Islands">Channel Islands</option>
										<option value="Chile">Chile</option>
										<option value="China">China</option>
										<option value="Christmas Island">Christmas Island</option>
										<option value="Cocos Island">Cocos Island</option>
										<option value="Colombia">Colombia</option>
										<option value="Comoros">Comoros</option>
										<option value="Congo">Congo</option>
										<option value="Cook Islands">Cook Islands</option>
										<option value="Costa Rica">Costa Rica</option>
										<option value="Cote DIvoire">Cote D'Ivoire</option>
										<option value="Croatia">Croatia</option>
										<option value="Cuba">Cuba</option>
										<option value="Curaco">Curacao</option>
										<option value="Cyprus">Cyprus</option>
										<option value="Czech Republic">Czech Republic</option>
										<option value="Denmark">Denmark</option>
										<option value="Djibouti">Djibouti</option>
										<option value="Dominica">Dominica</option>
										<option value="Dominican Republic">Dominican Republic</option>
										<option value="East Timor">East Timor</option>
										<option value="Ecuador">Ecuador</option>
										<option value="Egypt">Egypt</option>
										<option value="El Salvador">El Salvador</option>
										<option value="Equatorial Guinea">Equatorial Guinea</option>
										<option value="Eritrea">Eritrea</option>
										<option value="Estonia">Estonia</option>
										<option value="Ethiopia">Ethiopia</option>
										<option value="Falkland Islands">Falkland Islands</option>
										<option value="Faroe Islands">Faroe Islands</option>
										<option value="Fiji">Fiji</option>
										<option value="Finland">Finland</option>
										<option value="France">France</option>
										<option value="French Guiana">French Guiana</option>
										<option value="French Polynesia">French Polynesia</option>
										<option value="French Southern Ter">French Southern Ter</option>
										<option value="Gabon">Gabon</option>
										<option value="Gambia">Gambia</option>
										<option value="Georgia">Georgia</option>
										<option value="Germany">Germany</option>
										<option value="Ghana">Ghana</option>
										<option value="Gibraltar">Gibraltar</option>
										<option value="Great Britain">Great Britain</option>
										<option value="Greece">Greece</option>
										<option value="Greenland">Greenland</option>
										<option value="Grenada">Grenada</option>
										<option value="Guadeloupe">Guadeloupe</option>
										<option value="Guam">Guam</option>
										<option value="Guatemala">Guatemala</option>
										<option value="Guinea">Guinea</option>
										<option value="Guyana">Guyana</option>
										<option value="Haiti">Haiti</option>
										<option value="Hawaii">Hawaii</option>
										<option value="Honduras">Honduras</option>
										<option value="Hong Kong">Hong Kong</option>
										<option value="Hungary">Hungary</option>
										<option value="Iceland">Iceland</option>
										<option value="India">India</option>
										<option value="Indonesia">Indonesia</option>
										<option value="Iran">Iran</option>
										<option value="Iraq">Iraq</option>
										<option value="Ireland">Ireland</option>
										<option value="Isle of Man">Isle of Man</option>
										<option value="Israel">Israel</option>
										<option value="Italy">Italy</option>
										<option value="Jamaica">Jamaica</option>
										<option value="Japan">Japan</option>
										<option value="Jordan">Jordan</option>
										<option value="Kazakhstan">Kazakhstan</option>
										<option value="Kenya">Kenya</option>
										<option value="Kiribati">Kiribati</option>
										<option value="Korea North">Korea North</option>
										<option value="Korea Sout">Korea South</option>
										<option value="Kuwait">Kuwait</option>
										<option value="Kyrgyzstan">Kyrgyzstan</option>
										<option value="Laos">Laos</option>
										<option value="Latvia">Latvia</option>
										<option value="Lebanon">Lebanon</option>
										<option value="Lesotho">Lesotho</option>
										<option value="Liberia">Liberia</option>
										<option value="Libya">Libya</option>
										<option value="Liechtenstein">Liechtenstein</option>
										<option value="Lithuania">Lithuania</option>
										<option value="Luxembourg">Luxembourg</option>
										<option value="Macau">Macau</option>
										<option value="Macedonia">Macedonia</option>
										<option value="Madagascar">Madagascar</option>
										<option value="Malaysia">Malaysia</option>
										<option value="Malawi">Malawi</option>
										<option value="Maldives">Maldives</option>
										<option value="Mali">Mali</option>
										<option value="Malta">Malta</option>
										<option value="Marshall Islands">Marshall Islands</option>
										<option value="Martinique">Martinique</option>
										<option value="Mauritania">Mauritania</option>
										<option value="Mauritius">Mauritius</option>
										<option value="Mayotte">Mayotte</option>
										<option value="Mexico">Mexico</option>
										<option value="Midway Islands">Midway Islands</option>
										<option value="Moldova">Moldova</option>
										<option value="Monaco">Monaco</option>
										<option value="Mongolia">Mongolia</option>
										<option value="Montserrat">Montserrat</option>
										<option value="Morocco">Morocco</option>
										<option value="Mozambique">Mozambique</option>
										<option value="Myanmar">Myanmar</option>
										<option value="Nambia">Nambia</option>
										<option value="Nauru">Nauru</option>
										<option value="Nepal">Nepal</option>
										<option value="Netherland Antilles">Netherland Antilles</option>
										<option value="Netherlands">Netherlands (Holland, Europe)</option>
										<option value="Nevis">Nevis</option>
										<option value="New Caledonia">New Caledonia</option>
										<option value="New Zealand">New Zealand</option>
										<option value="Nicaragua">Nicaragua</option>
										<option value="Niger">Niger</option>
										<option value="Nigeria">Nigeria</option>
										<option value="Niue">Niue</option>
										<option value="Norfolk Island">Norfolk Island</option>
										<option value="Norway">Norway</option>
										<option value="Oman">Oman</option>
										<option value="Pakistan">Pakistan</option>
										<option value="Palau Island">Palau Island</option>
										<option value="Palestine">Palestine</option>
										<option value="Panama">Panama</option>
										<option value="Papua New Guinea">Papua New Guinea</option>
										<option value="Paraguay">Paraguay</option>
										<option value="Peru">Peru</option>
										<option value="Phillipines">Philippines</option>
										<option value="Pitcairn Island">Pitcairn Island</option>
										<option value="Poland">Poland</option>
										<option value="Portugal">Portugal</option>
										<option value="Puerto Rico">Puerto Rico</option>
										<option value="Qatar">Qatar</option>
										<option value="Republic of Montenegro">Republic of Montenegro</option>
										<option value="Republic of Serbia">Republic of Serbia</option>
										<option value="Reunion">Reunion</option>
										<option value="Romania">Romania</option>
										<option value="Russia">Russia</option>
										<option value="Rwanda">Rwanda</option>
										<option value="St Barthelemy">St Barthelemy</option>
										<option value="St Eustatius">St Eustatius</option>
										<option value="St Helena">St Helena</option>
										<option value="St Kitts-Nevis">St Kitts-Nevis</option>
										<option value="St Lucia">St Lucia</option>
										<option value="St Maarten">St Maarten</option>
										<option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
										<option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
										<option value="Saipan">Saipan</option>
										<option value="Samoa">Samoa</option>
										<option value="Samoa American">Samoa American</option>
										<option value="San Marino">San Marino</option>
										<option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
										<option value="Saudi Arabia">Saudi Arabia</option>
										<option value="Senegal">Senegal</option>
										<option value="Serbia">Serbia</option>
										<option value="Seychelles">Seychelles</option>
										<option value="Sierra Leone">Sierra Leone</option>
										<option value="Singapore">Singapore</option>
										<option value="Slovakia">Slovakia</option>
										<option value="Slovenia">Slovenia</option>
										<option value="Solomon Islands">Solomon Islands</option>
										<option value="Somalia">Somalia</option>
										<option value="South Africa">South Africa</option>
										<option value="Spain">Spain</option>
										<option value="Sri Lanka">Sri Lanka</option>
										<option value="Sudan">Sudan</option>
										<option value="Suriname">Suriname</option>
										<option value="Swaziland">Swaziland</option>
										<option value="Sweden">Sweden</option>
										<option value="Switzerland">Switzerland</option>
										<option value="Syria">Syria</option>
										<option value="Tahiti">Tahiti</option>
										<option value="Taiwan">Taiwan</option>
										<option value="Tajikistan">Tajikistan</option>
										<option value="Tanzania">Tanzania</option>
										<option value="Thailand">Thailand</option>
										<option value="Togo">Togo</option>
										<option value="Tokelau">Tokelau</option>
										<option value="Tonga">Tonga</option>
										<option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
										<option value="Tunisia">Tunisia</option>
										<option value="Turkey">Turkey</option>
										<option value="Turkmenistan">Turkmenistan</option>
										<option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
										<option value="Tuvalu">Tuvalu</option>
										<option value="Uganda">Uganda</option>
										<option value="Ukraine">Ukraine</option>
										<option value="United Arab Erimates">United Arab Emirates</option>
										<option value="United Kingdom">United Kingdom</option>
										<option value="United States of America">United States of America</option>
										<option value="Uraguay">Uruguay</option>
										<option value="Uzbekistan">Uzbekistan</option>
										<option value="Vanuatu">Vanuatu</option>
										<option value="Vatican City State">Vatican City State</option>
										<option value="Venezuela">Venezuela</option>
										<option value="Vietnam">Vietnam</option>
										<option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
										<option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
										<option value="Wake Island">Wake Island</option>
										<option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
										<option value="Yemen">Yemen</option>
										<option value="Zaire">Zaire</option>
										<option value="Zambia">Zambia</option>
										<option value="Zimbabwe">Zimbabwe</option>

									</select>
									



								</div>


								<div class="typeradio"><?php if(isset($result["gender"]) && $result["gender"] == "Female")
											{
												
												echo '<input type="radio" id="genderM" name="gender" value="Male" ><label for="genderM"> Male</label>
												<input type="radio" id="genderF" name="gender" value="Female" checked> <label for="genderF">Female </label>';																		
											}
											else 
											{
												echo '<input type="radio" id="genderM" name="gender" value="Male" checked><label for="genderM"> Male</label>
												<input type="radio" id="genderF" name="gender" value="Female" > <label for="genderF">Female </label>';
											}?>						
								</div>


							
								
								<div>
									<label> Subject </label>
								</div>
								
								<div>
									<select id="subject" name="subject" class="form-control" >
									<?php 

									if (isset($_POST['submit'])) 
									{
										echo '<option value="' . $result["subject"] .'" selected="selected" > ' . $result["subject"]  . '</option>
											  <option value="Hardware">Hardware</option>
											  <option value="Software">Software</option>
											  <option value="Delivery">Delivery</option>
											  <option value="Other" > Other</option>';
									}
									else 
									{ 	echo '<option value="Hardware">Hardware</option>
											  <option value="Software">Software</option>
										      <option value="Delivery">Delivery</option>
										      <option value="Other" selected="selected"> Other</option>';
									}
									?>	
									</select>  
									
								</div>
								
								<div class="text">
									<label>Message *</label><span class="msgError"><?php if (isset($_POST['submit']) && isset($messageError['message'])) {echo  " ". $messageError['message']; } ?></span>
								</div>
								<div>
									<textarea name="message" class='form-control <?php if (!empty($messageError["message"])){ echo "error";} ?>' rows="3" ><?php if (isset($result["message"])){ echo $result["message"];} ?></textarea>
								</div>
		 
							
								<button type="submit" form="form1" value="submit" name="submit">Submit</button>	

							</fieldset>
						</form>
					</div><!-- Fin de form-container -->
				</div><!-- Fin de col 9 md BOOTSTRAP-->
			</main><!-- fin de main -->
		</div><!-- Fin de ROW bootstrap -->
	</div><!-- Fin de container -->
</div><!--Fin de container fluid BOOTSTRAP -->
</body>
</html>
