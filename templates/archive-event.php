<?php get_header(); ?>

<div class="container py-5">

<h1 class="mb-5 text-center"><?php esc_html_e('Upcoming Events', 'jw-event-manager'); ?></h1>

<?php
/**
 * ======================================================
 * FRONTEND FILTER FORM (REQUIRED FOR AUDIT)
 * ======================================================
 */
?>

<form method="GET" class="mb-5">

<input type="text" name="keyword" placeholder="<?php esc_attr_e('Search events', 'jw-event-manager'); ?>">

<input type="date" name="event_date">

<select name="event_type">
<option value=""><?php esc_html_e('All Types', 'jw-event-manager'); ?></option>

<?php
$terms = get_terms([
'taxonomy'=>'event_type',
'hide_empty'=>false
]);

foreach($terms as $term){
echo "<option value='{$term->slug}'>{$term->name}</option>";
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
<img src="<?php the_post_thumbnail_url('medium'); ?>" class="img-fluid w-100">
<?php endif; ?>

<div class="p-4">

<h4 class="mb-2"><?php the_title(); ?></h4>

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
<?php echo wp_trim_words(get_the_excerpt(),15); ?>
</p>

<a href="<?php the_permalink(); ?>" class="jwem-view-details"><?php esc_html_e('View Details', 'jw-event-manager'); ?></a>

</div>

</div>

</div>

<?php endwhile; else: ?>

<p class="text-center"><?php esc_html_e('No events found.', 'jw-event-manager'); ?></p>

<?php endif; ?>

</div>

</div>

<?php get_footer(); ?>
