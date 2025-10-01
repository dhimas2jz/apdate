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
          <strong>Informasi:</strong> Password akan direset dengan format: <code>negrac#ddmmyyyy</code>
          <br>
          <small>Contoh: Jika tanggal lahir 15 Agustus 2005, maka password = <code>negrac#15082005</code></small>
        </div>
        <div class="table-responsive mt-3">
          <table id="datatable_serverside" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th>NISN</th>
                <th>Nama Siswa</th>
                <th>Tanggal Lahir</th>
                <th>Periode Bergabung</th>
                <th>Kelas Saat Ini</th>
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
  <input type="hidden" name="siswa_id" id="reset_siswa_id">
  <input type="hidden" name="siswa_nama" id="reset_siswa_nama">
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

  function resetPassword(siswaId, namaSiswa) {
    if (confirm('Apakah Anda yakin ingin mereset password untuk:\n\n' + namaSiswa + '\n\nPassword akan direset dengan format: negrac#ddmmyyyy')) {
      // Set value ke form
      document.getElementById('reset_siswa_id').value = siswaId;
      document.getElementById('reset_siswa_nama').value = namaSiswa;

      // Submit form
      document.getElementById('formResetPassword').submit();
    }
  }
</script>