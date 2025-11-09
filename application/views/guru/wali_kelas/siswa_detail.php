<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo $subjudul ?></h3>
      </div>
      <div class="card-body">
        <a href="<?= base_url('guru/wali-kelas/siswa') ?>" class="btn btn-secondary mb-3">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <h5 class="mb-3">Data Pribadi</h5>
        <div class="form-group row">
          <label class="col-lg-2 col-sm-12 col-form-label">NISN</label>
          <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" value="<?php echo $siswa->nisn; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-2 col-sm-12 col-form-label">Nomor Induk</label>
          <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" value="<?php echo $siswa->nomor_induk; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-2 col-sm-12 col-form-label">Nama Lengkap</label>
          <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" value="<?php echo $siswa->nama; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-2 col-sm-12 col-form-label">Tempat Lahir</label>
          <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" value="<?php echo $siswa->tempat_lahir; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-2 col-sm-12 col-form-label">Tanggal Lahir</label>
          <div class="col-lg-10 col-sm-12">
            <input type="date" class="form-control" value="<?php echo $siswa->tanggal_lahir; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-2 col-sm-12 col-form-label">Jenis Kelamin</label>
          <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" value="<?php echo $siswa->jenis_kelamin ?? '-'; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-2 col-sm-12 col-form-label">Agama</label>
          <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" value="<?php echo $siswa->agama; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-2 col-sm-12 col-form-label">Status Dalam Keluarga</label>
          <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" value="<?php echo $siswa->status_keluarga ?? 'Anak Kandung'; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-2 col-sm-12 col-form-label">Anak Ke-</label>
          <div class="col-lg-10 col-sm-12">
            <input type="number" class="form-control" value="<?php echo $siswa->anak_ke ?? 1; ?>" readonly>
          </div>
        </div>

        <hr>
        <h5 class="mb-3">Data Pendidikan</h5>
        <div class="form-group row">
          <label class="col-lg-2 col-sm-12 col-form-label">Sekolah Asal</label>
          <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" value="<?php echo $siswa->sekolah_asal; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-2 col-sm-12 col-form-label">Tanggal Diterima</label>
          <div class="col-lg-10 col-sm-12">
            <input type="date" class="form-control" value="<?php echo $siswa->tanggal_diterima; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-2 col-sm-12 col-form-label">Diterima di Kelas</label>
          <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" value="<?php echo $siswa->kelas_diterima ?? '-'; ?>" readonly>
          </div>
        </div>

        <hr>
        <h5 class="mb-3">Kontak</h5>
        <div class="form-group row">
          <label class="col-lg-2 col-sm-12 col-form-label">Nomor HP</label>
          <div class="col-lg-10 col-sm-12">
            <input type="text" class="form-control" value="<?php echo $siswa->nomor_hp; ?>" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-2 col-sm-12 col-form-label">Alamat</label>
          <div class="col-lg-10 col-sm-12">
            <textarea class="form-control" rows="3" readonly><?php echo $siswa->alamat; ?></textarea>
          </div>
        </div>

        <?php if (!empty($ortu)): ?>
        <hr>
        <h5 class="mb-3">Data Orang Tua / Wali</h5>
        <?php foreach ($ortu as $index => $orang_tua): ?>
          <div class="card mb-3">
            <div class="card-header bg-light">
              <strong><?= $orang_tua['hubungan_keluarga'] ?></strong>
            </div>
            <div class="card-body">
              <div class="form-group row">
                <label class="col-lg-2 col-sm-12 col-form-label">Nama Lengkap</label>
                <div class="col-lg-10 col-sm-12">
                  <input type="text" class="form-control" value="<?= $orang_tua['nama_lengkap'] ?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-2 col-sm-12 col-form-label">Pekerjaan</label>
                <div class="col-lg-10 col-sm-12">
                  <input type="text" class="form-control" value="<?= $orang_tua['pekerjaan'] ?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-2 col-sm-12 col-form-label">Nomor HP</label>
                <div class="col-lg-10 col-sm-12">
                  <input type="text" class="form-control" value="<?= $orang_tua['nomor_hp'] ?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-2 col-sm-12 col-form-label">Email</label>
                <div class="col-lg-10 col-sm-12">
                  <input type="email" class="form-control" value="<?= $orang_tua['email'] ?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-2 col-sm-12 col-form-label">Alamat</label>
                <div class="col-lg-10 col-sm-12">
                  <textarea class="form-control" rows="2" readonly><?= $orang_tua['alamat'] ?></textarea>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <div class="form-group row mt-4">
          <div class="col-lg-12 col-sm-12">
            <a href="<?= base_url('guru/wali-kelas/siswa') ?>" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
