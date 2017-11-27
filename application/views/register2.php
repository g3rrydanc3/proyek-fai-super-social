<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header.php');
?>
<div class='container wrapper'>
<?php if ($this->session->flashdata('errors') != null): ?>
	<div class="alert alert-danger">
	  <?php echo $this->session->flashdata('errors'); ?>
	</div>
<?php endif; ?>
<?php echo form_open('user/register_process2', 'class="form-horizontal"');?>
	<?php echo form_hidden("user_id", $user_id);?>
	<?php echo form_hidden("token", $token);?>
	<h1 class="form-signin-heading">Register</h1>
	<p>Untuk menyelesaikan registrasi, anda harus mengisi profile anda</p>
	<div class="form-group">
		<label class="control-label col-sm-2" for="alamat"><i class="fa fa-asterisk" aria-hidden="true"></i> Alamat:</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="alamat" name="alamat" placeholder="Enter alamat">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="kodepos">Kode Pos:</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="kodepos" name="kodepos" placeholder="Enter kode pos">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="negara"><i class="fa fa-asterisk" aria-hidden="true"></i> Negara:</label>
		<div class="col-sm-10">
			<?php
				$options = array(
					"-1" => "Select Country",
					"AF" => "Afghanistan",
					"AL" => "Albania",
					"DZ" => "Algeria",
					"AS" => "American Samoa",
					"AD" => "Andorra",
					"AO" => "Angola",
					"AI" => "Anguilla",
					"AQ" => "Antarctica",
					"AG" => "Antigua and Barbuda",
					"AR" => "Argentina",
					"AM" => "Armenia",
					"AW" => "Aruba",
					"AU" => "Australia",
					"AT" => "Austria",
					"AZ" => "Azerbaijan",
					"BS" => "Bahamas",
					"BH" => "Bahrain",
					"BD" => "Bangladesh",
					"BB" => "Barbados",
					"BY" => "Belarus",
					"BE" => "Belgium",
					"BZ" => "Belize",
					"BJ" => "Benin",
					"BM" => "Bermuda",
					"BT" => "Bhutan",
					"BO" => "Bolivia",
					"BA" => "Bosnia and Herzegowina",
					"BW" => "Botswana",
					"BV" => "Bouvet Island",
					"BR" => "Brazil",
					"IO" => "British Indian Ocean Territory",
					"BN" => "Brunei Darussalam",
					"BG" => "Bulgaria",
					"BF" => "Burkina Faso",
					"BI" => "Burundi",
					"KH" => "Cambodia",
					"CM" => "Cameroon",
					"CA" => "Canada",
					"CV" => "Cape Verde",
					"KY" => "Cayman Islands",
					"CF" => "Central African Republic",
					"TD" => "Chad",
					"CL" => "Chile",
					"CN" => "China",
					"CX" => "Christmas Island",
					"CC" => "Cocos (Keeling) Islands",
					"CO" => "Colombia",
					"KM" => "Comoros",
					"CG" => "Congo",
					"CK" => "Cook Islands",
					"CR" => "Costa Rica",
					"CI" => "Cote D'Ivoire",
					"HR" => "Croatia",
					"CU" => "Cuba",
					"CY" => "Cyprus",
					"CZ" => "Czech Republic",
					"DK" => "Denmark",
					"DJ" => "Djibouti",
					"DM" => "Dominica",
					"DO" => "Dominican Republic",
					"TL" => "East Timor",
					"EC" => "Ecuador",
					"EG" => "Egypt",
					"SV" => "El Salvador",
					"GQ" => "Equatorial Guinea",
					"ER" => "Eritrea",
					"EE" => "Estonia",
					"ET" => "Ethiopia",
					"FK" => "Falkland Islands (Malvinas)",
					"FO" => "Faroe Islands",
					"FJ" => "Fiji",
					"FI" => "Finland",
					"FR" => "France",
					"FX" => "France, Metropolitan",
					"GF" => "French Guiana",
					"PF" => "French Polynesia",
					"TF" => "French Southern Territories",
					"GA" => "Gabon",
					"GM" => "Gambia",
					"GE" => "Georgia",
					"DE" => "Germany",
					"GH" => "Ghana",
					"GI" => "Gibraltar",
					"GR" => "Greece",
					"GL" => "Greenland",
					"GD" => "Grenada",
					"GP" => "Guadeloupe",
					"GU" => "Guam",
					"GT" => "Guatemala",
					"GN" => "Guinea",
					"GW" => "Guinea-bissau",
					"GY" => "Guyana",
					"HT" => "Haiti",
					"HM" => "Heard and Mc Donald Islands",
					"HN" => "Honduras",
					"HK" => "Hong Kong",
					"HU" => "Hungary",
					"IS" => "Iceland",
					"IN" => "India",
					"ID" => "Indonesia",
					"IR" => "Iran (Islamic Republic of)",
					"IQ" => "Iraq",
					"IE" => "Ireland",
					"IL" => "Israel",
					"IT" => "Italy",
					"JM" => "Jamaica",
					"JP" => "Japan",
					"JO" => "Jordan",
					"KZ" => "Kazakhstan",
					"KE" => "Kenya",
					"KI" => "Kiribati",
					"KP" => "Korea, Democratic People's Republic of",
					"KR" => "Korea, Republic of",
					"KW" => "Kuwait",
					"KG" => "Kyrgyzstan",
					"LA" => "Lao People's Democratic Republic",
					"LV" => "Latvia",
					"LB" => "Lebanon",
					"LS" => "Lesotho",
					"LR" => "Liberia",
					"LY" => "Libyan Arab Jamahiriya",
					"LI" => "Liechtenstein",
					"LT" => "Lithuania",
					"LU" => "Luxembourg",
					"MO" => "Macau",
					"MK" => "Macedonia, The Former Yugoslav Republic of",
					"MG" => "Madagascar",
					"MW" => "Malawi",
					"MY" => "Malaysia",
					"MV" => "Maldives",
					"ML" => "Mali",
					"MT" => "Malta",
					"MH" => "Marshall Islands",
					"MQ" => "Martinique",
					"MR" => "Mauritania",
					"MU" => "Mauritius",
					"YT" => "Mayotte",
					"MX" => "Mexico",
					"FM" => "Micronesia, Federated States of",
					"MD" => "Moldova, Republic of",
					"MC" => "Monaco",
					"MN" => "Mongolia",
					"MS" => "Montserrat",
					"MA" => "Morocco",
					"MZ" => "Mozambique",
					"MM" => "Myanmar",
					"NA" => "Namibia",
					"NR" => "Nauru",
					"NP" => "Nepal",
					"NL" => "Netherlands",
					"AN" => "Netherlands Antilles",
					"NC" => "New Caledonia",
					"NZ" => "New Zealand",
					"NI" => "Nicaragua",
					"NE" => "Niger",
					"NG" => "Nigeria",
					"NU" => "Niue",
					"NF" => "Norfolk Island",
					"MP" => "Northern Mariana Islands",
					"NO" => "Norway",
					"OM" => "Oman",
					"PK" => "Pakistan",
					"PW" => "Palau",
					"PA" => "Panama",
					"PG" => "Papua New Guinea",
					"PY" => "Paraguay",
					"PE" => "Peru",
					"PH" => "Philippines",
					"PN" => "Pitcairn",
					"PL" => "Poland",
					"PT" => "Portugal",
					"PR" => "Puerto Rico",
					"QA" => "Qatar",
					"RE" => "Reunion",
					"RO" => "Romania",
					"RU" => "Russian Federation",
					"RW" => "Rwanda",
					"KN" => "Saint Kitts and Nevis",
					"LC" => "Saint Lucia",
					"VC" => "Saint Vincent and the Grenadines",
					"WS" => "Samoa",
					"SM" => "San Marino",
					"ST" => "Sao Tome and Principe",
					"SA" => "Saudi Arabia",
					"SN" => "Senegal",
					"SC" => "Seychelles",
					"SL" => "Sierra Leone",
					"SG" => "Singapore",
					"SK" => "Slovakia (Slovak Republic)",
					"SI" => "Slovenia",
					"SB" => "Solomon Islands",
					"SO" => "Somalia",
					"ZA" => "South Africa",
					"GS" => "South Georgia and the South Sandwich Islands",
					"ES" => "Spain",
					"LK" => "Sri Lanka",
					"SH" => "St. Helena",
					"PM" => "St. Pierre and Miquelon",
					"SD" => "Sudan",
					"SR" => "Suriname",
					"SJ" => "Svalbard and Jan Mayen Islands",
					"SZ" => "Swaziland",
					"SE" => "Sweden",
					"CH" => "Switzerland",
					"SY" => "Syrian Arab Republic",
					"TW" => "Taiwan",
					"TJ" => "Tajikistan",
					"TZ" => "Tanzania, United Republic of",
					"TH" => "Thailand",
					"TG" => "Togo",
					"TK" => "Tokelau",
					"TO" => "Tonga",
					"TT" => "Trinidad and Tobago",
					"TN" => "Tunisia",
					"TR" => "Turkey",
					"TM" => "Turkmenistan",
					"TC" => "Turks and Caicos Islands",
					"TV" => "Tuvalu",
					"UG" => "Uganda",
					"UA" => "Ukraine",
					"AE" => "United Arab Emirates",
					"GB" => "United Kingdom",
					"US" => "United States",
					"UM" => "United States Minor Outlying Islands",
					"UY" => "Uruguay",
					"UZ" => "Uzbekistan",
					"VU" => "Vanuatu",
					"VA" => "Vatican City State (Holy See)",
					"VE" => "Venezuela",
					"VN" => "Viet Nam",
					"VG" => "Virgin Islands (British)",
					"VI" => "Virgin Islands (U.S.)",
					"WF" => "Wallis and Futuna Islands",
					"EH" => "Western Sahara",
					"YE" => "Yemen",
					"RS" => "Serbia",
					"CD" => "The Democratic Republic of Congo",
					"ZM" => "Zambia",
					"ZW" => "Zimbabwe",
					"JE" => "Jersey",
					"BL" => "St. Barthelemy",
					"XU" => "St. Eustatius",
					"XC" => "Canary Islands",
					"ME" => "Montenegro"
					);
				echo form_dropdown('negara', $options, 'afghanistan', 'class="form-control" id="negara"');
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="jabatan"><i class="fa fa-asterisk" aria-hidden="true"></i> Jabatan:</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Enter jabatan">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="perusahaan"><i class="fa fa-asterisk" aria-hidden="true"></i> Perusahaan:</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="perusahaan" name="perusahaan" placeholder="Enter perusahaan">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="bioperusahaan">Bio Perusahaan :</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="bioperusahaan" name="bioperusahaan" placeholder="Enter bio perusahaan">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="biouser">Bio User :</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="biouser" name="biouser" placeholder="Enter bio user">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<small><i class="fa fa-asterisk" aria-hidden="true"></i> =  Harus di isi</small>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
		<button type="submit" class="btn btn-default" name="r2_register" value="Register">Register</button>
		</div>
	</div>
<?php echo form_close();?>
</div>
<?php $this->load->view('layout/footer.php');?>
