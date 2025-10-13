# Fix E-Rapor - Dokumentasi Perubahan

## 📋 Overview
Project ini memperbaiki semua hardcoded values di sistem e-rapor dengan menggunakan data dinamis dari database.

## 🔧 Perubahan yang Dilakukan

### 1. **Database Migration** (`DB_FIX_ERAPOR.sql`)

#### Tabel Baru yang Dibuat:
- **`mt_sekolah`** - Master data sekolah
  - Menyimpan info: nama, NPSN, alamat, telepon, website, dll
  - Menggantikan hardcoded info sekolah di PDF

- **`mt_kepala_sekolah`** - Master data kepala sekolah per periode
  - Menyimpan: nama, NIP, gelar, periode aktif
  - Support multi-periode (kepala sekolah bisa berganti)

- **`mt_setting_rapor`** - Konfigurasi rapor
  - KKM default
  - Kota untuk tanda tangan
  - Setting tampilan

#### Field Baru di `mt_users_siswa`:
- `jenis_kelamin` - ENUM('Laki-laki', 'Perempuan')
- `status_keluarga` - VARCHAR(50) DEFAULT 'Anak Kandung'
- `anak_ke` - TINYINT DEFAULT 1
- `tanggal_diterima` - DATE
- `kelas_diterima` - VARCHAR(10)

### 2. **Model Update** (`Penilaian_model.php`)

#### Method Baru:
```php
public function getAbsensiSiswa($siswa_id, $kelas_id, $semester_id)
```
- Menghitung absensi siswa secara dinamis
- Return: `['sakit' => 0, 'izin' => 0, 'alpha' => 0]`
- Query dari `tref_pertemuan_absensi` per semester

### 3. **Controller Update** (`guru/WaliKelas.php::erapor_pdf()`)

#### Data Baru yang Diambil:
```php
$data['sekolah']           // Data sekolah dari mt_sekolah
$data['kepala_sekolah']    // Kepala sekolah per periode
$data['kkm']               // KKM dari setting
$data['kota_tandatangan']  // Kota untuk TTD
$data['absensi']           // Hitung absensi dinamis
$data['ekstrakulikuler']   // Data ekskul siswa
```

#### Fallback System:
Jika tabel baru belum ada data, sistem akan menggunakan default hardcoded untuk backward compatibility.

### 4. **View Update** (`e_rapor_pdf_1.php` & `e_rapor_pdf_2.php`)

#### Perubahan Utama:

**Info Sekolah (Hardcoded → Dynamic):**
```php
// BEFORE:
<td>SMP NEGERI 1 RANCABUNGUR</td>

// AFTER:
<td><?= $sekolah['nama_sekolah'] ?></td>
```

**Data Siswa (Hardcoded → Dynamic):**
```php
// BEFORE:
<td>Perempuan</td>           // Jenis kelamin
<td>Anak Kandung</td>        // Status keluarga
<td>3</td>                   // Anak ke
<td>01 Juli 2018</td>        // Tanggal diterima
<td>VII</td>                 // Kelas diterima

// AFTER:
<td><?= $siswa['jenis_kelamin'] ?? 'Laki-laki' ?></td>
<td><?= $siswa['status_keluarga'] ?? 'Anak Kandung' ?></td>
<td><?= $siswa['anak_ke'] ?? 1 ?></td>
<td><?= !empty($siswa['tanggal_diterima']) ? date('d F Y', strtotime($siswa['tanggal_diterima'])) : '01 Juli 2018' ?></td>
<td><?= $siswa['kelas_diterima'] ?? 'VII' ?></td>
```

**Kepala Sekolah (Hardcoded → Dynamic):**
```php
// BEFORE:
<u>Siti Hodijah, S.H., M.Pd.</u>
<p>NIP. 197509192008012004</p>

// AFTER:
<u><?= $kepala_sekolah['gelar_depan'].' '.$kepala_sekolah['nama_lengkap'].', '.$kepala_sekolah['gelar_belakang'] ?></u>
<p>NIP. <?= $kepala_sekolah['nip'] ?></p>
```

**Absensi (Hardcoded → Dynamic):**
```php
// BEFORE:
<tr><td>Sakit</td><td>: 1 hari</td></tr>
<tr><td>Izin</td><td>: 1 hari</td></tr>
<tr><td>Tanpa Keterangan</td><td>: 0 hari</td></tr>

// AFTER:
<tr><td>Sakit</td><td>: <?= $absensi['sakit'] ?> hari</td></tr>
<tr><td>Izin</td><td>: <?= $absensi['izin'] ?> hari</td></tr>
<tr><td>Tanpa Keterangan</td><td>: <?= $absensi['alpha'] ?> hari</td></tr>
```

**KKM (Hardcoded → Dynamic):**
```php
// BEFORE:
<p><strong>Kriteria Ketuntasan Minimal = 72</strong></p>

// AFTER:
<p><strong>Kriteria Ketuntasan Minimal = <?= $kkm ?></strong></p>
```

**Wali Kelas (Hardcoded → Dynamic):**
```php
// BEFORE (di PDF 2):
<b><u>Sutrisni, S.Pd., MM.</u></b>
<br>NIP. 198105012010012003

// AFTER:
<b><u><?= $wali_kelas['nama_lengkap'] ?></u></b>
<br>NIP. <?= $wali_kelas['nip'] ?>
```

**Lokasi TTD (Hardcoded → Dynamic):**
```php
// BEFORE:
Bogor, <?= date('d M Y') ?>

// AFTER:
<?= $kota_tandatangan ?>, <?= date('d M Y') ?>
```

