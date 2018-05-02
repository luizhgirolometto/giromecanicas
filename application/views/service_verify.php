<?php
    require_once "includes/header.php";
    
    $carData    = $this->Constant_model->getDataOneColumn("cars", "id", $car_id);
    
    $car_owner_id    = $carData[0]->owner_id;
    $car_make_id    = $carData[0]->car_make_id;
    $car_model        = $carData[0]->car_model;
    $car_plate        = $carData[0]->plate_number;
    $car_color        = $carData[0]->color;
    
    
    $owner_name    = "";
    $ownerData        = $this->Constant_model->getDataOneColumn("customers", "id", $car_owner_id);
    if (count($ownerData) == 1) {
        $owner_name    = $ownerData[0]->firstname." ".$ownerData[0]->lastname;
    }
    
    $make_type        = "";
    $make_name        = "";
    $makeData        = $this->Constant_model->getDataOneColumn("car_make", "id", $car_make_id);
    if (count($makeData) == 1) {
        $make_name    = $makeData[0]->name;
        $make_type    = $makeData[0]->type;
    }
    
    $packArray        = explode(",", $pack_list);
?>
<script src="<?=base_url()?>assets/multisteps/jquery-1.8.2.min.js"></script>
<script src="<?=base_url()?>assets/multisteps/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/multisteps/jquery.wizard.js"></script>
<!-- <link href="<?=base_url()?>assets/multisteps/bootstrap.min.css" rel="stylesheet" media="screen"> -->
<link href="<?=base_url()?>assets/multisteps/jquery.wizard.css" rel="stylesheet">
<style type="text/css">
  
  .sidebar-nav {
    padding: 9px 0;
  }

  [data-wizard-init] {
	margin: auto;
	width: 600px;
  }
