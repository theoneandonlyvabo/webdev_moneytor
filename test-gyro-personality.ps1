$apiKey = (Get-Content .env | Select-String 'GEMINI_API_KEY').ToString().Split('=')[1].Trim()

Write-Host "`n🤖 Testing Gyro's New Personality..." -ForegroundColor Yellow
Write-Host "=" * 60 -ForegroundColor Gray

$url = "https://generativelanguage.googleapis.com/v1/models/gemini-2.0-flash:generateContent?key=$apiKey"

# Simplified system prompt for testing
$systemPrompt = @"
Lo adalah Gyro, AI Financial Advisor untuk Moneytor.
Pakai bahasa Jakarta (Gw/Lo), tone santai tapi informatif.
Fokus ke actionable advice tentang keuangan pribadi.
Struktur response: OVERVIEW → ACTIONABLE ADVICE → NEXT STEPS

---

User: Gw sering boncos tiap akhir bulan, gimana ya?
"@

$body = @{
    contents = @(
        @{
            parts = @(
                @{
                    text = $systemPrompt
                }
            )
        }
    )
} | ConvertTo-Json -Depth 10

try {
    $response = Invoke-RestMethod -Uri $url -Method Post -Body $body -ContentType "application/json"
    $gyroResponse = $response.candidates[0].content.parts[0].text
    
    Write-Host "`n✅ Gyro's Response:" -ForegroundColor Green
    Write-Host "=" * 60 -ForegroundColor Gray
    Write-Host $gyroResponse -ForegroundColor Cyan
    Write-Host "=" * 60 -ForegroundColor Gray
    Write-Host "`n✅ SUCCESS! Gyro personality is working!" -ForegroundColor Green
    Write-Host "Now test in dashboard: http://localhost:8000/dashboard" -ForegroundColor Yellow
}
catch {
    Write-Host "`n❌ ERROR!" -ForegroundColor Red
    Write-Host "Error: $($_.Exception.Message)" -ForegroundColor Red
}
