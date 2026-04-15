<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Booking.com (primary reservation channel)
    |--------------------------------------------------------------------------
    */

    'booking_com_url' => env('HOTEL_BOOKING_COM_URL', 'https://www.booking.com/hotel/rw/lucerna-kabgayi.html'),

    /*
    |--------------------------------------------------------------------------
    | TripAdvisor — property on TripAdvisor (locationId for widgets)
    |--------------------------------------------------------------------------
    */

    'tripadvisor_location_id' => env('HOTEL_TRIPADVISOR_LOCATION_ID', '28135123'),

    'tripadvisor_hotel_url' => env(
        'HOTEL_TRIPADVISOR_HOTEL_URL',
        'https://www.tripadvisor.com/Hotel_Review-g2720361-d28135123-Reviews-Lucerna_Kabgayi_Hotel-Muhanga_Southern_Province.html'
    ),

    'tripadvisor_write_review_url' => env(
        'HOTEL_TRIPADVISOR_WRITE_REVIEW_URL',
        'https://www.tripadvisor.com/UserReviewEdit-g2720361-d28135123-Lucerna_Kabgayi_Hotel-Muhanga_Southern_Province.html'
    ),

    /*
    |--------------------------------------------------------------------------
    | Google Maps / reviews (place link + optional embed)
    |--------------------------------------------------------------------------
    */

    'google_place_url' => env(
        'HOTEL_GOOGLE_PLACE_URL',
        'https://www.google.com/maps/place/Lucerna-Kabgayi+Hotel/@-2.0871407,29.7512686,17z/data=!3m1!4b1!4m6!3m5!1s0x19dccb9e7e84a8c1:0xbf93699bed85f0f!8m2!3d-2.0871407!4d29.7538435!16s%2Fg%2F11vk5674_p'
    ),

    /** Embed without API key (coordinates). */
    'google_maps_embed_url' => env(
        'HOTEL_GOOGLE_MAPS_EMBED_URL',
        'https://maps.google.com/maps?q=-2.0871407,29.7538435&z=16&output=embed'
    ),

    /*
    |--------------------------------------------------------------------------
    | WhatsApp — digits only, country code, no + (e.g. 250794191115)
    |--------------------------------------------------------------------------
    */

    'whatsapp_e164' => env('HOTEL_WHATSAPP_E164', '250794191115'),

    /** Default first message (URL-encoded automatically when building wa.me links). */
    'whatsapp_default_message' => env(
        'HOTEL_WHATSAPP_MESSAGE',
        'Hello Lucerna Kabgayi Hotel, I would like to enquire about:'
    ),

    /*
    |--------------------------------------------------------------------------
    | Public contact email (mailto + displayed)
    |--------------------------------------------------------------------------
    */

    'public_email' => env('HOTEL_PUBLIC_EMAIL', 'info@lucernakabgayihotel.com'),

];
