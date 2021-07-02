<section id="page-content">

	<!-- Start body content -->
	<div class="body-content animated fadeIn">

		<div class="row">
			<div class="col-lg-12">
				<h2 class="text-special mb-20 mt-5" style="font-size:25px;"> 
					<?php 
					if(!isset($_POST['search'])) {
						echo $lang['People'];
						echo '<a href="#" data-toggle="modal" data-target="#filter-results" class="btn btn-theme pull-right" style="color:#fff!important;"> <i class="fa fa-fw fa-sliders" style="color:#fff!important;"></i> '.$lang['Filter'].' </a>';
					} else {
						echo '<a href="'.$system->getDomain().'/people.php" style="font-size:22px;" class="no-underline mr-10"> <i class="fa fa-chevron-left" style="color:#e74c3c!important;"></i> </a>';
						echo sprintf($lang['Search_For'],$query);
					}
					?>
				</h2>
				<?php 
				if($people->num_rows >= 1) {
					while($person = $people->fetch_object()) { 
						?>
						<div class="col-lg-3 col-md-3 col-sm-4">
							<div class="panel rounded shadow">
								<div class="panel-body">
									<div class="inner-all">
										<ul class="list-unstyled">
											<li class="text-center">
												<a href="<?=$system->getDomain()?>/profile.php?id=<?=$person->id?>">
													<img class="img-circle" src="<?=$system->getProfilePicture($person)?>" alt="<?=$person->full_name?>" style="height:100px;width:100px;">
												</a>
											</li>
											<li class="text-center">
												<h4 class="font600" style="margin-bottom:5px;"> 
													<?php if($system->isOnline($person->last_active)) { ?> 
													<span class="badge badge-success badge-circle hand-cursor" data-toggle="tooltip" data-placement="bottom" data-title="<?=$lang['Online']?>" placeholder="" data-original-title="" title="">&nbsp</span> 
													<?php } else { ?> 
													<span class="badge badge-danger badge-circle hand-cursor"  data-toggle="tooltip" data-placement="bottom" data-title="<?=sprintf($lang['Last_Active'],$system->timeAgo($lang,$person->last_active))?>" placeholder="" data-original-title="" title="">&nbsp</span> 
													<?php } ?> 
													<?=$system->getFirstName($person->full_name)?>, <?=$person->age?>
												</h4>
												<p class="text-muted"> <?=$person->city?><?=$system->ifComma($person->city)?> <?=$person->country?></p>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<?php
					} 
				} else { 
					if(!isset($_POST['search'])) {
						$_error = $lang['No_Filter_Match'];
					} else {
						$_error = $lang['No_Search_Match'];
					}
					echo '<div class="panel rounded"> <div class="panel-body"> '.$_error.' </div> </div>'; 
				} 
				?>
				<div class="col-lg-12 col-md-12 col-sm-12">
					<ul class="pagination pagination-lg">
						<?php
						if(($last_page >= $p) && $last_page > 1) {
							for($i=1; $i<=$last_page; $i++) {
								if($i == $p) {
									echo '<li class="active"> <a href="'.$system->getDomain().'/people.php?p='.$i.'"> '.$i.' </a> </li>';
								} else {
									echo '<li> <a href="'.$system->getDomain().'/people.php?p='.$i.'"> '.$i.' </a> </li>';
								}
							}
						}
						?>
					</ul>
				</div>
			</div>
		</div>

	</div>
	<!--/ End body content -->

</section>

