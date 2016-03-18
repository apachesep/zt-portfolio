<?php
/**
 * @package     Zt Portfolio
 *
 * @copyright   Copyright (C) 2010 - 2015 ZooTemplate. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die();

require_once JPATH_COMPONENT . '/helpers/helper.php';
ZtPortfolioHelper::generateMeta($this->item);


$doc = JFactory::getDocument();
$doc->addStylesheet( JURI::root(true) . '/components/com_ztportfolio/assets/css/ztportfolio.css' );

$this->item->url = $_SERVER['SERVER_NAME'] . JRoute::_('index.php?option=com_ztportfolio&view=item&id='.$this->item->ztportfolio_item_id.':'.$this->item->alias );

$tags = ZtPortfolioHelper::getTags( (array) $this->item->ztportfolio_tag_id );
$newtags = array();
foreach ($tags as $tag) {
	$newtags[] 	 = $tag->title;
}

//video
if($this->item->video) {
	$video = parse_url($this->item->video);

	switch($video['host']) {
		case 'youtu.be':
		$video_id 	= trim($video['path'],'/');
		$video_src 	= '//www.youtube.com/embed/' . $video_id;
		break;

		case 'www.youtube.com':
		case 'youtube.com':
		parse_str($video['query'], $query);
		$video_id 	= $query['v'];
		$video_src 	= '//www.youtube.com/embed/' . $video_id;
		break;

		case 'vimeo.com':
		case 'www.vimeo.com':
		$video_id 	= trim($video['path'],'/');
		$video_src 	= "//player.vimeo.com/video/" . $video_id;
	}

}

?>

<div id="zt-portfolio" class="zt-portfolio zt-portfolio-view-item">
	<div class="zt-portfolio-image">
		<?php if($this->item->video) { ?>
		<div class="zt-portfolio-embed">
			<iframe src="<?php echo $video_src; ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
		</div>
		<?php } else { ?>
		<?php if($this->item->image) { ?>
		<img class="zt-portfolio-img" src="<?php echo $this->item->image; ?>" alt="<?php echo $this->item->title; ?>">
		<?php } else { ?>
		<img class="zt-portfolio-img" src="<?php echo $this->item->thumbnail; ?>" alt="<?php echo $this->item->title; ?>">
		<?php } ?>
		<?php } ?>
	</div>

	<div class="zt-portfolio-details clearfix">

		<div class="zt-portfolio-description">
			<h2><?php echo $this->item->title; ?></h2>
			<?php echo $this->item->description; ?>
		</div>

		<div class="zt-portfolio-meta">

			<div class="zt-portfolio-created">
				<h4><?php echo JText::_('COM_ZTPORTFOLIO_PROJECT_DATE'); ?></h4>
				<?php echo JHtml::_('date', $this->item->created_on, JText::_('DATE_FORMAT_LC3')); ?>
			</div>

			<div class="zt-portfolio-tags">
				<h4><?php echo JText::_('COM_ZTPORTFOLIO_PROJECT_CATEGORIES'); ?></h4>
				<?php echo implode(', ', $newtags); ?>
			</div>

			<div class="zt-portfolio-properties">
				<h4><?php echo JText::_('COM_ZTPORTFOLIO_PROJECT_PROPERTIES'); ?></h4>
				<?php 

				$properties = json_decode($this->item->properties, true);  
                if(count($properties) > 0)
    				foreach ($properties as $key => $item)
    	            {
    	                echo '<div class="control-group ">
    	                            <span><strong>' . base64_decode($item['name']) . ':</strong></span>
    	                            <span>' . base64_decode($item['value']) . '</span>
                                </div>';
    	            }
	          
				?>
				<div class="control-group ">
	                <a href="http://www.facebook.com/sharer.php?u=<?php echo $this->item->url; ?>" 
	                	class="post_share_facebook" 
	                	onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=220,width=600');return false;">
						<i class="fa fa-facebook"></i>
					</a>
	                <a href="https://twitter.com/share?url=<?php echo $this->item->url; ?>" 
	                	onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=260,width=600');return false;" 
	                	class="product_share_twitter">
						<i class="fa fa-twitter"></i>
					</a>
	                <a href="https://plus.google.com/share?url=<?php echo $this->item->url; ?>" 
	                	onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
						<i class="fa fa-google-plus"></i>
					</a>
	                <a href="http://pinterest.com/pin/create/button/?url=<?php echo $this->item->url; ?>&amp;media=<?php echo JURI::base() . $this->item->image; ?>&amp;description=" 
	                	onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
	                	<i class="fa fa-pinterest"></i>
	                </a>
                </div>
			</div>

			<?php if ($this->item->url) { ?>
			<div class="zt-portfolio-link">
				<a class="btn btn-primary" target="_blank" href="<?php echo $this->item->url; ?>"><?php echo JText::_('COM_ZTPORTFOLIO_VIEW_PROJECT'); ?></a>
			</div>
			<?php } ?>
		</div>
		
	</div>
	<div class="zt-portfolio-nav">
		<?php
		if($previous = ZtPortfolioHelper::getPreviousArticle($this->item->ztportfolio_item_id)): ?>
			<a class="btn btn-default portfolio-previous" href="<?php echo ZtPortfolioHelper::getPortfolioUrl($previous[0])?>"><?php echo $previous[0]['title']?></a>
		<?php
		endif;
		if($next = ZtPortfolioHelper::getNextArticle($this->item->ztportfolio_item_id)):
		?>
		<a class="btn btn-default portfolio-next" href="<?php echo ZtPortfolioHelper::getPortfolioUrl($next[0])?>"><?php echo $next[0]['title']?></a>
		<?php
		endif;?>
		
	</div>
</div>
