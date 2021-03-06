<?php
    require_once "includes/header.php";
?>
<!-- Select2 -->
<link href="<?=base_url()?>assets/css/select2.min.css" rel="stylesheet">

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Inserir Cliente</h1>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				
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
					
					<form class="form-horizontal" action="<?=base_url()?>customers/insertCustomer" method="post" onsubmit="kk()">
						<fieldset>
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									CPF/CPNJ <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="nric" required style="width: 100%;" autofocus autocomplete="off" />
								</div>
								<div class="col-md-3"></div>
							</div>
						
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Primeiro Nome <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="fn" required style="width: 100%;" autocomplete="off" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Sobrenome
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="ln" style="width: 100%;" autocomplete="off" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									E-mail
								</label>
								<div class="col-md-7">
									<input type="email" class="form-control" name="em" style="width: 100%;" autocomplete="off" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Telefone <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="mb" required style="width: 100%;" autocomplete="off" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Endereço
								</label>
								<div class="col-md-7">
									<textarea name="address" class="form-control"></textarea>
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									CEP
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="postal" style="width: 100%;" autocomplete="off" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									País
								</label>
								<div class="col-md-7">
									<select class="add_cust_country form-control" name="country" tabindex="-1" style="width: 100%;">
										<option value="">Selecione País</option>
									<?php
                                        $countryData        = $this->Constant_model->getDataAll("countries", "name", "ASC");
                                        for ($c = 0; $c < count($countryData); $c++) {
                                            $country_code        = $countryData[$c]->code;
                                            $country_name        = $countryData[$c]->name; ?>
											<option value="<?php echo $country_code; ?>">
												<?php echo $country_name; ?>
											</option>
									<?php

                                        }
                                    ?>
									</select>
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Grupo de Cliente
								</label>
								<div class="col-md-7">
									<select class="add_cust_group form-control" name="customer_group" tabindex="-1" style="width: 100%;" required>
									<?php
                                        $groupData        = $this->Constant_model->getDataOneColumnSortColumn("customer_groups", "status", "1", "id", "ASC");
                                        for ($g = 0; $g < count($groupData); $g++) {
                                            $group_id        = $groupData[$g]->id;
                                            $group_name    = $groupData[$g]->name; ?>
											<option value="<?php echo $group_id; ?>">
												<?php echo $group_name; ?>
											</option>
									<?php

                                        }
                                    ?>
									</select>	
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Status <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<select name="status" class="form-control">
										<option value="1">Ativo</option>
										<option value="0">Inativo</option>
									</select>
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<div class="col-md-2"></div>
								<div class="col-md-7 widget-left" style="height: auto; padding-top: 0px;">
									
									<button type="submit" class="btn btn-primary btn-md pull-left" id="nextGo">&nbsp;&nbsp;&nbsp;Inserir&nbsp;&nbsp;&nbsp;</button>
									
									<span id="pwait" style="display: none; font-size: 14px; font-weight: 300; font-family: 'Futura,Trebuchet MS',Arial,sans-serif;">
										<img src="<?=base_url()?>assets/images/loading.gif" />
										&nbsp;Processing.....
									</span>
									
								</div>
								<div class="col-md-3"></div>
							</div>
						</fieldset>
					</form>
					
				</div>
			</div>
			
			<a href="<?=base_url()?>customers/customer_lists" style="text-decoration: none;">
				<button type="reset" class="btn btn-default" style="background-color: #747274; color: #FFF;">&nbsp;&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;&nbsp;</button>
			</a>
		</div>
	</div>
	
</div>

<script src="<?=base_url()?>assets/js/select2.full.min.js"></script>
<!-- Select2 -->
<script>
	$(document).ready(function() {
		
		$(".add_cust_country").select2({
			placeholder: "Selecione o Pais",
			allowClear: true
		});
		
		$(".add_cust_group").select2({
			placeholder: "Selecione o grupo",
			allowClear: true
		});
		
		$(".add_car_owner").select2({
			placeholder: "Selecione o Proprietário",
			allowClear: true
		});
		
		$(".add_car_make").select2({
			placeholder: "Selecione o modelo do veículo",
			allowClear: true
		});
		
		$(".assign_task").select2({
			placeholder: "Escolha Tarefa Para Pacote de Serviços",
			allowClear: true
		});
	
	});
</script>
<!-- /Select2 -->

<?php
    require_once "includes/footer.php";
?>