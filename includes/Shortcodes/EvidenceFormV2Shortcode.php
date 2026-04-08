<?php
namespace Spectrum\Evidence\Shortcodes;

use Spectrum\Evidence\Core\Assets;
use Spectrum\Evidence\Core\Auth;
use Spectrum\Evidence\Core\Notices;
use Spectrum\Evidence\Core\View;

use Spectrum\Evidence\Repositories\MetricRepository;
use Spectrum\Evidence\Repositories\FunctionMetricAssignmentRepository;
use Spectrum\Evidence\Repositories\MetricNoDataRepository;

if (!defined('ABSPATH')) exit;

final class EvidenceFormV2Shortcode {
  public static function render() {
    if (!Auth::isLoggedIn()) return '<p>Silakan login untuk mengisi evidence.</p>';
    Assets::enqueueOnce();

    $user_id = Auth::userId();
    $unit_code = Auth::unitCode($user_id);
    $year = 2027;

    $mandatory_metrics = FunctionMetricAssignmentRepository::getAssignedMetricsByUnitAndYear($unit_code, $year, 'MANDATORY');
    $mandatory_ids = FunctionMetricAssignmentRepository::getAssignedMetricIdsByUnitAndYear($unit_code, $year);
    $no_data_ids = MetricNoDataRepository::getMetricIdsByUnitAndYear($unit_code, $year);

    $active_metrics = MetricRepository::getActiveMetricsByYear($year);
    $mandatory_lookup = array();
    foreach ((array)$mandatory_ids as $mid) $mandatory_lookup[(int)$mid] = true;

    $general_metrics = array();
    foreach ((array)$active_metrics as $m) {
      if (!empty($mandatory_lookup[(int)$m->id])) continue;
      $general_metrics[] = $m;
    }

    return View::render('evidence-form-v2', array(
      'active' => 'new2',
      'notice' => Notices::get($user_id),
      'year' => $year,
      'mandatory_metrics' => $mandatory_metrics,
      'general_metrics' => $general_metrics,
      'no_data_ids' => array_map('intval', (array)$no_data_ids),
    ));
  }
}
