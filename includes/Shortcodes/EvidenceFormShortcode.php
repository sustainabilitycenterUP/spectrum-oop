<?php
namespace Spectrum\Evidence\Shortcodes;

use Spectrum\Evidence\Core\Assets;
use Spectrum\Evidence\Core\Auth;
use Spectrum\Evidence\Core\Notices;
use Spectrum\Evidence\Core\View;

use Spectrum\Evidence\Repositories\MetricRepository;
use Spectrum\Evidence\Repositories\YearMetricRepository;
use Spectrum\Evidence\Repositories\FunctionMetricAssignmentRepository;
use Spectrum\Evidence\Repositories\MetricCoverageRepository;

if (!defined('ABSPATH')) exit;

final class EvidenceFormShortcode {

  public static function render() {
    if (!Auth::isLoggedIn()) return '<p>Silakan login untuk mengisi evidence.</p>';

    Assets::enqueueOnce();

    $user_id = Auth::userId();
    $unit_code = Auth::unitCode($user_id);

    $years = YearMetricRepository::yearsActiveDistinct();
    $metric_catalog = array();

    foreach ((array)$years as $year) {
      $year = (int)$year;

      $mandatory_metrics = FunctionMetricAssignmentRepository::getAssignedMetricsByUnitAndYear($unit_code, $year, 'MANDATORY');
      $recommended_metrics = FunctionMetricAssignmentRepository::getAssignedMetricsByUnitAndYear($unit_code, $year, 'RECOMMENDED');
      $assigned_ids = FunctionMetricAssignmentRepository::getAssignedMetricIdsByUnitAndYear($unit_code, $year);
      $approved_ids = MetricCoverageRepository::getApprovedMetricIdsByUnitAndYear($unit_code, $year);
      $all_active_metrics = MetricRepository::getActiveMetricsByYear($year);

      $assigned_lookup = array();
      foreach ((array)$assigned_ids as $mid) {
        $assigned_lookup[(int)$mid] = true;
      }

      $approved_lookup = array();
      foreach ((array)$approved_ids as $mid) {
        $approved_lookup[(int)$mid] = true;
      }

      $metric_catalog[$year] = array(
        'MANDATORY' => self::formatMetrics($mandatory_metrics, $approved_lookup),
        'RECOMMENDED' => self::formatMetrics($recommended_metrics, $approved_lookup),
        'GENERAL' => self::formatGeneralMetrics($all_active_metrics, $assigned_lookup),
      );
    }

    return View::render('evidence-form', array(
      'notice' => Notices::get($user_id),
      'years' => $years,
      'metric_catalog' => $metric_catalog,
    ));
  }

  private static function formatMetrics($metrics, $approved_lookup) {
    $out = array();

    foreach ((array)$metrics as $m) {
      $status_label = !empty($approved_lookup[(int)$m->metric_id]) ? 'Complete' : 'Uncompleted';

      $out[] = array(
        'id' => (int)$m->metric_id,
        'sdg_number' => (int)$m->sdg_number,
        'metric_code' => $m->metric_code,
        'metric_title' => $m->metric_title,
        'metric_question' => $m->metric_question,
        'metric_note' => $m->metric_note,
        'label' => 'SDG ' . $m->sdg_number . ' – ' . $m->metric_code . ' – ' . $m->metric_title . ' [' . $status_label . ']',
      );
    }

    return $out;
  }

  private static function formatGeneralMetrics($metrics, $assigned_lookup) {
    $out = array();

    foreach ((array)$metrics as $m) {
      if (!empty($assigned_lookup[(int)$m->id])) {
        continue;
      }

      $out[] = array(
        'id' => (int)$m->id,
        'sdg_number' => (int)$m->sdg_number,
        'metric_code' => $m->metric_code,
        'metric_title' => $m->metric_title,
        'metric_question' => $m->metric_question,
        'metric_note' => $m->metric_note,
        'label' => 'SDG ' . $m->sdg_number . ' – ' . $m->metric_code . ' – ' . $m->metric_title,
      );
    }

    return $out;
  }
}