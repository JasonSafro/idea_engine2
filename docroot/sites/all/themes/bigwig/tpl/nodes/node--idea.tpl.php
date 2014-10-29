<?php
/**
* @file
* Default theme implementation to display a node.
*
* Available variables:
* - $title: the (sanitized) title of the node.
* - $content: An array of node items. Use render($content) to print them all,
* or print a subset such as render($content['field_example']). Use
* hide($content['field_example']) to temporarily suppress the printing of a
* given element.
* - $user_picture: The node author's picture from user-picture.tpl.php.
* - $date: Formatted creation date. Preprocess functions can reformat it by
* calling format_date() with the desired parameters on the $created variable.
* - $name: Themed username of node author output from theme_username().
* - $node_url: Direct URL of the current node.
* - $display_submitted: Whether submission information should be displayed.
* - $submitted: Submission information created from $name and $date during
* template_preprocess_node().
* - $classes: String of classes that can be used to style contextually through
* CSS. It can be manipulated through the variable $classes_array from
* preprocess functions. The default values can be one or more of the
* following:
* - node: The current template type; for example, "theming hook".
* - node-[type]: The current node type. For example, if the node is a
* "Blog entry" it would result in "node-blog". Note that the machine
* name will often be in a short form of the human readable label.
* - node-teaser: Nodes in teaser form.
* - node-preview: Nodes in preview mode.
* The following are controlled through the node publishing options.
* - node-promoted: Nodes promoted to the front page.
* - node-sticky: Nodes ordered above other non-sticky nodes in teaser
* listings.
* - node-unpublished: Unpublished nodes visible only to administrators.
* - $title_prefix (array): An array containing additional output populated by
* modules, intended to be displayed in front of the main title tag that
* appears in the template.
* - $title_suffix (array): An array containing additional output populated by
* modules, intended to be displayed after the main title tag that appears in
* the template.
*
* Other variables:
* - $node: Full node object. Contains data that may not be safe.
* - $type: Node type; for example, story, page, blog, etc.
* - $comment_count: Number of comments attached to the node.
* - $uid: User ID of the node author.
* - $created: Time the node was published formatted in Unix timestamp.
* - $classes_array: Array of html class attribute values. It is flattened
* into a string within the variable $classes.
* - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
* teaser listings.
* - $id: Position of the node. Increments each time it's output.
*
* Node status variables:
* - $view_mode: View mode; for example, "full", "teaser".
* - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
* - $page: Flag for the full page state.
* - $promote: Flag for front page promotion state.
* - $sticky: Flags for sticky post setting.
* - $status: Flag for published status.
* - $comment: State of comment settings for the node.
* - $readmore: Flags true if the teaser content of the node cannot hold the
* main body content.
* - $is_front: Flags true when presented in the front page.
* - $logged_in: Flags true when the current user is a logged-in member.
* - $is_admin: Flags true when the current user is an administrator.
*
* Field variables: for each field instance attached to the node a corresponding
* variable is defined; for example, $node->body becomes $body. When needing to
* access a field's raw values, developers/themers are strongly encouraged to
* use these variables. Otherwise they will have to explicitly specify the
* desired field language; for example, $node->body['en'], thus overriding any
* language negotiation rule that was previously applied.
*
* @see template_preprocess()
* @see template_preprocess_node()
* @see template_process()
*
* @ingroup themeable
*/
//var_dump($node); die;
//var_dump( array_keys($content) ); die;


