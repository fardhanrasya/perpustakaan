<#
.SYNOPSIS
    Script Setup & Run Otomatis untuk Proyek Web 'Perpustakaan'
    Penulis: Antigravity Assistant
    
.DESCRIPTION
    Script ini menangani full lifecycle startup proyek di environment development Windows:
    1. Cek Environment (PHP, Composer, NPM, MySQL)
    2. Clone Repository (jika belum ada)
    3. Setup .env dan Key
    4. Install Dependensi (Composer & NPM)
    5. Setup Database (Create DB jika belum ada + Migrate)
    6. Build Frontend
    7. Jalankan Server (php artisan serve)

    Dilengkapi dengan Error Handling dan Fallbacks.
#>

$ErrorActionPreference = "Stop" # Hentikan script jika ada error fatal

# --- KONFIGURASI ---
$RepoUrl = "https://github.com/fardhanrasya/perpustakaan.git" # Opsional: Update ini jika ingin fitur auto-clone berfungsi di folder baru
$DbName  = "perpustakaan"
$DbHost  = "127.0.0.1"
$DbUser  = "root"
$DbPass  = "" # Default XAMPP/Laragon biasanya kosong

# --- FUNGSI BANTUAN ---

function Write-Log {
    param(
        [string]$Message,
        [string]$Color = "White",
        [switch]$Bold
    )
    $params = @{ ForegroundColor = $Color }
    if ($Bold) { $Message = "[$((Get-Date).ToString('HH:mm:ss'))] $Message".ToUpper() } 
    else { $Message = "  Waiting... $Message" }
    
    if ($Bold) { Write-Host "`n$Message" @params } else { Write-Host $Message @params }
}

function Check-Command {
    param([string]$Name)
    if (Get-Command $Name -ErrorAction SilentlyContinue) {
        return $true
    }
    Write-Host " [X] Command '$Name' tidak ditemukan di System PATH." -ForegroundColor Red
    return $false
}

function Test-Port {
    param([int]$Port)
    $tcp = New-Object Net.Sockets.TcpClient
    try {
        $tcp.Connect("127.0.0.1", $Port)
        $tcp.Close()
        return $true
    } catch {
        return $false
    }
}

# --- MAIN SCRIPT ---

Clear-Host
Write-Host "=============================================" -ForegroundColor Cyan
Write-Host "   AUTOMATED SETUP PROJECT: PERPUSTAKAAN     " -ForegroundColor Cyan
Write-Host "=============================================" -ForegroundColor Cyan

# 1. PERSIAPAN SISTEM
Write-Log "1. Memeriksa Ketersediaan Tools Utama..." -Color Yellow -Bold
$missingTools = @()
foreach ($tool in @("git", "php", "composer", "npm")) {
    if (-not (Check-Command $tool)) { $missingTools += $tool }
}

if ($missingTools.Count -gt 0) {
    Write-Host "ERROR: Tools berikut wajib diinstall manual: $($missingTools -join ', ')" -ForegroundColor Red
    Write-Host "Silakan install lalu jalankan script ini kembali." -ForegroundColor Gray
    exit
}
Write-Host " [V] Semua tools utama tersedia." -ForegroundColor Green

# 2. CEK FOLDER & GIT
Write-Log "2. Memeriksa Folder Proyek..." -Color Yellow -Bold
if (Test-Path "composer.json") {
    Write-Host " [V] Anda berada di dalam folder proyek." -ForegroundColor Green
} else {
    Write-Host " [i] Tidak mendeteksi 'composer.json' di sini." -ForegroundColor Yellow
    $ProjectDir = "perpustakaan"
    
    if (Test-Path $ProjectDir) {
        Write-Host " [!] Folder '$ProjectDir' ditemukan. Masuk ke folder..." -ForegroundColor Cyan
        Set-Location $ProjectDir
    } else {
        Write-Host " [i] Folder '$ProjectDir' tidak ditemukan." -ForegroundColor Cyan
        if ($RepoUrl -match "username") {
            Write-Host " [X] Harap update variable `$RepoUrl di dalam script ini dulu!" -ForegroundColor Red
            exit
        }
        Write-Host " [>] Memulai Clone dari $RepoUrl..." -ForegroundColor Cyan
        try {
            git clone $RepoUrl $ProjectDir
            Set-Location $ProjectDir
        } catch {
            Write-Host " [X] Gagal Clone: $($_.Exception.Message)" -ForegroundColor Red
            exit
        }
    }
    
    # Verifikasi ulang setelah masuk folder
    if (-not (Test-Path "composer.json")) {
        Write-Host " [X] Masih tidak menemukan composer.json di dalam $(Get-Location)." -ForegroundColor Red
        exit
    }
    Write-Host " [V] Berhasil masuk ke folder proyek." -ForegroundColor Green
}

# 3. SETUP ENV FILE
Write-Log "3. Konfigurasi Environment (.env)..." -Color Yellow -Bold
if (-not (Test-Path ".env")) {
    if (Test-Path ".env.example") {
        Copy-Item ".env.example" ".env"
        Write-Host " [V] File .env berhasil disalin dari .env.example." -ForegroundColor Green
    } else {
        Write-Host " [X] Fatal: Tidak ada .env maupun .env.example." -ForegroundColor Red
        exit
    }
} else {
    Write-Host " [V] File .env sudah ada." -ForegroundColor Green
}

