<?php 
 
 // get instances
  $getInstances   = $client->getInstances();
  
  require_once 'class/Options.class.php';
  require_once 'class/Wpp.class.php';
  
  $options = new Options($_SESSION['CLIENT']['id']);
  $wpp     = new Wpp($_SESSION['CLIENT']['id']);
  
  $options_charge      = $options->getOption('setting_charge',true);
  $options_charge_last = $options->getOption('setting_charge_last',true);
  $options_juros_multa = $options->getOption('setting_juros_multa',true);
  
  if(!$options_charge){
     $options_charge                    = new stdClass();
     $options_charge->days_charge       = 'false';
     $options_charge->hours_charge      = '12-16';
     $options_charge->days_antes_charge = '0';
     $options_charge->wpp_charge        = '0';
  }else{
      $options_charge = json_decode($options_charge);
  }
  
  if(!$options_charge_last){
     $options_charge_last                 = new stdClass();
     $options_charge_last->charge_last_1  = 1;
     $options_charge_last->charge_last_2  = 5;
     $options_charge_last->charge_last_3  = 9;
     $options_charge_last->charge_last_4  = 13;
  }else{
      $options_charge_last = json_decode($options_charge_last);
  }
  
  if(!$options_juros_multa){
     $options_juros_multa                  = new stdClass();
     $options_juros_multa->frequency_juros = 'diario';
     $options_juros_multa->juros_n         = '';
     $options_juros_multa->cobrar_multa    = 'sim';
     $options_juros_multa->valor_multa     = '';
     $options_juros_multa->active          = 0;
  }else{
      $options_juros_multa = json_decode($options_juros_multa);
  }
  
  $instance_whats = $wpp->getInstanceClient();

