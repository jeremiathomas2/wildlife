$ErrorActionPreference = 'Stop'

$ProjectRoot = 'C:\laragon\www\TDTS'
$Worker = Join-Path $ProjectRoot 'scripts\queue-worker.ps1'
$RunKey = 'HKCU:\Software\Microsoft\Windows\CurrentVersion\Run'
$RunName = 'TDTS Queue Worker'
$Value = 'powershell.exe -NoProfile -WindowStyle Hidden -ExecutionPolicy Bypass -File "' + $Worker + '"'

if (-not (Test-Path -LiteralPath $Worker)) {
    throw "Worker script not found: $Worker"
}

# Clean up any prior Start-Menu Startup .vbs version of this launcher.
# (A leftover from an earlier partial install may have a broken ACL; ignore it.)
$oldVbs = Join-Path (Join-Path $env:APPDATA 'Microsoft\Windows\Start Menu\Programs\Startup') 'TDTS Queue Worker.vbs'
try {
    if (Test-Path -LiteralPath $oldVbs -ErrorAction Stop) {
        Remove-Item -LiteralPath $oldVbs -Force -ErrorAction SilentlyContinue
    }
} catch {
    Write-Host 'Note: could not inspect old Startup-folder launcher (harmless).'
}

New-ItemProperty -Path $RunKey -Name $RunName -PropertyType String -Value $Value -Force | Out-Null

Write-Host "Auto-start installed: HKCU 'Run' ($RunName)" -ForegroundColor Green
Write-Host "It runs the queue worker silently at every Windows logon (no admin needed)."
Write-Host ""
Write-Host "Current entry:"
(Get-ItemProperty -Path $RunKey -Name $RunName) | Format-List
Write-Host "Start it right now (no reboot needed):"
Write-Host "  powershell -NoProfile -WindowStyle Hidden -ExecutionPolicy Bypass -File $Worker"
Write-Host ""
Write-Host "Verify running:"
Write-Host "  Get-CimInstance Win32_Process | Where-Object { `$_.CommandLine -match 'queue:work' } | Select-Object ProcessId, CommandLine"
Write-Host ""
Write-Host "Check log:"
Write-Host "  Get-Content '$ProjectRoot\storage\logs\queue-worker.log' -Tail 20"
Write-Host ""
Write-Host "Uninstall:"
Write-Host "  Remove-ItemProperty -Path '$RunKey' -Name '$RunName'"