<?php
$section_data = $this->getData() ?? [];
?>

<div class="section-header">
  <?php if (isset($section_data['badge']) && is_array($section_data['badge'])): ?>
    <div class="section-badge">
      <i class="<?= $section_data['badge']['icon'] ?? 'fas fa-star' ?>"></i>
      <span><?= $section_data['badge']['text'] ?? 'Section' ?></span>
    </div>
  <?php endif; ?>

  <?php if (isset($section_data['title']) && is_array($section_data['title'])): ?>
    <h2 class="section-title">
      <?= $section_data['title']['main'] ?? 'Section Title' ?>
      <?php if (isset($section_data['title']['highlight'])): ?>
        <span class="highlight"><?= $section_data['title']['highlight'] ?></span>
      <?php endif; ?>
    </h2>
  <?php endif; ?>

  <?php if (isset($section_data['description'])): ?>
    <p class="section-description">
      <?= $section_data['description'] ?>
    </p>
  <?php endif; ?>
</div>
