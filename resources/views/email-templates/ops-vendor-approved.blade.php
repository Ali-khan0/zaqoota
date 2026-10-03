<!doctype html>
<html lang="en">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>{{ $title }}</title></head>
<body style="margin:0;background:#f4f6f8;color:#334155;font-family:Arial,sans-serif;line-height:1.6">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0"><tr><td align="center" style="padding:30px 15px">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:600px;background:#fff;border:1px solid #dcebea;border-radius:14px;overflow:hidden">
        <tr><td style="padding:24px;background:#0d988d;color:#fff;text-align:center;font-size:26px;font-weight:700">ZAQOOTA</td></tr>
        <tr><td style="padding:34px">
            <h1 style="margin:0 0 16px;color:#102a33;font-size:22px">{{ $title }}</h1>
            <div style="margin-bottom:18px">{!! $body !!}</div>
            <div style="padding:16px;background:#f4fbfa;border:1px solid #d4ebe8;border-radius:10px">
                <strong>{{ $storeName }}</strong><br>{{ $email }}
            </div>
            <p>No password is included in this email. Create your own password using this single-use secure link:</p>
            <p style="margin:24px 0"><a href="{{ $setupUrl }}" style="display:inline-block;padding:13px 24px;background:#0d988d;color:#fff;text-decoration:none;border-radius:8px;font-weight:700">Set your password</a></p>
            <p style="font-size:13px;color:#64748b">This link expires {{ $expiresAt->format('d M Y, h:i A') }} and stops working immediately after use. If it expires, contact Zaqoota or use Forgot Password.</p>
            <p style="margin-top:26px">Thanks &amp; Regards,<br>{{ $companyName }}</p>
        </td></tr>
    </table>
</td></tr></table>
</body>
</html>
