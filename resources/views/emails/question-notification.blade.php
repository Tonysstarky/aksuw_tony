<!DOCTYPE html>
<html lang="tk">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #0b1536; color: #ffffff; margin: 0; padding: 24px; }
        .box { max-width: 580px; margin: 0 auto; background: #13224f; border-radius: 18px; padding: 28px; border: 1px solid #2a4185; }
        .logo { font-size: 24px; font-weight: 800; color: #38bdf8; margin-bottom: 12px; }
        h2 { font-size: 20px; margin-top: 0; color: #ffffff; }
        .msg-box { background: #1b2e69; border-radius: 12px; padding: 18px; margin: 18px 0; border: 1px solid #3353aa; line-height: 1.6; }
        .footer { font-size: 12px; color: #64748b; margin-top: 24px; text-align: center; }
    </style>
</head>
<body>
    <div class="box">
        <div class="logo">💧 Ak Suw Zawody</div>
        <h2>Täze Gizlin Sorag Gelip Gowuşdy</h2>
        <p style="color: #94a3b8;">Bu sorag hiç kime görünmeýär we diňe admin bilen ulanyjynyň arasynda gizlin galar.</p>

        <div style="background: rgba(255,255,255,0.05); padding: 14px; border-radius: 10px; font-size: 14px; line-height: 1.6; margin-bottom: 16px;">
            <div><strong>Ugradan:</strong> {{ $question->name }} ({{ $question->email }})</div>
            @if($question->phone)
                <div><strong>Telefon:</strong> {{ $question->phone }}</div>
            @endif
            <div><strong>Mowzuk:</strong> {{ $question->subject }}</div>
        </div>

        <h4 style="color: #38bdf8; margin: 0 0 8px 0;">Soragyň Mazmuny:</h4>
        <div class="msg-box">
            {{ $question->message }}
        </div>

        <div class="footer">
            © {{ date('Y') }} Ak Suw Zawody · Ýerine ýetiren: Yusup Gajaýew
        </div>
    </div>
</body>
</html>
