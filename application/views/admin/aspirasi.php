<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Data <?php echo $judul ?></h3>
      </div>
      <div class="card-body">
        <!-- Setting Menu Aspirasi -->
        <div class="mb-4 p-3 border rounded bg-light">
          <h5 class="mb-3"><i class="fa fa-cog"></i> Pengaturan Menu Aspirasi</h5>
          <form id="frm-aspirasi">
            <div class="form-group row">
              <label for="aspirasi_status" class="col-lg-2 col-sm-12 col-form-label">Status Menu Aspirasi</label>
              <div class="col-lg-4 col-sm-12">
                <select name="aspirasi_status" id="aspirasi_status" class="form-control">
                  <option value="open" <?= isset($aspirasi_setting['value']) && $aspirasi_setting['value'] == 'open' ? 'selected' : '' ?>>Open (Siswa dapat mengisi)</option>
                  <option value="close" <?= isset($aspirasi_setting['value']) && $aspirasi_setting['value'] == 'close' ? 'selected' : '' ?>>Close (Siswa tidak dapat mengisi)</option>
                </select>
              </div>
              <div class="col-lg-2 col-sm-12">
                <button type="button" onclick="simpanPerubahanAspirasi()" class="btn btn-primary btn-flat">
                  <i class="fa fa-save"></i> Update Setting
                </button>
              </div>
            </div>
          </form>
        </div>

        <hr>

        <div class="table-responsive mt-3">
          <table id="datatable_serverside" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
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
              "url": "<?= $own_link.'/datatables' ?>",
              "type": "POST"
          },
          "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            }
          ],
      });
  });

  function simpanPerubahanAspirasi() {
    var form = document.getElementById('frm-aspirasi');

    var formData = new FormData(form);

    fetch("<?= base_url('dashboard/aspirasi/do_update') ?>", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.status) {
        setTimeout(() => {
          window.location.reload();
        }, 1500);
        return toastSuccess(data.message);
      }
      return toastError(data.message);
    })
    .catch(error => {
      console.error('Gagal:', error);
      return toastError('Gagal menyimpan perubahan!');
    });
  }

</script>