<!-- Filter Results Modal -->
<div class="modal fade" id="filter-results" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<form action="" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><?=$lang['Filter_Results']?></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label style="font-size:14px;"><?=$lang['Gender']?></label>
						<select name="sexual_preference" class="chosen">
							<option value="3" <?php if($filter->sexual_preference == 3) { echo 'selected'; } ?>> <?=$lang['All_Genders']?> </option>
							<option value="1" <?php if($filter->sexual_preference == 1) { echo 'selected'; } ?>> <?=$lang['Male']?> </option>
							<option value="2" <?php if($filter->sexual_preference == 2) { echo 'selected'; } ?>> <?=$lang['Female']?> </option>
						</select>
					</div>
					<div class="form-group">
						<label style="font-size:14px;"><?=$lang['Sexual_Orientation']?></label>
						<select name="sexual_orientation" class="chosen">
							<option value="1" <?php if($filter->sexual_orientation == 1) { echo 'selected'; } ?>> <?=$lang['Straight']?> </option>
							<option value="2" <?php if($filter->sexual_orientation == 2) { echo 'selected'; } ?>> <?=$lang['Gay']?> </option>
							<option value="3" <?php if($filter->sexual_orientation == 3) { echo 'selected'; } ?>> <?=$lang['Lesbian']?> </option>
							<option value="4" <?php if($filter->sexual_orientation == 4) { echo 'selected'; } ?>> <?=$lang['Bisexual']?> </option>
						</select>
					</div>
					<div class="form-group">
						<label style="font-size:14px;"><?=$lang['Country']?></label>
						<select name="country" class="chosen">
							<option value="<?=$filter->country?>" selected><?=$lang['Current']?>: <?=$filter->country?></option>
							<option value="All Countries"><?=$lang['All_Countries']?></option>
							<option value="Afghanistan">Afghanistan</option>
							<option value="Albania">Albania</option>
							<option value="Algeria">Algeria</option>
							<option value="American Samoa">American Samoa</option>
							<option value="Andorra">Andorra</option>
							<option value="Angola">Angola</option>
							<option value="Anguilla">Anguilla</option>
							<option value="Antartica">Antarctica</option>
							<option value="Antigua and Barbuda">Antigua and Barbuda</option>
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
							<option value="Bosnia and Herzegowina">Bosnia and Herzegowina</option>
							<option value="Botswana">Botswana</option>
							<option value="Bouvet Island">Bouvet Island</option>
							<option value="Brazil">Brazil</option>
							<option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
							<option value="Brunei Darussalam">Brunei Darussalam</option>
							<option value="Bulgaria">Bulgaria</option>
							<option value="Burkina Faso">Burkina Faso</option>
							<option value="Burundi">Burundi</option>
							<option value="Cambodia">Cambodia</option>
							<option value="Cameroon">Cameroon</option>
							<option value="Canada">Canada</option>
							<option value="Cape Verde">Cape Verde</option>
							<option value="Cayman Islands">Cayman Islands</option>
							<option value="Central African Republic">Central African Republic</option>
							<option value="Chad">Chad</option>
							<option value="Chile">Chile</option>
							<option value="China">China</option>
							<option value="Christmas Island">Christmas Island</option>
							<option value="Cocos Islands">Cocos (Keeling) Islands</option>
							<option value="Colombia">Colombia</option>
							<option value="Comoros">Comoros</option>
							<option value="Congo">Congo</option>
							<option value="Congo">Congo, the Democratic Republic of the</option>
							<option value="Cook Islands">Cook Islands</option>
							<option value="Costa Rica">Costa Rica</option>
							<option value="Cota D'Ivoire">Cote d'Ivoire</option>
							<option value="Croatia">Croatia (Hrvatska)</option>
							<option value="Cuba">Cuba</option>
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
							<option value="Falkland Islands">Falkland Islands (Malvinas)</option>
							<option value="Faroe Islands">Faroe Islands</option>
							<option value="Fiji">Fiji</option>
							<option value="Finland">Finland</option>
							<option value="France">France</option>
							<option value="France Metropolitan">France, Metropolitan</option>
							<option value="French Guiana">French Guiana</option>
							<option value="French Polynesia">French Polynesia</option>
							<option value="French Southern Territories">French Southern Territories</option>
							<option value="Gabon">Gabon</option>
							<option value="Gambia">Gambia</option>
							<option value="Georgia">Georgia</option>
							<option value="Germany">Germany</option>
							<option value="Ghana">Ghana</option>
							<option value="Gibraltar">Gibraltar</option>
							<option value="Greece">Greece</option>
							<option value="Greenland">Greenland</option>
							<option value="Grenada">Grenada</option>
							<option value="Guadeloupe">Guadeloupe</option>
							<option value="Guam">Guam</option>
							<option value="Guatemala">Guatemala</option>
							<option value="Guinea">Guinea</option>
							<option value="Guinea-Bissau">Guinea-Bissau</option>
							<option value="Guyana">Guyana</option>
							<option value="Haiti">Haiti</option>
							<option value="Heard and McDonald Islands">Heard and Mc Donald Islands</option>
							<option value="Holy See">Holy See (Vatican City State)</option>
							<option value="Honduras">Honduras</option>
							<option value="Hong Kong">Hong Kong</option>
							<option value="Hungary">Hungary</option>
							<option value="Iceland">Iceland</option>
							<option value="India">India</option>
							<option value="Indonesia">Indonesia</option>
							<option value="Iran">Iran (Islamic Republic of)</option>
							<option value="Iraq">Iraq</option>
							<option value="Ireland">Ireland</option>
							<option value="Israel">Israel</option>
							<option value="Italy">Italy</option>
							<option value="Jamaica">Jamaica</option>
							<option value="Japan">Japan</option>
							<option value="Jordan">Jordan</option>
							<option value="Kazakhstan">Kazakhstan</option>
							<option value="Kenya">Kenya</option>
							<option value="Kiribati">Kiribati</option>
							<option value="Democratic People's Republic of Korea">Korea, Democratic People's Republic of</option>
							<option value="Korea">Korea, Republic of</option>
							<option value="Kuwait">Kuwait</option>
							<option value="Kyrgyzstan">Kyrgyzstan</option>
							<option value="Lao">Lao People's Democratic Republic</option>
							<option value="Latvia">Latvia</option>
							<option value="Lebanon">Lebanon</option>
							<option value="Lesotho">Lesotho</option>
							<option value="Liberia">Liberia</option>
							<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
							<option value="Liechtenstein">Liechtenstein</option>
							<option value="Lithuania">Lithuania</option>
							<option value="Luxembourg">Luxembourg</option>
							<option value="Macau">Macau</option>
							<option value="Macedonia">Macedonia, The Former Yugoslav Republic of</option>
							<option value="Madagascar">Madagascar</option>
							<option value="Malawi">Malawi</option>
							<option value="Malaysia">Malaysia</option>
							<option value="Maldives">Maldives</option>
							<option value="Mali">Mali</option>
							<option value="Malta">Malta</option>
							<option value="Marshall Islands">Marshall Islands</option>
							<option value="Martinique">Martinique</option>
							<option value="Mauritania">Mauritania</option>
							<option value="Mauritius">Mauritius</option>
							<option value="Mayotte">Mayotte</option>
							<option value="Mexico">Mexico</option>
							<option value="Micronesia">Micronesia, Federated States of</option>
							<option value="Moldova">Moldova, Republic of</option>
							<option value="Monaco">Monaco</option>
							<option value="Mongolia">Mongolia</option>
							<option value="Montserrat">Montserrat</option>
							<option value="Morocco">Morocco</option>
							<option value="Mozambique">Mozambique</option>
							<option value="Myanmar">Myanmar</option>
							<option value="Namibia">Namibia</option>
							<option value="Nauru">Nauru</option>
							<option value="Nepal">Nepal</option>
							<option value="Netherlands">Netherlands</option>
							<option value="Netherlands Antilles">Netherlands Antilles</option>
							<option value="New Caledonia">New Caledonia</option>
							<option value="New Zealand">New Zealand</option>
							<option value="Nicaragua">Nicaragua</option>
							<option value="Niger">Niger</option>
							<option value="Nigeria">Nigeria</option>
							<option value="Niue">Niue</option>
							<option value="Norfolk Island">Norfolk Island</option>
							<option value="Northern Mariana Islands">Northern Mariana Islands</option>
							<option value="Norway">Norway</option>
							<option value="Oman">Oman</option>
							<option value="Pakistan">Pakistan</option>
							<option value="Palau">Palau</option>
							<option value="Panama">Panama</option>
							<option value="Papua New Guinea">Papua New Guinea</option>
							<option value="Paraguay">Paraguay</option>
							<option value="Peru">Peru</option>
							<option value="Philippines">Philippines</option>
							<option value="Pitcairn">Pitcairn</option>
							<option value="Poland">Poland</option>
							<option value="Portugal">Portugal</option>
							<option value="Puerto Rico">Puerto Rico</option>
							<option value="Qatar">Qatar</option>
							<option value="Reunion">Reunion</option>
							<option value="Romania">Romania</option>
							<option value="Russia">Russian Federation</option>
							<option value="Rwanda">Rwanda</option>
							<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
							<option value="Saint LUCIA">Saint LUCIA</option>
							<option value="Saint Vincent">Saint Vincent and the Grenadines</option>
							<option value="Samoa">Samoa</option>
							<option value="San Marino">San Marino</option>
							<option value="Sao Tome and Principe">Sao Tome and Principe</option> 
							<option value="Saudi Arabia">Saudi Arabia</option>
							<option value="Senegal">Senegal</option>
							<option value="Seychelles">Seychelles</option>
							<option value="Sierra">Sierra Leone</option>
							<option value="Singapore">Singapore</option>
							<option value="Slovakia">Slovakia (Slovak Republic)</option>
							<option value="Slovenia">Slovenia</option>
							<option value="Solomon Islands">Solomon Islands</option>
							<option value="Somalia">Somalia</option>
							<option value="South Africa">South Africa</option>
							<option value="South Georgia">South Georgia and the South Sandwich Islands</option>
							<option value="Span">Spain</option>
							<option value="SriLanka">Sri Lanka</option>
							<option value="St. Helena">St. Helena</option>
							<option value="St. Pierre and Miguelon">St. Pierre and Miquelon</option>
							<option value="Sudan">Sudan</option>
							<option value="Suriname">Suriname</option>
							<option value="Svalbard">Svalbard and Jan Mayen Islands</option>
							<option value="Swaziland">Swaziland</option>
							<option value="Sweden">Sweden</option>
							<option value="Switzerland">Switzerland</option>
							<option value="Syria">Syrian Arab Republic</option>
							<option value="Taiwan">Taiwan, Province of China</option>
							<option value="Tajikistan">Tajikistan</option>
							<option value="Tanzania">Tanzania, United Republic of</option>
							<option value="Thailand">Thailand</option>
							<option value="Togo">Togo</option>
							<option value="Tokelau">Tokelau</option>
							<option value="Tonga">Tonga</option>
							<option value="Trinidad and Tobago">Trinidad and Tobago</option>
							<option value="Tunisia">Tunisia</option>
							<option value="Turkey">Turkey</option>
							<option value="Turkmenistan">Turkmenistan</option>
							<option value="Turks and Caicos">Turks and Caicos Islands</option>
							<option value="Tuvalu">Tuvalu</option>
							<option value="Uganda">Uganda</option>
							<option value="Ukraine">Ukraine</option>
							<option value="United Arab Emirates">United Arab Emirates</option>
							<option value="United Kingdom">United Kingdom</option>
							<option value="United States">United States</option>
							<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
							<option value="Uruguay">Uruguay</option>
							<option value="Uzbekistan">Uzbekistan</option>
							<option value="Vanuatu">Vanuatu</option>
							<option value="Venezuela">Venezuela</option>
							<option value="Vietnam">Viet Nam</option>
							<option value="Virgin Islands (British)">Virgin Islands (British)</option>
							<option value="Virgin Islands (U.S)">Virgin Islands (U.S.)</option>
							<option value="Wallis and Futana Islands">Wallis and Futuna Islands</option>
							<option value="Western Sahara">Western Sahara</option>
							<option value="Yemen">Yemen</option>
							<option value="Yugoslavia">Yugoslavia</option>
							<option value="Zambia">Zambia</option>
							<option value="Zimbabwe">Zimbabwe</option>
						</select>
					</div>
					<div class="form-group">
						<label style="font-size:14px;"><?=$lang['Order_By']?></label>
						<select name="order_by" class="chosen">
							<option value="1" <?php if($filter->order_by == 1) { echo 'selected'; } ?>> <?=$lang['Newest']?> </option>
							<option value="2" <?php if($filter->order_by == 2) { echo 'selected'; } ?>> <?=$lang['Oldest']?> </option>
							<option value="3" <?php if($filter->order_by == 3) { echo 'selected'; } ?>> <?=$lang['Last_Online']?> </option>
							<option value="4" <?php if($filter->order_by == 4) { echo 'selected'; } ?>> <?=$lang['Random']?> </option>
						</select>
					</div>
					<div class="form-group">
						<label style="font-size:14px;"><?=$lang['Age']?></label>
						<br>
						<input type="text" id="age_range" name="age_range" class="span2" value="" data-slider-min="<?=$minimum_age?>" data-slider-max="100" data-slider-step="1" data-slider-value="[<?=$filter->age_range?>]">
					</div>
					<div class="form-group">
						<label style="font-size:14px;"><?=$lang['Location_Dating']?></label>
						<br>
						<div class="ckbox ckbox-danger">
							<?php if($filter->location_dating == 1) { ?>
							<input id="location_dating" name="location_dating" checked="checked" type="checkbox">
							<? } else { ?>
							<input id="location_dating" name="location_dating" type="checkbox">
							<? } ?>
							<label for="location_dating"><?=$lang['Location_Dating_Description']?></label>
						</div>
					</div>
					<div class="form-group">
						<label style="font-size:14px;"><?=$lang['Distance']?></label>
						<br>
						<input type="text" id="distance_range" name="distance_range" class="span2" value="" data-slider-min="0" data-slider-max="500" data-slider-step="10" data-slider-value="[<?=$filter->distance_range?>]">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?=$lang['Close']?></button>
					<button type="submit" name="filter" class="btn btn-theme"><?=$lang['Filter']?></button>
				</div>
			</div>
		</form>
	</div>
</div>
