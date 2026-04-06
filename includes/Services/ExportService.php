<?php
namespace Spectrum\Evidence\Services;

if (!defined('ABSPATH')) exit;

final class ExportService {

  public static function outputCsv($filename, $headers, $rows) {
    if (ob_get_length()) {
      ob_end_clean();
    }

    nocache_headers();
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . sanitize_file_name($filename) . '"');

    $out = fopen('php://output', 'w');
    if (!$out) {
      wp_die('Gagal membuat file export.');
    }

    fputcsv($out, $headers);
    foreach ((array)$rows as $row) {
      fputcsv($out, (array)$row);
    }
    fclose($out);
    exit;
  }
}
