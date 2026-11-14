<!DOCTYPE html>
<html lang="tk">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #0b1536; color: #ffffff; margin: 0; padding: 24px; }
        .box { max-width: 580px; margin: 0 auto; background: #13224f; border-radius: 18px; padding: 28px; border: 1px solid #2a4185; }
        .logo { font-size: 24px; font-weight: 800; color: #38bdf8; margin-bottom: 12px; }
        h2 { font-size: 20px; margin-top: 0; color: #ffffff; }
        .answer-box { background: #064e3b; border-radius: 12px; padding: 18px; margin: 18px 0; border: 1px solid #059669; color: #ecfdf5; line-height: 1.6; }
        .msg-box { background: #1b2e69; border-radius: 12px; padding: 14px; margin: 14px 0; border: 1px solid #3353aa; font-size: 14px; color: #cbd5e1; }
        .footer { font-size: 12px; color: #64748b; margin-top: 24px; text-align: center; }
    </style>
</head>
<body>
    <div class="box">
        <div class="logo">💧 Ak Suw Zawody</div>
        <h2>Salam, {{ $question->name }}!</h2>
        <p style="color: #94a3b8;">Ugradan soragyňyza jogap berildi:</p>

        <div class="msg-box">
            <strong>Siziň soragyňyz:</strong><br>
            {{ $question->message }}
        </div>

        <h4 style="color: #4ade80; margin: 16px 0 8px 0;">Jogap:</h4>
        <div class="answer-box">
            {{ $question->answer }}
        </div>

        <div class="footer">
            © {{ date('Y') }} Ak Suw Zawody · Ýerine ýetiren: Yusup Gajaýew
        </div>
    </div>
</body>
</html>
