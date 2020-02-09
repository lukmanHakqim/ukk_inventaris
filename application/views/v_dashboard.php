<!DOCTYPE html>
<html>

<head>
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="<?= base_url('/assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
  <link href="<?= base_url('/assets/datatables/css/dataTables.bootstrap.css') ?>" rel="stylesheet">
  <link href="<?= base_url('/assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') ?>" rel="stylesheet">


</head>

<body>
  <?php $this->load->view('templates/navbar'); ?>
  <!--Include menu-->
  <h1 class="text-center">
    WELCOME BACK<br><br>You have been logged in as
    <span class="text-primary">
      <?= $this->session->userdata('ses_nama'); ?>
    </span>
  </h1>


  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="<?= base_url('assets/jquery/jquery-2.1.4.min.js') ?>"></script>
  <script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('assets/datatables/js/jquery.dataTables.min.js') ?>"></script>
  <script src="<?= base_url('assets/datatables/js/dataTables.bootstrap.js') ?>"></script>
  <script src="<?= base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"></script>
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; LUKMAN H <?= date('Y') ?></p>
    </div>
  </footer>

</body>

</html>