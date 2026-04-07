<?php
namespace Spectrum\Evidence\Repositories;

use Spectrum\Evidence\Core\Db;

if (!defined('ABSPATH')) exit;

final class DashboardRepository {

  public static function distinctYears() {
    global $wpdb;
    $e = Db::table('spectrum_evidence');
    return $wpdb->get_col("SELECT DISTINCT year FROM {$e} ORDER BY year DESC");
  }

  public static function statusCounts($year = 0) {
    global $wpdb;
    $e = Db::table('spectrum_evidence');

    $where = "1=1";
    $params = array();

    if ($year) {
      $where .= " AND year = %d";
      $params[] = $year;
    }

    $sql = "SELECT status, COUNT(*) AS total FROM {$e} WHERE {$where} GROUP BY status";
    if ($params) $sql = $wpdb->prepare($sql, $params);

    $rows = $wpdb->get_results($sql);
    $out = array('DRAFT'=>0,'SUBMITTED'=>0,'APPROVED'=>0,'REJECTED'=>0);
    foreach ((array)$rows as $r) $out[$r->status] = (int)$r->total;

    return $out;
  }

  public static function sdgSummary($year = 0) {
    global $wpdb;
    $s  = Db::table('spectrum_sdg');
    $m  = Db::table('spectrum_metric');
    $em = Db::table('spectrum_evidence_metric');
    $e  = Db::table('spectrum_evidence');

    $joinYear = '';
    $params = array();
    if ($year) {
      $joinYear = ' AND e.year = %d';
      $params[] = $year;
    }

    $sql = "
      SELECT
        s.sdg_number,
        s.sdg_title,
        COUNT(DISTINCT e.id) AS total,
        COUNT(DISTINCT CASE WHEN e.status='SUBMITTED' THEN e.id END) AS submitted,
        COUNT(DISTINCT CASE WHEN e.status='APPROVED' THEN e.id END) AS approved,
        COUNT(DISTINCT CASE WHEN e.status='REJECTED' THEN e.id END) AS rejected
      FROM {$s} s
      LEFT JOIN {$m} m ON m.sdg_number = s.sdg_number
      LEFT JOIN {$em} em ON em.metric_id = m.id
      LEFT JOIN {$e} e ON e.id = em.evidence_id {$joinYear}
      GROUP BY s.sdg_number, s.sdg_title
      ORDER BY s.sdg_number ASC
    ";

    if (!empty($params)) {
      $sql = $wpdb->prepare($sql, $params);
    }

    return $wpdb->get_results($sql);
  }

  public static function unitCounts($year = 0) {
    global $wpdb;
    $fma = Db::table('spectrum_function_metric_assignment');
    $em  = Db::table('spectrum_evidence_metric');
    $e   = Db::table('spectrum_evidence');

    $where = "WHERE f.category = 'MANDATORY'";
    $params = array();

    if ($year) {
      $where .= " AND f.year = %d";
      $params[] = $year;
    }

    $sql = "
      SELECT
        f.unit_code,
        COUNT(DISTINCT CONCAT(f.year, '-', f.metric_id)) AS mandatory_total,
        COUNT(DISTINCT CASE WHEN e.status IN ('SUBMITTED','APPROVED') THEN CONCAT(f.year, '-', f.metric_id) END) AS submitted_total
      FROM {$fma} f
      LEFT JOIN {$em} em ON em.metric_id = f.metric_id
      LEFT JOIN {$e} e ON e.id = em.evidence_id
                       AND e.unit_code = f.unit_code
                       AND e.year = f.year
      {$where}
      GROUP BY f.unit_code
      ORDER BY submitted_total DESC, f.unit_code ASC
    ";

    if (!empty($params)) {
      $sql = $wpdb->prepare($sql, $params);
    }

    $rows = $wpdb->get_results($sql);
    foreach ((array)$rows as $r) {
      $mandatory = (int)($r->mandatory_total ?? 0);
      $submitted = (int)($r->submitted_total ?? 0);
      $r->percent = $mandatory > 0 ? (int)round(($submitted / $mandatory) * 100) : 0;
    }

    return $rows;
  }

