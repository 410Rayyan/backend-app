<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Divided into separate files for each feature:
| - routes/auth.php
| - routes/properties.php
| - routes/bookings.php
*/

// Load User & Auth Routes
require __DIR__ . '/auth.php';

// Load Properties & Places Routes
require __DIR__ . '/properties.php';

// Load Bookings Routes
require __DIR__ . '/bookings.php';
