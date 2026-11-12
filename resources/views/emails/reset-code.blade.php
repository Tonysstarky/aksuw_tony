<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
</head>
<body style="margin:0;padding:30px;background:#0a1a6b;font-family:Arial,Helvetica,sans-serif;color:#ffffff;">
    <div style="max-width:520px;margin:0 auto;background:#1a3bd1;border:1px solid #7fa4ff;border-radius:20px;padding:32px;text-align:center;">
        <h1 style="margin:0 0 6px;font-size:26px;color:#ffffff;">💧 {{ __('messages.brand') }}</h1>
        <p style="margin:0 0 22px;color:#cfdcff;font-size:14px;">{{ __('messages.mail_hello', ['name' => $userName]) }}</p>

        <div style="background:#0d2494;border:2px dashed #8fb0ff;border-radius:14px;padding:20px;margin:18px 0;">
            <div style="font-size:12px;letter-spacing:1px;text-transform:uppercase;color:#bcd0ff;margin-bottom:8px;">{{ __('messages.mail_code_label') }}</div>
            <div style="font-size:38px;font-weight:800;letter-spacing:10px;color:#ffffff;">{{ $code }}</div>
        </div>

        <p style="color:#cfdcff;font-size:13px;line-height:1.6;">{{ __('messages.mail_valid', ['minutes' => $minutes]) }}</p>
        <p style="color:#9fb6f5;font-size:12px;line-height:1.6;">{{ __('messages.mail_ignore') }}</p>
    </div>
</body>
</html>
