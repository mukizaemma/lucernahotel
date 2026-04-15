<?php

namespace App\Support;

use App\Models\Setting;

/**
 * Resolves Booking.com, TripAdvisor, Google, WhatsApp, and contact email:
 * settings row overrides config/hotel_channels.php (which reads .env).
 */
final class HotelChannels
{
    private static ?array $cache = null;

    public static function forgetCache(): void
    {
        self::$cache = null;
    }

    /**
     * @return array<string, string|null>
     */
    public static function all(): array
    {
        if (self::$cache !== null) {
            return self::$cache;
        }

        $base = config('hotel_channels', []);
        $s = Setting::first();

        if ($s === null) {
            self::$cache = $base;

            return self::$cache;
        }

        $str = static function (?string $v): bool {
            return $v !== null && trim($v) !== '';
        };

        $publicEmail = $str($s->channel_contact_email ?? null)
            ? trim((string) $s->channel_contact_email)
            : ($str($s->email ?? null) ? trim((string) $s->email) : ($base['public_email'] ?? null));

        self::$cache = [
            'booking_com_url' => $str($s->booking_com_url ?? null)
                ? trim((string) $s->booking_com_url)
                : ($base['booking_com_url'] ?? null),
            'tripadvisor_location_id' => $str($s->tripadvisor_location_id ?? null)
                ? trim((string) $s->tripadvisor_location_id)
                : ($base['tripadvisor_location_id'] ?? null),
            'tripadvisor_hotel_url' => $str($s->tripadvisor_hotel_url ?? null)
                ? trim((string) $s->tripadvisor_hotel_url)
                : ($base['tripadvisor_hotel_url'] ?? null),
            'tripadvisor_write_review_url' => $str($s->tripadvisor_write_review_url ?? null)
                ? trim((string) $s->tripadvisor_write_review_url)
                : ($base['tripadvisor_write_review_url'] ?? null),
            'google_place_url' => $str($s->google_place_url ?? null)
                ? trim((string) $s->google_place_url)
                : ($base['google_place_url'] ?? null),
            'google_maps_embed_url' => $str($s->google_maps_embed_url ?? null)
                ? trim((string) $s->google_maps_embed_url)
                : ($base['google_maps_embed_url'] ?? null),
            'whatsapp_e164' => $str($s->whatsapp_e164 ?? null)
                ? preg_replace('/\D+/', '', (string) $s->whatsapp_e164) ?: ($base['whatsapp_e164'] ?? null)
                : ($base['whatsapp_e164'] ?? null),
            'whatsapp_default_message' => $str($s->whatsapp_default_message ?? null)
                ? trim((string) $s->whatsapp_default_message)
                : ($base['whatsapp_default_message'] ?? null),
            'public_email' => $publicEmail,
        ];

        return self::$cache;
    }
}
