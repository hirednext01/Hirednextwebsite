<?php
/**
 * CTA Button Component
 * Usage: <?= $this->include('components/cta_button', $button_data) ?>
 * 
 * $button_data structure:
 * [
 *     'text' => 'Get In Touch',
 *     'url' => 'contact',
 *     'type' => 'primary', // primary, secondary, outline
 *     'icon' => 'fas fa-arrow-right',
 *     'size' => 'large', // large, medium, small
 *     'target' => '_blank' // optional
 * ]
 */

// Get the data passed to this component
$button_data = $this->getData() ?? [];

// Set default values
$text = $button_data['text'] ?? 'Button';
$url = $button_data['url'] ?? '#';
$type = $button_data['type'] ?? 'primary';
$icon = $button_data['icon'] ?? null;
$size = $button_data['size'] ?? null;
$target = $button_data['target'] ?? null;

// Build button class
$button_class = 'btn btn-' . $type;
if ($size) {
    $button_class .= ' btn-' . $size;
}

// Build target attribute
$target_attr = $target ? ' target="' . $target . '"' : '';
?>

<a href="<?= base_url($url) ?>" class="<?= $button_class ?>"<?= $target_attr ?>>
  <?php if ($icon): ?>
    <i class="<?= $icon ?>"></i>
  <?php endif; ?>
  <span><?= $text ?></span>
</a>