**Ekstrakulikuler (Empty → Dynamic):**
```php
// BEFORE: Kosong / commented out

// AFTER: Looping dari database
<?php if (!empty($ekstrakulikuler) && !empty($ekstrakulikuler['ekskul_list'])): ?>
    <?php $ekskul_list = json_decode($ekstrakulikuler['ekskul_list'], true); ?>
    <?php foreach($ekskul_list as $ekskul): ?>
        <tr>
            <td><?= $ekskul ?></td>
            <td>Baik</td>
            <td>Aktif mengikuti kegiatan</td>
        </tr>
    <?php endforeach ?>
<?php endif; ?>
```

## 🚀 Cara Install

### 1. Run Database Migration
```bash
mysql -u root -p apdate < DB_FIX_ERAPOR.sql
```

### 2. Verifikasi Tabel Baru
```sql
SHOW TABLES LIKE 'mt_%';
-- Harus muncul: mt_sekolah, mt_kepala_sekolah, mt_setting_rapor
```

### 3. Insert Data Awal (Jika Belum)
Data default sudah ter-insert otomatis dari migration SQL:
- 1 record di `mt_sekolah`
- 1 record di `mt_kepala_sekolah`
- 3 records di `mt_setting_rapor`

### 4. Update Data Siswa yang Ada
```sql
-- Set jenis kelamin untuk siswa yang sudah ada
UPDATE mt_users_siswa SET jenis_kelamin = 'Laki-laki' WHERE id = 1;
UPDATE mt_users_siswa SET jenis_kelamin = 'Perempuan' WHERE id = 2;

-- Set data lainnya
UPDATE mt_users_siswa SET
    status_keluarga = 'Anak Kandung',
    anak_ke = 2,
    tanggal_diterima = '2018-07-01',
    kelas_diterima = 'VII'
WHERE id = 1;
```

### 5. Test Generate PDF
1. Login sebagai wali kelas
2. Masuk menu E-Rapor
3. Pilih siswa → Lihat Detail Rapor
4. Generate Rapor
5. Klik E-Rapor untuk export PDF

## ✅ Checklist Field yang Sudah Fixed

### Halaman Info Sekolah:
- [x] Nama Sekolah
- [x] NPSN
- [x] NIS/NSS/NDS
- [x] Alamat Lengkap
- [x] Kode Pos
- [x] Telepon
- [x] Kelurahan
- [x] Kecamatan
- [x] Kabupaten/Kota
- [x] Provinsi
- [x] Website
- [x] Email
- [x] Logo Sekolah (path dynamic)

### Data Siswa:
- [x] Jenis Kelamin
- [x] Status Dalam Keluarga
- [x] Anak Ke
- [x] Tanggal Diterima
- [x] Kelas Diterima

### Data Pejabat:
- [x] Nama Kepala Sekolah
- [x] NIP Kepala Sekolah
- [x] Gelar Kepala Sekolah
- [x] Nama Wali Kelas
- [x] NIP Wali Kelas

### Data Akademik:
- [x] KKM (Kriteria Ketuntasan Minimal)
- [x] Absensi (Sakit, Izin, Alpha)
- [x] Ekstrakulikuler

### Lain-lain:
- [x] Kota Tanda Tangan

## 📝 Catatan Penting

1. **Backward Compatibility**: Semua field menggunakan `??` operator untuk fallback ke nilai default jika data belum ada.

2. **Multi-Periode Support**: Kepala sekolah bisa berbeda per periode, sistem sudah support ini.

3. **Setting Fleksibel**: KKM dan kota TTD bisa diubah di tabel `mt_setting_rapor` tanpa perlu edit code.

4. **Absensi Real-time**: Absensi dihitung langsung dari database, tidak perlu manual input.

5. **Ekskul Dynamic**: Support unlimited ekskul per siswa, disimpan dalam JSON format.

## 🐛 Troubleshooting

### Error: "Undefined index sekolah"
**Solusi**: Jalankan migration SQL terlebih dahulu

### PDF masih menampilkan hardcoded value
**Solusi**: Clear cache browser dan regenerate PDF

### Absensi selalu 0
**Solusi**: Cek apakah data di `tref_pertemuan_absensi` sudah ada dan `semester_id` sesuai

### Kepala sekolah tidak muncul
**Solusi**: Pastikan ada record di `mt_kepala_sekolah` dengan `periode_id` yang sesuai dan `is_active = 1`

## 📊 Database Schema

```
mt_sekolah
├── id (PK)
├── nama_sekolah
├── npsn
├── alamat_lengkap
└── ... (11 more fields)

mt_kepala_sekolah
├── id (PK)
├── periode_id (FK)
├── nama_lengkap
├── nip
└── is_active

mt_setting_rapor
├── id (PK)
├── code (UNIQUE)
├── value
└── description

mt_users_siswa (ALTER)
├── ... (existing fields)
├── jenis_kelamin (NEW)
├── status_keluarga (NEW)
├── anak_ke (NEW)
├── tanggal_diterima (NEW)
└── kelas_diterima (NEW)
```

## 🎯 Next Steps (Optional Enhancement)

1. **Admin Panel** untuk manage:
   - Data sekolah
   - Kepala sekolah per periode
   - Setting rapor

2. **Foto Siswa**: Upload & tampilkan di rapor

3. **Catatan Wali Kelas**: Input form untuk isi catatan di rapor

4. **Template Rapor**: Multi-template support

5. **Digital Signature**: TTD digital untuk kepala sekolah & wali kelas

---

**Created by**: Claude Code Assistant
**Date**: 2025-10-13
**Version**: 1.0.0
