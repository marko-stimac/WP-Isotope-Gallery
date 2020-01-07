<?php

/**
 * Load scripts and images, show component
 */

namespace ms\IsotopeGallery;

defined('ABSPATH') || exit;

class IsotopeGallery
{

	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'registerScripts'));
	}


	/**
	 * Register scripts and styles
	 */
	public function registerScripts()
	{
		wp_register_style('fancybox', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css');
		wp_register_style('isotope-gallery', plugins_url('/assets/isotope-gallery.css', __DIR__), array('fancybox'));

		wp_register_script('fancybox', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js', array('jquery'), null, true);
		wp_register_script('isotope', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js', array('jquery'), null, true);
		wp_register_script('isotope-gallery', plugins_url('/assets/isotope-gallery.js', __DIR__), array('fancybox', 'isotope', 'jquery'), null, true);
	}

	/**
	 * Enqueue scripts and styles
	 */
	public function enqueueScripts()
	{
		wp_enqueue_style('isotope-gallery');
		wp_enqueue_script('isotope-gallery');
	}

	/**
	 * Create slug from string
	 * https://stackoverflow.com/a/40642103/5723816
	 */
	public function createSlug($str, $delimiter = '-')
	{

		$slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
		return $slug;
	}

	/**
	 * Show category buttons
	 */
	public function showCategoryButtons($page_id)
	{
		// Get categories
		$cats = [];
		if (have_rows('isotope_repeater', $page_id)) :
			while (have_rows('isotope_repeater', $page_id)) : the_row();

				$cat = get_sub_field('isotope_category');

				// Prepare array of category slug and name, if image has multiple tags explode it
				$exploded = explode(',', $cat);
				foreach ($exploded as $cat) {
					$cats[] = array(
						'slug' => trim($this->createSlug($cat)),
						'name' => trim($cat)
					);
				}

			endwhile;
		endif;

		// Count how many items are in a category
		$item_count = array_count_values(array_map(function ($foo) {
			return $foo['slug'];
		}, $cats));

		// Remove duplicates
		$cats = array_unique($cats, SORT_REGULAR);

		// Show buttons
		foreach ($cats as $cat) :
?>
<button class="isotope__btn btn" data-filter=".<?php echo $cat['slug']; ?>">
	<?php echo $cat['name']; ?>
	<span class="isotope__btn-count"><?php echo $item_count[$cat['slug']]; ?></span>
</button>
<?php
		endforeach;
	}

	/**
	 * Show images
	 */
	public function showImages($page_id)
	{

		if (have_rows('isotope_repeater', $page_id)) :
			while (have_rows('isotope_repeater', $page_id)) : the_row();

				$img = get_sub_field('isotope_image');

				// Thumbnail sizes
				$image_size = get_row_index() % 2 === 0 ? 'isotope-vertical' : 'isotope-horizontal';
				$img_thumb = wp_get_attachment_image_src($img['ID'], $image_size);

				// Full size image for popup
				$img_full = wp_get_attachment_image_src($img['ID'], 'full');

				// Prepare classes for filtering
				$cats = explode(',', get_sub_field('isotope_category'));
				$classes = array();
				foreach ($cats as $cat)
					$classes[] = trim($this->createSlug($cat));
			?>

<a href="<?php echo $img_full[0]; ?>" class="isotope__link isotope__link--<?php echo $image_size; ?> <?php echo implode(' ', $classes); ?> js-isotope__link js-fancybox" data-fancybox="group">
	<img src="<?php echo $img_thumb[0]; ?>" class="isotope__img isotope__img--<?php echo $image_size; ?>">
</a>

<?php
			endwhile;
		else :
			echo 'Notice: There are no images added for Isotope';
		endif;
	}

	/**
	 * Isotope component
	 */
	public function showComponent($atts)
	{
		$this->enqueueScripts();

		// If page ID is passed use it, or just use current page ID
		$atts = shortcode_atts(array('id' => ''), $atts);
		$page_id = !empty($atts['id']) ? $atts['id'] : get_the_ID();

		ob_start(); ?>

<div class="isotope">
	<div class="isotope__buttons js-isotope__buttons">
		<button class="isotope__btn btn is-checked" data-filter="*"><?php _e('All', 'ms-isotope-gallery'); ?></button>
		<?php $this->showCategoryButtons($page_id); ?>
	</div>
	<div class="isotope__gallery js-isotope__gallery">
		<?php $this->showImages($page_id); ?>
	</div>
</div>

<?php
		return ob_get_clean();
	}
}