# 3b. UPDATE .ENV FOR MYSQL
# Laravel 11 default is SQLite, we force it to MySQL based on Config
Write-Host " Memastikan konfigurasi database di .env adalah MySQL..." -ForegroundColor Gray
$envContent = Get-Content ".env"
if ($envContent -match "DB_CONNECTION=sqlite") {
    $envContent = $envContent -replace "DB_CONNECTION=sqlite", "DB_CONNECTION=mysql"
    $envContent = $envContent -replace "# DB_HOST=127.0.0.1", "DB_HOST=$DbHost"
    $envContent = $envContent -replace "# DB_PORT=3306", "DB_PORT=3306"
    $envContent = $envContent -replace "# DB_DATABASE=laravel", "DB_DATABASE=$DbName"
    $envContent = $envContent -replace "# DB_USERNAME=root", "DB_USERNAME=$DbUser"
    $envContent = $envContent -replace "# DB_PASSWORD=", "DB_PASSWORD=$DbPass"
    $envContent | Set-Content ".env"
    Write-Host " [V] .env berhasil diupdate ke MySQL ($DbName)." -ForegroundColor Green
}

# 4. COMPOSER INSTALL
Write-Log "4. Menginstall Dependensi Backend (Composer)..." -Color Yellow -Bold
if (-not (Test-Path "vendor/autoload.php")) {
    Write-Host " Folder 'vendor' atau autoload.php belum lengkap. Memulai instalasi..." -ForegroundColor Gray
    Write-Host " [i] Note: Tahap 'Generating optimized autoload files' mungkin agak lama di Windows." -ForegroundColor Cyan
    try {
        composer install --no-interaction
        Write-Host " [V] Composer install berhasil." -ForegroundColor Green
    } catch {
        Write-Host " [X] Gagal menjalankan composer install." -ForegroundColor Red
        Write-Host $_.Exception.Message -ForegroundColor Red
        exit
    }
} else {
    Write-Host " [V] Dependensi (vendor/autoload.php) sudah siap. Melewati instalasi berat." -ForegroundColor Gray
}

# 5. GENERATE KEY
Write-Log "5. Memeriksa Application Key..." -Color Yellow -Bold
$envContent = Get-Content ".env"
if ($envContent -match "APP_KEY=$") {
    Write-Host " APP_KEY kosong. Mem-generate key baru..." -ForegroundColor Gray
    php artisan key:generate
    Write-Host " [V] Key berhasil digenerate." -ForegroundColor Green
} else {
    Write-Host " [V] APP_KEY sudah terisi." -ForegroundColor Green
}

# 6. DATABASE SETUP
Write-Log "6. Menyiapkan Database dan Migrasi..." -Color Yellow -Bold

# 6a. Cek MySQL Service Port 3306
if (-not (Test-Port 3306)) {
    Write-Host " [!] Port 3306 tertutup. MySQL sepertinya mati." -ForegroundColor Red
    Write-Host "     Script akan mencoba menyalakan service umum (mysql/mysql80)..." -ForegroundColor Gray
    try {
        Start-Service "mysql" -ErrorAction SilentlyContinue
        Start-Service "wampmysqld64" -ErrorAction SilentlyContinue # WAMP
    } catch {}
    
    Start-Sleep -Seconds 2
    if (-not (Test-Port 3306)) {
        Write-Host " [X] Gagal menyalakan MySQL. Pastikan XAMPP/Laragon Anda RUNNING!" -ForegroundColor Red
        Read-Host "     Tekan ENTER jika Anda sudah menyalakan MySQL secara manual..."
    }
}

# 6b. Create DB logic (PHP script injection)
Write-Host " Memeriksa eksistensi database '$DbName'..." -ForegroundColor Gray
$phpCreateDb = "
try {
    `$pdo = new PDO('mysql:host=$DbHost', '$DbUser', '$DbPass');
    `$pdo->exec('CREATE DATABASE IF NOT EXISTS $DbName');
    echo 'SUCCESS';
} catch (PDOException `$e) {
    echo 'ERROR: ' . `$e->getMessage();
}
"
$res = php -r $phpCreateDb
if ($res -match "SUCCESS") {
    Write-Host " [V] Database '$DbName' siap." -ForegroundColor Green
} else {
    Write-Host " [!] Gagal membuat/cek database otomatis: $res" -ForegroundColor Red
    Write-Host "     Pastikan kredensial DB di script/env sesuai."
}

# 6c. Migrasi
try {
    Write-Host " Menjalankan migrasi..." -ForegroundColor Gray
    # Gunakan --force untuk production/automation
    php artisan migrate --force 
    Write-Host " [V] Migrasi tabel selesai." -ForegroundColor Green
} catch {
    Write-Host " [!] Terjadi kesalahan saat migrasi. Cek log di atas." -ForegroundColor Red
    # Jangan exit, mungkin user ingin menjalankan server saja
}


# 8. SERVE
Write-Log "8. MENJALANKAN APLIKASI" -Color Cyan -Bold
Write-Host "---------------------------------------------" -ForegroundColor Cyan
Write-Host "Aplikasi siap dijalankan!"
Write-Host "Server akan berjalan di: http://127.0.0.1:8000" -ForegroundColor Green
Write-Host "Tekan CTRL+C untuk menghentikan server." -ForegroundColor Gray
Write-Host "---------------------------------------------" -ForegroundColor Cyan

try {
    # Buka browser otomatis (opsional)
    # Start-Process "http://127.0.0.1:8000"
    php artisan serve
} catch {
    Write-Host " [X] Gagal start server: $($_.Exception.Message)" -ForegroundColor Red
    Read-Host "Tekan Enter untuk keluar..."
}
