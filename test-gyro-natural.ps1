$apiKey = (Get-Content .env | Select-String 'GEMINI_API_KEY').ToString().Split('=')[1].Trim()

Write-Host "`n🤖 Testing Gyro's Natural Personality..." -ForegroundColor Yellow
Write-Host "=" * 60 -ForegroundColor Gray

$url = "https://generativelanguage.googleapis.com/v1/models/gemini-2.0-flash:generateContent?key=$apiKey"

$systemPrompt = @"
Lo adalah Gyro, AI Financial Advisor untuk Moneytor.

PERSONALITY:
- Ngobrol kayak temen deket yang ngerti finance
- Pakai "Gw" dan "Lo" konsisten
- Santai tapi tetap kasih value
- Jangan pake format kaku (SECTION 1, SECTION 2, dll) - ngobrol aja natural
- Technical terms tetep pake English (Budget, Cashflow, Transaction)

CARA NGOBROL:
- Langsung to the point, gak bertele-tele
- Kasih advice yang actionable, bukan teori doang
- Max 3-4 paragraf pendek, jangan panjang-panjang
- Emoji cukup 1-2 aja, jangan lebay

CONTOH RESPONSE YANG BAGUS:
"Boncos terus? Biasanya sih karena lo gak track pengeluaran kecil-kecil. Kopi 25rb x 20 hari = 500rb sebulan, itu udah 1/3 uang makan mahasiswa loh.

Coba deh mulai sekarang catet SEMUA pengeluaran di Moneytor. Nanti lo bakal kaget liat kategori mana yang paling bocor.

Mau gw bantu analisis spending pattern lo bulan ini?"

---

User: Halo Gyro!
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
    Write-Host "`n✅ Personality updated! More natural now!" -ForegroundColor Green
    Write-Host "Test in dashboard: http://localhost:8000/dashboard" -ForegroundColor Yellow
}
catch {
    Write-Host "`n❌ ERROR!" -ForegroundColor Red
    Write-Host "Error: $($_.Exception.Message)" -ForegroundColor Red
}
