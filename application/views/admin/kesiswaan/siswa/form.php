<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $subjudul ?></h3>
      </div>
      <div class="card-body">
        <form action="<?php echo $own_link ?>/<?php echo $action ?>" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?php echo isset($model)?$model->id:""; ?>">

          <h5 class="mb-3">Data Pribadi</h5>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">NISN</label>
            <div class="col-lg-10 col-sm-12">
              <input type="text" name="nisn" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->nisn:""; ?>" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Nomor Induk</label>
            <div class="col-lg-10 col-sm-12">
              <input type="text" name="nomor_induk" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->nomor_induk:""; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Nama Lengkap</label>
            <div class="col-lg-10 col-sm-12">
              <input type="text" name="nama" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->nama:""; ?>" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Tempat Lahir</label>
            <div class="col-lg-10 col-sm-12">
              <input type="text" name="tempat_lahir" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->tempat_lahir:""; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Tanggal Lahir</label>
            <div class="col-lg-10 col-sm-12">
              <input type="date" name="tanggal_lahir" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->tanggal_lahir : ""; ?>" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Jenis Kelamin</label>
            <div class="col-lg-10 col-sm-12">
              <select name="jenis_kelamin" class="form-control">
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="Laki-laki" <?php echo (isset($model) && $model->jenis_kelamin == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                <option value="Perempuan" <?php echo (isset($model) && $model->jenis_kelamin == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Agama</label>
            <div class="col-lg-10 col-sm-12">
              <input type="text" name="agama" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->agama:""; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Status Dalam Keluarga</label>
            <div class="col-lg-10 col-sm-12">
              <input type="text" name="status_keluarga" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->status_keluarga:"Anak Kandung"; ?>" placeholder="Contoh: Anak Kandung, Anak Tiri, dll">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Anak Ke-</label>
            <div class="col-lg-10 col-sm-12">
              <input type="number" name="anak_ke" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->anak_ke:"1"; ?>" min="1" max="20">
            </div>
          </div>

          <hr>
          <h5 class="mb-3">Data Pendidikan</h5>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Sekolah Asal</label>
            <div class="col-lg-10 col-sm-12">
              <input type="text" name="sekolah_asal" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->sekolah_asal:""; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Tanggal Diterima</label>
            <div class="col-lg-10 col-sm-12">
              <input type="date" name="tanggal_diterima" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->tanggal_diterima:""; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Diterima di Kelas</label>
            <div class="col-lg-10 col-sm-12">
              <select name="kelas_diterima" class="form-control">
                <option value="">-- Pilih Kelas --</option>
                <option value="VII" <?php echo (isset($model) && $model->kelas_diterima == 'VII') ? 'selected' : ''; ?>>VII</option>
                <option value="VIII" <?php echo (isset($model) && $model->kelas_diterima == 'VIII') ? 'selected' : ''; ?>>VIII</option>
                <option value="IX" <?php echo (isset($model) && $model->kelas_diterima == 'IX') ? 'selected' : ''; ?>>IX</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Join Periode</label>
            <div class="col-lg-10 col-sm-12">
              <select class="form-control select2" style="width: 100%;" name="join_periode_id">
                <option value="<?= $periode['id'] ?>" selected><?= $periode['tahun_ajaran'] ?></option>
              </select>
            </div>
          </div>

          <hr>
          <h5 class="mb-3">Kontak</h5>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Nomor HP</label>
            <div class="col-lg-10 col-sm-12">
              <input type="text" name="nomor_hp" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->nomor_hp:""; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Alamat</label>
            <div class="col-lg-10 col-sm-12">
              <textarea name="alamat" class="form-control" rows="3"><?php echo isset($model)?$model->alamat:""; ?></textarea>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-lg-12 col-sm-12">
              <a href="<?php echo $own_link ?>" class="btn btn-danger">Batal</a>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){

  });
</script>
