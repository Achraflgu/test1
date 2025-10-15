@echo off
echo 🚀 Children's Universe - Vercel Deployment Script
echo ==================================================

REM Check if Vercel CLI is installed
where vercel >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo ❌ Vercel CLI is not installed. Please install it first:
    echo    npm install -g vercel
    pause
    exit /b 1
)

REM Check if user is logged in to Vercel
vercel whoami >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo 🔐 Please log in to Vercel:
    vercel login
)

echo 📦 Installing dependencies...
npm install

echo 🔧 Building project...
REM No build step required for static files

echo 🚀 Deploying to Vercel...
vercel --prod

echo ✅ Deployment complete!
echo.
echo 📋 Next steps:
echo 1. Set up your PostgreSQL database
echo 2. Configure environment variables in Vercel dashboard:
echo    - DB_HOST: Your PostgreSQL host
echo    - DB_NAME: children_universe
echo    - DB_USER: Your database username
echo    - DB_PASS: Your database password
echo    - DB_PORT: 5432
echo 3. Run the database schema: database/postgres_schema.sql
echo 4. Test your deployment!
echo.
echo 🌐 Your app should be live at the URL provided above.
pause
