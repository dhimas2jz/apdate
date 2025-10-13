<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $judul ?></h3>
      </div>
      <div class="card-body">
        <?php if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="icon fas fa-check"></i>
            <strong>Berhasil!</strong> <?php echo $this->session->flashdata('success'); ?>
            <?php if ($this->session->flashdata('password')): ?>
              <br><br>
              <strong>Password Baru:</strong>
              <code style="font-size: 16px; background: #fff; padding: 5px 10px; border-radius: 4px;">
                <?php echo $this->session->flashdata('password'); ?>
              </code>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="icon fas fa-times"></i>
            <strong>Gagal!</strong> <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <div class="alert alert-info">
          <i class="icon fas fa-info-circle"></i>
          <strong>Informasi:</strong> Password akan direset dengan format: <code>guru#6digitnomornipdaribelakang</code>
          <br>
          <small>Contoh: Jika NIP = 197509192008012004, maka password = <code>guru#012004</code></small>
        </div>
        <div class="table-responsive mt-3">
          <table id="datatable_serverside" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th>NIP</th>
                <th>Nama Guru</th>
                <th>Email</th>
                <th>Nomor HP</th>
                <th>Periode Bergabung</th>
                <th width="15%">Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Form untuk reset password -->
<form id="formResetPassword" method="POST" action="<?= $own_link ?>/submit" style="display: none;">
  <input type="hidden" name="guru_id" id="reset_guru_id">
  <input type="hidden" name="guru_nama" id="reset_guru_nama">
</form>

<script type="text/javascript">
  $(document).ready(function() {
      $('#datatable_serverside').DataTable({
          "processing": true,
          "serverSide": true,
          "order": [],
          "ajax": {
              "url": "<?= $own_link ?>/datatables",
              "type": "POST"
          },
          "columnDefs": [
            {
                "targets": [ 0, 6 ],
                "orderable": false,
            }
          ],
      });
  });

  function resetPassword(guruId, namaGuru, nipGuru) {
    // Ambil 6 digit terakhir NIP
    var nip_last_6 = nipGuru.slice(-6);
    var password_format = 'guru#' + nip_last_6;

    if (confirm('Apakah Anda yakin ingin mereset password untuk:\n\n' + namaGuru + '\n\nPassword akan direset dengan format: ' + password_format)) {
      // Set value ke form
      document.getElementById('reset_guru_id').value = guruId;
      document.getElementById('reset_guru_nama').value = namaGuru;

      // Submit form
      document.getElementById('formResetPassword').submit();
    }
  }
</script>
