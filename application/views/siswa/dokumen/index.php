<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Data <?php echo $judul ?></h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="datatable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th>Judul</th>
                <th width="15%">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($listdata)): ?>
                <?php foreach ($listdata as $i => $row): ?>
                  <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($row['judul']) ?></td>
                    <td>
                      <a href="<?= base_url($row['file']) ?>" target="_blank" class="btn btn-success btn-sm">
                        <i class="fas fa-eye"></i> Lihat File
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="3" class="text-center">Tidak ada dokumen tersedia.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
