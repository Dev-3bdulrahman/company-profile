<?php

namespace App\Services\External;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebhookService extends BaseExternalService
{
  /**
   * Send data to n8n webhook.
   *
   * @param string $event
   * @param array $data
   * @return void
   */
  public function send(string $event, array $data): void
  {
    $url = env('N8N_WEBHOOK_URL');

    if (!$url) {
      Log::warning('N8N_WEBHOOK_URL not set. Webhook skipped.', ['event' => $event]);
      return;
    }

    try {
      Http::timeout(10)->post($url, [
        'event' => $event,
        'data' => $data,
        'timestamp' => now()->toIso8601String(),
      ]);
    } catch (\Exception $e) {
      Log::error('Failed to send webhook to n8n', [
        'event' => $event,
        'error' => $e->getMessage(),
      ]);
    }
  }
}
