<?php
$hero_data = $this->getData() ?? [];
?>

<section class="hero hero-services" id="hero">
  <div class="container">
    <div class="hero-content">
      <?php if (isset($hero_data['badge']) && is_array($hero_data['badge'])): ?>
        <div class="hero-badge">
          <i class="<?= $hero_data['badge']['icon'] ?? 'fas fa-star' ?>"></i>
          <span><?= $hero_data['badge']['text'] ?? 'Welcome' ?></span>
        </div>
      <?php endif; ?>

      <?php if (isset($hero_data['title']) && is_array($hero_data['title'])): ?>
        <h1 class="hero-title">
          <?= $hero_data['title']['main'] ?? 'Welcome' ?>
          <?php if (isset($hero_data['title']['gradient'])): ?>
            <br />
            <span class="gradient-text"><?= $hero_data['title']['gradient'] ?></span>
          <?php endif; ?>
        </h1>
      <?php endif; ?>

      <?php if (isset($hero_data['description'])): ?>
        <p class="hero-description">
          <?= $hero_data['description'] ?>
        </p>
      <?php endif; ?>

      <?php if (isset($hero_data['buttons']) && is_array($hero_data['buttons']) && !empty($hero_data['buttons'])): ?>
        <div class="hero-buttons">
          <?php foreach ($hero_data['buttons'] as $button): ?>
            <?php if (is_array($button)): ?>
              <a href="<?= base_url($button['url'] ?? '#') ?>" class="btn btn-<?= $button['type'] ?? 'primary' ?> btn-large">
                <?php if (isset($button['icon'])): ?>
                  <i class="<?= $button['icon'] ?>"></i>
                <?php endif; ?>
                <span><?= $button['text'] ?? 'Button' ?></span>
              </a>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php if (isset($hero_data['stats']) && is_array($hero_data['stats']) && !empty($hero_data['stats'])): ?>
        <div class="hero-stats">
          <?php foreach ($hero_data['stats'] as $stat): ?>
            <?php if (is_array($stat)): ?>
              <div class="stat-item">
                <div class="stat-icon">
                  <i class="<?= $stat['icon'] ?? 'fas fa-star' ?>"></i>
                </div>
                <div class="stat-number"><?= $stat['number'] ?? '0' ?></div>
                <div class="stat-label"><?= $stat['label'] ?? 'Label' ?></div>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
