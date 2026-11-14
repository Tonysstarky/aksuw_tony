<!DOCTYPE html>
<html lang="tk">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #0b1536; color: #ffffff; margin: 0; padding: 24px; }
        .box { max-width: 580px; margin: 0 auto; background: #13224f; border-radius: 18px; padding: 28px; border: 1px solid #2a4185; }
        .logo { font-size: 24px; font-weight: 800; color: #38bdf8; margin-bottom: 12px; }
        h2 { font-size: 20px; margin-top: 0; color: #ffffff; }
        .item-card { background: #1b2e69; border-radius: 12px; padding: 18px; margin: 18px 0; border: 1px solid #3353aa; }
        .price { font-size: 22px; font-weight: 800; color: #4ade80; }
        .row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; }
        .muted { color: #94a3b8; }
        .badge { display: inline-block; padding: 4px 12px; background: #0284c7; color: #fff; border-radius: 999px; font-size: 12px; font-weight: 700; }
        .footer { font-size: 12px; color: #64748b; margin-top: 24px; text-align: center; }
    </style>
</head>
<body>
    <div class="box">
        <div class="logo">💧 Ak Suw Zawody</div>
        <h2>Täze Suw Sargydy #{{ $order->id }}</h2>
        <p class="muted">Sargyt üstünlikli kabul edildi we işlenilmäge berildi.</p>

        <div class="item-card">
            <span class="badge">{{ $order->water->category->name ?? 'Suw' }}</span>
            <h3 style="margin: 10px 0 6px 0; font-size: 18px; color: #fff;">{{ $order->water->name }}</h3>
            <div class="row">
                <span class="muted">Göwrümi:</span>
                <b>{{ $order->water->volume }}</b>
            </div>
            <div class="row">
                <span class="muted">Mukdary:</span>
                <b>{{ $order->quantity }} sany</b>
            </div>
            <div class="row">
                <span class="muted">Biriniň bahasy:</span>
                <b>{{ number_format($order->water->price, 2) }} TMT</b>
            </div>
            <hr style="border: none; border-top: 1px solid #3353aa; margin: 12px 0;">
            <div class="row" style="font-size: 16px;">
                <span>Jemi Töläp Bolar:</span>
                <span class="price">{{ number_format($order->total_price, 2) }} TMT</span>
            </div>
        </div>

        <h4 style="color: #38bdf8; margin-bottom: 10px;">Gowşurylmaly Maglumatlar:</h4>
        <div style="background: rgba(255,255,255,0.05); padding: 14px; border-radius: 10px; font-size: 14px; line-height: 1.6;">
            <div><strong>Sargyt eden:</strong> {{ $order->user->name ?? 'Ulanyjy' }} ({{ $order->user->email ?? '—' }})</div>
            <div><strong>Telefon belgi:</strong> {{ $order->phone }}</div>
            <div><strong>Gowşurylmaly salgy:</strong> {{ $order->delivery_address }}</div>
            @if($order->notes)
                <div><strong>Bellik:</strong> {{ $order->notes }}</div>
            @endif
        </div>

        <div class="footer">
            © {{ date('Y') }} Ak Suw Zawody · Ýerine ýetiren: Yusup Gajaýew
        </div>
    </div>
</body>
</html>
