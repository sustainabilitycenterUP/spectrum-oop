<?php
use Spectrum\Evidence\Core\Url;

if (!defined('ABSPATH')) exit;

$active = 'new';
include __DIR__ . '/layout-open.php';
?>

<div class="sp-page-header">
  <div>
    <h1>Buat Evidence Baru</h1>
    <p>Isi form berikut untuk menyimpan draft atau submit evidence.</p>
  </div>
  <a class="sp-btn-secondary" href="<?php echo esc_url(Url::page('my')); ?>">← Kembali</a>
</div>

<section class="sp-card">
  <?php if (!empty($notice) && !empty($notice['messages'])): ?>
    <div class="sp-alert <?php echo ($notice['type']==='success') ? 'sp-alert-success' : 'sp-alert-error'; ?>">
      <ul>
        <?php foreach ((array)$notice['messages'] as $m): ?>
          <li><?php echo esc_html($m); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data" class="sp-form-wrapper">
    <?php wp_nonce_field('spectrum_save_evidence', 'spectrum_nonce'); ?>

    <!-- TAHUN -->
    <div class="sp-form-row">
      <label class="sp-label">Tahun Pelaporan *</label>
      <select name="year" id="year_select" class="sp-select" required>
        <option value="">-- Pilih Tahun --</option>
        <?php foreach ((array)$years as $y): ?>
          <option value="<?php echo esc_attr($y); ?>"><?php echo esc_html($y); ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- KATEGORI -->
    <div class="sp-form-row">
      <label class="sp-label">Kategori Metric *</label>
      <div style="display:flex;gap:18px;align-items:center;flex-wrap:wrap;">
        <label style="display:flex;gap:6px;align-items:center;">
          <input type="radio" name="metric_category" value="MANDATORY" required> Mandatory
        </label>
        <label style="display:flex;gap:6px;align-items:center;">
          <input type="radio" name="metric_category" value="RECOMMENDED" required> Recommended
        </label>
        <label style="display:flex;gap:6px;align-items:center;">
          <input type="radio" name="metric_category" value="GENERAL" required> General
        </label>
      </div>
      <div id="metric_category_help" class="sp-help" style="margin-top:6px;"></div>
    </div>

    <!-- METRIC -->
    <div class="sp-form-row">
      <label class="sp-label">Metrik THE *</label>
      <select name="metric_id" id="metric_select" class="sp-select" required disabled>
        <option value="">-- Pilih Tahun & Kategori dulu --</option>
      </select>
    </div>

    <!-- QUESTION & NOTE -->
    <div id="metric_info" class="sp-metric-box" style="display:none;">
      <div class="sp-metric-title">Metric Question</div>
      <div id="metric_question"></div>
      <div class="sp-metric-title" style="margin-top:8px;">Metric Note</div>
      <div id="metric_note"></div>
    </div>

    <!-- JUDUL -->
    <div class="sp-form-row">
      <label class="sp-label">Judul Evidence *</label>
      <input type="text" name="title" class="sp-input" required>
    </div>

    <!-- BENTUK EVIDENCE -->
    <div class="sp-form-row">
      <label class="sp-label">Bentuk Evidence *</label>
      <div style="display:flex;gap:16px;align-items:center;">
        <label style="display:flex;gap:6px;align-items:center;">
          <input type="radio" name="source_type" value="link" required> Link
        </label>
        <label style="display:flex;gap:6px;align-items:center;">
          <input type="radio" name="source_type" value="file" required> File
        </label>
      </div>
    </div>

    <!-- LINK -->
    <div class="sp-form-row sp-source sp-source-link" style="display:none;">
      <label class="sp-label">Link URL *</label>
      <input type="url" name="link_url" class="sp-input" placeholder="https://...">
      <div class="sp-help">Catatan: pastikan link accessible dan bisa diakses sampai tahun 2025.</div>
    </div>

    <!-- FILE -->
    <div class="sp-form-row sp-source sp-source-file" style="display:none;">
      <label class="sp-label">Upload File *</label>
      <input type="file" name="evidence_file" class="sp-input">
      <div class="sp-help">File akan tersimpan di Media Library WordPress.</div>
    </div>

    <!-- RINGKASAN -->
    <div class="sp-form-row">
      <label class="sp-label">Ringkasan Evidence *</label>
      <textarea name="summary" class="sp-textarea" required></textarea>
    </div>

    <!-- ACTION -->
    <div class="sp-form-actions">
      <button type="submit" name="spectrum_action" value="draft" class="sp-btn-secondary">Simpan Draft</button>
      <button type="submit" name="spectrum_action" value="submit" class="sp-btn-primary">Submit</button>
    </div>
  </form>
