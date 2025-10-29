<?php

return [
    'policy' => [
        'loan_days'     => 7,
        'fine_per_day'  => 1000,
        'grace_days'    => 0,
        'max_items'     => 3,
        'renew_max'     => 2,   // maksimal perpanjangan per loan
        'reservation_ready_days' => 2, // masa ambil setelah siap (hari)
    ],
];
