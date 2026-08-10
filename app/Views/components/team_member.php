<div class="team-member">
  <div class="member-image">
    <?php if (!empty($member_data['image'])): ?>
      <img
        src="<?= $member_data['image'] ?>"
        alt="<?= $member_data['name'] ?>"
        class="member-photo"
      />
    <?php else: ?>
      <div class="member-photo-placeholder">
        <i class="fas fa-user"></i>
      </div>
    <?php endif; ?>
  </div>
  <div class="member-info">
    <h3 class="member-name"><?= $member_data['name'] ?></h3>
    <p class="member-role"><?= $member_data['role'] ?></p>
    <p class="member-bio"><?= $member_data['bio'] ?></p>
    
    <?php if (isset($member_data['email']) || isset($member_data['linkedin'])): ?>
      <div class="member-social">
        <?php if (isset($member_data['email'])): ?>
          <a href="mailto:<?= $member_data['email'] ?>" class="social-link" title="Email">
            <i class="fas fa-envelope"></i>
          </a>
        <?php endif; ?>
        
        <?php if (isset($member_data['linkedin'])): ?>
          <a href="<?= $member_data['linkedin'] ?>" class="social-link" target="_blank" title="LinkedIn">
            <i class="fab fa-linkedin"></i>
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
