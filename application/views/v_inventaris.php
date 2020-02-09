<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Inventaris</title>
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/datatables/css/dataTables.bootstrap.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <?php $this->load->view('templates/navbar'); ?>
    <div class="">
        <h1 style="font-size:20pt">Data Inventaris</h1>
        <br />
        <button class="btn btn-success" onclick="add_inventaris()"><i class="glyphicon glyphicon-plus"></i> Add Inventaris</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <br />
        <br />


        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No Inventaris</th>
                    <th>Nama Inventaris</th>
                    <th>Kondisi</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                    <th>Jenis</th>
                    <th>Tanggal Register</th>
                    <th>Ruang</th>
                    <th>Kode Inventaris</th>
                    <th>Petugas</th>
                    <th style="width:125px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
                <tr>
                    <th>No Inventaris</th>
                    <th>Nama Inventaris</th>
                    <th>Kondisi</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                    <th>Jenis</th>
                    <th>Tanggal Register</th>
                    <th>Ruang</th>
                    <th>Kode Inventaris</th>
                    <th>Petugas</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>


    <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js') ?>"></script>
    <script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"></script>


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
                    "url": "<?php echo site_url('inventaris/ajax_list') ?>",
                    "type": "POST"
                },

                //Set column definition initialisation properties.
                "columnDefs": [{
                    "targets": [-1], //last column
                    "orderable": false, //set not orderable
                }, ],

            });

            $('#btn-filter').click(function() { //button filter event click
                table.ajax.reload(); //just reload table
            });
            $('#btn-reset').click(function() { //button reset event click
                $('#form-filter')[0].reset();
                table.ajax.reload(); //just reload table
            });

            //set input/textarea/select event when change value, remove class error and remove text help block 
            $("input").change(function() {
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



        function add_inventaris() {
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add inventaris'); // Set Title to Bootstrap modal title
        }

        function edit_inventaris(id_inventaris) {
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url: "<?php echo site_url('inventaris/ajax_edit/') ?>/" + id_inventaris,
                type: "GET",
                dataType: "JSON",
                success: function(data) {

                    $('[name="id_inventaris"]').val(data.id_inventaris);
                    $('[name="nama_inventaris"]').val(data.nama_inventaris);
                    $('[name="kondisi"]').val(data.kondisi);
                    $('[name="keterangan"]').val(data.keterangan);
                    $('[name="jumlah"]').val(data.jumlah);
                    $('[name="id_jenis"]').val(data.id_jenis);
                    $('[name="tanggal_register"]').val(data.tanggal_register);
                    $('[name="id_ruang"]').val(data.id_ruang);
                    $('[name="kode_inventaris"]').val(data.kode_inventaris);
                    $('[name="id_petugas"]').val(data.id_petugas);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit inventaris'); // Set title to Bootstrap modal title

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax 
        }

        function save() {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 
            var url;

            if (save_method == 'add') {
                url = "<?php echo site_url('inventaris/ajax_add') ?>";
            } else {
                url = "<?php echo site_url('inventaris/ajax_update') ?>";
            }

            // ajax adding data to database
            $.ajax({
                url: url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data) {

                    if (data.status) //if success close modal and reload ajax table
                    {
                        $('#modal_form').modal('hide');
                        reload_table();
                    } else {
                        for (var i = 0; i < data.inputerror.length; i++) {
                            $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                            $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                    }
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data');
                    $('#btnSave').text('save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 

                }
            });
        }

        function delete_inventaris(id_inventaris) {
            if (confirm('Are you sure delete this data?')) {
                // ajax delete data to database
                $.ajax({
                    url: "<?php echo site_url('inventaris/ajax_delete') ?>/" + id_inventaris,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');
                        reload_table();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
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
                    <h3 class="modal-title">inventaris Form</h3>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal">

                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">No Inventaris</label>
                                <div class="col-md-9">
                                    <input name="id_inventaris" placeholder="No Inventaris" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Nama Inventaris</label>
                                <div class="col-md-9">
                                    <input name="nama_inventaris" placeholder="Nama Inventaris" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Kondisi</label>
                                <div class="col-md-9">
                                    <textarea name="kondisi" placeholder="Kondisi" class="form-control"></textarea>
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
                                <label class="control-label col-md-3">Jumlah</label>
                                <div class="col-md-9">
                                    <input type="number" name="jumlah" placeholder="Jumlah" class="form-control">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Jenis</label>
                                <div class="col-md-9">
                                    <select name="id_jenis" class="form-control">
                                        <option value="">Pilih Jenis</option>
                                        <?php
                                        $query = $this->db->query("SELECT * FROM jenis");
                                        foreach ($query->result() as $row) { ?>
                                            <option value="<?php echo $row->id_jenis; ?>"> <?php echo $row->nama_jenis; ?></option>

                                        <?php
                                        }
                                        ?>

                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Tanggal Register</label>
                                <div class="col-md-9">
                                    <input type="date" name="tanggal_register" placeholder="Tanggal Register" class="form-control">
                                    <span class="help-block"></span>
                                </div>
                                <!-- <script>
                                $(document).ready(function(){
                                    $('.tgl').datepicker({
                                        format: "yyyy-mm-dd",
                                        autoclose: true
                                    });
                                });
                            </script> -->
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Ruang</label>
                                <div class="col-md-9">
                                    <select name="id_ruang" class="form-control">
                                        <option value="">Pilih Ruang</option>
                                        <?php
                                        $query = $this->db->query("SELECT * FROM ruang");
                                        foreach ($query->result() as $row) { ?>
                                            <option value="<?php echo $row->id_ruang; ?>"> <?php echo $row->nama_ruang; ?></option>

                                        <?php
                                        }
                                        ?>

                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Kode Inventaris</label>
                                <div class="col-md-9">
                                    <input type="text" name="kode_inventaris" placeholder="Kode Inventaris" class="form-control">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Petugas</label>
                                <div class="col-md-9">
                                    <select name="id_petugas" class="form-control">
                                        <option value="">Pilih Petugas</option>
                                        <?php
                                        $query = $this->db->query("SELECT * FROM petugas");
                                        foreach ($query->result() as $row) { ?>
                                            <option value="<?php echo $row->id_petugas; ?>"> <?php echo $row->nama_petugas; ?></option>

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