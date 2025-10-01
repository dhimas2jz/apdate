<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $judul ?></h3>
      </div>
      <div class="card-body">
        <div class="alert alert-info">
          <i class="icon fas fa-info-circle"></i>
          <strong>Informasi:</strong> Password akan direset ke NISN siswa yang bersangkutan.
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
    Swal.fire({
        title: 'Konfirmasi Reset Password',
        html: `Apakah Anda yakin ingin mereset password untuk:<br><strong>${namaSiswa}</strong>?<br><br>Password akan direset ke NISN siswa.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Reset Password!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Memproses...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Submit AJAX
            $.ajax({
                url: '<?= $own_link ?>/submit',
                type: 'POST',
                dataType: 'json',
                data: {
                    siswa_id: siswaId
                },
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memproses request',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });
  }
</script>