?>
<?php include_once 'inc/head.php'; ?>
<body class="">
  <div class="wrapper ">
    <?php include_once 'inc/sidebar.php'; ?>
    <div class="main-panel" id="main-panel">
      <?php include_once 'inc/navbar.php'; ?>
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">

        <div class="row">

          <div class="col-md-12">
            <div class="form-group">
               
            </div>
          </div>
          
           <input type="hidden" id="interative_qr" value="0" />
           <input type="hidden" id="init_connect" value="0" />
           
           
            <?php if(!$instance_whats){ ?>
              <div class="col-md-12" >
                <p class="alert alert-primary" >
                   <i class="fa-regular fa-face-frown-open"></i> Identifiquei que você não possui um whatsapp conectado! <br />
                   Conecte-se primeiro, depois configure as cobranças. <a class="text-warning" href="instances" > <i class="fa fa-plug" ></i> Conectar</a>
                </p>
             </div>
            <?php } ?>

            <div class="col-lg-6 col-md-12">
                <div class="card" >

                  <div class="card-body">
                    
                    <div class="row">
                        
                        
                        <?php if(strtotime('now') > $dadosClient->due_date){ ?>

                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    <i class="fa fa-warning" ></i> Sua assinatura está expirada. As mensagens de cobrança não serão enviadas.</u>
                                </div>
                             </div>
                               
                         <?php } ?>
                        
                        <div class="col-md-6">
                            <h3 class="pb-0 mb-2" >Configurar cobranças <i class="fa fa-clock" ></i> </h3>
                            <p>Defina o modo de cobranças dos clientes</p>
                        </div>
                        
                        <div class="col-md-6 text-right">
                            <p style="font-size:12px;" >Cortesia de <a href="https://cron-job.org" target="_blank" >cron-job.org <i class="fa fa-heart"></i> </a>  </p>
                        </div>
                        
                        <div class="col-md-3">
                            <?php if(!$instance_whats){ ?><p class="blut_setting"></p><?php } ?>
                            <div class="form-group">
                                <label>Verificar cobranças</label>
                                <select id="days_charge"  class="form-control">
                                    <option <?php if($options_charge->days_charge == "false" ){ echo 'selected'; } ?> value="false" >Não cobrar</option>
                                    <option <?php if($options_charge->days_charge == "all" ){ echo 'selected'; } ?> value="all" >Todos os dias</option>
                                    <option <?php if($options_charge->days_charge == "0" ){ echo 'selected'; } ?> value="0" >Todo Domingo</option>
                                    <option <?php if($options_charge->days_charge == "1" ){ echo 'selected'; } ?> value="1" >Toda Segunda-feira</option>
                                    <option <?php if($options_charge->days_charge == "2" ){ echo 'selected'; } ?> value="2" >Toda Terça-feira</option>
                                    <option <?php if($options_charge->days_charge == "3" ){ echo 'selected'; } ?> value="3" >Toda Quarta-feira</option>
                                    <option <?php if($options_charge->days_charge == "4" ){ echo 'selected'; } ?> value="4" >Toda Quinta-feira</option>
                                    <option <?php if($options_charge->days_charge == "5" ){ echo 'selected'; } ?> value="5" >Toda Sexta-feira</option>
                                    <option <?php if($options_charge->days_charge == "6" ){ echo 'selected'; } ?> value="6" >Todo sábado</option>
                                </select>
                            </div>
                        </div>
                        
                         <div class="col-md-3">
                             <?php if(!$instance_whats){ ?><p class="blut_setting"></p><?php } ?>
                            <div class="form-group">
                                <label>Horário</label>
                                <select id="hours_charge" class="form-control">
                                    <option <?php if($options_charge->hours_charge == "8-12"  ){ echo 'selected'; } ?> value="8-12" >8:00 ás 12:00</option>
                                    <option <?php if($options_charge->hours_charge == "12-16" ){ echo 'selected'; } ?> value="12-16" >12:00 ás 16:00</option>
                                    <option <?php if($options_charge->hours_charge == "16-20" ){ echo 'selected'; } ?> value="16-20" >16:00 ás 20:00</option>
                                    <option <?php if($options_charge->hours_charge == "20-23" ){ echo 'selected'; } ?> value="20-23" >20:00 ás 23:00</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <?php if(!$instance_whats){ ?><p class="blut_setting"></p><?php } ?>
                            <div class="form-group">
                                <label>Cobrança antecipada</label>
                                <select id="days_antes_charge" class="form-control">
                                    <option <?php if($options_charge->days_antes_charge == "0"  ){ echo 'selected'; } ?> value="0" >Não cobrar antecipadamente</option>
                                    <option <?php if($options_charge->days_antes_charge == "1"  ){ echo 'selected'; } ?> value="1" >1 dia</option>
                                    <option <?php if($options_charge->days_antes_charge == "2"  ){ echo 'selected'; } ?> value="2" >2 dias</option>
                                    <option <?php if($options_charge->days_antes_charge == "3"  ){ echo 'selected'; } ?> value="3" >3 dias</option>
                                    <option <?php if($options_charge->days_antes_charge == "4"  ){ echo 'selected'; } ?> value="4" >4 dias</option>
                                    <option <?php if($options_charge->days_antes_charge == "5"  ){ echo 'selected'; } ?> value="5" >5 dias</option>
                                    <option <?php if($options_charge->days_antes_charge == "6"  ){ echo 'selected'; } ?> value="6" >6 dias</option>
                                    <option <?php if($options_charge->days_antes_charge == "7"  ){ echo 'selected'; } ?> value="7" >7 dias</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <?php if(!$instance_whats){ ?><p class="blut_setting"></p><?php } ?>
                            <div class="form-group">
                                <label>Whatsapp de cobrança</label>
                                <select id="wpp_charge" class="form-control">
                                    <option <?php if($options_charge->wpp_charge == '0' ){ echo 'selected'; } ?> value="0" >Selecionar whatsapp</option>
                                    <?php if($getInstances){ foreach($getInstances as $key => $value){ ?>
                                     <option <?php if($options_charge->wpp_charge == $value->id ){ echo 'selected'; } ?> value="<?= $value->id; ?>" ><?= $value->etiqueta; ?></option>
                                    <?php } }else{ ?>
                                    <option value="0" >Nenhum whatsapp conectado</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <?php if($instance_whats){ ?>
                        <div class="col-md-12">
                            <button style="width:100%;" id="saveCharge" class="btn btn-lg btn-success" >Salvar</button>
                        </div>
                        

                        <?php } ?>
                        
                    </div>
                    
                  
                  
                  </div>

                </div>
            </div>
            
            <div class="col-lg-6 col-md-12" >
                <div class="card">
                    <div class="card-body">
                        
                        <div class="row" >
                            
                            <div class="pl-3 col-md-12" >
                                 <h3 class="pb-0 mb-2 "  > <input <?php if(isset($options_charge_last->active)){ if($options_charge_last->active == 1){ echo 'checked';} } ?> type="checkbox" id="charge_last" class="flipswitch" /> Cobranças após o vencimento <i class="fa fa-clock" ></i> </h3>
                                 <p>Monte sua régua de cobranças</p>
                            </div>
                            
                            
                             <div class="col-md-3" >
                                <?php if(!$instance_whats){ ?><p class="blut_setting"></p><?php } ?>
                                <div class="form-group" >
                                    <label>Enviar cobrança após:</label>
                                    <select id="charge_last_1" class="form-control" >
                                        <option <?php if($options_charge_last->charge_last_1 == 1  ){ echo 'selected'; } ?> value="1" >1 dia de vencimento</option>
                                        <option <?php if($options_charge_last->charge_last_1 == 2  ){ echo 'selected'; } ?> value="2" >2 dias de vencimento</option>
                                        <option <?php if($options_charge_last->charge_last_1 == 3  ){ echo 'selected'; } ?> value="3" >3 dias de vencimento</option>
                                        <option <?php if($options_charge_last->charge_last_1 == 4  ){ echo 'selected'; } ?> value="4" >4 dias de vencimento</option>
                                    </select>
                                </div>
                            </div>
                            
                             <div class="col-md-3" >
                                <?php if(!$instance_whats){ ?><p class="blut_setting"></p><?php } ?>
                                <div class="form-group" >
                                    <label>Enviar cobrança após:</label>
                                    <select id="charge_last_2" class="form-control" >
                                        <option <?php if($options_charge_last->charge_last_2 == 5  ){ echo 'selected'; } ?> value="5" >5 dias de vencimento</option>
                                        <option <?php if($options_charge_last->charge_last_2 == 6  ){ echo 'selected'; } ?> value="6" >6 dias de vencimento</option>
                                        <option <?php if($options_charge_last->charge_last_2 == 7  ){ echo 'selected'; } ?> value="7" >7 dias de vencimento</option>
                                        <option <?php if($options_charge_last->charge_last_2 == 8  ){ echo 'selected'; } ?> value="8" >8 dias de vencimento</option>
                                    </select>
                                </div>
                            </div>
                            
                             <div class="col-md-3" >
                                <?php if(!$instance_whats){ ?><p class="blut_setting"></p><?php } ?>
                                <div class="form-group" >
                                    <label>Enviar cobrança após:</label>
                                    <select id="charge_last_3" class="form-control" >
                                        <option <?php if($options_charge_last->charge_last_3 == 9  ){ echo 'selected'; } ?> value="9" >9 dias de vencimento</option>
                                        <option <?php if($options_charge_last->charge_last_3 == 10  ){ echo 'selected'; } ?> value="10" >10 dias de vencimento</option>
                                        <option <?php if($options_charge_last->charge_last_3 == 11  ){ echo 'selected'; } ?> value="11" >11 dias de vencimento</option>
                                        <option <?php if($options_charge_last->charge_last_3 == 12  ){ echo 'selected'; } ?> value="12" >12 dias de vencimento</option>
                                    </select>
                                </div>
                             </div>
                             
                              <div class="col-md-3" >
                                 <?php if(!$instance_whats){ ?><p class="blut_setting"></p><?php } ?>
                                 <div class="form-group" >
                                    <label>Enviar cobrança após:</label>
                                    <select id="charge_last_4" class="form-control" >
                                        <option <?php if($options_charge_last->charge_last_4 == 13  ){ echo 'selected'; } ?> value="13" >13 dias de vencimento</option>
                                        <option <?php if($options_charge_last->charge_last_4 == 14  ){ echo 'selected'; } ?> value="14" >14 dias de vencimento</option>
                                        <option <?php if($options_charge_last->charge_last_4 == 15  ){ echo 'selected'; } ?> value="15" >15 dias de vencimento</option>
                                        <option <?php if($options_charge_last->charge_last_4 == 16  ){ echo 'selected'; } ?> value="16" >16 dias de vencimento</option>
                                    </select>
                                </div>
                             </div>
                            
                            <?php if($instance_whats){ ?>
                                <div class="col-md-12">
                                    <button style="width:100%;" id="saveChargeLast" class="btn btn-lg btn-success" >Salvar</button>
                                </div>
                            <?php } ?>
                            
                        </div>    
                        
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12 col-md-12">
                <div class="card" >

                  <div class="card-body">
                    
                    <div class="row">
                        
                        <div class="col-md-12">
                            <h3 class="pb-0 mb-2" > <input type="checkbox" <?php if($options_juros_multa){ if($options_juros_multa->active == 1){ echo 'checked';} } ?> id="juros_charge" class="flipswitch" /> Juros e multas <i class="fa-sharp fa-solid fa-receipt"></i> </h3>
                            <p>Deseja cobrar juros e multa dos clientes que atrasarem o pagamento das cobranças?</p>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cobras juros</label>
                                <select id="frequency_juros"  class="form-control">
                                    <option <?php if($options_juros_multa->frequency_juros == 'diario'  ){ echo 'selected'; } ?> value="diario" >Diário</option>
                                    <option <?php if($options_juros_multa->frequency_juros == 'semanal'  ){ echo 'selected'; } ?> value="semanal" >Semanal</option>
                                    <option <?php if($options_juros_multa->frequency_juros == 'mensal'  ){ echo 'selected'; } ?> value="mensal" >Mensal</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                 <label>Porcentagem do juros</label>
                                 <input type="number" value="<?php if($options_juros_multa){ echo $options_juros_multa->juros_n; } ?>" placeholder="0%" id="juros_n" class="form-control" />
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cobrar multa</label>
                                <select id="cobrar_multa" class="form-control">
                                    <option <?php if($options_juros_multa->cobrar_multa == 'sim'  ){ echo 'selected'; } ?> value="sim" >Sim</option>
                                    <option <?php if($options_juros_multa->cobrar_multa == 'nao'  ){ echo 'selected'; } ?> value="nao" >Não</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valor da multa</label>
                                <input type="text" placeholder="0,00" value="<?php if($options_juros_multa){ echo $options_juros_multa->valor_multa; } ?>" id="valor_multa" class="form-control" />
                            </div>
                        </div>
                        

                        <div class="col-md-12">
                            <button style="width:100%;" id="saveJuros" class="btn btn-lg btn-success" >Salvar</button>
                        </div>
                        

                    </div>
                    
                  
                  
                  </div>

                </div>
            </div>
            
             <div class="col-md-12">
                <div class="card" >
                  <div class="card-body">
                      
                    <div class="card-head text-success text-center">
                        <h3>Régua de cobranças</h3>
                    </div>
                    
                    <div class="row">
                        
                    
                        <div class="col-md-12">
                            
                            
                             <div class="row text-center" >
                                 
                                 <div class="col-md-2 col-6">
                                 
                                     <h5 class="regua_desinger" ><span style="z-index:3;position: relative;" ><?= $options_charge->days_antes_charge; ?> dia<?php if($options_charge->days_antes_charge>1){ echo 's'; } ?> antes</span>
                                     <br /> 
                                     <span style="font-size: 9px;top: 26px;left: 64px;position: absolute;width: 50%;">Envio de cobrança</span></h5>
                                 
                                 </div>
                                 <div class="col-md-2 col-6">
                                 
                                     <h5 class="regua_desinger" ><span style="z-index:3;position: relative;" >No dia</span>
                                     <br /> 
                                     <span style="font-size: 9px;top: 26px;left: 64px;position: absolute;width: 50%;">Envio de cobrança</span></h5>
                                 
                                 </div>
                                 <div class="col-md-2 col-6">
                                 
                                     <h5 class="regua_desinger" ><span style="z-index:3;position: relative;" ><?= $options_charge_last->charge_last_1 ?> dia<?php if($options_charge_last->charge_last_1>1){ echo 's'; } ?> após</span>
                                     <br /> 
                                     <span style="font-size: 9px;top: 26px;left: 64px;position: absolute;width: 50%;">Envio de cobrança</span></h5>
                                 
                                 </div>
                                 <div class="col-md-2 col-6">
                                 
                                     <h5 class="regua_desinger" ><span style="z-index:3;position: relative;" ><?= $options_charge_last->charge_last_2 ?> dia<?php if($options_charge_last->charge_last_2>1){ echo 's'; } ?> após</span>
                                     <br /> 
                                     <span style="font-size: 9px;top: 26px;left: 64px;position: absolute;width: 50%;">Envio de cobrança</span></h5>
                                 
                                 </div>
                                 <div class="col-md-2 col-6">
                                 
                                     <h5 class="regua_desinger" ><span style="z-index:3;position: relative;" ><?= $options_charge_last->charge_last_3 ?> dia<?php if($options_charge_last->charge_last_3>1){ echo 's'; } ?> após</span>
                                     <br /> 
                                     <span style="font-size: 9px;top: 26px;left: 64px;position: absolute;width: 50%;">Envio de cobrança</span></h5>
                                 
                                 </div>
                                 <div class="col-md-2 col-6">
                                 
                                     <h5 class="regua_desinger" ><span style="z-index:3;position: relative;" ><?= $options_charge_last->charge_last_4 ?> dia<?php if($options_charge_last->charge_last_4>1){ echo 's'; } ?> após</span>
                                     <br /> 
                                     <span style="font-size: 9px;top: 26px;left: 64px;position: absolute;width: 50%;">Envio de cobrança</span></h5>
                                 
                                 </div>
                                 
                             </div>

                                
                         </div>
                        

                        
                        <div class="col-md-8 mt-4">
                             <small>
                                 Crie sua régua de cobranças e evite inadimplências.
                             </small>
                        </div>
                        
                    </div>

                  </div>
                </div>
            </div>
            
        </div>
      </div>

      


      <?php include_once 'inc/footer.php'; ?>
