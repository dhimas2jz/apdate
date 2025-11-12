<h5 class="text-danger">
    Wali Kelas bisa meng-generate rapor ketika periode berubah ke status reporting <br/>
    dan nilai akhir sudah diinput semua oleh guru
</h5>
<?php
    $ternilai   = 0;
    $total_data = count($data);
    $is_close   = (!empty($rapor) && $rapor['is_close'] == 1) ? 1:0;
    $ekskul     = $this->db->where(['kelas_id' => $siswa['kelas_id'], 'siswa_id' => $siswa['siswa_id']])->get('tref_kelas_siswa_ekskul')->row_array();
    $ekskul_list = !empty($ekskul) && !empty($ekskul['ekskul_list']) ? json_decode($ekskul['ekskul_list'], true) : [];
?>
<form id="frm-rapor">
    <input type="hidden" name="periode_id" value="<?= $siswa['periode_id'] ?>">
    <input type="hidden" name="semester_id" value="<?= $siswa['semester_id'] ?>">
    <input type="hidden" name="siswa_id" value="<?= $siswa['siswa_id'] ?>">
    <input type="hidden" name="kelas_id" value="<?= $siswa['kelas_id'] ?>">
    <div class="table-responsive mt-5">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="20%">Mata Pelajaran</th>
                    <th width="20%">Pengajar</th>
                    <th width="20%">Nilai Akhir</th>
                    <th width="20%">Grade</th>
                    <th width="20%">Keterangan</th>
                </tr>
            </thead>
            <tbody id="table-detail">
                <?php if(isset($data) && is_array($data) && $total_data > 0): ?>
                    <?php foreach($data as $i => $a): ?>
                        <input type="hidden" name="mapel_code[<?= $i ?>]" value="<?= $a['mapel_code'] ?>">
                        <input type="hidden" name="guru_code[<?= $i ?>]" value="<?= $a['guru_code'] ?>">
                        <input type="hidden" name="grade[<?= $i ?>]" value="<?= $a['grade'] ?>">
                        <input type="hidden" name="keterangan[<?= $i ?>]" value="<?= $a['keterangan'] ?>">
                        <input type="hidden" name="nilai_old[<?= $i ?>]" value="<?= $a['nilai_akhir'] ?>">
                        <tr>
                            <td><?= $a['mapel_code'].' - '.$a['mapel_name'] ?></td>
                            <td><?= $a['guru_code'].' - '.$a['guru_name'] ?></td>
                            <td><input type="number" name="nilai[<?= $i ?>]" max="100" class="form-control nilai_akhir" value="<?= $a['nilai_akhir'] ?>" <?= $is_close == 1 ? 'readonly' : '' ?>></td>
                            <td><?= $a['grade'] ?></td>
                            <td><?= $a['keterangan'] ?></td>
                        </tr>
                        <?php if (!is_null($a['nilai_akhir'])) { $ternilai++; } ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Ekstrakurikuler Section (Read Only) -->
    <div class="mt-4">
        <h5><i class="fa fa-trophy"></i> Ekstrakurikuler</h5>
        <div class="alert alert-secondary">
            <?php if (!empty($ekskul_list)): ?>
                <ul class="mb-0">
                    <?php foreach ($ekskul_list as $ekskul_item): ?>
                        <li><?= htmlspecialchars($ekskul_item) ?></li>
                    <?php endforeach ?>
                </ul>
            <?php else: ?>
                <em>Tidak mengikuti ekstrakurikuler</em>
            <?php endif ?>
        </div>
    </div>

    <!-- Catatan Wali Kelas Section -->
    <div class="mt-4">
        <h5><i class="fa fa-comment"></i> Catatan Wali Kelas</h5>
        <textarea name="catatan_wali_kelas" id="catatan_wali_kelas" class="form-control" rows="4" placeholder="Masukkan catatan untuk siswa..."><?= !empty($rapor['catatan_wali_kelas']) ? htmlspecialchars($rapor['catatan_wali_kelas']) : '' ?></textarea>
    </div>
</form>

<?php if ($total_data > 0 && $ternilai == $total_data && $active_periode['status_code'] == '3'): ?>
    <?php if ($is_close == 0): ?>
        <!-- Rapor Belum Generate -->
        <div class="mt-4">
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> <strong>Petunjuk:</strong><br>
                - Anda dapat mengubah nilai dan catatan wali kelas<br>
                - Klik tombol "Simpan & Generate Rapor" untuk menyimpan dan menghasilkan rapor final<br>
                - Setelah rapor di-generate, nilai tidak dapat diubah lagi
            </div>
            <button type="button" onclick="generateRapor()" class="btn btn-primary btn-lg">
                <i class="fa fa-save"></i> Simpan & Generate Rapor
            </button>
        </div>
    <?php else: ?>
        <!-- Rapor Sudah Generate -->
        <div class="mt-4">
            <div class="alert alert-success">
                <i class="fa fa-check-circle"></i> <strong>Rapor sudah di-generate dan sudah final.</strong><br>
                Nilai sudah terkunci dan tidak bisa diubah, tapi Anda masih bisa mengubah Catatan Wali Kelas.
            </div>
            <button type="button" onclick="updateCatatanWaliKelas()" class="btn btn-warning btn-lg">
                <i class="fa fa-edit"></i> Update Catatan Wali Kelas
            </button>
            <a href="<?= base_url('guru/wali-kelas/e-rapor/pdf/' . $rapor['id']) ?>" class="btn btn-success btn-lg" target="_blank">
                <i class="fa fa-file-pdf"></i> Lihat PDF Rapor
            </a>
        </div>
    <?php endif ?>
<?php else: ?>
    <!-- Kondisi belum terpenuhi untuk generate rapor -->
    <div class="mt-4">
        <div class="alert alert-warning">
            <i class="fa fa-exclamation-triangle"></i> <strong>Rapor belum bisa di-generate</strong><br><br>
            <strong>Persyaratan:</strong><br>
            <?php if ($total_data <= 0): ?>
                <span class="text-danger">✗ Tidak ada data mata pelajaran untuk kelas ini</span><br>
            <?php else: ?>
                <span class="text-success">✓ Ada <?= $total_data ?> mata pelajaran</span><br>
            <?php endif ?>

            <?php if ($ternilai != $total_data): ?>
                <span class="text-danger">✗ Masih ada <?= ($total_data - $ternilai) ?> mata pelajaran yang belum dinilai (Nilai Akhir masih kosong)</span><br>
            <?php else: ?>
                <span class="text-success">✓ Semua mata pelajaran sudah dinilai</span><br>
            <?php endif ?>

            <?php if ($active_periode['status_code'] != '3'): ?>
                <span class="text-danger">✗ Status periode saat ini adalah "<?= $active_periode['status_code'] ?>", harus "3" (Reporting Period)</span><br>
            <?php else: ?>
                <span class="text-success">✓ Periode dalam status Reporting (status code: 3)</span><br>
            <?php endif ?>
        </div>
    </div>
<?php endif ?>