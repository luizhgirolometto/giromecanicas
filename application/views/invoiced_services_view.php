<?php
    require_once "includes/header.php";
    
    $serviceDtaData        = $this->Constant_model->getDataOneColumn("service_jobs", "id", $job_id);
    if (count($serviceDtaData) == 0) {
        redirect(base_url().'services/invoiced_services', 'refresh');
    }
    
    $cust_fn                = $serviceDtaData[0]->firstname;
    $cust_ln                = $serviceDtaData[0]->lastname;
    $cust_em                = $serviceDtaData[0]->email;
    $cust_mb                = $serviceDtaData[0]->mobile;
    $car_id                = $serviceDtaData[0]->car_id;
    $car_plate_numb        = $serviceDtaData[0]->car_plate_number;
    $car_mileage            = $serviceDtaData[0]->mileage_after;
    $service_advisor_id    = $serviceDtaData[0]->service_advisor_id;
    $service_tech_id        = $serviceDtaData[0]->technician_id;
    $service_date            = date("$dateformat h:i A", strtotime($serviceDtaData[0]->created_datetime));
    $service_status_id        = $serviceDtaData[0]->status;
    $invoice_numb            = $serviceDtaData[0]->invoice_number;
    $invoice_date            = date("$dateformat h:i A", strtotime($serviceDtaData[0]->invoice_datetime));
    $dis_percent            = $serviceDtaData[0]->discount_percentage;
    $dis_amt                = $serviceDtaData[0]->discount_amt;
    $subTotal_amt            = $serviceDtaData[0]->subtotal_amt;
    $taxTotal_amt            = $serviceDtaData[0]->tax_amt;
    $grandTotal_amt        = $serviceDtaData[0]->grandtotal_amt;
    
    $advisor_fullname        = "";
    $advisorDtaData        = $this->Constant_model->getDataOneColumn("users", "id", $service_advisor_id);
    $advisor_fullname        = $advisorDtaData[0]->fullname;
    
    $technician_name        = "";
    $techDtaData            = $this->Constant_model->getDataOneColumn("users", "id", $service_tech_id);
    $technician_name        = $techDtaData[0]->fullname;
    
    
    $siteDtaResult            = $this->db->get_where('site_setting');
    $siteDtaData            = $siteDtaResult->row();
    
    $siteDta_name            = $siteDtaData->site_name;
    $siteDta_address        = $siteDtaData->address;
    $siteDta_tel            = $siteDtaData->telephone;
    $siteDta_fax            = $siteDtaData->fax;
    $siteData_logo            = $siteDtaData->site_logo;
    
    $carDtaData            = $this->Constant_model->getDataOneColumn("cars", "id", $car_id);
    $car_model                = $carDtaData[0]->car_model;
    $car_make_id            = $carDtaData[0]->car_make_id;
    $car_color                = $carDtaData[0]->color;
    
    $carMakeNameData        = $this->Constant_model->getDataOneColumn("car_make", "id", $car_make_id);
    $car_make_name            = $carMakeNameData[0]->name;
    
    $status_name    = "";
    $statusNameData    = $this->Constant_model->getDataOneColumn("service_job_status", "id", $service_status_id);
    $status_name    = $statusNameData[0]->name;
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
			<h1 class="page-header">Serviços Faturados para o id#<?php echo $job_id; ?></h1>
		</div>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">				
				<div class="panel-heading">
					<table border="0" style="border-collapse: collapse; width: 100%; height: auto;">
						<tr>
							<td width="50%">
								Serviços Faturados para: Id #<?php echo $job_id; ?>
							</td>
							<td width="50%" style="text-align: right;"></td>
						</tr>
					</table>
				</div>	
				<div class="panel-body" style="padding: 10px 15px 15px 15px;">
					
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
                    
                    <div class="row" style="border-bottom: 1px solid #ddd; padding-bottom: 15px;">
	                    <div class="col-md-5">
		                    <div class="row">
			                    <div class="col-md-12">
				                    <label style="font-size: 18px;">Detalhes do Cliente</label>
			                    </div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Nome</div>
			                    <div class="col-md-8">: <?php echo $cust_fn." ".$cust_ln; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Telefone</div>
			                    <div class="col-md-8">: <?php echo $cust_mb; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">E-mail</div>
			                    <div class="col-md-8">: <?php echo $cust_em; ?></div>
		                    </div>
		                    
		                    <div class="row" style="padding-top: 15px;">
			                    <div class="col-md-12">
				                    <label style="font-size: 18px;">Detalhes do Veículo</label>
			                    </div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Fabricante</div>
			                    <div class="col-md-8">: <?php echo $car_make_name; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Modelo</div>
			                    <div class="col-md-8">: <?php echo $car_model; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Placa</div>
			                    <div class="col-md-8">: <?php echo $car_plate_numb; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Cor</div>
			                    <div class="col-md-8">: <?php echo $car_color; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Odômetro</div>
			                    <div class="col-md-8">: <?php echo $car_mileage; ?>KM</div>
		                    </div>
		                    
	                    </div><!-- Left // END -->
	                    <div class="col-md-7">
		                    
		                    <div class="row">
			                    <div class="col-md-12">
				                    <label style="font-size: 18px;">Detalhes do Serviço</label>
			                    </div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Número do Pedido</div>
			                    <div class="col-md-8">: <?php echo $invoice_numb; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Id</div>
			                    <div class="col-md-8">: #<?php echo $job_id; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Data Serviço &amp; Tempo</div>
			                    <div class="col-md-8">: <?php echo $service_date; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Data da Fatura &amp; Tempo</div>
			                    <div class="col-md-8">: <?php echo $invoice_date; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Placa</div>
			                    <div class="col-md-8">: <?php echo $car_plate_numb; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Odômetro Atual</div>
			                    <div class="col-md-8">: <?php echo $car_mileage; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Vendedor</div>
			                    <div class="col-md-8">: <?php echo $advisor_fullname; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Mecânico</div>
			                    <div class="col-md-8">: <?php echo $technician_name; ?></div>
		                    </div>
		                    
	                    </div><!-- Right // END -->
                    </div>
					
					<?php
                        $serpackResult        = $this->db->query("SELECT * FROM service_job_packages WHERE service_job_id = '$job_id' ORDER BY id DESC ");
                        $serpackRows        = $serpackResult->num_rows();
                        
                        if ($serpackRows > 0) {
                            ?>
					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table">
									<tr>
										<td colspan="2" width="100%" style="border-top: 0px; padding-left: 0px; font-size: 18px; padding-bottom: 0px;">
											<label>Pacote de Serviços</label>
										</td>
									</tr>
									<tr>
							            <th width="80%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 40px; border-top: 0px; background-color: #9b9b9b; color: #FFF;"><span>Pacote</span></th>
								    	<th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 40px; border-top: 0px; background-color: #9b9b9b; color: #FFF; text-align: right;"><span>Preço</span></th>
									</tr>
									<?php
                                        $serpackData    = $serpackResult->result();
                            for ($sp = 0; $sp < count($serpackData); $sp++) {
                                $serpack_name        = $serpackData[$sp]->package_name;
                                $serpack_price        = $serpackData[$sp]->package_price; ?>
											<tr>
												<td><?php echo $serpack_name; ?></td>
												<td style="text-align: right;"><?php echo "$".number_format($serpack_price, 2); ?></td>
											</tr>
									<?php
                                            unset($serpack_name);
                                unset($serpack_price);
                            }
                            unset($serpackData); ?>
								</table>
							</div>
						</div>
					</div>
					<?php

                        }
                        unset($serpackResult);
                        unset($serpackRows);
                    ?>
					
					<?php
                        $defectResult        = $this->db->query("SELECT * FROM service_job_defects WHERE service_job_id = '$job_id' ORDER BY id DESC ");
                        $defectRows        = $defectResult->num_rows();
                        if ($defectRows > 0) {
                            ?>
							<div class="row" style="margin-top: 0px;">
								<div class="col-md-12">
									<div class="table-responsive">
										<table class="table">
											<tr>
												<td colspan="3" width="100%" style="border-top: 0px; padding-left: 0px; font-size: 18px; padding-bottom: 0px;">
													<label>Peças Informadas com Defeito</label>
												</td>
											</tr>
											<tr>
									            <th width="40%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 40px; border-top: 0px; background-color: #9b9b9b; color: #FFF;"><span>Informação de Defeitos (OBS)</span></th>
									            <th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 40px; border-top: 0px; background-color: #9b9b9b; color: #FFF;"><span>Peças</span></th>
									            <th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 40px; border-top: 0px; background-color: #9b9b9b; color: #FFF;"><span>Qtde.</span></th>
									            <th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 40px; border-top: 0px; background-color: #9b9b9b; color: #FFF;"><span>Por Item</span></th>
										    	<th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 40px; border-top: 0px; background-color: #9b9b9b; color: #FFF;"><span>Preço</span></th>
											</tr>
											<?php
                                                $defectData    = $defectResult->result();
                            for ($df = 0; $df < count($defectData); $df++) {
                                $defect_id            = $defectData[$df]->id;
                                $defect_name        = $defectData[$df]->defect_name;
                                $defect_remark        = $defectData[$df]->remarks;
                                                    
                                $defectMatResult    = $this->db->query("SELECT * FROM service_job_defects_material WHERE service_job_defects_id = '$defect_id' AND customer_approved = '1' AND status = '1' ");
                                $defectMatData        = $defectMatResult->result();
                                for ($dfm = 0; $dfm < count($defectMatData); $dfm++) {
                                    $mat_name        = $defectMatData[$dfm]->material_name;
                                    $mat_issued_qty    = $defectMatData[$dfm]->issued_qty;
                                    $mat_price        = $defectMatData[$dfm]->price;
                                                        
                                    $each_row_price = 0;
                                    $each_row_price = $mat_issued_qty * $mat_price; ?>
											<tr>
												<td>
													<?php
                                                        if ($dfm == 0) {
                                                            echo $defect_name;
                                                        
                                                            if (!empty($defect_remark)) {
                                                                echo "(".$defect_remark.")";
                                                            }
                                                        } ?>
												</td>
												<td><?php echo $mat_name; ?></td>
												<td><?php echo $mat_issued_qty; ?></td>
												<td><?php echo "$".number_format($mat_price, 2); ?></td>
												<td style="text-align: right;"><?php echo "$".number_format($each_row_price, 2); ?></td>
											</tr>	
											<?php
                                                        unset($mat_name);
                                    unset($mat_issued_qty);
                                    unset($mat_price);
                                }
                                unset($defectMatResult);
                                unset($defectMatData);

                                unset($defect_id);
                                unset($defect_name);
                                unset($defect_remark);
                            }
                            unset($defectData); ?>
										</table>
									</div>
								</div>
							</div>
					<?php

                        }
                        unset($defectResult);
                        unset($defectRows);
                    ?>
					
					<div class="row" style="border-top: 1px solid #ddd; padding-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table">
									<?php
                                        if ($dis_percent > 0) {
                                            ?>
									<tr>
										<td width="50%" height="30px" style="border-top: 0px; padding: 0px;"></td>
										<td width="30%" style="text-align: right; border-top: 0px; padding: 0px;" valign="middle">
											<label style="font-weight: bold;">Desconto (<?php echo $dis_percent; ?>%) :</label>
										</td>
										<td width="20%" style="border-top: 0px; text-align: right; padding: 0px;">
											<label style="font-weight: bold; padding-right: 7px;">-$<?php echo number_format(abs($dis_amt), 2); ?></label>
										</td>
									</tr>
									<?php

                                        }
                                    ?>
									
									<tr>
										<td width="50%" height="30px" style="border-top: 0px; padding: 0px;"></td>
										<td width="30%" style="text-align: right; border-top: 0px; padding: 0px;" valign="middle">
											<label style="font-weight: bold;">Sub Total :</label>
										</td>
										<td width="20%" style="border-top: 0px; text-align: right; padding: 0px;">
											<label style="font-weight: bold; padding-right: 7px;">$<?php echo number_format($subTotal_amt, 2); ?></label>
										</td>
									</tr>
									<tr>
										<td width="50%" height="30px" style="border-top: 0px; padding: 0px;"></td>
										<td width="30%" style="text-align: right; border-top: 0px; padding: 0px;">
											<label style="font-weight: bold;">Taxas :</label>
										</td>
										<td width="20%" style="border-top: 0px; text-align: right; padding: 0px;">
											<label style="font-weight: bold; padding-right: 7px;">$<?php echo number_format($taxTotal_amt, 2); ?></label>
										</td>
									</tr>
									<tr>
										<td width="50%" height="30px" style="border-top: 0px; padding: 0px;"></td>
										<td width="30%" style="text-align: right; border-top: 0px; padding: 0px;">
											<label style="font-weight: bold;">Total :</label>
										</td>
										<td width="20%" style="border-top: 0px; text-align: right; padding: 0px;">
											<label style="font-weight: bold; padding-right: 7px;">$<?php echo number_format($grandTotal_amt, 2); ?></label>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					
					<?php
                        if ($service_status_id == "6") {
                            ?>
						<div class="row" style="padding-top: 20px; padding-bottom: 20px;">
							<div class="col-md-12" style="text-align: center;">
								<a href="<?=base_url()?>services/paymentInvoice?job_id=<?php echo $job_id; ?>" style="text-decoration: none;">
									<div class="btn btn-primary" style="padding: 14px 30px; font-size: 20px;">
										Formas de Pagamento
									</div>
								</a>
							</div>	
						</div>
					<?php

                        }
                    ?>
					
					
					
				</div>
			</div>
		</div>
	</div>
	
	<a href="<?=base_url()?>services/invoiced_services" style="text-decoration: none;">
		<div class="btn btn-default" style="background-color: #4a4a4a; color: #FFF; border-radius: 3px; border: 1px solid #111;">
			&nbsp;&nbsp;Voltar&nbsp;&nbsp;
		</div>
	</a>
	
</div>

<?php
    require_once "includes/footer.php";
?>