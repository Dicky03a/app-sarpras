<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Database Design

### Entity Relationship Diagram

```mermaid
erDiagram
    USERS ||--o{ BORROWINGS : "requests"
    USERS ||--o{ REPORT_DAMAGES : "reports"
    USERS ||--o{ BORROWING_MOVES : "admin_moves"
    USERS ||--o{ NOTIFICATIONS : "receives"
    
    ASSET_CATEGORIES ||--o{ ASSETS : "categorizes"
    
    ASSETS ||--o{ BORROWINGS : "is_borrowed_in"
    ASSETS ||--o{ REPORT_DAMAGES : "has_damage_reports"
    ASSETS ||--o{ BORROWING_MOVES : "moved_from (old)"
    ASSETS ||--o{ BORROWING_MOVES : "moved_to (new)"
    
    BORROWINGS ||--o| BORROWING_REJECTIONS : "may_have"
    BORROWINGS ||--o{ BORROWING_MOVES : "can_be_moved"
    
    USERS {
        bigint id PK
        string name
        string email
        string password
        string role "implied (user/admin/superadmin)"
        timestamp email_verified_at
        timestamp created_at
        timestamp updated_at
    }

    ASSET_CATEGORIES {
        bigint id PK
        string name
        timestamp created_at
        timestamp updated_at
    }

    ASSETS {
        bigint id PK
        bigint category_id FK
        string name
        string slug
        string kode_aset
        string lokasi
        enum kondisi "baik, rusak ringan, rusak berat"
        text deskripsi
        enum status "tersedia, dipinjam, rusak"
        timestamp created_at
        timestamp updated_at
    }

    BORROWINGS {
        bigint id PK
        bigint user_id FK "User who borrows"
        bigint asset_id FK
        bigint admin_id FK "Admin who processes"
        date tanggal_mulai
        date tanggal_selesai
        text keperluan
        string lampiran_bukti
        enum status "pending, disetujui, ditolak, dipinjam, selesai"
        timestamp created_at
        timestamp updated_at
    }

    BORROWING_REJECTIONS {
        bigint id PK
        bigint borrowing_id FK
        text alasan
        timestamp created_at
        timestamp updated_at
    }
    
    BORROWING_MOVES {
        bigint id PK
        bigint borrowing_id FK
        bigint old_asset_id FK
        bigint new_asset_id FK
        bigint admin_id FK
        text alasan_pemindahan
        timestamp moved_at
        timestamp created_at
        timestamp updated_at
    }

    REPORT_DAMAGES {
        bigint id PK
        bigint user_id FK
        bigint asset_id FK
        bigint admin_id FK "Verifier"
        text deskripsi_kerusakan
        string foto_kerusakan
        timestamp tanggal_lapor
        enum status "menunggu_verifikasi, selesai"
        enum kondisi_setelah_verifikasi "baik, rusak_ringan, rusak_berat"
        text pesan_tindak_lanjut
        timestamp tanggal_verifikasi
        timestamp created_at
        timestamp updated_at
    }
    
    NOTIFICATIONS {
        uuid id PK
        string type
        string notifiable_type
        bigint notifiable_id
        text data
        timestamp read_at
        timestamp created_at
        timestamp updated_at
    }
```

## API Documentation

This application includes API endpoints for various operations. Documentation is available in the following formats:

- **Postman Collection**: Located at `storage/api/WebSarpras.postman_collection.json`
- **Markdown Documentation**: Located at `docs/api-documentation.md`
- **Swagger UI**: Accessible at `/api/documentation` when the application is running

### Available API Endpoints

- `GET /api/user` - Get authenticated user info
- `POST /api/check-availability/{asset}` - Check asset availability for a date range

### API Authentication

The API uses Laravel Sanctum for authentication. Include your API token in the Authorization header:

```
Authorization: Bearer {your-token-here}
```

### Rate Limiting

API endpoints are rate limited to 60 requests per minute per user/IP address.
