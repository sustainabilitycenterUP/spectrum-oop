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
      <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
        <h3 style="margin:0;">
          Progress per Unit
          <span title="Dihitung berdasarkan cakupan metrik MANDATORY (status SUBMITTED/APPROVED)" style="cursor:help;color:#6b7280;">ⓘ</span>
        </h3>
      </div>
      <div style="font-size:12px;color:#6b7280;margin-top:4px;">
        Semua unit ditampilkan (termasuk yang progress 0%).
      </div>
      <?php if (empty($unit)): ?>
        <div style="color:#6b7280;margin-top:10px;">Belum ada data unit.</div>
      <?php else: ?>
        <div style="margin-top:12px;">
          <canvas id="sp-unit-progress-chart" style="max-height:480px;"></canvas>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- SDG Evidence Status Chart -->
  <div class="sp-box" style="margin-top:14px;">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
      <h3 style="margin:0;">SDG Evidence Status</h3>
      <label style="font-size:12px;color:#334155;display:flex;align-items:center;gap:6px;">
        Filter Status
        <select id="sp-sdg-status-filter" class="sp-select" style="width:auto;min-width:140px;padding:4px 8px;">
          <option value="ALL">Semua</option>
          <option value="APPROVED">Approved</option>
          <option value="SUBMITTED">Submitted</option>
          <option value="REJECTED">Rejected</option>
        </select>
      </label>
    </div>
    <div style="font-size:12px;color:#6b7280;margin-top:6px;">
      Grouped bar chart jumlah evidence per SDG (Approved 100%, Submitted 50%, Rejected 20% warna SDG).
    </div>
    <div style="margin-top:12px;">
      <canvas id="sp-sdg-evidence-chart" style="max-height:460px;"></canvas>
    </div>
  </div>

  <!-- SDG Evidence Status Chart -->
  <div class="sp-box" style="margin-top:14px;">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">
      <h3 style="margin:0;">SDG Evidence Status</h3>
      <label style="font-size:12px;color:#334155;display:flex;align-items:center;gap:6px;">
        Filter Status
        <select id="sp-sdg-status-filter" class="sp-select" style="width:auto;min-width:140px;padding:4px 8px;">
          <option value="ALL">Semua</option>
          <option value="APPROVED">Approved</option>
          <option value="SUBMITTED">Submitted</option>
          <option value="REJECTED">Rejected</option>
        </select>
      </label>
    </div>
    <div style="font-size:12px;color:#6b7280;margin-top:6px;">
      Grouped bar chart jumlah evidence per SDG (Approved 100%, Submitted 50%, Rejected 20% warna SDG).
    </div>
    <div style="margin-top:12px;">
      <canvas id="sp-sdg-evidence-chart" style="max-height:460px;"></canvas>
    </div>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function(){
  const rows = <?php echo wp_json_encode(array_values((array)$sdg_summary)); ?>;
  const unitRows = <?php echo wp_json_encode(array_values((array)$unit)); ?>;
  const labels = rows.map(r => 'SDG ' + (r.sdg_number || 0));
  const approved = rows.map(r => Number(r.approved || 0));
  const submitted = rows.map(r => Number(r.submitted || 0));
  const rejected = rows.map(r => Number(r.rejected || 0));

  const sdgColorMap = {
    1:'#e5243b', 2:'#dda63a', 3:'#4c9f38', 4:'#c5192d', 5:'#ff3a21', 6:'#26bde2',
    7:'#fcc30b', 8:'#a21942', 9:'#fd6925', 10:'#dd1367', 11:'#fd9d24', 12:'#bf8b2e',
    13:'#3f7e44', 14:'#0a97d9', 15:'#56c02b', 16:'#00689d', 17:'#19486a'
  };

  const baseColors = rows.map(r => sdgColorMap[Number(r.sdg_number)] || '#64748b');
  const hexToRgba = (hex, alpha) => {
    const c = hex.replace('#','');
    const r = parseInt(c.substring(0,2), 16);
    const g = parseInt(c.substring(2,4), 16);
    const b = parseInt(c.substring(4,6), 16);
    return `rgba(${r},${g},${b},${alpha})`;
  };

  const approvedColors = baseColors.map(c => hexToRgba(c, 1));
  const submittedColors = baseColors.map(c => hexToRgba(c, 0.5));
  const rejectedColors = baseColors.map(c => hexToRgba(c, 0.2));

  const el = document.getElementById('sp-sdg-evidence-chart');
  if (!el || typeof Chart === 'undefined') return;

  const commonTooltip = {
    backgroundColor: '#dcfce7',
    titleColor: '#166534',
    bodyColor: '#14532d',
    borderColor: '#86efac',
    borderWidth: 1,
    titleFont: { size: 11, weight: '600' },
    bodyFont: { size: 11 }
  };

  const sdgChart = new Chart(el, {
    type: 'bar',
    data: {
      labels,
      datasets: [
        { key:'APPROVED', label:'Approved', data: approved, backgroundColor: approvedColors },
        { key:'SUBMITTED', label:'Submitted', data: submitted, backgroundColor: submittedColors },
        { key:'REJECTED', label:'Rejected', data: rejected, backgroundColor: rejectedColors }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'top' },
        tooltip: {
          ...commonTooltip,
          callbacks: {
            label: function(ctx){ return `${ctx.dataset.label}: ${ctx.raw}`; }
          }
        }
      },
      scales: {
        x: {
          ticks: { maxRotation: 45, minRotation: 45 }
        },
        y: {
          beginAtZero: true,
          title: { display: true, text: 'Jumlah Evidence' }
        }
      }
    }
  });

  const statusFilter = document.getElementById('sp-sdg-status-filter');
  if (statusFilter) {
    statusFilter.addEventListener('change', function(){
      const selected = this.value;
      sdgChart.data.datasets.forEach(function(ds){
        ds.hidden = (selected !== 'ALL' && ds.key !== selected);
      });
      sdgChart.update();
    });
  }

  const unitCanvas = document.getElementById('sp-unit-progress-chart');
  if (unitCanvas && unitRows.length) {
    const unitLabels = unitRows.map(u => u.unit_code || '—');
    const approvedTotal = unitRows.map(u => Number(u.approved_total || 0));
    const noDataTotal = unitRows.map(u => Number(u.no_data_total || 0));
    const mandatoryTotal = unitRows.map(u => Number(u.mandatory_total || 0));
    const approvedPercent = unitRows.map((u, i) => mandatoryTotal[i] > 0 ? (approvedTotal[i] / mandatoryTotal[i]) * 100 : 0);
    const noDataPercent = unitRows.map((u, i) => mandatoryTotal[i] > 0 ? (noDataTotal[i] / mandatoryTotal[i]) * 100 : 0);

    new Chart(unitCanvas, {
      type: 'bar',
      data: {
        labels: unitLabels,
        datasets: [
          {
            label: 'Approved',
            data: approvedPercent,
            backgroundColor: '#2563eb',
            borderColor: '#1d4ed8',
            borderWidth: 1
          },
          {
            label: 'NO Data',
            data: noDataPercent,
            backgroundColor: '#fb923c',
            borderColor: '#ea580c',
            borderWidth: 1
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: true, position: 'top' },
          tooltip: {
            ...commonTooltip,
            callbacks: {
              title: function(items){ return items[0] ? items[0].label : ''; },
              label: function(ctx){
                const idx = ctx.dataIndex;
                const approved = approvedTotal[idx];
                const noData = noDataTotal[idx];
                const mandatory = mandatoryTotal[idx];
                if (ctx.dataset.label === 'Approved') {
                  return `Approved: ${approved} (${approved}/${mandatory})`;
                }
                return `No data: ${noData} (${noData}/${mandatory})`;
              }
            }
          }
        },
        scales: {
          x: {
            stacked: true,
            ticks: { maxRotation: 45, minRotation: 45 }
          },
          y: {
            beginAtZero: true,
            stacked: true,
            max: 100,
            title: { display: true, text: 'Persentase Data Terkumpul (%)' }
          }
        }
      }
    });
  }
})();
</script>

<?php include __DIR__ . '/layout-close.php'; ?>
