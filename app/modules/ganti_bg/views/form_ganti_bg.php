<link href="<?php echo base_url();?>assets/plugins/parsley/src/parsley.css" rel="stylesheet" />

<script src="<?php echo base_url();?>assets/plugins/parsley/dist/parsley.js"></script>

<div class="row">

    <div class="col-md-12">

    <div class="panel panel-inverse" data-sortable-id="form-validation-2">

        <div class="panel-heading">

            <div class="panel-heading-btn">

                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>

                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

            </div>

            <h4 class="panel-title"><?php echo $halaman;?></h4>

        </div>

         <div class="panel-body">

                <div>

                      <form class="form-horizontal form-bordered" action="<?php echo $action;?>" method="post" enctype="multipart/form-data" data-parsley-validate="true">

                        <?php

                        if($cek=='edit'){

                          ?>

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3">Background :</label>

                            <div class="col-md-2 col-sm-2">

                            <?php

                              if($foto==""){

                                $fotox = "no.jpg";

                              }else{

                                $fotox = $foto;

                              }

                            ?>

                              <img src="<?php echo base_url();?>assets/img/login-bg/<?php echo $fotox;?>" style="width:150px;text-align:center;height:180px;">

                            </div>

                          </div>

                          <?php 

                        }

                        ?>

                        <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3">Background * :<br/><small><b>* Max Size : 1MB</b></small></label>


                          <div class="col-md-2 col-sm-2">

                              <input name="MAX_FILE_SIZE" value="9999999999" type="hidden">

                              <input type="file" id="foto" name="foto" />  

                          </div>

                        </div>

                        <div class="form-group">

                          <label class="control-label col-md-3 col-sm-3"></label>

                          <div class="col-md-2 col-sm-2">

                            <button type="submit" class="btn btn-success btn-sm"><?php echo $tombolsimpan;?></button>

                            <button type="button" onclick="history.go(-1)" class="btn btn-info btn-sm"><?php echo $tombolbatal ; ?></button>

                          </div>

                        </div>

                      </form>

                  </div>

                </div>

        </div>

    </div>

  </div>

</div>

