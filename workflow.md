## 1. Workflow (Alur Kerja)

Sistem ini memiliki tiga aktor utama: **Publik (Tamu)**, **User (Peminjam)**, dan **Admin**.

### A. Pengguna Publik (Tanpa Login)

1.  **Melihat Halaman Utama**: Mengakses informasi umum sistem sarpras.
2.  **Melihat Kategori**: Menelusuri aset berdasarkan kategori.
3.  **Melihat Aset**: Melihat daftar aset yang tersedia beserta statusnya (Tersedia/Dipinjam).
4.  **Detail Aset**: Melihat detail spesifikasi dan kondisi aset.

### B. User (Peminjam)

1.  **Login**: Masuk ke dalam sistem.
2.  **Dashboard User**: Melihat ringkasan aktivitas.
3.  **Pengajuan Peminjaman**:
    -   Memilih aset yang tersedia.
    -   Mengisi form peminjaman (Tanggal mulai, selesai, keperluan, bukti lampiran).
    -   Mengirim pengajuan (Status awal: `pending`).
4.  **Memantau Status**: Melihat status pengajuan di halaman "Requests" (Pending, Disetujui, Ditolak, Selesai).
5.  **Pelaporan Kerusakan**: Melaporkan kerusakan pada aset yang dipinjam atau ditemukan rusak.

### C. Admin

1.  **Manajemen Master Data**:
    -   **Kategori**: Menambah, mengedit, menghapus kategori aset.
    -   **Aset**: Menambah aset baru, update kondisi/status, hapus aset.
2.  **Manajemen Peminjaman**:
    -   **Review Pengajuan**: Melihat daftar pengajuan yang masuk.
    -   **Persetujuan**:
        -   **Approve**: Menyetujui peminjaman.
        -   **Reject**: Menolak peminjaman (wajib isi alasan).
    -   **Proses Barang Keluar**: Menandai barang sebagai "Dipinjam" (saat user mengambil barang).
    -   **Proses Barang Masuk**: Menandai barang sebagai "Dikembalikan" (Status: Selesai).
3.  **Manajemen Laporan Kerusakan**: Memantau dan menindaklanjuti laporan kerusakan dari user.

---

## 2. Flowchart Sistem

Berikut adalah diagram alur proses peminjaman aset dari sisi User dan Admin.

```text
START
  │
  ▼
LOGIN? ─── No ───> [ Halaman Publik ]
  │
  Yes
  │
  ▼
CHECK ROLE ─── User ───> [ Dashboard User ] ───> [ Pilih Aset/Form ] ───> [ Kirim Pengajuan ]
  │                                                                             │
  Admin                                                                         │
  │                                                                             ▼
  ▼                                                                    (Menunggu Persetujuan)
[ Dashboard Admin ] <───────────────────────────────────────────────────────────┘
  │
  ▼
[ Lihat Daftar Peminjaman ]
  │
  ▼
KEPUTUSAN? ─── Tolak ───> [ Tolak & Isi Alasan ] ───> (Status: Ditolak) ───> END
  │
  Setuju
  │
  ▼
[ Setujui Peminjaman ] ───> (Status: Disetujui)
  │
  ▼
[ User Mengambil Barang ] ───> [ Admin: Mark as Borrowed ] ───> (Status: Dipinjam)
                                                                     │
                                                                     ▼
[ Cek Kondisi ] <── [ User Mengembalikan Barang ] <──────────────────┘
  │      │
  │      └─ Rusak ──> [ Buat Laporan Kerusakan ] ──┐
  │                                                │
  └──── Baik ──────────────────────────────────────┴─> [ Admin: Mark as Returned ]
                                                                     │
                                                                     ▼
                                                              (Status: Selesai)
                                                                     │
                                                                     ▼
                                                                    END
```

---

## 3. Entity Relationship Diagram (ERD)

Berikut adalah struktur database dan relasi antar tabel dalam sistem.

### 1. Tabel Users

| Kolom    | Tipe Data | Keterangan        |
| -------- | --------- | ----------------- |
| id       | bigint    | Primary Key (PK)  |
| name     | string    | Nama User         |
| email    | string    | Email (Unique)    |
| password | string    | Password Enkripsi |
| role     | string    | Role (admin/user) |

### 2. Tabel Asset Categories

| Kolom      | Tipe Data | Keterangan       |
| ---------- | --------- | ---------------- |
| id         | bigint    | Primary Key (PK) |
| name       | string    | Nama Kategori    |
| created_at | timestamp | Waktu Dibuat     |

### 3. Tabel Assets

| Kolom       | Tipe Data | Keterangan                            |
| ----------- | --------- | ------------------------------------- |
| id          | bigint    | Primary Key (PK)                      |
| category_id | bigint    | Foreign Key (FK) -> Asset Categories  |
| name        | string    | Nama Aset                             |
| kode_aset   | string    | Unique Code                           |
| lokasi      | string    | Lokasi Aset                           |
| kondisi     | enum      | 'baik', 'rusak ringan', 'rusak berat' |
| deskripsi   | string    | Deskripsi Aset                        |
| status      | enum      | 'tersedia', 'dipinjam', 'rusak'       |

### 4. Tabel Borrowings (Peminjaman)

| Kolom           | Tipe Data | Keterangan                                               |
| --------------- | --------- | -------------------------------------------------------- |
| id              | bigint    | Primary Key (PK)                                         |
| user_id         | bigint    | FK -> Users (Peminjam)                                   |
| asset_id        | bigint    | FK -> Assets                                             |
| admin_id        | bigint    | FK -> Users (Admin Pemroses)                             |
| tanggal_mulai   | date      | Mulai Pinjam                                             |
| tanggal_selesai | date      | Selesai Pinjam                                           |
| keperluan       | text      | Alasan Peminjaman                                        |
| lampiran_bukti  | string    | Path File Bukti                                          |
| status          | enum      | 'pending', 'disetujui', 'ditolak', 'dipinjam', 'selesai' |

### 5. Tabel Borrowing Rejections (Penolakan)

| Kolom        | Tipe Data | Keterangan       |
| ------------ | --------- | ---------------- |
| id           | bigint    | Primary Key (PK) |
| borrowing_id | bigint    | FK -> Borrowings |
| alasan       | text      | Alasan Penolakan |

### 6. Tabel Report Damages (Laporan Kerusakan)

| Kolom               | Tipe Data | Keterangan       |
| ------------------- | --------- | ---------------- |
| id                  | bigint    | Primary Key (PK) |
| user_id             | bigint    | FK -> Users      |
| asset_id            | bigint    | FK -> Assets     |
| deskripsi_kerusakan | text      | Detail Kerusakan |
| tanggal_lapor       | timestamp | Waktu Lapor      |

![alt text](<Untitled Diagram-ERD Online Learning Courses(1).jpg>)
