<style>
  #drop-area {
      border: 2px dashed #ccc;
      border-radius: 20px;
      width: 500px;
      padding: 50px;
      text-align: center;
      font-size: 1.2em;
      color: #666;
      transition: border-color 0.3s, background-color 0.3s;
  }
  #drop-area.highlight {
      border-color: #007bff;
      background-color: #f0f8ff;
  }
  #status {
      margin-top: 20px;
      font-weight: bold;
  }
  #status .success { color: green; }
  #status .error { color: red; }

   video, #preview {
          border: 1px solid black;
          margin-bottom: 10px;
      }
</style>


<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $subjudul ?></h3>
      </div>
      <div class="card-body">
        <!-- Nav tabs -->
        <a href="<?= base_url('siswa/kelas/detail/'.$pertemuan['jadwal_kelas_id']) ?>" class="btn btn-warning">Kembali</a>
        <ul class="nav nav-tabs mt-2" id="absensiTugasTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="absensi-tab" data-toggle="tab" href="#absensi" role="tab" aria-controls="absensi" aria-selected="true">Absensi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tugas-tab" data-toggle="tab" href="#tugas" role="tab" aria-controls="tugas" aria-selected="false">Tugas</a>
          </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content mt-3">
          <div class="tab-pane fade show active" id="absensi" role="tabpanel" aria-labelledby="absensi-tab">
            <?php if(!empty($absensi)): ?>
              <div class="form-group">
                <label>Foto Absensi:</label><br>
                <img src="<?= base_url($absensi['foto']) ?>" width="320" height="240" alt="Foto absensi">
              </div>

              <div class="form-group">
                <label>Waktu Absensi:</label>
                <p><?= date('d-m-Y H:i:s', strtotime($absensi['created_at'])) ?></p>
              </div>

              <div class="form-group">
                <label>Lokasi Absensi (Map):</label>
                <?php
                  $coords = explode(',', $absensi['coordinate']);
                  $lat = $coords[0] ?? '';
                  $lng = $coords[1] ?? '';
                ?>
                <?php if ($lat && $lng): ?>
                  <iframe width="100%" height="300" frameborder="0" style="border:0"
                    src="https://www.google.com/maps?q=<?= $lat ?>,<?= $lng ?>&hl=es;z=14&output=embed">
                  </iframe>
                <?php else: ?>
                  <p>Lokasi tidak tersedia.</p>
                <?php endif; ?>
              </div>
            <?php else: ?>
              <!-- Form Absensi Siswa -->
              <form id="formAbsenNow">
                <input type="hidden" name="pertemuan_id" value="<?= $pertemuan['id'] ?>">
                <div class="form-group">
                  <label>Ambil Foto (Kamera)</label><br>
                  <video id="video" width="100%" height="200" autoplay style="background:#eee;"></video>
                  <input type="hidden" name="foto" id="fotoData" required>
                  <button  type="button" onclick="takeSnapshot()" class="btn btn-info btn-sm mt-2">Ambil Foto</button>
                  <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
                  <div>
                    <strong>Preview Foto:</strong><br>
                    <img id="preview" src="" width="320" height="240" alt="Belum ada foto">
                  </div>
                </div>
                <div class="form-group">
                  <label>Lokasi (GPS)</label>
                  <input type="text" class="form-control" name="lokasi" id="lokasi" readonly required>
                  <button type="button" class="btn btn-secondary btn-sm mt-2" id="getLocationBtn">Ambil Lokasi</button>
                </div>
                <div class="form-group mt-3">
                  <button id="btnSimpanAbsensi" type="submit" class="btn btn-success">Simpan Absensi</button>
                </div>
              </form>
            <?php endif ?>
            
          </div>
          <div class="tab-pane fade" id="tugas" role="tabpanel" aria-labelledby="tugas-tab">
            <!-- Form Upload Tugas -->
            <form id="formTugas">
              <input type="hidden" name="pertemuan_id" value="<?= $pertemuan['id'] ?>">
              <div class="form-group row">
                <label for="jumlah_pertemuan" class="col-sm-12 col-md-12 col-form-label">Upload Tugas</label>
                <div class="col-sm-12 col-md-12">
                  <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt">
                  <br>
                  <span>Hanya bisa mengupload file pdf, excel, docs, txt</span>
                </div>
              </div>
              <?php if(isset($tugas) && !empty($tugas['file'])): ?>
              <br>
                <a href="<?= base_url($tugas['file']) ?>" target="_blank" class="btn btn-info">LIHAT FILE</a>
              <br>
              <?php endif; ?>
              <div class="form-group row">
                <label for="jumlah_pertemuan" class="col-sm-12 col-md-12 col-form-label">Link</label>
                <div class="col-sm-12 col-md-12">
                  <input type="text" name="link" class="form-control" ><?php if(isset($tugas) && !empty($tugas['link'])) echo $tugas['link']; ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="jumlah_pertemuan" class="col-sm-12 col-md-12 col-form-label">Deskripsi <span class="text-danger">*</span></label>
                <div class="col-sm-12 col-md-12">
                  <textarea name="deskripsi" id="tinymce"><?php if(isset($tugas) && !empty($tugas['deskripsi'])) echo htmlspecialchars($tugas['deskripsi']); ?></textarea>
                </div>
              </div>
              <div class="form-group mt-2">
                <button id="btnSimpanTugas" type="submit" class="btn btn-success">Simpan Tugas</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

 <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="<?php echo base_url('assets/plugins/tinymce/js/tinymce/tinymce.min.js'); ?>"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof tinymce !== 'undefined') {
      tinymce.init({
        selector: 'textarea',  // change this value according to your HTML
        license_key: 'gpl'
      });
    }
  });

  $('#formAbsenNow').on('submit', function(e) {
    e.preventDefault();
    // Validasi
    if ($('#fotoData').val().trim() === '') {
        toastError('Silakan capture foto terlebih dahulu sebelum submit absen!');
        return;
    }
    if ($('#lokasi').val().trim() === '') {
        toastError('Silakan ambil lokasi terlebih dahulu sebelum submit absen!');
        return;
    }

    $("#btnSimpanAbsensi").prop('disabled', true).text('Mengirim...');

    const formData = new FormData();
    formData.append('foto', $('#fotoData').val());
    formData.append('lokasi', $('#lokasi').val());
    formData.append('pertemuan_id', '<?= $pertemuan['id'] ?>');

    fetch("<?= base_url('siswa/pertemuan/absensi-update') ?>", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // jika kamu kirim JSON, sesuaikan
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
        $("#btnSimpanAbsensi").prop('disabled', false).text('Simpan Absen');
        return toastError('Gagal mengirim data!');
    });
  });

  $('#formTugas').on('submit', function(e) {
    e.preventDefault();
    // Validasi: minimal salah satu file atau link harus diisi
    var fileInput = $(this).find('input[type="file"]')[0];
    var linkInput = $(this).find('input[name="link"]').val().trim();

    if ((!fileInput.files || fileInput.files.length === 0) && linkInput === '') {
        toastError('Silakan upload file tugas atau isi link terlebih dahulu!');
        return;
    }
    
    const formData = new FormData();
    formData.append('pertemuan_id', '<?= $pertemuan['id'] ?>');

    $("#btnSimpanTugas").prop('disabled', true).text('Mengirim...');

    // Append file jika ada
    if (fileInput.files && fileInput.files.length > 0) {
      formData.append('file', fileInput.files[0]);
    }
    // Append link jika ada
    formData.append('link', linkInput);
    formData.append('deskripsi', $(this).find('textarea[name="deskripsi"]').val());

    fetch("<?= base_url('siswa/pertemuan/tugas-update') ?>", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // jika kamu kirim JSON, sesuaikan
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
        $("#btnSimpanTugas").prop('disabled', false).text('Simpan Tugas');
        return toastError('Gagal mengirim data!');
    });
  });
  
          

  // Ambil lokasi GPS
  $('#getLocationBtn').on('click', function() {
      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
              const lat = position.coords.latitude;
              const lng = position.coords.longitude;
              $('#lokasi').val(lat + ',' + lng);
          }, function() {
              toastError('Gagal mendapatkan lokasi. Pastikan GPS Anda aktif dan diizinkan.');
          });
      } else {
          toastError('Browser tidak mendukung geolocation.');
      }
  });
</script>

<?php if(empty($absensi)): ?>
 <script>
      const video = document.getElementById('video');
      const canvas = document.getElementById('canvas');
      const fotoInput = document.getElementById('fotoData');
      const previewImg = document.getElementById('preview');

      // Aktifkan webcam
      navigator.mediaDevices.getUserMedia({ video: true })
          .then(stream => {
              video.srcObject = stream;
          }).catch(err => {
              toastError("Gagal mengakses kamera: " + err);
          });

      function takeSnapshot() {
        const context = canvas.getContext('2d');

        // Ambil ukuran video yang sesungguhnya
        const width = video.videoWidth;
        const height = video.videoHeight;

        // Atur ulang ukuran canvas agar sesuai
        canvas.width = width;
        canvas.height = height;

        // Gambar frame video ke canvas
        context.drawImage(video, 0, 0, width, height);

        // Ambil data base64 dari canvas
        const dataUrl = canvas.toDataURL('image/png');
        fotoInput.value = dataUrl;

        // Preview dan debug
        previewImg.src = dataUrl;
        toastSuccess('Foto berhasil diambil!');
    }

  </script>
<?php endif ?>