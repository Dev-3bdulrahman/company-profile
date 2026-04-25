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

            <!-- Badge -->
            <div style="display:inline-block;background:rgba(249,115,22,0.12);border:1px solid rgba(249,115,22,0.3);border-radius:50px;padding:6px 16px;margin-bottom:24px;">
              <span style="color:#f97316;font-size:12px;font-weight:600;letter-spacing:0.5px;">📩 {{ __('New Message') }}</span>
            </div>

            <h2 style="margin:0 0 8px;font-size:24px;font-weight:700;color:#ffffff;">{{ __('You have a new message') }}</h2>
            <p style="margin:0 0 32px;font-size:15px;color:rgba(255,255,255,0.5);">{{ __('Someone reached out through your portfolio') }}</p>

            <!-- Sender Info Card -->
            <table width="100%" cellpadding="0" cellspacing="0" style="background:#242424;border-radius:12px;border:1px solid rgba(255,255,255,0.06);margin-bottom:24px;">
              <tr>
                <td style="padding:24px;">
                  <p style="margin:0 0 16px;font-size:11px;font-weight:600;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:1px;">{{ __('Sender Details') }}</p>
                  <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                      <td style="padding:8px 0;border-bottom:1px solid rgba(255,255,255,0.04);">
                        <span style="font-size:13px;color:rgba(255,255,255,0.4);display:inline-block;width:80px;">{{ __('Name') }}</span>
                        <span style="font-size:14px;color:#ffffff;font-weight:600;">{{ $senderName }}</span>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding:8px 0;border-bottom:1px solid rgba(255,255,255,0.04);">
                        <span style="font-size:13px;color:rgba(255,255,255,0.4);display:inline-block;width:80px;">{{ __('Email') }}</span>
                        <a href="mailto:{{ $senderEmail }}" style="font-size:14px;color:#f97316;font-weight:600;text-decoration:none;">{{ $senderEmail }}</a>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding:8px 0;">
                        <span style="font-size:13px;color:rgba(255,255,255,0.4);display:inline-block;width:80px;">IP</span>
                        <span style="font-size:13px;color:rgba(255,255,255,0.5);">{{ $ip }}</span>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>

            <!-- Message Card -->
            <table width="100%" cellpadding="0" cellspacing="0" style="background:#242424;border-radius:12px;border:1px solid rgba(255,255,255,0.06);margin-bottom:32px;">
              <tr>
                <td style="padding:24px;">
                  <p style="margin:0 0 12px;font-size:11px;font-weight:600;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:1px;">{{ __('Message') }}</p>
                  <p style="margin:0;font-size:15px;color:rgba(255,255,255,0.8);line-height:1.8;white-space:pre-wrap;">{{ $senderMessage }}</p>
                </td>
              </tr>
            </table>

            <!-- CTA Button -->
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center">
                  <a href="mailto:{{ $senderEmail }}?subject=Re: {{ $subject }}"
                    style="display:inline-block;background:linear-gradient(135deg,#f97316,#ef4444);color:#ffffff;font-size:15px;font-weight:700;text-decoration:none;padding:14px 36px;border-radius:50px;letter-spacing:0.3px;">
                    {{ __('Reply Now') }} →
                  </a>
                </td>
              </tr>
            </table>

          </td>
        </tr>

        <!-- Footer -->
        <tr>
          <td style="background:#111111;border-radius:0 0 16px 16px;padding:24px 40px;text-align:center;border-top:1px solid rgba(255,255,255,0.04);">
            <p style="margin:0 0 4px;font-size:13px;color:rgba(255,255,255,0.3);">{{ $siteName }} &copy; {{ date('Y') }}</p>
            <p style="margin:0;font-size:12px;color:rgba(255,255,255,0.15);">{{ __('This email was sent automatically from your portfolio contact form.') }}</p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>

</body>
</html>