  public static function latestEvidence($limit = 8, $year = 0) {
    global $wpdb;
    $e  = Db::table('spectrum_evidence');
    $em = Db::table('spectrum_evidence_metric');
    $m  = Db::table('spectrum_metric');

    $where = "1=1";
    $params = array();

    if ($year) {
      $where .= " AND e.year = %d";
      $params[] = $year;
    }

    $sql = "
      SELECT e.id, e.title, e.unit_code, e.status, e.updated_at, e.year,
             m.sdg_number, m.metric_code
      FROM {$e} e
      LEFT JOIN {$em} em ON em.evidence_id = e.id
      LEFT JOIN {$m}  m  ON m.id = em.metric_id
      WHERE {$where}
      ORDER BY e.updated_at DESC, e.created_at DESC
      LIMIT %d
    ";
    $params[] = (int)$limit;

    $sql = $wpdb->prepare($sql, $params);
    return $wpdb->get_results($sql);
  }

  public static function topApprovedUnits($year = 0) {
    global $wpdb;
    $e = Db::table('spectrum_evidence');

    $where = "status = 'APPROVED'";
    $params = array();

    if ($year) {
      $where .= " AND year = %d";
      $params[] = $year;
    }

    $sql = "
      SELECT unit_code, COUNT(*) AS total
      FROM {$e}
      WHERE {$where}
      GROUP BY unit_code
      ORDER BY total DESC
      LIMIT 3
    ";

    if ($params) $sql = $wpdb->prepare($sql, $params);

    return $wpdb->get_results($sql);
  }

  public static function metricSummaryTop($year = 0, $limit = 10) {
    global $wpdb;

    $e  = Db::table('spectrum_evidence');
    $em = Db::table('spectrum_evidence_metric');
    $m  = Db::table('spectrum_metric');

    $where = "e.id IS NOT NULL";
    $params = array();

    if ($year) {
      $where .= " AND e.year = %d";
      $params[] = $year;
    }

    $sql = "
      SELECT
        m.sdg_number,
        m.metric_code,
        m.metric_title ,

        COUNT(DISTINCT e.id) AS total,

        COUNT(DISTINCT CASE WHEN e.status = 'SUBMITTED' THEN e.id END) AS submitted,

        COUNT(DISTINCT CASE WHEN e.status = 'APPROVED' THEN e.id END) AS approved

      FROM {$e} e
      LEFT JOIN {$em} em ON em.evidence_id = e.id
      LEFT JOIN {$m} m ON m.id = em.metric_id

      WHERE {$where} AND m.sdg_number IS NOT NULL

      GROUP BY m.id, m.sdg_number, m.metric_code, m.metric_title

      ORDER BY total DESC, submitted DESC, approved DESC, m.sdg_number ASC
      LIMIT %d
    ";

    $params[] = (int)$limit;

    if ($params) {
      $sql = $wpdb->prepare($sql, $params);
    }
    return $wpdb->get_results($sql);
  }

  public static function weeklyCounts($year = 0) {
    global $wpdb;
    $e = Db::table('spectrum_evidence');

    $where = "created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
    $params = array();

    if ($year) {
      $where .= " AND year = %d";
      $params[] = $year;
    }

    $sql = "
      SELECT
        COUNT(*) AS total,
        SUM(CASE WHEN status='SUBMITTED' THEN 1 ELSE 0 END) AS submitted,
        SUM(CASE WHEN status='APPROVED' THEN 1 ELSE 0 END) AS approved
      FROM {$e}
      WHERE {$where}
    ";

    if (!empty($params)) {
      $sql = $wpdb->prepare($sql, $params);
    }

    $row = $wpdb->get_row($sql);

    return array(
      'total' => (int)($row->total ?? 0),
      'submitted' => (int)($row->submitted ?? 0),
      'approved' => (int)($row->approved ?? 0),
    );
  }
}
