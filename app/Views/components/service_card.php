<?php
  // Parse images from service data
  $images = [];
  if (!empty($service_data['image'])) {
    if (is_string($service_data['image'])) {
      // Try to parse as JSON
      $decoded = json_decode($service_data['image'], true);
      if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        $images = array_filter($decoded, function($img) {
          return !empty(trim($img));
        });
      } else {
        // Single image string
        $trimmed = trim($service_data['image']);
        if (!empty($trimmed)) {
          $images = [$trimmed];
        }
      }
    } elseif (is_array($service_data['image'])) {
      $images = array_filter($service_data['image'], function($img) {
        return !empty(trim($img));
      });
    }
  }
  
  // Check if image is actually an image URL/path or a FontAwesome icon
  $hasImages = false;
  $imageUrls = [];
  foreach ($images as $img) {
    $img = trim($img);
    if (empty($img)) continue;
    
    // Check if it's an image URL/path
    $isImage = (
      strpos($img, 'http://') === 0 ||
      strpos($img, 'https://') === 0 ||
      strpos($img, 'uploads/') !== false ||
      strpos($img, '/uploads/') !== false ||
      preg_match('/\.(jpg|jpeg|png|gif|webp|svg)(\?.*)?$/i', $img)
    );
    
    if ($isImage) {
      $hasImages = true;
      // If it's a relative path, add base_url
      if (strpos($img, 'http://') !== 0 && strpos($img, 'https://') !== 0) {
        // Remove leading slash if present to avoid double slashes
        $img = ltrim($img, '/');
        $imageUrls[] = base_url($img);
      } else {
        $imageUrls[] = $img;
      }
    }
  }
  
  // Get icon (fallback or from icon field)
  $icon = $service_data['icon'] ?? 'fa-solid fa-briefcase';
?>
<div class="service-card">
  <?php if ($hasImages && !empty($imageUrls)): ?>
    <!-- Image Gallery -->
    <div class="service-image-gallery">
      <?php if (count($imageUrls) === 1): ?>
        <!-- Single Image -->
        <div class="service-image-single">
          <img src="<?= esc($imageUrls[0]) ?>" alt="<?= esc($service_data['title']) ?>" loading="lazy" />
        </div>
      <?php else: ?>
        <!-- Multiple Images - Carousel -->
        <div class="service-image-carousel" data-carousel-id="service-<?= $service_data['id'] ?? uniqid() ?>">
          <div class="service-carousel-container">
            <?php foreach ($imageUrls as $idx => $imgUrl): ?>
              <div class="service-carousel-slide <?= $idx === 0 ? 'active' : '' ?>">
                <img src="<?= esc($imgUrl) ?>" alt="<?= esc($service_data['title']) ?> - Image <?= $idx + 1 ?>" loading="<?= $idx === 0 ? 'eager' : 'lazy' ?>" />
              </div>
            <?php endforeach; ?>
          </div>
          <?php if (count($imageUrls) > 1): ?>
            <div class="service-carousel-controls">
              <button class="service-carousel-prev" aria-label="Previous image">
                <i class="fa-solid fa-chevron-left"></i>
              </button>
              <div class="service-carousel-indicators">
                <?php foreach ($imageUrls as $idx => $imgUrl): ?>
                  <button class="service-carousel-indicator <?= $idx === 0 ? 'active' : '' ?>" data-slide="<?= $idx ?>" aria-label="Go to image <?= $idx + 1 ?>"></button>
                <?php endforeach; ?>
              </div>
              <button class="service-carousel-next" aria-label="Next image">
                <i class="fa-solid fa-chevron-right"></i>
              </button>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  <?php else: ?>
    <!-- Icon Fallback -->
    <div class="service-icon">
      <i class="<?= esc($icon) ?>"></i>
    </div>
  <?php endif; ?>
  
  <h3 class="service-title"><?= esc($service_data['title']) ?></h3>
  <p class="service-description"><?= esc($service_data['description']) ?></p>
  
  <?php 
    $features = [];
    if (isset($service_data['features']) && !empty($service_data['features'])) {
      if (is_string($service_data['features'])) {
        $decoded = json_decode($service_data['features'], true);
        $features = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : [];
      } elseif (is_array($service_data['features'])) {
        $features = $service_data['features'];
      }
    }
  ?>
  <?php if (!empty($features)): ?>
    <ul class="service-features">
      <?php foreach (array_slice($features, 0, 4) as $feature): ?>
        <li><?= esc($feature) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  
  <?php if (isset($service_data['cta_url']) || isset($service_data['cta_text'])): ?>
    <div class="service-cta">
      <a href="<?= base_url($service_data['cta_url'] ?? 'contact') ?>" class="btn btn-secondary">
        <span><?= esc($service_data['cta_text'] ?? 'Learn More') ?></span>
        <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  <?php endif; ?>
</div>
