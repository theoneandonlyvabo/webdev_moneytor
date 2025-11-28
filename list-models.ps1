$apiKey = (Get-Content .env | Select-String 'GEMINI_API_KEY').ToString().Split('=')[1].Trim()

Write-Host "Fetching available Gemini models..." -ForegroundColor Yellow

$url = "https://generativelanguage.googleapis.com/v1/models?key=$apiKey"

try {
    $response = Invoke-RestMethod -Uri $url -Method Get
    Write-Host "`n✅ Available Models:" -ForegroundColor Green
    foreach ($model in $response.models) {
        if ($model.name -like "*gemini*") {
            Write-Host "  - $($model.name)" -ForegroundColor Cyan
        }
    }
} catch {
    Write-Host "`n❌ ERROR!" -ForegroundColor Red
    Write-Host "Error: $($_.Exception.Message)" -ForegroundColor Red
}
