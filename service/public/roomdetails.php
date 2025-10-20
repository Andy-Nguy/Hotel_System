<?php
/**
 * Compatibility shim: redirect legacy /roomdetails.php to the Laravel route
 * /roomdetails while preserving the original query string (e.g., ?id=P001).
 * This avoids path info quirks when including index.php directly.
 */

$qs = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== ''
	? ('?' . $_SERVER['QUERY_STRING'])
	: '';

// Use a relative root path to keep current host and scheme
header('Location: /roomdetails' . $qs, true, 302);
exit;
