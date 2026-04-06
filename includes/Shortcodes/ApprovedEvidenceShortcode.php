<?php
namespace Spectrum\Evidence\Shortcodes;

use Spectrum\Evidence\Core\Assets;
use Spectrum\Evidence\Core\Auth;
use Spectrum\Evidence\Core\View;

use Spectrum\Evidence\Repositories\ApprovedEvidenceRepository;
use Spectrum\Evidence\Services\ExportService;

if (!defined('ABSPATH')) exit;

final class ApprovedEvidenceShortcode {

  public static function render() {
    if (!Auth::isLoggedIn()) return '<p>Silakan login.</p>';
    if (!Auth::isReviewer()) return '<p>Halaman ini hanya untuk reviewer.</p>';

    Assets::enqueueOnce();

    $unit = isset($_GET['unit_code']) ? sanitize_text_field($_GET['unit_code']) : '';
    $sdg  = isset($_GET['sdg_number']) ? (int)$_GET['sdg_number'] : 0;

    $filters = array(
      'unit_code' => $unit,
      'sdg_number' => $sdg,
    );

    $rows = ApprovedEvidenceRepository::list($filters);
    if (!empty($_GET['export']) && $_GET['export'] === 'xlsx') {
      $export_rows = array();
      foreach ((array)$rows as $r) {
        $export_rows[] = array(
          'ID' => (int)$r->id,
          'Year' => (int)$r->year,
          'Title' => $r->title,
          'Unit' => $r->unit_code,
          'Status' => $r->status,
          'SDG' => !empty($r->sdg_number) ? ('SDG ' . (int)$r->sdg_number) : '',
          'Metric Code' => $r->metric_code ?? '',
          'Metric Title' => $r->metric_title ?? '',
          'Updated At' => $r->updated_at,
        );
      }
      ExportService::outputXlsx(
        'approved-evidence-' . date('Ymd-His') . '.xlsx',
        array('ID', 'Year', 'Title', 'Unit', 'Status', 'SDG', 'Metric Code', 'Metric Title', 'Updated At'),
        $export_rows
      );
    }

    return View::render('approved-evidence', array(
      'active' => 'approved',
      'filters' => $filters,
      'units' => ApprovedEvidenceRepository::distinctUnits(),
      'rows' => $rows,
    ));
  }
}
