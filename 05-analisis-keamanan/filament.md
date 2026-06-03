# ANALISIS KEAMANAN SISTEM POS LARAVEL FILAMENT

---

## 1. RINGKASAN KEAMANAN SISTEM

| Aspek Keamanan | Teknologi / Mekanisme | Status Implementasi | Evidence File | Keterangan | Dokumentasi Resmi |
| --- | --- | --- | --- | --- | --- |
| **Authentication** | Laravel Session Guard + Filament Auth | Digunakan | [config/auth.php](config/auth.php) | Session-based authentication dengan Eloquent provider | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Laravel Session](https://laravel.com/docs/12.x/session)<br>[Filament Users](https://filamentphp.com/docs/3.x/panels/users) |
| **Password Hashing** | Laravel Hash Cast | Digunakan | [app/Models/User.php](app/Models/User.php#L32) | Password otomatis di-hash dengan cast 'hashed' | [Laravel Hashing](https://laravel.com/docs/12.x/hashing)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Authorization** | Filament Shield + Spatie Permission | Digunakan | [config/filament-shield.php](config/filament-shield.php) | Permission dan role-based access control | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield) |
| **Role Management** | Spatie Permission Traits | Digunakan | [app/Models/User.php](app/Models/User.php#L13) | HasRoles trait untuk role assignment | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Policies** | Laravel Policies + Spatie Permission Integration | Digunakan | [app/Policies/](app/Policies/) | Policy-based authorization per resource | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield) |
| **Middleware Security** | Comprehensive Middleware Stack | Digunakan | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L25) | CSRF, Session, Cookie, Binding validation | [Laravel Middleware](https://laravel.com/docs/12.x/middleware)<br>[Laravel CSRF](https://laravel.com/docs/12.x/csrf)<br>[Laravel Session](https://laravel.com/docs/12.x/session) |
| **CSRF Protection** | VerifyCsrfToken Middleware | Digunakan | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L31) | Global CSRF protection di middleware stack | [Laravel Middleware](https://laravel.com/docs/12.x/middleware)<br>[Laravel CSRF](https://laravel.com/docs/12.x/csrf)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration) |
| **Session Security** | AuthenticateSession + StartSession | Digunakan | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L26-27) | Session creation dan authentication validation | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Laravel Session](https://laravel.com/docs/12.x/session)<br>[Filament Users](https://filamentphp.com/docs/3.x/panels/users) |
| **Mass Assignment Protection** | Protected $fillable Arrays | Digunakan | [app/Models/Product.php](app/Models/Product.php#L8) | Whitelist model attributes | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Soft Delete Protection** | SoftDeletes Trait | Digunakan | [app/Models/Product.php](app/Models/Product.php#L5) | Soft delete pada Product, Transaction, Category | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Form Validation** | Filament Form Validation | Digunakan | [app/Filament/Resources/ProductResource.php](app/Filament/Resources/ProductResource.php#L57) | Numeric, required, maxLength validation | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **File Upload Security** | File Upload Validation | Digunakan | [app/Filament/Resources/ProductResource.php](app/Filament/Resources/ProductResource.php#L76) | Image validation untuk product uploads | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament FileUpload](https://filamentphp.com/docs/3.x/forms/fields/file-upload) |
| **Storage Security** | Custom Filesystem Disk | Digunakan | [config/filesystems.php](config/filesystems.php#L42) | public_direct disk untuk product images | [Laravel Filesystem](https://laravel.com/docs/12.x/filesystem)<br>[Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| **Database Integrity** | Eloquent Observers | Digunakan | [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php#L23) | Observer untuk data consistency | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Route Protection** | Filament Panel Auth Middleware | Digunakan | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L34) | Authenticate middleware on panel routes | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Filament Users](https://filamentphp.com/docs/3.x/panels/users)<br>[Laravel Middleware](https://laravel.com/docs/12.x/middleware) |
| **PDF/Receipt Security** | findOrFail() Query | Digunakan | [app/Http/Controllers/ReceiptController.php](app/Http/Controllers/ReceiptController.php#L12) | 404 on invalid transaction ID | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Query Builder](https://laravel.com/docs/12.x/queries)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| **Barcode Security** | Checksum Validation | Digunakan | [app/Observers/ProductObserver.php](app/Observers/ProductObserver.php#L35) | 13-digit barcode dengan checksum digit | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Milon Barcode](https://github.com/milon/barcode) |
| **Printer Security** | Try-Catch Error Handling | Digunakan | [app/Services/DirectPrintService.php](app/Services/DirectPrintService.php#L50) | Exception handling untuk printer errors | [ESC/POS PHP](https://github.com/mike42/escpos-php) |
| **XSS Protection** | Bawaan Blade Template | Digunakan | Framework Default | Blade templating engine escaping by default | [Laravel Blade](https://laravel.com/docs/12.x/blade) |
| **SQL Injection Protection** | Eloquent ORM | Digunakan | Framework Default | Parameterized queries via Eloquent | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Query Builder](https://laravel.com/docs/12.x/queries) |
| **Livewire Security** | Session-based Cart Storage | Digunakan | [app/Livewire/Pos.php](app/Livewire/Pos.php#L45) | Cart data stored in session, validated on checkout | [Laravel Session](https://laravel.com/docs/12.x/session)<br>[Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Livewire Forms](https://livewire.laravel.com/docs/forms) |

---

## 2. ANALISIS PER ASPEK KEAMANAN

### 2.1 Authentication Security

| Komponen | Implementasi | Evidence File | Tingkat Keamanan | Keterangan | Dokumentasi Resmi |
| --- | --- | --- | --- | --- | --- |
| **Session Authentication** | Laravel session guard dengan Eloquent provider | [config/auth.php](config/auth.php#L33-45) | Tinggi | Default guard adalah 'web' dengan session driver | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Laravel Session](https://laravel.com/docs/12.x/session)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Password Hashing** | Hash cast pada User model | [app/Models/User.php](app/Models/User.php#L32) | Tinggi | Password otomatis di-hash saat create/update | [Laravel Hashing](https://laravel.com/docs/12.x/hashing)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Filament Login Panel** | Built-in Filament login dengan ->login() | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L19) | Tinggi | Panel login authentication terintegrasi | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Filament Users](https://filamentphp.com/docs/3.x/panels/users)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| **Password Reset Token** | Database token dengan expire time | [config/auth.php](config/auth.php#L100-103) | Tinggi | Token expire 60 menit, throttle 60 detik | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Laravel Session](https://laravel.com/docs/12.x/session)<br>[Laravel Rate Limiting](https://laravel.com/docs/12.x/rate-limiting) |
| **User Provider** | Eloquent User Provider | [config/auth.php](config/auth.php#L59) | Tinggi | Menggunakan User::class model | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| **FilamentUser Interface** | User implements FilamentUser contract | [app/Models/User.php](app/Models/User.php#L11) | Tinggi | canAccessPanel() method untuk akses control | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Filament Users](https://filamentphp.com/docs/3.x/panels/users)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |

**Penjelasan:**
Sistem menggunakan Laravel session-based authentication dengan hashing password. Setiap user harus implementasi `FilamentUser` interface yang mendefinisikan `canAccessPanel()` method. Saat ini semua user dikembalikan `true` tanpa kondisi apapun, yang berarti semua authenticated user dapat akses panel.

---

### 2.2 Authorization Security

| Komponen | Implementasi | Evidence File | Tingkat Keamanan | Keterangan | Dokumentasi Resmi |
| --- | --- | --- | --- | --- | --- |
| **Filament Shield** | BezhanSalleh FilamentShield plugin | [config/filament-shield.php](config/filament-shield.php#L27) | Tinggi | Auto-generate permissions untuk resources | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **Spatie Permission** | HasRoles trait + permission checking | [config/permission.php](config/permission.php#L1) | Tinggi | Role dan permission management | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| **Resource Policies** | Policy classes dengan can() checking | [app/Policies/ProductPolicy.php](app/Policies/ProductPolicy.php) | Tinggi | Per-action authorization (view, create, update, delete) | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **Permission Prefixes** | Standard prefixes (view_any, create, update, delete, etc) | [config/filament-shield.php](config/filament-shield.php#L31-44) | Tinggi | Structured permission naming convention | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| **Super Admin Role** | Enabled dengan intercept_before gate | [config/filament-shield.php](config/filament-shield.php#L18-21) | Tinggi | Super admin dapat bypass semua permissions | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield) |
| **Resource-level Authorization** | HasShieldPermissions interface | [app/Filament/Resources/ProductResource.php](app/Filament/Resources/ProductResource.php#L18) | Tinggi | Explicit permission prefixes per resource | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield) |

**Penjelasan:**
Sistem menggunakan kombinasi Filament Shield dan Spatie Permission untuk authorization. Setiap resource mengimplementasikan `HasShieldPermissions` interface yang mendefinisikan permission prefixes. Policies menggunakan `$user->can('permission_name')` untuk setiap action. Super admin role dapat bypass semua checks via gate interception.

---

### 2.3 Route Protection

| Route / Panel | Middleware Protection | Protection Type | Evidence File | Status | Dokumentasi Resmi |
| --- | --- | --- | --- | --- | --- |
| **/admin (Panel)** | Authenticate middleware | auth.filament | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L34) | ✅ Protected | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Filament Users](https://filamentphp.com/docs/3.x/panels/users)<br>[Laravel Authorization](https://laravel.com/docs/12.x/authorization) |
| **/pos (PosPage)** | Authenticate + HasPageShield | auth.filament + page permission | [app/Filament/Pages/PosPage.php](app/Filament/Pages/PosPage.php#L7) | ✅ Protected | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Filament Users](https://filamentphp.com/docs/3.x/panels/users)<br>[Laravel Authorization](https://laravel.com/docs/12.x/authorization) |
| **/dashboard (Dashboard)** | Authenticate + HasPageShield | auth.filament + page permission | [app/Filament/Pages/Dashboard.php](app/Filament/Pages/Dashboard.php#L10) | ✅ Protected | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Filament Users](https://filamentphp.com/docs/3.x/panels/users)<br>[Laravel Authorization](https://laravel.com/docs/12.x/authorization) |
| **GET /receipt/{id}** | **TIDAK ADA MIDDLEWARE** | Tidak diproteksi | [routes/web.php](routes/web.php#L7) | ⚠️ **UNPROTECTED** | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Middleware](https://laravel.com/docs/12.x/middleware)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| **GET /receipt/{id}/download** | **TIDAK ADA MIDDLEWARE** | Tidak diproteksi | [routes/web.php](routes/web.php#L8) | ⚠️ **UNPROTECTED** | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Middleware](https://laravel.com/docs/12.x/middleware)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |

**Penjelasan:**
Semua Filament panel routes dilindungi dengan `Authenticate` middleware. Namun, receipt routes di `web.php` TIDAK memiliki middleware auth, yang berarti siapapun bisa akses receipt dengan mengetahui ID transaksi. Controller menggunakan `findOrFail()` yang akan return 404 jika ID tidak ada, tetapi tidak mengecek authorization siapa yang membuat transaksi tersebut.

**POTENSI RISIKO:** Receipt yang berisi customer data dan detail produk dapat diakses oleh siapapun yang mengetahui transaction ID. Ini adalah **informasi disclosure vulnerability**.

---

### 2.4 Middleware Security

| Middleware | Deskripsi | Evidence File | Status | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| **EncryptCookies** | Encrypt cookies di request/response | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L26) | ✅ Active | [Laravel Middleware](https://laravel.com/docs/12.x/middleware)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| **AddQueuedCookiesToResponse** | Add queued cookies ke response | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L27) | ✅ Active | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration) |
| **StartSession** | Start session untuk aplikasi | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L28) | ✅ Active | [Laravel Middleware](https://laravel.com/docs/12.x/middleware)<br>[Laravel Session](https://laravel.com/docs/12.x/session)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration) |
| **AuthenticateSession** | Regenerate session ID untuk security | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L29) | ✅ Active | [Laravel Middleware](https://laravel.com/docs/12.x/middleware)<br>[Laravel Session](https://laravel.com/docs/12.x/session)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration) |
| **ShareErrorsFromSession** | Share validation errors dengan view | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L30) | ✅ Active | [Laravel Middleware](https://laravel.com/docs/12.x/middleware)<br>[Laravel Session](https://laravel.com/docs/12.x/session)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration) |
| **VerifyCsrfToken** | CSRF token verification | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L31) | ✅ Active | [Laravel Middleware](https://laravel.com/docs/12.x/middleware)<br>[Laravel CSRF](https://laravel.com/docs/12.x/csrf)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration) |
| **SubstituteBindings** | Route model binding resolution | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L32) | ✅ Active | [Laravel Middleware](https://laravel.com/docs/12.x/middleware)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **DisableBladeIconComponents** | Disable blade icon components | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L33) | ✅ Active | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration)<br>[Laravel Blade](https://laravel.com/docs/12.x/blade) |
| **DispatchServingFilamentEvent** | Dispatch Filament serving event | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L34) | ✅ Active | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration) |
| **Authenticate (authMiddleware)** | Authentication check pada panel access | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L37) | ✅ Active | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Filament Users](https://filamentphp.com/docs/3.x/panels/users)<br>[Laravel Middleware](https://laravel.com/docs/12.x/middleware) |

**Penjelasan:**
Middleware stack di Filament panel sangat comprehensive mencakup semua aspek keamanan penting: CSRF, session handling, cookie encryption, dan authentication. Middleware ini dijalankan untuk SEMUA requests ke Filament panel (/admin, /pos, /dashboard, dll).

---

### 2.5 Role & Permission Security

| Komponen | Implementasi | Evidence File | Tingkat Keamanan | Keterangan | Dokumentasi Resmi |
| --- | --- | --- | --- | --- | --- |
| **Role Assignment** | User hasMany roles via pivot table | [app/Models/User.php](app/Models/User.php#L13) | Tinggi | Spatie Permission role assignment | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Filament Tables](https://filamentphp.com/docs/3.x/tables/getting-started) |
| **Permission Checking** | user->can('permission_name') | [app/Policies/ProductPolicy.php](app/Policies/ProductPolicy.php#L12) | Tinggi | Gate checking di policies | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction) |
| **Resource Permissions** | view_any, create, update, delete, restore, etc | [config/filament-shield.php](config/filament-shield.php#L31-44) | Tinggi | 10 permission prefixes per resource | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **Page Permissions** | view_page_{page_name} | [config/filament-shield.php](config/filament-shield.php#L45) | Tinggi | Explicit page permissions | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Filament Pages](https://filamentphp.com/docs/3.x/panels/pages) |
| **Widget Permissions** | Widget permissions disabled in config | [config/filament-shield.php](config/filament-shield.php#L54) | Medium | Widgets tidak diproteksi dengan permissions | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Filament Widgets](https://filamentphp.com/docs/3.x/widgets/stats-overview) |
| **Super Admin Bypass** | Super admin role can bypass gates | [config/filament-shield.php](config/filament-shield.php#L18-21) | Tinggi | define_via_gate=false, intercept_gate=before | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield) |
| **Permission Granularity** | Per-action, per-resource permissions | [app/Filament/Resources/](app/Filament/Resources/) | Tinggi | Granular access control pada action level | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield) |

**Penjelasan:**
Sistem permission sangat granular dengan 10+ permission prefixes per resource. Setiap action (view, create, update, delete, restore, force_delete, dll) memiliki permission tersendiri. User dikecek via Policies sebelum action dapat dijalankan. Super admin role dapat bypass semua checks.

---

### 2.6 Session Security

| Komponen | Implementasi | Evidence File | Tingkat Keamanan | Keterangan | Dokumentasi Resmi |
| --- | --- | --- | --- | --- | --- |
| **Session Guard** | Session-based guard | [config/auth.php](config/auth.php#L33) | Tinggi | Default web guard menggunakan session | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Laravel Session](https://laravel.com/docs/12.x/session)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| **Session Encryption** | EncryptCookies middleware | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L26) | Tinggi | Session cookie terenkripsi | [Laravel Middleware](https://laravel.com/docs/12.x/middleware)<br>[Laravel Session](https://laravel.com/docs/12.x/session)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration) |
| **AuthenticateSession** | Session authentication validation | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L29) | Tinggi | Regenerate session ID untuk security | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Laravel Session](https://laravel.com/docs/12.x/session)<br>[Filament Users](https://filamentphp.com/docs/3.x/panels/users) |
| **Cart Session Storage** | Order items stored in session | [app/Livewire/Pos.php](app/Livewire/Pos.php#L45) | Medium | session()->put('orderItems', ...) | [Laravel Session](https://laravel.com/docs/12.x/session)<br>[Laravel Filesystem](https://laravel.com/docs/12.x/filesystem)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| **Session Validation** | Validated before checkout | [app/Livewire/Pos.php](app/Livewire/Pos.php#L326) | Medium | Check session before creating transaction | [Laravel Session](https://laravel.com/docs/12.x/session)<br>[Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Livewire Forms](https://livewire.laravel.com/docs/forms) |
| **Session Timeout** | Not explicitly configured | [config/session.php](config/session.php) | Low | Default Laravel session lifetime (120 minutes) | [Laravel Session](https://laravel.com/docs/12.x/session)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |

**Penjelasan:**
Session security menggunakan Laravel default session guard dengan encryption. Session data terenkripsi di cookie. Cart items disimpan di session dan divalidasi sebelum checkout. Tidak ada custom session timeout configuration yang ditemukan.

---

### 2.7 Validation Security

| Fitur | Jenis Validasi | Evidence File | Validasi Type | Status | Dokumentasi Resmi |
| --- | --- | --- | --- | --- | --- |
| **Product Form** | Numeric price, required fields, maxLength | [app/Filament/Resources/ProductResource.php](app/Filament/Resources/ProductResource.php#L57-88) | Client + Server | ✅ Implemented | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Product Price** | numeric() validation | [app/Filament/Resources/ProductResource.php](app/Filament/Resources/ProductResource.php#L68-70) | Server | ✅ Implemented | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **Product Stock** | numeric() + readOnly | [app/Filament/Resources/ProductResource.php](app/Filament/Resources/ProductResource.php#L77-80) | Server | ✅ Implemented | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **Product Image** | image() validation | [app/Filament/Resources/ProductResource.php](app/Filament/Resources/ProductResource.php#L76) | Server | ✅ Implemented | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **Transaction Items** | Repeater validation | [app/Filament/Resources/TransactionResource.php](app/Filament/Resources/TransactionResource.php#L71) | Server | ✅ Implemented | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **Payment Method** | required() + reactive | [app/Filament/Resources/TransactionResource.php](app/Filament/Resources/TransactionResource.php#L100) | Server | ✅ Implemented | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Livewire Security](https://livewire.laravel.com/docs/security) |
| **Inventory Type** | ToggleButtons dengan options | [app/Filament/Resources/InventoryResource.php](app/Filament/Resources/InventoryResource.php#L41) | Server | ✅ Implemented | [Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started)<br>[Filament Forms](https://filamentphp.com/docs/3.x/forms/getting-started) |
| **Inventory Source** | Dynamic options based on type | [app/Filament/Resources/InventoryResource.php](app/Filament/Resources/InventoryResource.php#L48) | Server | ✅ Implemented | [Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **Checkout Validation** | Custom validation dengan messages | [app/Livewire/Pos.php](app/Livewire/Pos.php#L315-330) | Server | ✅ Implemented | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Livewire Forms](https://livewire.laravel.com/docs/forms)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| **Cash Validation** | Numeric conversion + comparison | [app/Livewire/Pos.php](app/Livewire/Pos.php#L318-325) | Server | ✅ Implemented | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Livewire Forms](https://livewire.laravel.com/docs/forms)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| **Stock Check** | Stock availability check | [app/Livewire/Pos.php](app/Livewire/Pos.php#L187-190) | Business Logic | ✅ Implemented | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Livewire Forms](https://livewire.laravel.com/docs/forms)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |

**Penjelasan:**
Form validation comprehensif menggunakan Filament Form validation rules. Setiap field memiliki type casting dan rule validation. Di Livewire Pos component, ada custom validation untuk checkout dengan message handling. Stock availability dicek sebelum adding to cart.

---

### 2.8 File Upload Security

| Feature | Storage Method | Validation | Evidence File | Tingkat Risiko | Dokumentasi Resmi |
| --- | --- | --- | --- | --- | --- |
| **Product Image** | public_direct disk | image() validation | [app/Filament/Resources/ProductResource.php](app/Filament/Resources/ProductResource.php#L76) | **Sedang** | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament FileUpload](https://filamentphp.com/docs/3.x/forms/fields/file-upload) |
| **Payment Method Icon** | public disk | image() validation | [app/Filament/Resources/PaymentMethodResource.php](app/Filament/Resources/PaymentMethodResource.php#L41) | **Sedang** | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament FileUpload](https://filamentphp.com/docs/3.x/forms/fields/file-upload) |
| **Logo/Setting Image** | Assumed public disk | Not explicitly validated | [app/Services/DirectPrintService.php](app/Services/DirectPrintService.php#L53) | **Sedang** | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Laravel Filesystem](https://laravel.com/docs/12.x/filesystem) |
| **Report PDF** | storage/app/public | Generated via Observer | [app/Observers/ReportObserver.php](app/Observers/ReportObserver.php#L21-22) | **Rendah** | [Laravel Filesystem](https://laravel.com/docs/12.x/filesystem)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[DomPDF](https://github.com/barryvdh/laravel-dompdf) |

**Detail Analisis:**

1. **Product Image Upload:**
   - Disk: `public_direct` (langsung ke public_path)
   - Validation: `->image()` (Filament image validation)
   - Directory: `storage/products/`
   - Visibility: public
   - Risiko: Medium - File bisa diakses publik, namun sudah di-validate sebagai image

2. **Payment Method Icon:**
   - Validation: `->image()` required
   - Disk: Assumed public
   - Risiko: Medium - Similar to product image

3. **Report PDF Generation:**
   - Generated via Observer saat create/update Report
   - Saved ke `storage/app/public/reports/`
   - Naming: LAPORAN-YYYYMMDD-{number}
   - Risiko: Low - PDF generated otomatis, bukan user upload

**Potensi Risiko:**
- Tidak ada validasi file size pada upload
- Tidak ada MIME type validation (hanya image() check)
- File langsung disimpan ke public directory

---

### 2.9 Database Integrity

| Mekanisme | Implementasi | Evidence File | Perlindungan | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| **Foreign Keys** | Eloquent relationships | [app/Models/Product.php](app/Models/Product.php#L12) | Data consistency via ORM | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Soft Deletes** | SoftDeletes trait | [app/Models/Product.php](app/Models/Product.php#L5) | Logical deletion dengan timestamps | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Cascade Operations** | Observer-based cascade | [app/Observers/CategoryObserver.php](app/Observers/CategoryObserver.php) | Manual cascade delete/restore | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Mass Assignment** | Protected $fillable | [app/Models/Product.php](app/Models/Product.php#L8) | Attribute whitelist protection | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Observer Validation** | Business logic in observers | [app/Observers/TransactionItemObserver.php](app/Observers/TransactionItemObserver.php) | Stock validation | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| **Stock Sync** | Automatic via observers | [app/Observers/InventoryItemObserver.php](app/Observers/InventoryItemObserver.php) | Real-time inventory sync | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| **CashFlow Sync** | Automatic via observers | [app/Observers/TransactionObserver.php](app/Observers/TransactionObserver.php#L18) | Auto cashflow creation | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |

**Penjelasan:**
Database integrity dijaga via kombinasi:
1. Eloquent ORM dengan relationships
2. SoftDeletes untuk logical deletion
3. Protected $fillable untuk mass assignment protection
4. Comprehensive observer system untuk data sync

---

### 2.10 Observer Integrity

| Observer | Fungsi | Evidence File | Dampak Keamanan | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| **TransactionItemObserver** | Stock decrement pada create/update/delete | [app/Observers/TransactionItemObserver.php](app/Observers/TransactionItemObserver.php) | **KRITIS** - Mencegah overselling; throw exception jika stock insufficient | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| **InventoryItemObserver** | Sync inventory dengan stock produk | [app/Observers/InventoryItemObserver.php](app/Observers/InventoryItemObserver.php) | **KRITIS** - Automatic stock adjustment; support 3 inventory types (in/out/adjustment) | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| **InventoryObserver** | Generate reference number, CashFlow sync | [app/Observers/InventoryObserver.php](app/Observers/InventoryObserver.php) | **TINGGI** - Automatic reference number generation; cashflow tracking | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| **TransactionObserver** | Generate transaction number, CashFlow creation | [app/Observers/TransactionObserver.php](app/Observers/TransactionObserver.php) | **KRITIS** - Automatic transaction ID generation; cashflow sync; stock restoration on delete | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| **ProductObserver** | SKU generation, Barcode generation | [app/Observers/ProductObserver.php](app/Observers/ProductObserver.php) | **TINGGI** - Automatic SKU generation; unique barcode dengan checksum | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Milon Barcode](https://github.com/milon/barcode) |
| **CategoryObserver** | Cascade delete/restore/forceDelete | [app/Observers/CategoryObserver.php](app/Observers/CategoryObserver.php) | **TINGGI** - Cascade operations untuk product consistency | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **ReportObserver** | PDF generation dan storage | [app/Observers/ReportObserver.php](app/Observers/ReportObserver.php) | **MEDIUM** - Automatic report PDF generation on create/update | [Laravel Filesystem](https://laravel.com/docs/12.x/filesystem)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[DomPDF](https://github.com/barryvdh/laravel-dompdf) |

**Analisis Detail:**

**TransactionItemObserver (KRITIS):**
```
Creating: Check stock >= quantity, throw exception jika insufficient
Updated: Restore old quantity, deduct new quantity
Deleted: Restore quantity ke stok
```
Ini mencegah overselling dan menjaga stock accuracy.

**InventoryItemObserver (KRITIS):**
```
Created: Sync stok berdasarkan tipe (in/out/adjustment)
Updated: Kalkulasi delta dan update stok
Deleted: Reverse operation (undo)
```

**TransactionObserver (KRITIS):**
```
Creating: Generate unique transaction number via TransactionHelper
Created: Create CashFlow income entry
Updated: Update CashFlow amount jika total berubah
Deleted: Create refund CashFlow entry, restore product stocks
Restored: Create restored income entry, reduce stocks again
ForceDeleted: Delete related CashFlow entries
```

Semua observer ini bekerja otomatis tanpa user intervention, memastikan data consistency.

---

### 2.11 Transaction Consistency

| Aspek | Implementasi | Evidence File | Status | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| **Transaction Number** | Unique auto-generated via helper | [app/Helpers/TransactionHelper.php](app/Helpers/TransactionHelper.php) | ✅ Unique dengan existence check | Bukti utama dari kode repository; tidak ada dokumentasi resmi spesifik untuk baris ini |
| **Stock Lock** | Validated pada TransactionItem creation | [app/Observers/TransactionItemObserver.php](app/Observers/TransactionItemObserver.php#L13) | ✅ Exception jika stock insufficient | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| **CashFlow Sync** | Automatic via TransactionObserver | [app/Observers/TransactionObserver.php](app/Observers/TransactionObserver.php#L18) | ✅ Sync otomatis | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| **Refund Handling** | Reverse operations pada deleted | [app/Observers/TransactionObserver.php](app/Observers/TransactionObserver.php#L31) | ✅ Reverse cashflow + stock | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| **Restore Handling** | Recreate cashflow pada restored | [app/Observers/TransactionObserver.php](app/Observers/TransactionObserver.php#L45) | ✅ Restore income entry | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| **Profit Tracking** | total_profit calculated per item | [app/Livewire/Pos.php](app/Livewire/Pos.php#L185) | ✅ Profit margin tracking | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration)<br>[Livewire Security](https://livewire.laravel.com/docs/security) |

**Penjelasan:**
Konsistensi transaksi dijaga melalui:
1. Observer yang auto-trigger pada create/update/delete
2. Stock validation sebelum transaction finalization
3. CashFlow entries yang otomatis dibuat
4. Reverse operations untuk deletions/restores

---

### 2.12 CSRF Protection

| Komponen | Status | Evidence File | Detail | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| **VerifyCsrfToken Middleware** | ✅ Active | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L31) | Global CSRF protection di middleware stack | [Laravel Middleware](https://laravel.com/docs/12.x/middleware)<br>[Laravel CSRF](https://laravel.com/docs/12.x/csrf)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration) |
| **Filament Forms** | ✅ Auto Protected | [app/Filament/Resources/ProductResource.php](app/Filament/Resources/ProductResource.php) | Form submission otomatis include CSRF token | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel CSRF](https://laravel.com/docs/12.x/csrf)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Livewire Components** | ✅ Auto Protected | [app/Livewire/Pos.php](app/Livewire/Pos.php) | Livewire otomatis handle CSRF tokens | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel CSRF](https://laravel.com/docs/12.x/csrf)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| **API Routes** | N/A | [routes/web.php](routes/web.php) | Tidak ada API routes yang ditemukan | [Laravel Routing](https://laravel.com/docs/12.x/routing) |

**Penjelasan:**
CSRF protection tercakup oleh `VerifyCsrfToken` middleware yang included di AdminPanelProvider middleware stack. Semua form submission (Filament Forms dan Livewire) otomatis protected karena middleware ini di-apply pada semua Filament panel requests.

---

### 2.13 XSS Protection

| Komponen | Status | Evidence File | Mekanisme | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| **Blade Template Escaping** | ✅ Default | Views di resources/ | Blade {{ }} otomatis escape HTML | [Laravel Blade](https://laravel.com/docs/12.x/blade)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **Filament Form Rendering** | ✅ Default | [app/Filament/Resources/](app/Filament/Resources/) | Filament component otomatis safe | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started)<br>[Filament Forms](https://filamentphp.com/docs/3.x/forms/getting-started) |
| **Livewire Data Binding** | ✅ Default | [app/Livewire/Pos.php](app/Livewire/Pos.php) | Livewire otomatis escape by default | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration)<br>[Livewire Security](https://livewire.laravel.com/docs/security) |
| **PDF Generation** | ✅ DomPDF Safe | [app/Http/Controllers/ReceiptController.php](app/Http/Controllers/ReceiptController.php#L27) | DomPDF dengan isHtml5ParserEnabled=true | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[DomPDF](https://github.com/barryvdh/laravel-dompdf)<br>[Laravel Responses](https://laravel.com/docs/12.x/responses) |

**Penjelasan:**
XSS protection bawaan framework:
1. Blade template escaping otomatis untuk {{ }}
2. Filament components sudah aman by design
3. Livewire otomatis escape output
4. PDF generation menggunakan safe parser options

---

### 2.14 SQL Injection Protection

| Komponen | Status | Evidence File | Detail | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| **Eloquent ORM** | ✅ Protected | All Models | Parameterized queries via Eloquent | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Query Builder](https://laravel.com/docs/12.x/queries) |
| **Query Builder** | ✅ Protected | [app/Filament/Resources/TransactionResource.php](app/Filament/Resources/TransactionResource.php#L97) | when() helper untuk conditional queries | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Query Builder](https://laravel.com/docs/12.x/queries) |
| **Raw Queries** | ❌ Tidak Ditemukan | Code Review | Tidak ditemukan raw SQL queries | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Query Builder](https://laravel.com/docs/12.x/queries) |
| **Barcode Lookup** | ✅ Protected | [app/Livewire/Pos.php](app/Livewire/Pos.php#L138) | where('barcode', $barcode) via Eloquent | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Query Builder](https://laravel.com/docs/12.x/queries) |
| **Report Generation** | ✅ Protected | [app/Observers/ReportObserver.php](app/Observers/ReportObserver.php#L23) | Query builder with when() helper | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Query Builder](https://laravel.com/docs/12.x/queries) |

**Penjelasan:**
SQL injection protection tercakup penuh via Eloquent ORM. Tidak ditemukan raw SQL queries yang rentan. Semua database interactions menggunakan parameterized queries melalui Eloquent method chains.

---

### 2.15 Mass Assignment Protection

| Model | Protected Attributes | Evidence File | Status | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| **User** | name, email, password | [app/Models/User.php](app/Models/User.php#L23-26) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Product** | category_id, name, stock, cost_price, price, image, barcode, sku, description, is_active | [app/Models/Product.php](app/Models/Product.php#L8-11) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Milon Barcode](https://github.com/milon/barcode) |
| **Transaction** | payment_method_id, transaction_number, name, email, phone, address, notes, total, cash_received, change | [app/Models/Transaction.php](app/Models/Transaction.php#L8-11) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **TransactionItem** | transaction_id, product_id, quantity, price, cost_price, total_profit | [app/Models/TransactionItem.php](app/Models/TransactionItem.php#L8-10) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| **Inventory** | type, source, total, notes | [app/Models/Inventory.php](app/Models/Inventory.php#L5) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **InventoryItem** | inventory_id, product_id, cost_price, quantity | [app/Models/InventoryItem.php](app/Models/InventoryItem.php#L6-10) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| **Category** | name | [app/Models/Category.php](app/Models/Category.php#L5) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **PaymentMethod** | name, image, is_cash | [app/Models/PaymentMethod.php](app/Models/PaymentMethod.php#L5) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **CashFlow** | date, type, source, amount, notes | [app/Models/CashFlow.php](app/Models/CashFlow.php#L5) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Setting** | logo, name, phone, address, print_via_bluetooth, name_printer_local | [app/Models/Setting.php](app/Models/Setting.php#L5) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[ESC/POS PHP](https://github.com/mike42/escpos-php) |

**Penjelasan:**
Semua models memiliki `protected $fillable` array yang mendefinisikan attributes mana saja yang dapat mass-assigned. Ini mencegah unauthorized attributes dari di-assign via create() atau update() methods.

---

### 2.16 Soft Delete Protection

| Model | Soft Delete Status | Evidence File | Behavior | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| **Product** | ✅ Active | [app/Models/Product.php](app/Models/Product.php#L5) | Use SoftDeletes trait | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Transaction** | ✅ Active | [app/Models/Transaction.php](app/Models/Transaction.php#L5) | Use SoftDeletes trait | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Category** | ✅ Active | [app/Models/Category.php](app/Models/Category.php#L5) | Use SoftDeletes trait | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **PaymentMethod** | ✅ Active | [app/Models/PaymentMethod.php](app/Models/PaymentMethod.php#L5) | Use SoftDeletes trait | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **User** | ❌ None | [app/Models/User.php](app/Models/User.php) | Hard delete (permanent) | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Report** | ❌ None | [app/Models/Report.php](app/Models/Report.php) | Hard delete | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **CashFlow** | ❌ None | [app/Models/CashFlow.php](app/Models/CashFlow.php) | Hard delete | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **InventoryItem** | ❌ None | [app/Models/InventoryItem.php](app/Models/InventoryItem.php) | Hard delete | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |

**Penjelasan:**
Soft delete digunakan pada models yang critical (Product, Transaction, Category, PaymentMethod). Ini memungkinkan restoration jika terjadi kesalahan delete. Resource pages menampilkan TrashedFilter untuk manage deleted records.

**Catatan Penting:**
User model tidak menggunakan soft delete, artinya user delete adalah permanent. CashFlow juga hard delete yang berarti record cashflow tidak bisa di-restore.

---

### 2.17 Runtime Configuration Protection

| Konfigurasi | Lokasi | Value | Evidence File | Status | Dokumentasi Resmi |
| --- | --- | --- | --- | --- | --- |
| **App Key** | .env | Random string (untuk encryption) | [config/app.php](config/app.php) | ✅ Required | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| **Debug Mode** | .env (APP_DEBUG) | false di production | Framework Config | ✅ Should be false | [Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| **Session Driver** | [config/session.php](config/session.php) | file/database | Laravel Default | ✅ Configured | [Laravel Session](https://laravel.com/docs/12.x/session)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| **Database Connection** | .env | Configured in config/database.php | [config/database.php](config/database.php) | ✅ Configured | [Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| **Filesystem Disk** | [config/filesystems.php](config/filesystems.php#L30) | local (default) | [config/filesystems.php](config/filesystems.php) | ✅ Configured | [Laravel Filesystem](https://laravel.com/docs/12.x/filesystem)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| **Upload Disk** | ProductResource | public_direct | [app/Filament/Resources/ProductResource.php](app/Filament/Resources/ProductResource.php#L76) | ✅ Explicit | [Filament FileUpload](https://filamentphp.com/docs/3.x/forms/fields/file-upload)<br>[Laravel Filesystem](https://laravel.com/docs/12.x/filesystem)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |

**Penjelasan:**
Runtime configuration dilindungi via .env file. Tidak ada hardcoded secrets dalam source code. Filesystem disk dikonfigurasi dengan multiple disk options (local, public, public_direct, s3).

---

### 2.18 PDF / Receipt Security

| Aspek | Implementasi | Evidence File | Tingkat Keamanan | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| **Receipt Access** | findOrFail($id) | [app/Http/Controllers/ReceiptController.php](app/Http/Controllers/ReceiptController.php#L12) | Medium - ID-based access tanpa auth | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Query Builder](https://laravel.com/docs/12.x/queries) |
| **Receipt Generation** | DomPDF library | [app/Http/Controllers/ReceiptController.php](app/Http/Controllers/ReceiptController.php#L24) | Tinggi - Safe library | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[DomPDF](https://github.com/barryvdh/laravel-dompdf)<br>[Laravel Responses](https://laravel.com/docs/12.x/responses) |
| **PDF Options** | isPhpEnabled=false, isHtml5ParserEnabled=true | [app/Http/Controllers/ReceiptController.php](app/Http/Controllers/ReceiptController.php#L28) | Tinggi - Disable PHP execution | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[DomPDF](https://github.com/barryvdh/laravel-dompdf)<br>[Laravel Responses](https://laravel.com/docs/12.x/responses) |
| **Data Included** | Transaction + items + payment method | [app/Http/Controllers/ReceiptController.php](app/Http/Controllers/ReceiptController.php#L13) | Medium - Sensitive data included | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[DomPDF](https://github.com/barryvdh/laravel-dompdf)<br>[Laravel Responses](https://laravel.com/docs/12.x/responses) |
| **Download Response** | streamDownload | [app/Http/Controllers/ReceiptController.php](app/Http/Controllers/ReceiptController.php#L30) | Tinggi - Direct stream | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[DomPDF](https://github.com/barryvdh/laravel-dompdf)<br>[Laravel Responses](https://laravel.com/docs/12.x/responses) |
| **Report PDF** | Observer-generated | [app/Observers/ReportObserver.php](app/Observers/ReportObserver.php) | Tinggi - Server-side generation | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[DomPDF](https://github.com/barryvdh/laravel-dompdf)<br>[Laravel Responses](https://laravel.com/docs/12.x/responses) |

**Penjelasan:**
PDF generation menggunakan DomPDF dengan safe options (PHP disabled, HTML5 parser enabled). Receipt controller menggunakan `findOrFail()` yang return 404 untuk invalid IDs. Namun, **tidak ada authorization check** untuk memverifikasi apakah user yang request adalah yang membuat receipt.

**RISIKO UTAMA:** Siapapun yang tahu transaction ID dapat mengakses dan download receipt milik orang lain.

---

### 2.19 Printer / Bluetooth Security

| Aspek | Implementasi | Evidence File | Keterangan | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| **Printer Type** | Windows Print Connector via Mike42 Escpos | [app/Services/DirectPrintService.php](app/Services/DirectPrintService.php#L23) | Local thermal printer | [ESC/POS PHP](https://github.com/mike42/escpos-php) |
| **Connection Method** | WindowsPrintConnector | [app/Services/DirectPrintService.php](app/Services/DirectPrintService.php#L23) | Windows printer API | [ESC/POS PHP](https://github.com/mike42/escpos-php) |
| **Printer Name** | Stored in Setting model | [app/Services/DirectPrintService.php](app/Services/DirectPrintService.php#L21) | Database stored | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[ESC/POS PHP](https://github.com/mike42/escpos-php) |
| **Bluetooth Option** | Setting flag (print_via_bluetooth) | [app/Livewire/Pos.php](app/Livewire/Pos.php#L30) | Via Livewire dispatch event | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration)<br>[ESC/POS PHP](https://github.com/mike42/escpos-php) |
| **Error Handling** | Try-catch exception handling | [app/Services/DirectPrintService.php](app/Services/DirectPrintService.php#L50) | Graceful error notification | Bukti utama dari kode repository; tidak ada dokumentasi resmi spesifik untuk baris ini |
| **Image Handling** | EscposImage with public path | [app/Services/DirectPrintService.php](app/Services/DirectPrintService.php#L28) | Load dari public storage | [Laravel Filesystem](https://laravel.com/docs/12.x/filesystem)<br>[Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |

**Analisis:**

**Direct Print (Kabel):**
- Menggunakan WindowsPrintConnector dari Mike42 library
- Printer name diambil dari Setting->name_printer_local
- Error handling dengan try-catch, notifikasi jika printer tidak terdaftar

**Bluetooth Print:**
- Via Livewire dispatch event 'doPrintReceipt'
- Data dikirim ke frontend untuk JavaScript handling
- Tidak ada implementasi backend Bluetooth handler yang ditemukan

**Potensi Risiko:**
1. Printer name stored di database tanpa validation
2. Bluetooth implementation di client-side (tidak aman)
3. Tidak ada queue system untuk print jobs
4. Tidak ada print job logging/audit trail

---

### 2.20 Barcode Scanner Security

| Aspek | Implementasi | Evidence File | Detail | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| **Barcode Input** | Livewire reactive property | [app/Livewire/Pos.php](app/Livewire/Pos.php#L137) | updatedBarcode($barcode) | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration) |
| **Scanner Event Listener** | Livewire listener | [app/Livewire/Pos.php](app/Livewire/Pos.php#L54) | 'scanResult' => 'handleScanResult' | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration)<br>[html5-qrcode](https://github.com/mebjas/html5-qrcode) |
| **Barcode Lookup** | Database query dengan validation | [app/Livewire/Pos.php](app/Livewire/Pos.php#L140) | where('barcode', $barcode)->where('is_active', 1) | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Livewire Forms](https://livewire.laravel.com/docs/forms)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Not Found Handling** | Notification + barcode reset | [app/Livewire/Pos.php](app/Livewire/Pos.php#L143) | Danger notification jika tidak ditemukan | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration)<br>[Milon Barcode](https://github.com/milon/barcode) |
| **Barcode Format** | 13-digit dengan checksum | [app/Observers/ProductObserver.php](app/Observers/ProductObserver.php#L35) | Generated via ProductObserver | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Milon Barcode](https://github.com/milon/barcode)<br>[Filament Forms](https://filamentphp.com/docs/3.x/forms/getting-started) |
| **Manual Barcode** | Optional input di product form | [app/Filament/Resources/ProductResource.php](app/Filament/Resources/ProductResource.php#L96) | Auto-generated jika kosong | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Milon Barcode](https://github.com/milon/barcode)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |

**Penjelasan:**

Barcode scanner terintegrasi via dua mekanisme:
1. **Manual input:** updatedBarcode reactive property
2. **Hardware scanner:** handleScanResult event listener

Keduanya melakukan lookup yang sama:
- Query product by barcode
- Filter active products only
- Notify jika tidak ditemukan
- Add to cart jika ditemukan dengan stock validation

**Keamanan:**
- Barcode di-generate dengan 13-digit + checksum (UPC-A format)
- Checksum validation mencegah invalid barcode entry
- Stock check mencegah overselling

---

### 2.21 Access Restriction

| Halaman / Resource | Akses Requirement | Evidence File | Status | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| **/admin/** (All Filament) | Authenticate (logged-in) | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L34) | ✅ Login required | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| **POS Page (/pos)** | Authenticate + HasPageShield permission | [app/Filament/Pages/PosPage.php](app/Filament/Pages/PosPage.php#L7) | ✅ Role-based | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| **Dashboard Page** | Authenticate + HasPageShield permission | [app/Filament/Pages/Dashboard.php](app/Filament/Pages/Dashboard.php#L10) | ✅ Role-based | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| **Product Resource** | create_product, view_any_product, update_product, delete_product | [app/Filament/Resources/ProductResource.php](app/Filament/Resources/ProductResource.php#L18) | ✅ Permission-based | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **Transaction Resource** | create_transaction, view_any_transaction, update_transaction, delete_transaction | [app/Filament/Resources/TransactionResource.php](app/Filament/Resources/TransactionResource.php#L23) | ✅ Permission-based | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **User Resource** | create_user, update_user, view_any_user, delete_any_user | [app/Filament/Resources/UserResource.php](app/Filament/Resources/UserResource.php#L18) | ✅ Permission-based | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **Receipt Public (/receipt/{id})** | **NONE** | [routes/web.php](routes/web.php#L7) | ❌ **Unrestricted** | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[DomPDF](https://github.com/barryvdh/laravel-dompdf)<br>[Laravel Responses](https://laravel.com/docs/12.x/responses) |
| **Report PDF (/receipt/{id}/download)** | **NONE** | [routes/web.php](routes/web.php#L8) | ❌ **Unrestricted** | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[DomPDF](https://github.com/barryvdh/laravel-dompdf)<br>[Laravel Responses](https://laravel.com/docs/12.x/responses) |

**Analisis Kritis:**
Semua Filament resources protected dengan permission system KECUALI receipt routes di web.php. Ini adalah potensi **Information Disclosure** vulnerability.

---

### 2.22 Resource Permission

| Resource | Implemented Permissions | Evidence File | Detail | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| **Product** | view_any, create, update, delete, delete_any, restore, restore_any, force_delete, force_delete_any | [app/Filament/Resources/ProductResource.php](app/Filament/Resources/ProductResource.php#L18) | 9 permissions | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **Category** | view, view_any, create, update, delete, delete_any, restore, restore_any, force_delete, force_delete_any | [app/Filament/Resources/CategoryResource.php](app/Filament/Resources/CategoryResource.php#L20) | 10 permissions | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **Transaction** | view, view_any, create, update, delete, delete_any, restore, restore_any, force_delete, force_delete_any | [app/Filament/Resources/TransactionResource.php](app/Filament/Resources/TransactionResource.php#L23) | 10 permissions | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **User** | view_any, create, update, delete_any | [app/Filament/Resources/UserResource.php](app/Filament/Resources/UserResource.php#L18) | 4 permissions | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **PaymentMethod** | view, view_any, create, update, delete, delete_any, restore, restore_any, force_delete, force_delete_any | [app/Filament/Resources/PaymentMethodResource.php](app/Filament/Resources/PaymentMethodResource.php#L13) | 10 permissions | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **Inventory** | view_any, create, update, delete_any | [app/Filament/Resources/InventoryResource.php](app/Filament/Resources/InventoryResource.php#L18) | 4 permissions | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **CashFlow** | view_any, create, update, delete_any | [app/Filament/Resources/CashFlowResource.php](app/Filament/Resources/CashFlowResource.php#L28) | 4 permissions | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **Report** | (Generated by Filament Shield) | [app/Filament/Resources/ReportResource.php](app/Filament/Resources/) | Auto-generated | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| **Setting** | (Generated by Filament Shield) | [app/Filament/Resources/SettingResource.php](app/Filament/Resources/) | Auto-generated | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |

**Penjelasan:**
Setiap resource mengimplementasikan `HasShieldPermissions` interface yang mendefinisikan permission prefixes yang relevan untuk resource tersebut. Ini memungkinkan Filament Shield auto-generate permissions. User harus memiliki permission yang sesuai untuk akses resource.

---

### 2.23 Policy Protection

| Policy | Methods | Evidence File | Authorization Logic | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| **UserPolicy** | viewAny, view, create, update, delete, deleteAny, forceDelete, forceDeleteAny | [app/Policies/UserPolicy.php](app/Policies/UserPolicy.php) | user->can('view_any_user'), user->can('create_user'), etc | [Laravel Authorization](https://laravel.com/docs/12.x/authorization) |
| **ProductPolicy** | viewAny, view, create, update, delete, deleteAny, forceDelete, forceDeleteAny, restore, restoreAny, replicate | [app/Policies/ProductPolicy.php](app/Policies/ProductPolicy.php) | Check corresponding permission | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction) |
| **TransactionPolicy** | viewAny, view, create, update, delete, deleteAny, forceDelete, forceDeleteAny, restore, restoreAny, replicate | [app/Policies/TransactionPolicy.php](app/Policies/TransactionPolicy.php) | Check corresponding permission | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction) |
| **CategoryPolicy** | Full CRUD permissions | [app/Policies/CategoryPolicy.php](app/Policies/CategoryPolicy.php) | Standard Filament Shield pattern | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield) |
| **InventoryPolicy** | CRUD permissions | [app/Policies/InventoryPolicy.php](app/Policies/InventoryPolicy.php) | Check inventory permissions | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction) |
| **PaymentMethodPolicy** | Full CRUD permissions | [app/Policies/PaymentMethodPolicy.php](app/Policies/PaymentMethodPolicy.php) | Check payment method permissions | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction) |
| **CashFlowPolicy** | Limited permissions (no delete single) | [app/Policies/CashFlowPolicy.php](app/Policies/CashFlowPolicy.php) | Read-only atau limited write | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction) |
| **RolePolicy** | Role management permissions | [app/Policies/RolePolicy.php](app/Policies/RolePolicy.php) | Role-based access | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction) |
| **ReportPolicy** | Report creation and viewing | [app/Policies/ReportPolicy.php](app/Policies/ReportPolicy.php) | User->can() checking | [Laravel Authorization](https://laravel.com/docs/12.x/authorization) |
| **SettingPolicy** | Setting management | [app/Policies/SettingPolicy.php](app/Policies/SettingPolicy.php) | Likely admin-only | [Laravel Authorization](https://laravel.com/docs/12.x/authorization) |

**Penjelasan:**
Setiap resource memiliki corresponding Policy class yang mengimplementasikan authorization logic. Policy methods di-call oleh Filament otomatis sebelum action dapat dijalankan. Semua policy methods check `user->can('permission_name')` menggunakan Spatie Permission.

---

### 2.24 Livewire Security

| Komponen Livewire | Risiko | Mitigasi | Evidence File | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| **Cart Session Storage** | Session manipulation | Validation on checkout, stock re-check | [app/Livewire/Pos.php](app/Livewire/Pos.php#L45-46) | [Laravel Session](https://laravel.com/docs/12.x/session)<br>[Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Livewire Forms](https://livewire.laravel.com/docs/forms) |
| **Barcode Scanner Input** | Injection attack | Escaped by Livewire, lookup via Eloquent | [app/Livewire/Pos.php](app/Livewire/Pos.php#L137-142) | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration) |
| **Quantity Manipulation** | Over-add items beyond stock | Stock check per item addition | [app/Livewire/Pos.php](app/Livewire/Pos.php#L187-190) | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Livewire Forms](https://livewire.laravel.com/docs/forms)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| **Price Tampering** | Manual price change | Price taken from Product DB on checkout | [app/Livewire/Pos.php](app/Livewire/Pos.php#L186) | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration)<br>[Livewire Security](https://livewire.laravel.com/docs/security) |
| **Payment Method Switch** | Invalid payment selection | Reactive select with validation | [app/Livewire/Pos.php](app/Livewire/Pos.php#L102-110) | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Livewire Forms](https://livewire.laravel.com/docs/forms)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| **Cash Calculation** | Math manipulation | Numeric validation + calculation check | [app/Livewire/Pos.php](app/Livewire/Pos.php#L127-135) | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Livewire Forms](https://livewire.laravel.com/docs/forms)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| **Checkout Mutation** | Invalid state on checkout | Full validation + re-fetch dari DB | [app/Livewire/Pos.php](app/Livewire/Pos.php#L315-352) | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Livewire Forms](https://livewire.laravel.com/docs/forms)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| **ScannerModalComponent** | Event hijacking | Livewire protected events | [app/Livewire/ScannerModalComponent.php](app/Livewire/ScannerModalComponent.php) | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[html5-qrcode](https://github.com/mebjas/html5-qrcode)<br>[Livewire Security](https://livewire.laravel.com/docs/security) |

**Analisis Detail:**

**Potensi Vulnerabilitas:**
1. **Cart Price Caching:** Cart items dalam session memuat harga dari saat add-to-cart. Jika harga berubah, user masih lihat harga lama.
   - Mitigasi: Harga di-re-fetch saat checkout? (Perlu verify di controller)
   
2. **Session-based Cart:** Dapat dimanipulasi jika session cookie di-compromise
   - Mitigasi: CSRF token protection, encrypted cookies
   
3. **Stock Race Condition:** Jika 2 user add item sama secara bersamaan, bisa terjadi overselling
   - Mitigasi: Observer check pada TransactionItem creation (fail jika stock insufficient)

**Strength:**
- Livewire otomatis handle CSRF
- Barcode input escaped otomatis
- Stock validation ketat
- Checkout validation comprehensive

---

### 2.25 Storage Security

| Disk | Driver | Root Path | URL | Visibility | Usage | Risiko | Dokumentasi Resmi |
| --- | --- | --- | --- | --- | --- | --- | --- |
| **local** | local | storage/app/private | - | private | Private files | Rendah | [Laravel Filesystem](https://laravel.com/docs/12.x/filesystem) |
| **public** | local | storage/app/public | /storage | public | Downloadable files | Sedang | [Laravel Filesystem](https://laravel.com/docs/12.x/filesystem)<br>[DomPDF](https://github.com/barryvdh/laravel-dompdf)<br>[Laravel Responses](https://laravel.com/docs/12.x/responses) |
| **public_direct** | local | public_path() | / | public | Direct public access | Sedang | [Laravel Filesystem](https://laravel.com/docs/12.x/filesystem)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| **s3** | s3 | N/A | AWS CloudFront | cloud | Cloud storage | Rendah (jika configured) | [Laravel Filesystem](https://laravel.com/docs/12.x/filesystem) |

**Penggunaan di Aplikasi:**
1. **Product Image:** public_direct disk → langsung di public folder
2. **Report PDF:** public disk → via /storage symbolic link
3. **Payment Icon:** Assumed public disk
4. **Settings/Logo:** Stored in public atau public_direct

**Analisis Keamanan:**
- **public_direct disk:** File langsung di public folder, tidak melalui /storage
- **No access control:** Tidak ada authorization check saat accessing file
- **Filename guessing:** Predictable filenames (products/product-1.jpg, dll)

**POTENSI RISIKO:** User dapat guess filenames dan akses files langsung via URL.

---

## 3. ANALISIS KEAMANAN PER FITUR

### 3.1 Login / Authentication

| Mekanisme Keamanan | Teknologi | Evidence File | Fungsi | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| Session Login | Laravel Auth + Session Guard | [config/auth.php](config/auth.php#L33) | Session-based login | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Laravel Session](https://laravel.com/docs/12.x/session)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| Password Hash | Laravel Hash facade | [app/Models/User.php](app/Models/User.php#L32) | Auto-hash password on store | [Laravel Hashing](https://laravel.com/docs/12.x/hashing)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| Filament Login UI | Built-in Filament login page | [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php#L19) | ->login() configuration | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Filament Users](https://filamentphp.com/docs/3.x/panels/users)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| Session Duration | Configurable via config/session.php | [config/session.php](config/session.php) | Default 2 hours | [Laravel Session](https://laravel.com/docs/12.x/session)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| Remember Me | Laravel remember_token | [app/Models/User.php](app/Models/User.php#L36) | 'remember_token' hidden field | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| Password Reset | Email token with expiry | [config/auth.php](config/auth.php#L100) | Reset token expire 60 minutes | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Laravel Session](https://laravel.com/docs/12.x/session)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |

**Keamanan Detail:**
- Login via Filament built-in UI
- Password di-hash otomatis dengan cast 'hashed'
- Session guard digunakan untuk persistence
- Password reset token dengan expire time

---

### 3.2 Dashboard

| Mekanisme Keamanan | Teknologi | Evidence File | Status | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| Page Access Control | HasPageShield trait | [app/Filament/Pages/Dashboard.php](app/Filament/Pages/Dashboard.php#L10) | Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield) |
| Data Filtering | Date range filter dengan DatePicker | [app/Filament/Pages/Dashboard.php](app/Filament/Pages/Dashboard.php#L19) | User can filter | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration)<br>[Filament Forms](https://filamentphp.com/docs/3.x/forms/getting-started) |
| Widget Display | Multiple dashboard widgets | [app/Filament/Pages/Dashboard.php](app/Filament/Pages/Dashboard.php) | Depends on permissions | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| Performance | Filament dashboard widgets | [app/Filament/Widgets/](app/Filament/Widgets/) | Should be optimized | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Filament Forms](https://filamentphp.com/docs/3.x/forms/getting-started)<br>[Filament Pages](https://filamentphp.com/docs/3.x/panels/pages) |

**Keamanan:** Dashboard protected dengan authentication dan page shield permission.

---

### 3.3 POS / Kasir

| Mekanisme Keamanan | Teknologi | Evidence File | Tingkat Keamanan | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| Page Authorization | HasPageShield trait | [app/Filament/Pages/PosPage.php](app/Filament/Pages/PosPage.php#L7) | Tinggi | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield) |
| Cart Session | Session-based with validation | [app/Livewire/Pos.php](app/Livewire/Pos.php#L45) | Tinggi | [Laravel Session](https://laravel.com/docs/12.x/session)<br>[Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Livewire Forms](https://livewire.laravel.com/docs/forms) |
| Stock Validation | Per-item stock check | [app/Livewire/Pos.php](app/Livewire/Pos.php#L187-190) | Tinggi | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Livewire Forms](https://livewire.laravel.com/docs/forms)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| Barcode Scanner | Livewire event handling | [app/Livewire/Pos.php](app/Livewire/Pos.php#L152-161) | Tinggi | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration)<br>[Milon Barcode](https://github.com/milon/barcode) |
| Checkout Validation | Custom validation + re-check | [app/Livewire/Pos.php](app/Livewire/Pos.php#L315-352) | Tinggi | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Livewire Forms](https://livewire.laravel.com/docs/forms)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |
| Transaction Creation | Via Observer auto-generation | [app/Observers/TransactionObserver.php](app/Observers/TransactionObserver.php) | Tinggi | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| CashFlow Sync | Automatic via Observer | [app/Observers/TransactionObserver.php](app/Observers/TransactionObserver.php#L18) | Tinggi | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| Printer Integration | Direct print + Bluetooth option | [app/Services/DirectPrintService.php](app/Services/DirectPrintService.php) | Medium | [ESC/POS PHP](https://github.com/mike42/escpos-php) |
| Receipt | Display + Download | [app/Http/Controllers/ReceiptController.php](app/Http/Controllers/ReceiptController.php) | Medium | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[DomPDF](https://github.com/barryvdh/laravel-dompdf)<br>[Laravel Responses](https://laravel.com/docs/12.x/responses) |

**Analisis:**
POS adalah fitur paling kompleks dengan multiple security layers:
1. Page authorization via HasPageShield
2. Session-based cart dengan validation
3. Real-time stock checking
4. Comprehensive checkout validation
5. Automatic observer-based data integrity

**Kelemahan:**
- Cart prices cached dari saat add-to-cart (bisa outdated)
- Session cart bisa dimanipulasi jika session cookie di-breach
- Printer implementation kurang robust

---

### 3.4 Produk

| Mekanisme Keamanan | Teknologi | Evidence File | Status | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| Resource Authorization | ProductPolicy + permissions | [app/Policies/ProductPolicy.php](app/Policies/ProductPolicy.php) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield) |
| Form Validation | Numeric, required, maxLength | [app/Filament/Resources/ProductResource.php](app/Filament/Resources/ProductResource.php#L57) | ✅ Implemented | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| Image Upload | image() validation + public_direct disk | [app/Filament/Resources/ProductResource.php](app/Filament/Resources/ProductResource.php#L76) | ✅ Validated | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament FileUpload](https://filamentphp.com/docs/3.x/forms/fields/file-upload) |
| SKU Generation | Auto-generated via ProductObserver | [app/Observers/ProductObserver.php](app/Observers/ProductObserver.php#L12) | ✅ Unique | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| Barcode Generation | Auto-generated dengan checksum | [app/Observers/ProductObserver.php](app/Observers/ProductObserver.php#L18) | ✅ Unique | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Milon Barcode](https://github.com/milon/barcode) |
| Stock Management | Read-only di product form (via inventory) | [app/Filament/Resources/ProductResource.php](app/Filament/Resources/ProductResource.php#L77-80) | ✅ Isolated | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| Soft Delete | SoftDeletesScope + restore/force delete | [app/Models/Product.php](app/Models/Product.php#L5) | ✅ Recoverable | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| Category Cascade | Cascade delete via CategoryObserver | [app/Observers/CategoryObserver.php](app/Observers/CategoryObserver.php) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |

---

### 3.5 Kategori

| Mekanisme Keamanan | Teknologi | Evidence File | Status | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| Authorization | CategoryPolicy + permissions | [app/Policies/CategoryPolicy.php](app/Policies/CategoryPolicy.php) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction) |
| Form Validation | required, maxLength | [app/Filament/Resources/CategoryResource.php](app/Filament/Resources/CategoryResource.php#L56) | ✅ Validated | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| Cascade Delete | Products deleted when category deleted | [app/Observers/CategoryObserver.php](app/Observers/CategoryObserver.php#L12) | ✅ Integrity | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| Cascade Restore | Products restored when category restored | [app/Observers/CategoryObserver.php](app/Observers/CategoryObserver.php#L17) | ✅ Integrity | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| Soft Delete | SoftDeletes trait | [app/Models/Category.php](app/Models/Category.php#L5) | ✅ Recoverable | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |

---

### 3.6 Inventory

| Mekanisme Keamanan | Teknologi | Evidence File | Status | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| Authorization | Permission-based access | [app/Filament/Resources/InventoryResource.php](app/Filament/Resources/InventoryResource.php) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield) |
| Reference Number | Auto-generated with uniqueness | [app/Observers/InventoryObserver.php](app/Observers/InventoryObserver.php#L9) | ✅ Unique | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| Type Validation | ToggleButtons with options (in/out/adjustment) | [app/Filament/Resources/InventoryResource.php](app/Filament/Resources/InventoryResource.php#L41) | ✅ Validated | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| Source Validation | Dynamic options based on type | [app/Filament/Resources/InventoryResource.php](app/Filament/Resources/InventoryResource.php#L48) | ✅ Validated | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| Stock Sync | Automatic via InventoryItemObserver | [app/Observers/InventoryItemObserver.php](app/Observers/InventoryItemObserver.php) | ✅ Automatic | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| CashFlow Sync | Automatic via InventoryObserver | [app/Observers/InventoryObserver.php](app/Observers/InventoryObserver.php) | ✅ Automatic | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| Items Repeater | Validation per item | [app/Filament/Resources/InventoryResource.php](app/Filament/Resources/InventoryResource.php#L58) | ✅ Validated | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |

---

### 3.7 Transaksi

| Mekanisme Keamanan | Teknologi | Evidence File | Tingkat Keamanan | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| Authorization | TransactionPolicy + permissions | [app/Policies/TransactionPolicy.php](app/Policies/TransactionPolicy.php) | Tinggi | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction) |
| Transaction Number | Unique auto-generated | [app/Helpers/TransactionHelper.php](app/Helpers/TransactionHelper.php) | Tinggi | Bukti utama dari kode repository; tidak ada dokumentasi resmi spesifik untuk baris ini |
| Stock Validation | Per-item on creation | [app/Observers/TransactionItemObserver.php](app/Observers/TransactionItemObserver.php#L12) | Tinggi | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| CashFlow Sync | Automatic on create/update/delete | [app/Observers/TransactionObserver.php](app/Observers/TransactionObserver.php) | Tinggi | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| Refund Handling | Reverse operations on delete | [app/Observers/TransactionObserver.php](app/Observers/TransactionObserver.php#L31) | Tinggi | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |
| Date Range Filter | Validation-based filtering | [app/Filament/Resources/TransactionResource.php](app/Filament/Resources/TransactionResource.php#L97) | Medium | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| Soft Delete | Transaction dapat di-restore | [app/Models/Transaction.php](app/Models/Transaction.php#L5) | Tinggi | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| Payment Validation | Required + reactive | [app/Filament/Resources/TransactionResource.php](app/Filament/Resources/TransactionResource.php#L100) | Medium | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Livewire Security](https://livewire.laravel.com/docs/security) |

---

### 3.8 CashFlow

| Mekanisme Keamanan | Teknologi | Evidence File | Status | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| Authorization | Permission-based access | [app/Filament/Resources/CashFlowResource.php](app/Filament/Resources/CashFlowResource.php) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield) |
| Auto-Creation | Via Observers (Transaction, Inventory) | [app/Observers/TransactionObserver.php](app/Observers/TransactionObserver.php#L18) | ✅ Automatic | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| Type Validation | ToggleButtons (income/expense) | [app/Filament/Resources/CashFlowResource.php](app/Filament/Resources/CashFlowResource.php#L36) | ✅ Validated | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| Source Validation | Dynamic based on type | [app/Filament/Resources/CashFlowResource.php](app/Filament/Resources/CashFlowResource.php#L40) | ✅ Validated | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| Amount Validation | Numeric with prefix | [app/Filament/Resources/CashFlowResource.php](app/Filament/Resources/CashFlowResource.php#L42) | ✅ Validated | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| Read Access | Limited (view_any, create, update, delete_any) | [app/Filament/Resources/CashFlowResource.php](app/Filament/Resources/CashFlowResource.php#L28) | ✅ Restricted | [Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| Hard Delete | No soft delete (permanent) | [app/Models/CashFlow.php](app/Models/CashFlow.php) | ⚠️ Permanent | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |

---

### 3.9 Payment Method

| Mekanisme Keamanan | Teknologi | Evidence File | Status | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| Authorization | PaymentMethodPolicy + permissions | [app/Policies/PaymentMethodPolicy.php](app/Policies/PaymentMethodPolicy.php) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction) |
| Name Validation | required, maxLength | [app/Filament/Resources/PaymentMethodResource.php](app/Filament/Resources/PaymentMethodResource.php#L38) | ✅ Validated | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| Icon Upload | image() validation required | [app/Filament/Resources/PaymentMethodResource.php](app/Filament/Resources/PaymentMethodResource.php#L41) | ✅ Validated | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament FileUpload](https://filamentphp.com/docs/3.x/forms/fields/file-upload) |
| Cash Toggle | Boolean toggle for cash payment | [app/Filament/Resources/PaymentMethodResource.php](app/Filament/Resources/PaymentMethodResource.php#L44) | ✅ Clear | [Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| Soft Delete | Recoverable via restore | [app/Models/PaymentMethod.php](app/Models/PaymentMethod.php#L5) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| Usage Validation | Payment method checked in transactions | [app/Livewire/Pos.php](app/Livewire/Pos.php#L102) | ✅ Used | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Livewire Forms](https://livewire.laravel.com/docs/forms)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing) |

---

### 3.10 Report / Laporan

| Mekanisme Keamanan | Teknologi | Evidence File | Status | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| Authorization | ReportPolicy + permissions | [app/Filament/Resources/ReportResource.php](app/Filament/Resources/) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield) |
| PDF Generation | Observer-based auto generation | [app/Observers/ReportObserver.php](app/Observers/ReportObserver.php) | ✅ Automatic | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[DomPDF](https://github.com/barryvdh/laravel-dompdf)<br>[Laravel Responses](https://laravel.com/docs/12.x/responses) |
| Report Type | Selection (inflow/outflow/sales) | [app/Filament/Resources/ReportResource.php](app/Filament/Resources/) | ✅ Validated | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| Date Filtering | start_date, end_date validation | [app/Observers/ReportObserver.php](app/Observers/ReportObserver.php#L20) | ✅ Validated | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Filament Tables](https://filamentphp.com/docs/3.x/tables/getting-started) |
| Filename Generation | Format LAPORAN-YYYYMMDD-{number} | [app/Observers/ReportObserver.php](app/Observers/ReportObserver.php#L13) | ✅ Unique | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Filament Forms](https://filamentphp.com/docs/3.x/forms/getting-started) |
| PDF Storage | storage/app/public/reports | [app/Observers/ReportObserver.php](app/Observers/ReportObserver.php#L35) | ✅ Stored | [Laravel Filesystem](https://laravel.com/docs/12.x/filesystem)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[DomPDF](https://github.com/barryvdh/laravel-dompdf) |
| File Access | Via storage link (public) | Framework | ⚠️ Public accessible | [Laravel Filesystem](https://laravel.com/docs/12.x/filesystem) |

---

### 3.11 User Management

| Mekanisme Keamanan | Teknologi | Evidence File | Tingkat Keamanan | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| Authorization | UserPolicy + permissions | [app/Policies/UserPolicy.php](app/Policies/UserPolicy.php) | Tinggi | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction) |
| Password Hashing | Hash::make() dehydration | [app/Filament/Resources/UserResource.php](app/Filament/Resources/UserResource.php#L30) | Tinggi | [Laravel Hashing](https://laravel.com/docs/12.x/hashing)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| Password Required | On create only, optional on update | [app/Filament/Resources/UserResource.php](app/Filament/Resources/UserResource.php#L32) | Medium | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| Email Validation | email() + required | [app/Filament/Resources/UserResource.php](app/Filament/Resources/UserResource.php#L28) | Tinggi | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| Role Assignment | Relationship to roles | [app/Filament/Resources/UserResource.php](app/Filament/Resources/UserResource.php#L34) | Tinggi | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| Hard Delete | No soft delete (permanent) | [app/Models/User.php](app/Models/User.php) | ⚠️ Permanent | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| List View | recordAction=null (no detail page) | [app/Filament/Resources/UserResource.php](app/Filament/Resources/UserResource.php#L52) | Medium | [Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started)<br>[Filament Pages](https://filamentphp.com/docs/3.x/panels/pages) |
| Bulk Actions | Disabled | [app/Filament/Resources/UserResource.php](app/Filament/Resources/UserResource.php#L57) | Medium | [Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started)<br>[Filament Tables](https://filamentphp.com/docs/3.x/tables/getting-started)<br>[Filament Actions](https://filamentphp.com/docs/3.x/actions/overview) |

**Potensi Risiko:**
- User delete adalah permanent (tidak bisa di-restore)
- Password optional pada update (hanya update kalau diisi)
- No user activity logging ditemukan

---

### 3.12 Role / Permission

| Mekanisme Keamanan | Teknologi | Evidence File | Status | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| Role Management | Spatie Permission + Filament Shield | [config/filament-shield.php](config/filament-shield.php) | ✅ Integrated | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| Permission Assignment | Via Filament Shield UI | [config/filament-shield.php](config/filament-shield.php#L27) | ✅ Auto-generated | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| Super Admin Role | Enabled dengan intercept | [config/filament-shield.php](config/filament-shield.php#L18) | ✅ Bypass all | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| Permission Caching | Spatie Permission caching | [config/permission.php](config/permission.php#L75) | ✅ Cached | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| Permission Prefixes | Structured naming | [config/filament-shield.php](config/filament-shield.php#L31) | ✅ Consistent | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| Custom Permissions | Disabled in config | [config/filament-shield.php](config/filament-shield.php#L60) | ⚠️ Limited flexibility | [Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |

---

### 3.13 Setting

| Mekanisme Keamanan | Teknologi | Evidence File | Status | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| Authorization | SettingPolicy + permissions | [app/Policies/SettingPolicy.php](app/Policies/SettingPolicy.php) | ✅ Protected | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction) |
| Logo Upload | FileUpload component | [app/Filament/Resources/SettingResource.php](app/Filament/Resources/) | ✅ Stored | [Filament FileUpload](https://filamentphp.com/docs/3.x/forms/fields/file-upload)<br>[Laravel Filesystem](https://laravel.com/docs/12.x/filesystem)<br>[Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) |
| Printer Configuration | name_printer_local field | [app/Models/Setting.php](app/Models/Setting.php#L5) | ✅ Configured | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[ESC/POS PHP](https://github.com/mike42/escpos-php)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| Bluetooth Toggle | Boolean flag | [app/Models/Setting.php](app/Models/Setting.php#L5) | ✅ Configured | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[ESC/POS PHP](https://github.com/mike42/escpos-php) |
| Shop Info | name, phone, address fields | [app/Models/Setting.php](app/Models/Setting.php#L5) | ✅ Stored | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| Single Record | Singleton pattern | [app/Http/Controllers/ReceiptController.php](app/Http/Controllers/ReceiptController.php#L13) | ✅ Setting::first() | [Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[DomPDF](https://github.com/barryvdh/laravel-dompdf)<br>[Laravel Responses](https://laravel.com/docs/12.x/responses) |

---

## 4. ANALISIS MIDDLEWARE & ROUTE PROTECTION

### Middleware Stack (AdminPanelProvider)

```
1. EncryptCookies - Encrypt request/response cookies
2. AddQueuedCookiesToResponse - Queue cookies to response
3. StartSession - Start PHP session
4. AuthenticateSession - Validate session authentication
5. ShareErrorsFromSession - Share validation errors
6. VerifyCsrfToken - Verify CSRF token
7. SubstituteBindings - Route model binding
8. DisableBladeIconComponents - Disable blade icons
9. DispatchServingFilamentEvent - Dispatch Filament event
10. Authenticate (authMiddleware) - Check authentication
```

**Semua middleware di-apply untuk SETIAP request ke Filament panel** (/admin, /pos, /dashboard, dll)

### Route Protection Summary

| Route Pattern | Middleware | Status | Evidence | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| `/admin/*` | Full middleware stack + Authenticate | ✅ Protected | AdminPanelProvider | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Middleware](https://laravel.com/docs/12.x/middleware)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration) |
| `/pos` | Full middleware stack + HasPageShield | ✅ Protected | PosPage.php | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield) |
| `/dashboard` | Full middleware stack + HasPageShield | ✅ Protected | Dashboard.php | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield) |
| `/receipt/{id}` | **NONE** | ❌ **UNPROTECTED** | routes/web.php | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[Laravel Middleware](https://laravel.com/docs/12.x/middleware) |
| `/receipt/{id}/download` | **NONE** | ❌ **UNPROTECTED** | routes/web.php | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Routing](https://laravel.com/docs/12.x/routing)<br>[Laravel Middleware](https://laravel.com/docs/12.x/middleware) |

---

## 5. ANALISIS VALIDATION SECURITY

### Form-Level Validation

**ProductResource:**
- name: required, maxLength(255)
- category_id: required
- cost_price: required, numeric
- price: required, numeric
- stock: readOnly (can't edit here)
- sku: optional, maxLength(255)
- barcode: optional, numeric
- image: image validation, nullable
- is_active: required toggle

**TransactionResource:**
- name: maxLength(255)
- email: email validation
- phone: tel validation
- items: Repeater with validation
- payment_method_id: required, reactive
- cash_received: numeric, reactive
- total: numeric, readOnly

**Livewire Checkout:**
- name: string, maxLength(255)
- payment_method_id: required
- cash_received: required (if cash), >= total
- order_items: not empty, valid stock

**InventoryResource:**
- type: required (in/out/adjustment)
- source: required, dynamic options
- total: required, numeric

### Business Logic Validation

1. **Stock Validation** - per item pada add to cart dan checkout
2. **Payment Method Validation** - required, exists in database
3. **Price Validation** - taken from database, not from client
4. **Quantity Validation** - numeric, > 0

---

## 6. ANALISIS UPLOAD & STORAGE SECURITY

### Storage Configuration

**Disk: public_direct**
```
Driver: local
Root: public_path() (direktly di public folder)
URL: APP_URL
Visibility: public
Usage: Product images, payment icons
Risiko: Files directly accessible via URL
```

**Disk: public**
```
Driver: local
Root: storage/app/public
URL: APP_URL/storage
Visibility: public
Usage: Report PDFs
Risiko: Files accessible via storage link
```

### Upload Validation

**Product Image:**
- Validation: image() [checks: image, max 1MB by default]
- Disk: public_direct
- Directory: storage/products/
- No size limit config found

**Payment Icon:**
- Validation: image() required
- Disk: public (assumed)
- No size limit config found

### Security Gaps

1. ❌ No explicit file size limit
2. ❌ No MIME type restriction (beyond image check)
3. ❌ No scan untuk malicious files
4. ❌ Filenames predictable
5. ⚠️ No access control untuk downloaded files

---

## 7. ANALISIS OBSERVER & DATA INTEGRITY

### Observer Chain untuk Transactions

```
TransactionObserver.creating()
  → Generate unique transaction number

TransactionObserver.created()
  → Create CashFlow income entry

TransactionItemObserver.created() (per item)
  → Check stock >= quantity
  → Decrement stock
  → Throw exception jika insufficient

TransactionObserver.updated()
  → Update CashFlow amount jika total berubah

TransactionObserver.deleted()
  → Create CashFlow refund entry
  → Restore product stocks (reverse TransactionItem)

TransactionObserver.restored()
  → Create restored income entry
  → Reduce stocks again

TransactionObserver.forceDeleted()
  → Delete related CashFlow entries
```

### Observer Chain untuk Inventory

```
InventoryObserver.creating()
  → Generate unique reference number

InventoryObserver.created()
  → Create CashFlow expense entry (if purchase_stock type)

InventoryItemObserver.created() (per item)
  → Sync stock based on type (in/out/adjustment)

InventoryItemObserver.updated()
  → Calculate delta and update stock

InventoryItemObserver.deleted()
  → Reverse operation
  → Log warning jika adjustment deleted
```

### Integritas Data Dijamin

✅ Stock synchronization otomatis
✅ CashFlow entries otomatis
✅ Transaction number unique
✅ Reference numbers unique
✅ Cascade delete/restore untuk kategori

---

## 8. ANALISIS LIVEWIRE SECURITY

### Pos Component Security

| Aspek | Implementasi | Risiko Level | Dokumentasi Resmi |
| --- | --- | --- | --- |
| **Session Cart** | Stored in session, validated on checkout | Medium | [Laravel Session](https://laravel.com/docs/12.x/session)<br>[Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Livewire Forms](https://livewire.laravel.com/docs/forms) |
| **Barcode Input** | Escaped by Livewire, lookup via Eloquent | Low | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Milon Barcode](https://github.com/milon/barcode)<br>[Livewire Security](https://livewire.laravel.com/docs/security) |
| **Quantity Manipulation** | Stock check per addition | Low | [Laravel Validation](https://laravel.com/docs/12.x/validation) |
| **Price Integrity** | Taken from DB on checkout, not from client | Low | Bukti utama dari kode repository; tidak ada dokumentasi resmi spesifik untuk baris ini |
| **Payment Selection** | Reactive with validation | Low | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Livewire Security](https://livewire.laravel.com/docs/security)<br>[Livewire Properties](https://livewire.laravel.com/docs/properties) |
| **Cash Calculation** | Numeric conversion + validation | Low | [Laravel Validation](https://laravel.com/docs/12.x/validation) |
| **Stock Re-validation** | At TransactionItem creation via Observer | Low | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Database Transactions](https://laravel.com/docs/12.x/database#database-transactions) |

### Keamanan Kuat

✅ Livewire otomatis handle CSRF (token di request)
✅ Data binding reactive dengan validation
✅ Observer validation pada create TransactionItem
✅ Stock check ketat pada add to cart
✅ Payment method validated

### Kelemahan

⚠️ Cart prices cached dari saat add-to-cart
⚠️ Session-based cart bisa dimanipulasi
⚠️ Tidak ada event logging untuk checkout

---

## 9. KESIMPULAN AKHIR & REKOMENDASI KEAMANAN

### Mekanisme Keamanan Utama

1. **Session-based Authentication** via Laravel
2. **Filament Shield + Spatie Permission** untuk authorization
3. **Comprehensive Middleware Stack** dengan CSRF, session, binding
4. **Observer-based Data Integrity** untuk stock/cashflow sync
5. **Form Validation** di Filament resources
6. **Database Soft Deletes** untuk recovery

### Bergantung Pada Keamanan Framework

Sistem **lebih bergantung pada keamanan bawaan framework** daripada custom implementation:
- Auth via Laravel default
- Session via Laravel default
- CSRF via middleware default
- ORM injection protection via Eloquent

Ini adalah **BAIK** karena framework-provided security sudah battle-tested.

### Fitur Paling Kompleks (Keamanan)

**POS / Kasir System:**
- Multiple validation layers (form, livewire, checkout, observer)
- Real-time stock checking
- Comprehensive cashflow sync
- Transaction integrity via observers
- Payment method validation
- Barcode scanner integration

### Area Keamanan Paling Kuat

1. ✅ **Authorization System** - Granular permissions via Filament Shield
2. ✅ **Transaction Integrity** - Observer-based automatic sync
3. ✅ **Stock Management** - Real-time validation + observer check
4. ✅ **Data Consistency** - Cascade operations pada delete/restore
5. ✅ **SQL Injection Protection** - Eloquent ORM untuk semua queries

### Area Keamanan Paling Berisiko

1. ⚠️ **Receipt Routes Unprotected** - Siapapun bisa akses receipt dengan ID
2. ⚠️ **Session-based Cart** - Bisa dimanipulasi jika session di-compromise
3. ⚠️ **File Upload** - No size limit, no MIME restriction beyond image check
4. ⚠️ **Printer Integration** - Error handling kurang robust
5. ⚠️ **Price Caching** - Cart prices dari saat add-to-cart, not real-time

### Permission System Granularity

✅ **SANGAT GRANULAR:**
- 10+ permission per resource
- Separate permissions: view_any, view, create, update, delete, delete_any, restore, restore_any, force_delete, force_delete_any
- Page-level permissions
- Super admin bypass

Ini memungkinkan **fine-grained access control** sampai action level.

### Observer Contribution ke Data Integrity

✅ **SANGAT BERKONTRIBUSI:**
- Auto-sync stock dengan inventory
- Auto-create CashFlow entries
- Cascade delete/restore untuk kategori
- Transaction number generation
- Reference number generation
- Stock validation via exception

Observers memastikan **consistency bahkan jika direct DB manipulation terjadi**.

### Upload/Storage Safety

⚠️ **MODERATE:**
- Image validation ada
- No size limit restriction
- Files publicly accessible
- No access control pada download
- Filenames somewhat predictable

Perlu tambahan security: file size limit, scan for malicious content, access logging.

### Tambahan POS Risks

POS system memiliki risiko khusus:
1. **Race Condition:** Simultaneous add-to-cart bisa cause overselling (mitigated by observer check)
2. **Price Manipulation:** Frontend price change tidak berpengaruh (harga dari DB), namun perlu audit
3. **Negative Stock:** Bisa terjadi jika observer crash/exception (mitigated by validation)
4. **Printer Failure:** No fallback strategy
5. **Session Loss:** Cart hilang jika session expire

---

## 10. RISIKO DAN REKOMENDASI

### CRITICAL RISKS

1. **🔴 Unprotected Receipt Routes**
   - Status: UNPROTECTED
   - Risk: Information Disclosure
   - File: [routes/web.php](routes/web.php#L7-8)
   - **Rekomendasi:** Add middleware auth or policy check
   ```php
   Route::get('/receipt/{id}', [ReceiptController::class, 'show'])
       ->middleware('auth')
       ->name('receipt.show');
   ```

2. **🔴 Missing Authorization in Receipt Controller**
   - Status: ID-based access without ownership check
   - Risk: Access other users' receipts
   - File: [app/Http/Controllers/ReceiptController.php](app/Http/Controllers/ReceiptController.php)
   - **Rekomendasi:** Verify user owns transaction
   ```php
   public function show($id) {
       $transaction = Transaction::findOrFail($id);
       $this->authorize('view', $transaction); // Add this
   }
   ```

### HIGH RISKS

3. **🟠 Session-based Cart Manipulation**
   - Status: Session vulnerable if cookie compromised
   - Risk: Cart data tampering
   - File: [app/Livewire/Pos.php](app/Livewire/Pos.php#L45)
   - **Rekomendasi:** Add integrity check atau move to database

4. **🟠 File Upload Without Size Limit**
   - Status: No size validation
   - Risk: Large file upload / DoS
   - File: [app/Filament/Resources/ProductResource.php](app/Filament/Resources/ProductResource.php#L76)
   - **Rekomendasi:** Add maxSize validation
   ```php
   ->image()->maxSize(5120) // 5MB max
   ```

5. **🟠 CashFlow Hard Delete**
   - Status: Permanent deletion without recovery
   - Risk: Audit trail loss
   - File: [app/Models/CashFlow.php](app/Models/CashFlow.php)
   - **Rekomendasi:** Use SoftDeletes trait

### MEDIUM RISKS

6. **🟡 User Hard Delete**
   - Status: Permanent deletion
   - Risk: Data orphaning, audit loss
   - File: [app/Models/User.php](app/Models/User.php)
   - **Rekomendasi:** Use SoftDeletes or soft deactivation

7. **🟡 No Audit Logging**
   - Status: Not ditemukan
   - Risk: No change history
   - **Rekomendasi:** Implement audit logs untuk sensitive actions

8. **🟡 Printer Configuration**
   - Status: Stored in DB without validation
   - Risk: Invalid printer name / DoS
   - File: [app/Services/DirectPrintService.php](app/Services/DirectPrintService.php#L21)
   - **Rekomendasi:** Validate printer name existence

9. **🟡 Session Timeout**
   - Status: Default 2 hours
   - Risk: Session hijacking window
   - **Rekomendasi:** Consider reducing timeout untuk POS sistem

10. **🟡 No Rate Limiting**
    - Status: Not implemented
    - Risk: Brute force attacks
    - **Rekomendasi:** Add ThrottleRequests middleware

---

## 11. RINGKASAN IMPLEMENTASI KEAMANAN

| Kategori | Implementasi | Tingkat | Evidence | Dokumentasi Resmi |
| --- | --- | --- | --- | --- |
| **Authentication** | Session Guard + Hash | Tinggi | config/auth.php, User.php | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Laravel Session](https://laravel.com/docs/12.x/session)<br>[Laravel Configuration](https://laravel.com/docs/12.x/configuration) |
| **Authorization** | Filament Shield + Spatie Permission | Tinggi | config/filament-shield.php, Policies | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Spatie Permission](https://spatie.be/docs/laravel-permission/v7/introduction)<br>[Filament Shield](https://filamentphp.com/plugins/bezhansalleh-shield) |
| **Middleware** | Comprehensive stack (9 middleware) | Tinggi | AdminPanelProvider | [Laravel Middleware](https://laravel.com/docs/12.x/middleware)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration) |
| **Route Protection** | Auth middleware pada panel routes | Tinggi | AdminPanelProvider, pages | [Laravel Auth](https://laravel.com/docs/12.x/authentication)<br>[Filament Users](https://filamentphp.com/docs/3.x/panels/users)<br>[Laravel Middleware](https://laravel.com/docs/12.x/middleware) |
| **Database Protection** | Eloquent ORM + SoftDeletes | Tinggi | Models, observers | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Data Integrity** | Observer-based sync | Tinggi | AppServiceProvider, observers | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **Form Validation** | Filament validation rules | Tinggi | Resources | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |
| **File Upload** | Image validation | Medium | ProductResource, PaymentMethodResource | [Laravel Validation](https://laravel.com/docs/12.x/validation)<br>[Filament Form Validation](https://filamentphp.com/docs/3.x/forms/validation)<br>[Filament FileUpload](https://filamentphp.com/docs/3.x/forms/fields/file-upload) |
| **CSRF Protection** | VerifyCsrfToken middleware | Tinggi | AdminPanelProvider | [Laravel Middleware](https://laravel.com/docs/12.x/middleware)<br>[Laravel CSRF](https://laravel.com/docs/12.x/csrf)<br>[Filament Panel](https://filamentphp.com/docs/3.x/panels/configuration) |
| **XSS Protection** | Blade template escaping | Tinggi | Framework default | [Laravel Blade](https://laravel.com/docs/12.x/blade) |
| **SQL Injection** | Eloquent ORM | Tinggi | All models | [Laravel Eloquent](https://laravel.com/docs/12.x/eloquent)<br>[Laravel Query Builder](https://laravel.com/docs/12.x/queries) |
| **Mass Assignment** | Protected $fillable | Tinggi | All models | [Laravel Authorization](https://laravel.com/docs/12.x/authorization)<br>[Laravel Eloquent](https://laravel.com/docs/12.x/eloquent) |

---
