$ErrorActionPreference = 'Continue'

$ProjectRoot = 'C:\laragon\www\TDTS'
$LogFile = Join-Path $ProjectRoot 'storage\logs\queue-worker.log'

function Write-Log([string]$msg) {
    $line = ('[{0}] {1}' -f (Get-Date -Format 'yyyy-MM-dd HH:mm:ss'), $msg)
    Add-Content -LiteralPath $LogFile -Value $line
}

# Only ever run one worker for this app.
$existing = Get-CimInstance Win32_Process -Filter "Name = 'php.exe'" |
    Where-Object { $_.CommandLine -match 'artisan' -and $_.CommandLine -match 'queue:work' }
if ($existing) {
    Write-Log 'Another queue:work instance is already running; exiting wrapper.'
    exit 0
}

Write-Log 'Queue worker wrapper started (idle poll every 5 seconds).'

while ($true) {
    Write-Log 'Starting: php artisan queue:work --sleep=5 --tries=3 --timeout=90'
    Push-Location $ProjectRoot
    & php artisan queue:work --sleep=5 --tries=3 --timeout=90 2>&1 | ForEach-Object { Write-Log ($_ -as [string]) }
    $code = $LASTEXITCODE
    Pop-Location
    Write-Log "Worker exited with code $code. Restarting in 2 seconds."
    Start-Sleep -Seconds 2
}