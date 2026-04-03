<?php get_header(); ?>

<div class="container py-5">

<h1 class="mb-5 text-center"><?php esc_html_e('Upcoming Events', 'jw-event-manager'); ?></h1>

<?php
/** Render the archive filter form. */
?>

<form method="GET" class="mb-5">

<input type="text" name="keyword" placeholder="<?php esc_attr_e('Search events', 'jw-event-manager'); ?>" value="<?php echo isset($_GET['keyword']) ? esc_attr(sanitize_text_field(wp_unslash($_GET['keyword']))) : ''; ?>">

<input type="date" name="event_date" value="<?php echo isset($_GET['event_date']) ? esc_attr(sanitize_text_field(wp_unslash($_GET['event_date']))) : ''; ?>">

<select name="event_type">
<option value=""><?php esc_html_e('All Types', 'jw-event-manager'); ?></option>

<?php
$terms = get_terms([
'taxonomy'=>'event_type',
'hide_empty'=>false
]);

foreach($terms as $term){
    printf(
        '<option value="%1$s" %2$s>%3$s</option>',
        esc_attr($term->slug),
        selected(isset($_GET['event_type']) ? sanitize_title(wp_unslash($_GET['event_type'])) : '', $term->slug, false),
        esc_html($term->name)
    );
}
?>

</select>

<button type="submit"><?php esc_html_e('Filter', 'jw-event-manager'); ?></button>

</form>

<div class="row">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php 
$event_date = get_post_meta(get_the_ID(),'date',true);
$location   = get_post_meta(get_the_ID(),'loc',true);
$published_date = get_the_date();
?>

<div class="col-md-4 mb-4">

<div class="jwem-card bg-white">

<?php if (has_post_thumbnail()) : ?>
<img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" class="img-fluid w-100" alt="<?php echo esc_attr(get_the_title()); ?>">
<?php endif; ?>

<div class="p-4">

<h4 class="mb-2"><?php echo esc_html(get_the_title()); ?></h4>

<div class="jwem-meta mb-2">
📅 <?php esc_html_e('Event Date:', 'jw-event-manager'); ?>
<strong>
<?php echo $event_date ? esc_html(date_i18n(get_option('date_format'), strtotime($event_date))) : esc_html__('TBA', 'jw-event-manager'); ?>
</strong>
</div>

<div class="jwem-meta mb-2">
📍 <?php esc_html_e('Location:', 'jw-event-manager'); ?>
<strong>
<?php echo $location ? esc_html($location) : esc_html__('Not specified', 'jw-event-manager'); ?>
</strong>
</div>

<div class="jwem-meta mb-3">
🕒 <?php esc_html_e('Published:', 'jw-event-manager'); ?>
<?php echo esc_html(get_the_date()); ?>
</div>

<p>
<?php echo esc_html(wp_trim_words(wp_strip_all_tags(get_the_excerpt()),15)); ?>
</p>

<a href="<?php echo esc_url(get_permalink()); ?>" class="jwem-view-details"><?php esc_html_e('View Details', 'jw-event-manager'); ?></a>

</div>

</div>

</div>

<?php endwhile; else: ?>

<p class="text-center"><?php esc_html_e('No events found.', 'jw-event-manager'); ?></p>

<?php endif; ?>

</div>

</div>

<?php get_footer(); ?>
