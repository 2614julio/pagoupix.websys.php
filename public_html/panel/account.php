
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
          
            <div class="col-md-12">
                <div class="card" >

                  <div class="card-body">
                    
                    <div class="row">
                        
                        <div class="col-md-12">
                            <h3>Seus dados <i class="fa fa-user" ></i> </h3>
                        </div>
 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" id="nome" placeholder="Seu nome" value="<?= $dadosClient->nome; ?>" class="form-control" />
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Whatsapp</label>
                                <input type="text" id="whatsapp" placeholder="Seu whatsapp" value="<?= $dadosClient->whatsapp ? $dadosClient->whatsapp : ""; ?>" class="form-control" />
                            </div>
                        </div>
                        
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="email" id="email" placeholder="Seu email" value="<?= $dadosClient->email; ?>" class="form-control" />
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Senha</label>
                                <input autocomplete="false" type="password" id="pass" placeholder="Nova senha" value="" class="form-control" />
                                <small style="font-size:10px;" >Use uma senha com mais de 6 caracteres com letras e números maiúsculas e minúsculas</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Repita a senha</label>
                                <input autocomplete="false" type="password" id="pass_confirm" placeholder="Repita a senha" value="" class="form-control" />
                            </div>
                        </div>


                        <div class="col-md-12">
                            <button style="width:100%;" id="saveUser" class="btn btn-lg btn-success" >Salvar</button>
                        </div>


                    </div>
                    
                  
                  
                  </div>

                </div>
            </div>
        </div>
      </div>

      


      <?php include_once 'inc/footer.php'; ?>
