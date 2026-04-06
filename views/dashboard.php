<?php
if (!defined('ABSPATH')) exit;

include __DIR__ . '/layout-open.php';

$year = (int)($year ?? 0);
$status = $status ?? array();
$weekly = $weekly ?? array('total' => 0, 'submitted' => 0, 'approved' => 0);
$sdg_summary = $sdg_summary ?? array();
$metric_summary = $metric_summary ?? array();
?>

<div class="sp-page-header">
  <div class="sp-page-title-block">
    <h1>Dashboard SPECTRUM</h1>
    <p>Ringkasan progres pengumpulan evidence (semua status).</p>
  </div>
</div>

<section class="sp-card">

  <!-- Cards status -->
  <div style="display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;">
    <?php
      $totalEvidence =
        (int)($status['DRAFT'] ?? 0) +
        (int)($status['SUBMITTED'] ?? 0) +
        (int)($status['APPROVED'] ?? 0) +
        (int)($status['REJECTED'] ?? 0);

      $cards = array(
        'Total Evidence' => $totalEvidence,
        'Submitted'      => (int)($status['SUBMITTED'] ?? 0),
        'Approved'       => (int)($status['APPROVED'] ?? 0),
      );
    ?>
    <?php foreach ($cards as $k => $v): ?>
      <div class="sp-box">
        <div style="color:#6b7280;font-size:12px;"><?php echo esc_html($k); ?></div>
        <div style="font-size:26px;font-weight:650;margin-top:6px;"><?php echo esc_html($v); ?></div>
        <div style="margin-top:6px;">
          <span style="background:#dcfce7;color:#166534;padding:3px 8px;border-radius:999px;font-size:11px;">
            +<?php
              echo ($k === 'Total Evidence')
                ? (int)$weekly['total']
                : (($k === 'Submitted') ? (int)$weekly['submitted'] : (int)$weekly['approved']);
            ?> dalam 7 hari
          </span>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div style="display:grid;grid-template-columns: 1fr; gap:14px; margin-top:16px;">
    <!-- UNIT -->
    <div class="sp-box">
      <h3 style="margin-top:0;">
        Progress per Unit
        <span title="Dihitung berdasarkan cakupan metrik MANDATORY (status SUBMITTED/APPROVED)" style="cursor:help;color:#6b7280;">ⓘ</span>
      </h3>

      <?php if (empty($unit)): ?>
        <div style="color:#6b7280;">Belum ada data unit.</div>
      <?php else: ?>
        <?php foreach ($unit as $u): ?>
          <div style="margin-bottom:12px;">
            <div style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:4px;">
              <div><?php echo esc_html($u->unit_code ?: '—'); ?></div>
              <div><?php echo (int)$u->submitted_total; ?> / <?php echo (int)$u->mandatory_total; ?> (<?php echo (int)$u->percent; ?>%)</div>
            </div>

            <div style="background:#eee;height:8px;border-radius:4px;">
              <div style="width:<?php echo min((int)$u->percent,100); ?>%;background:#1d4ed8;height:8px;border-radius:4px;"></div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <!-- Evidence per SDG -->
  <div class="sp-box" style="margin-top:14px;">
    <h3 style="margin:0;">Evidence per SDG</h3>

    <?php if (empty($sdg_summary)): ?>
      <div style="color:#6b7280;margin-top:8px;">Belum ada data SDG.</div>
    <?php else: ?>
      <table class="sp-table" style="margin-top:10px;">
        <thead>
          <tr>
            <th style="width:70px;">SDG</th>
            <th>Topic</th>
            <th>Total</th>
            <th>Submitted</th>
            <th>Approved</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($sdg_summary as $row): ?>
            <tr>
              <td><strong><?php echo (int)$row->sdg_number; ?></strong></td>
              <td><?php echo esc_html($row->sdg_title); ?></td>
              <td><?php echo (int)$row->total; ?></td>
              <td><?php echo (int)$row->submitted; ?></td>
              <td><?php echo (int)$row->approved; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

  <!-- Ringkasan per Metrik -->
  <div class="sp-box" style="margin-top:14px;">
    <h3 style="margin:0;">Ringkasan per Metrik</h3>
    <div style="font-size:12px;color:#6b7280;">Top 10 metrik dengan evidence terbanyak.</div>

    <?php if (empty($metric_summary)): ?>
      <div style="color:#6b7280;margin-top:8px;">Belum ada data metrik.</div>
    <?php else: ?>
      <table class="sp-table" style="margin-top:10px;">
        <thead>
          <tr>
            <th style="width:70px;">SDG</th>
            <th style="width:140px;">Kode Metrik</th>
            <th>Nama Metrik</th>
            <th>Total Evidence</th>
            <th>Submitted</th>
            <th>Approved</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($metric_summary as $row): ?>
            <tr>
              <td><strong><?php echo (int)$row->sdg_number; ?></strong></td>
              <td><?php echo esc_html($row->metric_code); ?></td>
              <td><?php echo esc_html($row->metric_title); ?></td>
              <td><?php echo (int)$row->total; ?></td>
              <td><?php echo (int)$row->submitted; ?></td>
              <td><?php echo (int)$row->approved; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

</section>

<?php include __DIR__ . '/layout-close.php'; ?>
