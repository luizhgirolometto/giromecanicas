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
					Step 3 of 6 - Choose Servicing Package
				</div>	
				<div class="panel-body" style="padding: 25px;">
					
					<?php
                        if (!empty($alert_msg)) {
                            $flash_status = $alert_msg[0];
                            $flash_header = $alert_msg[1];
                            $flash_desc = $alert_msg[2];

                            if ($flash_status == 'failure') {
                                ?>
							<div class="row" id="notificationWrp">
								<div class="col-md-12">
									<div class="alert bg-warning" role="alert">
										<i class="icono-exclamationCircle" style="color: #FFF;"></i> 
										<?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
									</div>
								</div>
							</div>
					<?php	
                            }
                            if ($flash_status == 'success') {
                                ?>
							<div class="row" id="notificationWrp">
								<div class="col-md-12">
									<div class="alert bg-success" role="alert">
										<i class="icono-check" style="color: #FFF;"></i> 
										<?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
									</div>
								</div>
							</div>
					<?php

                            }
                        }
                    ?>
					
					<form class="form-horizontal" action="<?=base_url()?>services/fourth_step" method="post">
						<input type="hidden" name="car_id" value="<?php echo $car_id; ?>" />
					
					<h4 style="font-weight: bold; padding-bottom: 10px; margin-top: -10px;">
						Choose Service Package
					</h4>
					
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
							<input type="text" name="mileage" class="form-control" style="width: 50%;" autocomplete="off" autofocus required />
						</div>
					</div>
					
					
						<fieldset>
							
							<div class="table-responsive" style="margin-top: 10px; border-top: 1px solid #ddd;">
								<table class="table">
									<thead>
										<tr>
									    	<th width="5%" style="border-bottom: 1px solid #111; height: 40px;"><span>Choose</span></th>
								            <th width="20%" style="border-bottom: 1px solid #111; height: 40px;"><span>Service Package Name</span></th>
									    	<th width="10%" style="border-bottom: 1px solid #111; height: 40px;"><span>Price</span></th>
										</tr>
									</thead>
									<tbody>
									<?php
                                        $packResult    = $this->db->query("SELECT * FROM service_packages WHERE car_make_type = '$make_type' ORDER BY price DESC ");
                                        $packData        = $packResult->result();
                                        
                                        for ($p = 0; $p < count($packData); $p++) {
                                            $pack_id        = $packData[$p]->id;
                                            $pack_name        = $packData[$p]->name;
                                            $pack_price    = $packData[$p]->price; ?>
											<tr>
												<td>
													<input type="checkbox" name="pack_id[]" value="<?php echo $pack_id; ?>" />
												</td>
												<td>
													<?php echo $pack_name; ?>
												</td>
												<td>
													<?php echo "$".number_format($pack_price, 2, '.', ''); ?>
												</td>
											</tr>
									<?php
                                            unset($pack_id);
                                            unset($pack_name);
                                            unset($pack_price);
                                        }
                                        
                                        unset($packResult);
                                        unset($packData);
                                    ?>
										<tr>
											<td colspan="3" align="center" style="text-align: center;">
												<button type="submit" class="btn btn-primary btn-md" style="padding-left: 30px; padding-right: 30px;">
													Next
												</button>
											</td>
										</tr>
									</tbody>
								</table>
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