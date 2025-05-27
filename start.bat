@echo off
echo ==========================================
echo  BLOSSOM BOUTIQUE - LARAVEL SETUP SCRIPT
echo ==========================================
echo.

echo [1/8] Copying environment file...
if not exist .env (
    copy .env.example .env
    echo .env file created from .env.example
) else (
    echo .env file already exists
)
echo.

echo [2/8] Installing Composer dependencies...
call composer install
if %errorlevel% neq 0 (
    echo ERROR: Composer install failed!
    pause
    exit /b 1
)
echo.

echo [3/8] Installing NPM dependencies...
call npm install
if %errorlevel% neq 0 (
    echo ERROR: NPM install failed!
    pause
    exit /b 1
)
echo.

echo [4/8] Generating application key...
call php artisan key:generate
echo.

echo [5/8] Creating storage link...
call php artisan storage:link
echo.

echo [6/8] Running database migrations...
call php artisan migrate:fresh --seed
if %errorlevel% neq 0 (
    echo ERROR: Database migration failed!
    echo Please check your database configuration in .env file
    pause
    exit /b 1
)
echo.

echo [7/8] Clearing application cache...
call php artisan cache:clear
call php artisan config:clear
call php artisan route:clear
call php artisan view:clear
echo.

echo [8/8] Building frontend assets...
call npm run dev
echo.

echo ==========================================
echo  SETUP COMPLETED SUCCESSFULLY!
echo ==========================================
echo.
echo Your application is ready!
echo.
echo To start the server, run:
echo php artisan serve
echo.
echo Then visit: http://localhost:8000
echo.
echo Test accounts:
echo - Admin: admin@pwa.rs / admin
echo - User:  user@pwa.rs / user
echo.
pause