</section>

<script>
(function(){
  const metricCatalog = <?php echo wp_json_encode($metric_catalog); ?>;

  const yearSelect = document.getElementById('year_select');
  const metricSelect = document.getElementById('metric_select');
  const metricInfo = document.getElementById('metric_info');
  const metricQuestion = document.getElementById('metric_question');
  const metricNote = document.getElementById('metric_note');
  const categoryHelp = document.getElementById('metric_category_help');

  const categoryRadios = document.querySelectorAll('input[name="metric_category"]');
  const sourceRadios = document.querySelectorAll('input[name="source_type"]');

  const linkWrap = document.querySelector('.sp-source-link');
  const fileWrap = document.querySelector('.sp-source-file');
  const linkInput = document.querySelector('input[name="link_url"]');
  const fileInput = document.querySelector('input[name="evidence_file"]');

  function getSelectedCategory() {
    const checked = document.querySelector('input[name="metric_category"]:checked');
    return checked ? checked.value : '';
  }

  function setCategoryHelp(category) {
    let text = '';
    if (category === 'MANDATORY') {
      text = 'Metric wajib untuk fungsi Anda. Prioritaskan metric dengan status Uncompleted.';
    } else if (category === 'RECOMMENDED') {
      text = 'Metric yang direkomendasikan untuk memperkuat coverage evidence fungsi Anda.';
    } else if (category === 'GENERAL') {
      text = 'Metric terbuka di luar assignment fungsi Anda.';
    }
    categoryHelp.textContent = text;
  }

  function rebuildMetricOptions() {
    const year = yearSelect.value;
    const category = getSelectedCategory();

    metricSelect.innerHTML = '';
    metricSelect.disabled = true;
    metricInfo.style.display = 'none';

    if (!year || !category) {
      const opt = document.createElement('option');
      opt.value = '';
      opt.textContent = '-- Pilih Tahun & Kategori dulu --';
      metricSelect.appendChild(opt);
      return;
    }

    setCategoryHelp(category);

    const items = (metricCatalog[year] && metricCatalog[year][category]) ? metricCatalog[year][category] : [];
    const opt0 = document.createElement('option');
    opt0.value = '';
    opt0.textContent = items.length ? '-- Pilih Metrik --' : '-- Tidak ada metrik tersedia --';
    metricSelect.appendChild(opt0);

    items.forEach(function(item){
      const opt = document.createElement('option');
      opt.value = item.id;
      opt.textContent = item.label;
      opt.dataset.question = item.metric_question || '';
      opt.dataset.note = item.metric_note || '';
      metricSelect.appendChild(opt);
    });

    metricSelect.disabled = items.length === 0;
  }

  function onMetricChange() {
    const opt = metricSelect.options[metricSelect.selectedIndex];
    if (!opt || !opt.value) {
      metricInfo.style.display = 'none';
      return;
    }

    metricQuestion.innerHTML = opt.dataset.question || '-';
    metricNote.innerHTML = opt.dataset.note || '-';
    metricInfo.style.display = 'block';
  }

  function setSourceMode(mode) {
    if (mode === 'link') {
      linkWrap.style.display = '';
      fileWrap.style.display = 'none';
      linkInput.required = true;
      fileInput.required = false;
      fileInput.value = '';
    } else if (mode === 'file') {
      linkWrap.style.display = 'none';
      fileWrap.style.display = '';
      linkInput.required = false;
      fileInput.required = true;
      linkInput.value = '';
    }
  }

  yearSelect.addEventListener('change', rebuildMetricOptions);
  categoryRadios.forEach(function(r){
    r.addEventListener('change', rebuildMetricOptions);
  });
  metricSelect.addEventListener('change', onMetricChange);

  sourceRadios.forEach(function(r){
    r.addEventListener('change', function(){
      setSourceMode(r.value);
    });
  });
})();
</script>

<?php include __DIR__ . '/layout-close.php'; ?>