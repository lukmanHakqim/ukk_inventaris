<!DOCTYPE html>
<html>
    <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Peminjaman</title>
    <link href="<?= base_url('/assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?= base_url('/assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?= base_url('/assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head> 
<body>
    <?php $this->load->view('templates/navbar'); ?>
    <div class="wrapper">
        <h1 style="font-size:20pt">Data Peminjaman</h1>

        <br />
        <button class="btn btn-success" onclick="add_peminjaman()"><i class="glyphicon glyphicon-plus"></i> Add Peminjaman</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Id Peminjaman</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Kembali</th>
                    <th>Status Peminjaman</th>
                    <th>Nama Pegawai</th>
                    <th style="width:125px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
 
            <tfoot>
            <tr>
               <th>Id Peminjaman</th>
                <th>Tanggal Peminjaman</th>
                <th>Tanggal Kembali</th>
                <th>Status Peminjaman</th>
                <th>Nama Pegawai</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
    </div>
 
 
<script src="<?= base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?= base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
 
 
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
            "url": "<?= site_url('peminjaman/ajax_list')?>",
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
 
 
 
function add_peminjaman()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add peminjaman'); // Set Title to Bootstrap modal title
}
 
function edit_peminjaman(id_peminjaman)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?= site_url('peminjaman/ajax_edit/')?>/" + id_peminjaman,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id_peminjaman"]').val(data.id_peminjaman);
            $('[name="tanggal_peminjaman"]').val(data.tanggal_peminjaman);
            $('[name="tanggal_kembali"]').val(data.tanggal_kembali);
            $('[name="status_peminjaman"]').val(data.status_peminjaman);
            $('[name="id_pegawai"]').val(data.id_pegawai);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Peminjaman'); // Set title to Bootstrap modal title
 
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
        url = "<?= site_url('peminjaman/ajax_add')?>";
    } else {
        url = "<?= site_url('peminjaman/ajax_update')?>";
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
 
function delete_peminjaman(id_peminjaman)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?= site_url('peminjaman/ajax_delete')?>/"+id_peminjaman,
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
                <h3 class="modal-title">peminjaman Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Id Peminjaman</label>
                            <div class="col-md-9">
                                <input name="id_peminjaman" placeholder="Id peminjaman" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal Peminjaman</label>
                            <div class="col-md-9">
                                <input type="date" name="tanggal_peminjaman" placeholder="Tanggal peminjaman" class="form-control">
                                <span class="help-block"></span>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="control-label col-md-3">Tanggal Kembali</label>
                            <div class="col-md-9">
                                <input type="date" name="tanggal_kembali" placeholder="Tanggal Kembali" class="form-control">
                                <span class="help-block"></span>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="control-label col-md-3">Status peminjaman</label>
                            <div class="col-md-9">
                                <input type="text" name="status_peminjaman" placeholder="Status peminjaman" class="form-control">
                                <span class="help-block"></span>
                            </div>
                        </div>
                       
                        <div class="form-group">
                          <label class="control-label col-md-3">Nama pegawai</label>
                            <div class="col-md-9">
                                <select name="id_pegawai" class="form-control">
                                     <option value="">Pilih pegawai</option>
                                        <?php
                                        $query = $this->db->query("SELECT * FROM pegawai");
                                       foreach ($query->result() as $row) { ?>
                                        <option value="<?= $row->id_pegawai; ?>"> <?= $row->nama_pegawai; ?></option>

                                        <?php  
                                        }
                                        ?>
                                       
                                </select>
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
    <p class="m-0 text-center text-white">Copyright &copy; LUKMAN H <?= date('Y') ?></p>
  </div>
</footer>
</body>
</html>
