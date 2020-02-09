<nav class="navbar navbar-light bg-danger">
    <button class="navbar-brand btn" onclick="tampil()">WARNING!!!</button>
    <ul class="nav navbar-nav">
        <?php if ($this->session->userdata('akses') == 1) : ?>
            <li class="nav-item active">
                <a class="nav-link" href="<?= base_url('page') ?>">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('page/level'); ?>">Level</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('page/petugas'); ?>">Petugas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('page/pegawai'); ?>">Pegawai</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('page/jenis'); ?>">Jenis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('page/ruang'); ?>">Ruang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('page/peminjaman'); ?>">Peminjaman</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('page/inventaris'); ?>">Inventaris</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('page/detail_pinjam'); ?>">Detail Pinjam</a>
            </li>
        <?php elseif ($this->session->userdata('akses') == 2) : ?>
            <li class="active">
                <a href="<?php echo base_url('page') ?>">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('page/peminjaman'); ?>">Peminjaman</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('page/detail_pinjam'); ?>">Detail Pinjam</a>
            </li>
        <?php endif; ?>
    </ul>

    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="#"> <?= $this->session->userdata('ses_nama'); ?></a>
        </li>
        <li>
            <a href="<?= base_url('login/logout') ?>">Logout</a>
        </li>
    </ul>
</nav>

<!-- Script menampilkan modal lukman -->
<script>
    function tampil() {
        $('#tampil').modal('show');
    }
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="tampil" role="dialog">
    <div class="modal-dialog" style="width: 100%; padding: 0; margin: 0;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: gold;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <center>
                    <h1 class="modal-title text-danger">PERINGATAN !!!</h1>
                </center>
            </div>
            <div class="modal-body" style="background-color: black; height: 458pt;">
                <center>
                    <p class="modal-title" style="font-size: 120pt; color: gold;">DILARANG<br>`COPY > PASTE`</p><br>
                    <h1 style="color: darkgrey;">Copyright &copy; LUKMAN HAKQIM <?= date('Y') ?></h1>
                </center>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div> -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->