</style>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Open New Service</h1>
		</div>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">				
				<div class="panel-heading">
					Step 6 of 6 - Verify New Service
				</div>	
				<div class="panel-body" style="padding: 25px;">
					
					<form class="form-horizontal" action="<?=base_url()?>services/confirmService" method="post" onsubmit="return confirm('Are you confirm to Open New Service for Plate Number : <?php echo $car_plate; ?>?')" onsubmit="kk()">
						
						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>Car Owner</b>
							</div>
							<div class="col-md-10">
								: <?php echo $owner_name; ?>
							</div>
						</div>
						
						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>Car Plate Number</b>
							</div>
							<div class="col-md-10">
								: <?php echo $car_plate; ?>
							</div>
						</div>
						
						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>Car Make & Model</b>
							</div>
							<div class="col-md-10">
								: <?php echo $make_name." ".$car_model; ?>
							</div>
						</div>
						
						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>Color</b>
							</div>
							<div class="col-md-10">
								: <?php echo $car_color; ?>
							</div>
						</div>
						
						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>Current Mileage</b>
							</div>
							<div class="col-md-10">
								: <?php echo $mileage; ?> km
							</div>
						</div>
						
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12" style="border-top: 1px solid #ddd;"></div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h4 style="font-weight: bold; padding-top: 10px;">
									Service Package
								</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3"></div>
							<div class="col-md-6">
								<div class="table-responsive">
									<table class="table">
										<tr>
								            <th width="20%" style="border-bottom: 1px solid #111; height: 40px; border-top: 0px;"><span>Package Name</span></th>
									    	<th width="10%" style="border-bottom: 1px solid #111; height: 40px; border-top: 0px;"><span>Package Price</span></th>
										</tr>
										<?php
                                            for ($p = 0; $p < count($packArray); $p++) {
                                                $pack_id        = $packArray[$p];
                                                
                                                if (!empty($pack_id)) {
                                                    $packNameData    = $this->Constant_model->getDataOneColumn("service_packages", "id", $pack_id);
                                                
                                                    $pack_name        = $packNameData[0]->name;
                                                    $pack_price    = $packNameData[0]->price; ?>
													<tr>
														<td><?php echo $pack_name; ?></td>
														<td><?php echo "$".number_format($pack_price, 2); ?></td>
													</tr>
										<?php

                                                }
                                            }
                                        ?>
									</table>
								</div>
							</div>
							<div class="col-md-3"></div>
						</div>
						
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12" style="border-top: 1px solid #ddd;"></div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h4 style="font-weight: bold; padding-top: 10px;">
									Report Defects
								</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3"></div>
							<div class="col-md-6">
								<div class="table-responsive">
									<table class="table">
										<tr>
								            <th width="20%" style="border-bottom: 1px solid #111; height: 40px; border-top: 0px;"><span>Report Defects Name</span></th>
									    	<th width="10%" style="border-bottom: 1px solid #111; height: 40px; border-top: 0px;"><span>Report Defects Remark</span></th>
										</tr>
										<?php
                                            if (!empty($tyres)) {
                                                ?>
												<tr>
													<td>Tyres</td>
													<td><?php echo $tyres; ?></td>
												</tr>
										<?php	
                                            }
                                        ?>
										<?php
                                            if (!empty($steering)) {
                                                ?>
												<tr>
													<td>Steering</td>
													<td><?php echo $steering; ?></td>
												</tr>
										<?php	
                                            }
                                        ?>
										<?php
                                            if (!empty($engine)) {
                                                ?>
												<tr>
													<td>Engine</td>
													<td><?php echo $engine; ?></td>
												</tr>
										<?php	
                                            }
                                        ?>
										<?php
                                            if (!empty($suspension)) {
                                                ?>
												<tr>
													<td>Suspension</td>
													<td><?php echo $suspension; ?></td>
												</tr>
										<?php	
                                            }
                                        ?>
										<?php
                                            if (!empty($battery)) {
                                                ?>
												<tr>
													<td>Battery</td>
													<td><?php echo $battery; ?></td>
												</tr>
										<?php	
                                            }
                                        ?>
										<?php
                                            if (!empty($others)) {
                                                ?>
												<tr>
													<td>Others</td>
													<td><?php echo $others; ?></td>
												</tr>
										<?php	
                                            }
                                        ?>
									</table>
								</div>
							</div>
							<div class="col-md-3"></div>
						</div>
						
						
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12" style="border-top: 1px solid #ddd;"></div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h4 style="font-weight: bold; padding-top: 10px;">
									Technician
								</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3"></div>
							<div class="col-md-6">
								<div class="table-responsive">
									<table class="table">
										<tr>
								            <th width="20%" style="border-bottom: 1px solid #111; height: 40px; border-top: 0px;"><span>Technician Name</span></th>
									    </tr>
									    <tr>
										    <td>
										<?php
                                            $userDtaResult    = $this->db->query("SELECT * FROM users WHERE id = '$tech' ");
                                            $userDtaData    = $userDtaResult->result();
                                        
                                            echo $userDtaData[0]->fullname;
                                            
                                            unset($userDtaResult);
                                            unset($userDtaData);
                                        ?>
										    </td>
									    </tr>
									</table>
								</div>
							</div>
							<div class="col-md-3"></div>
						</div>
						
						
						
						
						
						
						
							
						<fieldset>
							
							
							<div class="form-group">
								<div class="col-md-2"></div>
								<div class="col-md-8" style="text-align: center;">
									
									<input type="hidden" name="car_id" value="<?php echo $car_id; ?>" />
									<input type="hidden" name="pack_list" value="<?php echo $pack_list; ?>" />
									<input type="hidden" name="mileage" value="<?php echo $mileage; ?>" />
									
									<input type="hidden" name="tyres" value="<?php echo $tyres; ?>" />
									<input type="hidden" name="steering" value="<?php echo $steering; ?>" />
									<input type="hidden" name="engine" value="<?php echo $engine; ?>" />
									<input type="hidden" name="suspension" value="<?php echo $suspension; ?>" />
									<input type="hidden" name="battery" value="<?php echo $battery; ?>" />
									<input type="hidden" name="others" value="<?php echo $others; ?>" />
									
									<input type="hidden" name="tech" value="<?php echo $tech; ?>" />
								
									<button type="submit" class="btn btn-primary btn-md" style="padding-left: 30px; padding-right: 30px;">
										Submit
									</button>
									
									<span id="pwait" style="display: none; font-size: 14px; font-weight: 300; font-family: 'Futura,Trebuchet MS',Arial,sans-serif;">
										<img src="<?=base_url()?>assets/images/loading.gif" />
										&nbsp;Processing.....
									</span>
									
								</div>
								<div class="col-md-2"></div>
							</div>
								</div>
								<div class="col-md-3"></div>
							</div>
								
								
						</fieldset>
					</form>
				
					
				</div>
			</div>
		</div>
	</div>
	
</div>

<?php
    require_once "includes/footer.php";
?>