<!DOCTYPE html>
<html>
    <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Jurusan</title>
    <link href="<?php echo base_url('/assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('/assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('/assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head> 
<body>
  <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark ml-auto">
    <div class="container">
      <a class="navbar-brand" href="#">Follow Me</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">HOME <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#about">ABOUT</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#work">WORK</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">MY BLOG</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact">CONTACT ME</a>
          </li>
        </ul> 
      </div>
    </div>
</nav>
        
       

    <div class="container">
        <h1 style="font-size:20pt">Data Jurusan</h1>
 
        <h3>Jurusan Data</h3>
        <br />
        <button class="btn btn-success" onclick="add_jurusan()"><i class="glyphicon glyphicon-plus"></i> Add Jurusan</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <br />
        <br />


        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Id Jurusan</th>
                    <th>Nama Jurusan</th>
                    <th>Keterangan</th>
                    <th>Tahun</th>
                    <th>Kurikulum</th>
                    <th>Sekolah</th>
                    <th>Akreditasi</th>
                    <th style="width:125px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
 
            <tfoot>
            <tr>
               <th>Id Jurusan</th>
                    <th>Nama Jurusan</th>
                    <th>Keterangan</th>
                    <th>Tahun</th>
                    <th>Kurikulum</th>
                    <th>Sekolah</th>
                    <th>Akreditasi</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
    </div>
 
 
<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
 
 
<script type="text/javascript">
 
var save_method; //for save method string
var table;
 
$(document).ready(function() {
 
    //datatables
    table = $('#table').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('jurusan/ajax_list')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
    $('#btn-filter').click(function(){ //button filter event click
        table.ajax.reload();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        table.ajax.reload();  //just reload table
    });

    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    // $("textarea").change(function(){
    //     $(this).parent().parent().removeClass('has-error');
    //     $(this).next().empty();
    // });
    // $("select").change(function(){
    //     $(this).parent().parent().removeClass('has-error');
    //     $(this).next().empty();
    // });
 
});
 
 
 
function add_jurusan()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Jurusan'); // Set Title to Bootstrap modal title
}
 
function edit_jurusan(id_jurusan)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('jurusan/ajax_edit/')?>/" + id_jurusan,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id_jurusan"]').val(data.id_jurusan);
            $('[name="jurusan"]').val(data.jurusan);
            $('[name="keterangan"]').val(data.keterangan);
            $('[name="tahun"]').val(data.tahun);
            $('[name="id_kurikulum"]').val(data.id_kurikulum);
            $('[name="id_sekolah"]').val(data.id_sekolah);
            $('[name="akreditasi"]').val(data.akreditasi);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Jurusan'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
 
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}
 
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('jurusan/ajax_add')?>";
    } else {
        url = "<?php echo site_url('jurusan/ajax_update')?>";
    }
 
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
 
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
        }
    });
}
 
function delete_jurusan(id_jurusan)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('jurusan/ajax_delete')?>/"+id_jurusan,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
 
    }
}

 

</script>

 
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Jurusan Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Id Jurusan</label>
                            <div class="col-md-9">
                                <input name="id_jurusan" placeholder="Id Jurusan" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nama Jurusan</label>
                            <div class="col-md-9">
                                <input name="jurusan" placeholder="Kode Jurusan" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="control-label col-md-3">Keterangan</label>
                            <div class="col-md-9">
                                <textarea name="keterangan" placeholder="Keterangan" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Tahun</label>
                            <div class="col-md-9">
                                <textarea name="tahun" placeholder="Tahun" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>

                      <div class="form-group">
                            <label class="control-label col-md-3">Kurikulum</label>
                            <div class="col-md-9">
                                <select name="id_kurikulum" class="form-control">
                                     <option value="">Pilih Kurikulum</option>
                                        <?php
                                        $query = $this->db->query("SELECT * FROM kurikulum");
                                       foreach ($query->result() as $row) { ?>
                                        <option value="<?php echo $row->id_kurikulum; ?>"> <?php echo $row->kurikulum; ?></option>

                                        <?php  
                                        }
                                        ?>
                                       
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Sekolah</label>
                            <div class="col-md-9">
                                <textarea name="id_sekolah" placeholder="Kurikulum" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>

                       <div class="form-group">
                            <label class="control-label col-md-3">Akreditasi</label>
                            <div class="col-md-9">
                                <textarea name="akreditasi" placeholder="Akreditasi" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<footer class="py-5 bg-dark">
  <div class="container">
    <p class="m-0 text-center text-white">Copyright &copy; SMK YKP 2019</p>
  </div>
</footer>
</body>
</html>
