<?php // var_dump( array_keys($fields) ); ?>
<a href="<?php print url('node/'.$fields['nid']->raw); ?>">
  <div class="one-challenge-container">
    <?php print $fields['field_flare_image']->content; ?>
    <div class="one-challenge-overlay one-challenge-overlay-<?php print ($fields['field_group_status_1']->content==TID_GROUP_STATUS_ARCHIVE ? 'archive' : 'active'); ?>">
      <div class="text-container">
        <?php print $fields['title']->content; ?>
        <?php if( $fields['field_group_status_1']->content == TID_GROUP_STATUS_ARCHIVE ) : ?>
          <div class="challenge-status-message challenge-status-message-archive">This challenge has ended</div>
        <?php else : ?>
          <div class="challenge-status-message challenge-status-message-active">Answer the challenge!</div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</a>