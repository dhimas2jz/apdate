<style>
    .select2-selection__choice {
    display: block !important;
    width: 100%;
    margin: 2px 0;
    }
</style>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $subjudul ?></h3>
      </div>
      <div class="card-body">
        <form action="<?php echo $own_link ?>/<?php echo $action ?>" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?php echo isset($model)?$model->id:""; ?>">

          <h5 class="mb-3">Data Kepegawaian</h5>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">NIP</label>
            <div class="col-lg-10 col-sm-12">
              <input type="text" name="nip" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->nip:""; ?>" required>
            </div>
          </div>

          <hr>
          <h5 class="mb-3">Data Pribadi</h5>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Gelar Depan</label>
            <div class="col-lg-10 col-sm-12">
              <input type="text" name="gelar_depan" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->gelar_depan:""; ?>" placeholder="Contoh: Dr., Drs., Prof.">
              <small class="form-text text-muted">Kosongkan jika tidak ada gelar</small>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Nama Lengkap</label>
            <div class="col-lg-10 col-sm-12">
              <input type="text" name="nama" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->nama:""; ?>" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Gelar Belakang</label>
            <div class="col-lg-10 col-sm-12">
              <input type="text" name="gelar_belakang" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->gelar_belakang:""; ?>" placeholder="Contoh: S.Pd., M.Pd., M.M.">
              <small class="form-text text-muted">Kosongkan jika tidak ada gelar</small>
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
            <label class="col-lg-2 col-sm-12 col-form-label">Tempat Lahir</label>
            <div class="col-lg-10 col-sm-12">
              <input type="text" name="tempat_lahir" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->tempat_lahir:""; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Tanggal Lahir</label>
            <div class="col-lg-10 col-sm-12">
              <input type="date" name="tanggal_lahir" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->tanggal_lahir:""; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Agama</label>
            <div class="col-lg-10 col-sm-12">
              <select name="agama" class="form-control">
                <option value="">-- Pilih Agama --</option>
                <option value="Islam" <?php echo (isset($model) && $model->agama == 'Islam') ? 'selected' : ''; ?>>Islam</option>
                <option value="Kristen" <?php echo (isset($model) && $model->agama == 'Kristen') ? 'selected' : ''; ?>>Kristen</option>
                <option value="Katolik" <?php echo (isset($model) && $model->agama == 'Katolik') ? 'selected' : ''; ?>>Katolik</option>
                <option value="Hindu" <?php echo (isset($model) && $model->agama == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                <option value="Buddha" <?php echo (isset($model) && $model->agama == 'Buddha') ? 'selected' : ''; ?>>Buddha</option>
                <option value="Konghucu" <?php echo (isset($model) && $model->agama == 'Konghucu') ? 'selected' : ''; ?>>Konghucu</option>
              </select>
            </div>
          </div>

          <hr>
          <h5 class="mb-3">Kontak & Alamat</h5>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Email</label>
            <div class="col-lg-10 col-sm-12">
              <input type="email" name="email" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->email : ""; ?>" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Nomor HP</label>
            <div class="col-lg-10 col-sm-12">
              <input type="text" name="nomor_hp" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->nomor_hp : ""; ?>" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Alamat</label>
            <div class="col-lg-10 col-sm-12">
              <textarea name="alamat" class="form-control" rows="3"><?php echo isset($model)?$model->alamat:""; ?></textarea>
            </div>
          </div>

          <hr>
          <h5 class="mb-3">Data Pendidikan</h5>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Asal Universitas</label>
            <div class="col-lg-10 col-sm-12">
              <input type="text" name="asal_universitas" class="form-control" autocomplete="off" value="<?php echo isset($model)?$model->asal_universitas:""; ?>" placeholder="Contoh: Universitas Negeri Jakarta">
            </div>
          </div>

          <hr>
          <h5 class="mb-3">Data Periode</h5>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Join Periode</label>
            <div class="col-lg-10 col-sm-12">
              <select class="form-control select2" style="width: 100%;" name="join_periode_id">
                <option value="<?= $periode['id'] ?>" selected><?= $periode['tahun_ajaran'] ?></option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Status Aktif</label>
            <div class="col-lg-10 col-sm-12">
              <select class="form-control select2" style="width: 100%;" name="is_active">
                <option <?= (isset($model) && $model->is_active == 0) ? 'selected' : '' ?> value="0">Tidak Aktif</option>
                <option <?= (isset($model) && $model->is_active == 1) ? 'selected' : '' ?> value="1">Aktif</option>
              </select>
            </div>
          </div>

          <?php if(isset($model)): ?>
          <hr>
          <h5 class="mb-3">Mata Pelajaran yang Diampu</h5>
          <div class="form-group row">
            <label class="col-lg-2 col-sm-12 col-form-label">Mata Pelajaran</label>
            <div class="col-lg-10 col-sm-12">
              <select class="form-control select2" style="width: 100%;" name="mata_pelajaran_ids[]" multiple>
                 <?php foreach ($mata_pelajaran as $field): ?>
                  <option <?= in_array($field['id'], $model_mapel) ? 'selected' : '' ?> value="<?= $field['id'] ?>"><?= $field['code'].' - '.$field['name'] ?></option>
                <?php endforeach ?>
              </select>
              <small class="form-text text-muted">Pilih satu atau lebih mata pelajaran yang diampu. Mata pelajaran hanya bisa diubah saat periode dalam status "Assign Mata Pelajaran (1.1)"</small>
            </div>
          </div>
          <?php endif ?>

          <hr>
          <div class="form-group row">
            <div class="col-lg-10 col-sm-12">
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