<?php
declare(strict_types=1);

/**
 * CIPCard Platform - Root Entrypoint Proxy
 * Delegates execution to public/index.php for standard cPanel DocumentRoot environments
 */
require_once __DIR__ . '/public/index.php';
