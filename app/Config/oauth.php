<?php

return [

    /*
     * The location of the VATSIM OAuth interface
     */
    'base' => env('OAUTH_URL', 'https://auth-dev.vatsim.net'),

    /*
     * The consumer key for your organisation
     */
    'id' => env('OAUTH_ID', '176'),

    /*
     * The secret key for your organisation
     * Do not give this to anyone else or display it to your users. It must be kept server-side
     */
    'secret' => env('OAUTH_SECRET', 'nxbWbCSm1CAVeZV5xysLyuEyvhTHIdn2jJ9TV11v'),

];