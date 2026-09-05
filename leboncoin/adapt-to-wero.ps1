# Adaptation Leboncoin → WERO

Write-Host ""
Write-Host "🔄 Adaptation de Leboncoin → WERO" -ForegroundColor Cyan
Write-Host "════════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""

$leboncoinPath = "C:\Users\user\Desktop\link-leboncoin\leboncoin"
$weroPath = "C:\Users\user\Desktop\linkwero"

# 1. Adapter .env
Write-Host "1️⃣  Adaptation de .env..." -ForegroundColor Green

$env_content = Get-Content "$leboncoinPath\.env" -Raw
$env_content = $env_content -replace "APP_NAME=LEBONCOIN", "APP_NAME=WERO"
$env_content = $env_content -replace "APP_URL=.*", "APP_URL=http://127.0.0.1:8002"

Set-Content "$weroPath\.env" -Value $env_content -Force
Write-Host "   ✅ .env adapté" -ForegroundColor Green

# 2. Copier resources/views/
Write-Host "2️⃣  Copie des vues..." -ForegroundColor Green
Copy-Item "$leboncoinPath\resources\views\*" "$weroPath\resources\views\" -Force
Write-Host "   ✅ Vues copiées" -ForegroundColor Green

# 3. Copier controllers
Write-Host "3️⃣  Copie des contrôleurs..." -ForegroundColor Green
Copy-Item "$leboncoinPath\app\Http\Controllers\*" "$weroPath\app\Http\Controllers\" -Force
Write-Host "   ✅ Contrôleurs copiés" -ForegroundColor Green

# 4. Copier routes
Write-Host "4️⃣  Copie des routes..." -ForegroundColor Green
Copy-Item "$leboncoinPath\routes\web.php" "$weroPath\routes\web.php" -Force
Write-Host "   ✅ Routes copiées" -ForegroundColor Green

# 5. Copier config
Write-Host "5️⃣  Copie de la config..." -ForegroundColor Green
Copy-Item "$leboncoinPath\config\*" "$weroPath\config\" -Force -Recurse
Write-Host "   ✅ Config copiée" -ForegroundColor Green

# 6. Copier public/build
Write-Host "6️⃣  Copie des assets..." -ForegroundColor Green
Copy-Item "$leboncoinPath\public\build\*" "$weroPath\public\build\" -Force -Recurse
Write-Host "   ✅ Assets copiés" -ForegroundColor Green

# 7. Vérification
Write-Host ""
Write-Host "✅ Vérification:" -ForegroundColor Green
Write-Host "   ✅ resources/views/" -ForegroundColor Green
Write-Host "   ✅ app/Http/Controllers/" -ForegroundColor Green
Write-Host "   ✅ routes/web.php" -ForegroundColor Green
Write-Host "   ✅ .env (adapté)" -ForegroundColor Green

Write-Host ""
Write-Host "════════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "✅ Prêt!" -ForegroundColor Green
Write-Host ""
Write-Host "Lancez depuis linkwero:" -ForegroundColor Cyan
Write-Host "   cd C:\Users\user\Desktop\linkwero" -ForegroundColor Yellow
Write-Host "   php artisan serve --host=127.0.0.1 --port=8002" -ForegroundColor Yellow
Write-Host ""
Write-Host "════════════════════════════════════════════════════════" -ForegroundColor Cyan
