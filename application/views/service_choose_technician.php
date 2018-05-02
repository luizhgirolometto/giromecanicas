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
					Step 5 of 6 - Assign Technician
				</div>	
				<div class="panel-body" style="padding: 25px;">
					
					<form class="form-horizontal" action="<?=base_url()?>services/verify_step" method="post">
						
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
						
						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>Service Package</b>
							</div>
							<div class="col-md-10">
								: 
								<?php 
                                    $pack_list_name    = "";
                                    for ($p = 0; $p < count($packArray); $p++) {
                                        $pack_id        = $packArray[$p];
                                        
                                        if (!empty($pack_id)) {
                                            $packNameData    = $this->Constant_model->getDataOneColumn("service_packages", "id", $pack_id);
                                        
                                            $pack_list_name    .= $packNameData[0]->name.", ";
                                        }
                                    }
                                    $pack_list_name    = trim($pack_list_name, ", ");
                                    
                                    if (empty($pack_list_name)) {
                                        echo "-";
                                    } else {
                                        echo $pack_list_name;
                                    }
                                ?>
							</div>
						</div>
						
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12" style="border-top: 1px solid #ddd;"></div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h4 style="font-weight: bold; padding-bottom: 10px;">
									Assign Technician
								</h4>
							</div>
						</div>	
						
						
							
						<fieldset>
							<div class="row">
								<div class="col-md-4"></div>
								<div class="col-md-4">
							<div class="table-responsive" style="margin-top: 10px; border-top: 0px solid #ddd;">
								<table class="table">
									<thead>
										<tr>
									    	<th width="5%" style="border-bottom: 1px solid #111; height: 40px;"><span>Choose</span></th>
								            <th width="20%" style="border-bottom: 1px solid #111; height: 40px;"><span>Technician Name</span></th>
									    </tr>
									</thead>
									<tbody>
									<?php
                                        $userDtaResult    = $this->db->query("SELECT * FROM users WHERE role_id = '3' AND status = '1' ");
                                        $userDtaData    = $userDtaResult->result();
                                        
                                        for ($t = 0; $t < count($userDtaData); $t++) {
                                            $tech_id        = $userDtaData[$t]->id;
                                            $tech_fn        = $userDtaData[$t]->fullname; ?>
											<tr>
												<td>
													<input type="radio" name="tech" value="<?php echo $tech_id; ?>" required />
												</td>
												<td>
													<?php echo $tech_fn; ?>
												</td>
												
											</tr>
									<?php
                                            unset($tech_id);
                                            unset($tech_fn);
                                        }
                                        unset($userDtaResult);
                                        unset($userDtaData);
                                    ?>
									</tbody>
								</table>
							</div>
							
							
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
								
									<button type="submit" class="btn btn-primary btn-md" style="padding-left: 30px; padding-right: 30px;">
										Next
									</button>
								
								</div>
								<div class="col-md-2"></div>
							</div>
								</div>
								<div class="col-md-4"></div>
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