$workflow_state_object = $node->field_workflow_state[LANGUAGE_NONE][0]['taxonomy_term'];
// var_dump($workflow_state_object); die;
$workflow_state_image_vars = array(
  'style_name' => 'group_banner',
  'path' => $workflow_state_object->field_photo[LANGUAGE_NONE][0]['uri'],
  'alt' => $workflow_state_object->field_photo[LANGUAGE_NONE][0]['alt'],
  'title' => $workflow_state_object->field_photo[LANGUAGE_NONE][0]['title'],
  'width' => $workflow_state_object->field_photo[LANGUAGE_NONE][0]['width'],
  'height' => $workflow_state_object->field_photo[LANGUAGE_NONE][0]['height'],
);
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php if (!$page): ?>
    <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
  <?php endif; ?>
  <?php print render($title_suffix); ?>

  <div class="content"<?php print $content_attributes; ?>>
    <div class="workflow-state-container">
      <div class="workflow-state-image">
        <?php print theme_image_style( $workflow_state_image_vars ); ?>
      </div>
      <div class="workflow-state-overlay workflow-state-overlay-background"></div>
      <div class="workflow-state-overlay workflow-state-overlay-text">
        <div class="idea-title-container">
          <div class="idea-title"><h3><?php print $node->title; ?></h3></div>
          <div class="idea-attribution">
            <?php if ($display_submitted): ?>
            <div class="submitted">
            <?php print $submitted; ?>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="workflow-state-label-container">
          <div class="workflow-state-label"><h4><?php print $workflow_state_object->name; ?></h4></div>
          <div class="workflow-state-description"><?php print $workflow_state_object->description; ?></div>
        </div>
      </div>
    </div>

    <?php if( $node->field_workflow_state[LANGUAGE_NONE][0]['tid'] == TID_IDEA_STATUS_NEW ) : ?>
    <div class="contentBox contentBox-needs-votes">
      <div class="row-fluid">
        <h3>Is this a good idea?</h3>
        <p>Vote now or leave a comment below.</p>
        <?php print render( $content['field_rating'] ); ?>
      </div>
    </div>
    <?php endif; ?>

    
    <?php if( isset($content['group_access']) && is_array($content['group_access']) ) : ?>
      <div class="contentBox contentBox-group-access">
        <div class="row-fluid">
          <h3>Group Status</h3>
          <?php print render($content['group_access']); ?>
        </div>
      </div>
    <?php endif; ?>
    
    <div class="row-fluid">
      <div class="hero-unit">
        <header>
          <h3>About the Idea</h3>
        </header>
        <?php if( isset($content['field_department']) ) : ?>
        <section class="container-field_department">
          <?php print render($content['field_department']); ?>
        </section>
        <?php endif; ?>
      
        <section class="container-body">
          <?php print render($content['body']); ?>
        </section>
        
        <?php if( isset($content['field_implementation_suggestions']) ) : ?>
        <section class="container-field_implementation_suggestions">
          <?php print render($content['field_implementation_suggestions']); ?>
        </section>
        <?php endif; ?>
        
        <?php if( isset($content['field_measureable_metrics']) ) : ?>
        <section class="container-field_measureable_metrics">
          <?php print render($content['field_measureable_metrics']); ?>
        </section>
        <?php endif; ?>
        
        <?php if( isset($content['field_file_attachments']) ) : ?>
        <section class="container-field_file_attachments">
          <?php print render($content['field_file_attachments']); ?>
        </section>
        <?php endif; ?>
      </div>
    </div>
    
    <div class="row-fluid">
      <div class="hero-unit hero-unit-approval">
        <header>
          <h3>Administrative Approval</h3>
          <p class="small">All ideas must be reviewed by Idea Engine administrators for content and Terms of Use violations. This approval does not guarantee that the idea will be implemented.</p>
        </header>
        
        <?php if( !isset($node->field_reviewed_for_terms_of_use[LANGUAGE_NONE][0]['value']) || empty($node->field_reviewed_for_terms_of_use[LANGUAGE_NONE][0]['value']) ) : ?>
        <p>This idea is under review for administrative approval</p>
        <?php else : ?>
        <p>This idea has been approved for content.</p>
        
        <?php if( isset($content['field_admin_review_by']) ) : ?>
        <section class="container-field_admin_review_by">
          <?php print render($content['field_admin_review_by']); ?>
        </section>
        <?php endif; ?>

        <?php if( isset($content['field_admin_approval_date']) ) : ?>
        <section class="container-field_admin_approval_date">
          <?php print render($content['field_admin_approval_date']); ?>
        </section>
        <?php endif; ?>
        
        <?php endif; ?>
      </div>
    </div>
    
<?php
  switch( $workflow_state_object->tid ) :
    case TID_IDEA_STATUS_REJECTED:
?>
    <div class="row-fluid">
      <div class="hero-unit hero-unit-approval">
        <header>
          <h3>Workflow State: Idea Rejected</h3>
          <p class="small"><?php print $workflow_state_object->field_extended_description[LANGUAGE_NONE][0]['value']; ?></p>
        </header>
               
        <?php if( isset($content['field_rejected_by']) ) : ?>
        <section class="container-field_rejected_by">
          <?php print render($content['field_rejected_by']); ?>
        </section>
        <?php endif; ?>

        <?php if( isset($content['field_reason_for_rejection']) ) : ?>
        <section class="container-field_reason_for_rejection">
          <?php print render($content['field_reason_for_rejection']); ?>
        </section>
        <?php endif; ?>
        
        <?php if( isset($content['field_rejection_notes']) ) : ?>
        <section class="container-field_rejection_notes">
          <?php print render($content['field_rejection_notes']); ?>
        </section>
        <?php endif; ?>
        
      </div>
    </div>
<?php
    break;
    
    case TID_IDEA_STATUS_UNDER_DEPARTMENT_REVIEW:
?>
    <div class="row-fluid">
      <div class="hero-unit hero-unit-approval">
        <header>
          <h3>Workflow State: Under Department Review</h3>
          <p class="small"><?php print $workflow_state_object->field_extended_description[LANGUAGE_NONE][0]['value']; ?></p>
        </header>

        <?php if( isset($content['field_department']) ) : ?>
        <section class="container-field_department">
          <?php print render($content['field_department']); ?>
        </section>
        <?php endif; ?>
        
        <?php if( isset($content['field_sent_to_department_on']) ) : ?>
        <section class="container-field_sent_to_department_on">
          <?php print render($content['field_sent_to_department_on']); ?>
        </section>
        <?php endif; ?>
        
        <?php if( isset($content['field_rating']) ) : ?>
        <section class="container-field_rating">
          <?php print render($content['field_rating']); ?>
        </section>
        <?php endif; ?>
        
      </div>
    </div>
<?php
    break;
    
    case TID_IDEA_STATUS_READY_FOR_IMPLEMENTATION:
?>
    <div class="row-fluid">
      <div class="hero-unit hero-unit-approval">
        <header>
          <h3>Workflow State: Ready for Implementation</h3>
          <p class="small"><?php print $workflow_state_object->field_extended_description[LANGUAGE_NONE][0]['value']; ?></p>
        </header>
               
        <?php if( isset($content['field_department']) ) : ?>
        <section class="container-field_department">
          <?php print render($content['field_department']); ?>
        </section>
        <?php endif; ?>
        
        <?php if( isset($content['field_implementation_deadline']) ) : ?>
        <section class="container-field_implementation_deadline">
          <?php print render($content['field_implementation_deadline']); ?>
        </section>
        <?php endif; ?>
        
        <?php if( isset($content['field_implementation_plan']) ) : ?>
        <section class="container-field_implementation_plan">
          <?php print render($content['field_implementation_plan']); ?>
        </section>
        <?php endif; ?>
        
      </div>
    </div>
<?php
    break;
  endswitch;
?>

  </div>

  <?php print render($content['links']); ?>
  <?php print render($content['comments']); ?>
</div> 