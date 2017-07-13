<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$itemCount = 0;
?>
<ul class="list-view<?php echo $moduleclass_sfx; ?>">
		<?php
      foreach ($list as $item) :
      $itemCount++;
    ?>
			<li class="<?php echo $itemCount == 1? 'item-first':''; ?>">
          <?php  
          //Get images 
          $images = "";
          if (isset($item->images)) {
            $images = json_decode($item->images);
          }
          $imgexists = (isset($images->image_intro) and !empty($images->image_intro)) || (isset($images->image_fulltext) and !empty($images->image_fulltext));
          
          if ($imgexists) {			
          $images->image_intro = $images->image_intro?$images->image_intro:$images->image_fulltext;
          ?>
      
          <div class="item-image">
            <img src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo $item->title; ?>" />
          </div>
          <?php } ?>
          
          <h3 class="item-title">
            <?php if ($params->get('link_titles') == 1) : ?>
              <a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
                <?php echo $item->title; ?>
              </a>
            <?php else : ?>
              <?php echo $item->title; ?>
            <?php endif; ?>
          </h3>
          
				<?php if ($params->get('show_introtext')) : ?>
					<p class="mod-articles-category-introtext">
						<?php echo $item->displayIntrotext; ?>
					</p>
				<?php endif; ?>
	
			</li>
		<?php endforeach; ?>
</ul>
