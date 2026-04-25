<!DOCTYPE html>
<html lang="{{ $locale ?? 'ar' }}" dir="{{ ($locale ?? 'ar') === 'ar' ? 'rtl' : 'ltr' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $subject }}</title>
</head>
<body style="margin:0;padding:0;background:#0f0f0f;font-family:'Segoe UI',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#0f0f0f;padding:40px 20px;">
  <tr>
    <td align="center">
      <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">

        <!-- Header -->
        <tr>
          <td style="background:linear-gradient(135deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%);border-radius:16px 16px 0 0;padding:40px 40px 30px;text-align:center;border-bottom:1px solid rgba(255,255,255,0.05);">
            @if($logoUrl)
            <img src="{{ $logoUrl }}" alt="{{ $siteName }}" style="height:64px;width:auto;object-fit:contain;margin-bottom:16px;display:block;margin-left:auto;margin-right:auto;">
            @endif
            <h1 style="margin:0;font-size:22px;font-weight:700;color:#ffffff;letter-spacing:-0.5px;">{{ $siteName }}</h1>
            <p style="margin:6px 0 0;font-size:13px;color:rgba(255,255,255,0.45);letter-spacing:1px;text-transform:uppercase;">Portfolio</p>
          </td>
        </tr>

        <!-- Orange accent bar -->
        <tr>
          <td style="background:linear-gradient(90deg,#f97316,#ef4444);height:3px;"></td>
        </tr>

        <!-- Body -->
        <tr>
          <td style="background:#1a1a1a;padding:40px;">

            <p style="margin:0 0 24px;font-size:16px;color:#ffffff;font-weight:600;">{{ __('Hello') }} {{ $recipientName }} 👋</p>

            <!-- Message Card -->
            <table width="100%" cellpadding="0" cellspacing="0" style="background:#242424;border-radius:12px;border:1px solid rgba(255,255,255,0.06);margin-bottom:32px;">
              <tr>
                <td style="padding:28px;">
                  <p style="margin:0;font-size:15px;color:rgba(255,255,255,0.85);line-height:1.9;white-space:pre-wrap;">{{ $replyMessage }}</p>
                </td>
              </tr>
            </table>

            <!-- Divider -->
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
              <tr><td style="border-top:1px solid rgba(255,255,255,0.06);"></td></tr>
            </table>

            <p style="margin:0;font-size:14px;color:rgba(255,255,255,0.4);line-height:1.7;">
              {{ __('Best regards,') }}<br>
              <strong style="color:rgba(255,255,255,0.7);">{{ $siteName }}</strong>
            </p>

          </td>
        </tr>

        <!-- Footer -->
        <tr>
          <td style="background:#111111;border-radius:0 0 16px 16px;padding:24px 40px;text-align:center;border-top:1px solid rgba(255,255,255,0.04);">
            <p style="margin:0 0 4px;font-size:13px;color:rgba(255,255,255,0.3);">{{ $siteName }} &copy; {{ date('Y') }}</p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>

</body>
</html>
