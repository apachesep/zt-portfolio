<?php


//echo '<pre>';
//print_r($portfolios);
//die;
?>

<div class="portfolio-wrap">
    <div class="portfolio-header">
        <div class="portfolio-header-center">
            <div class="portfolio-header-center-left">
                <div class="portfolio-header-center-left-title"><?php echo(JText::_('MOD_ZTPORTFOLIO_ALL_CATEGORY')); ?></div>
            </div>
            <div class="portfolio-header-center-right">
                <div data-filter="all" class="zt_filter filter-all"><?php echo(JText::_('MOD_ZTPORTFOLIO_ALL_CATEGORY')); ?></div>
                <?php foreach ($tags as $tag): ?>
                    <?php $class = $tag['alias']; ?>
                    <?php $filter[] = $class; ?>
                    <div data-filter="<?php echo $class; ?>" class="zt_filter filter-<?php echo $class; ?>"><?php echo($tag['title']); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="portfolio-content">
        <div class="portfolio-content-center">
            <?php foreach ($portfolios as $portfolio): ?>
                <?php $portfolio['ztportfolio_tag_id'] = json_decode($portfolio['ztportfolio_tag_id']); ?>
                <?php $class = array(); ?>
                <?php foreach ($portfolio['ztportfolio_tag_id'] as $id): ?>
                    <?php $portfolioTag = ModZtPortfolioHelper::getTag($id); ?>
                    <?php $class[] = $portfolioTag['alias']; ?>
                <?php endforeach; ?>
                <?php  ?>
                <div class="<?php echo(implode(' ', $class));  ?> gird-common all" style="background-image: url('<?php echo ModZtPortfolioHelper::getUrl($portfolio['image']); ?>');">
                    <a href="<?php echo(ModZtPortfolioHelper::getUrl('/index.php?module=mod_ztporfolio&show=' . $portfolio['ztportfolio_item_id'])); ?>"><?php echo($portfolio['title']); ?></a>
                    <div><?php echo($portfolio['url']); ?></div>
                    <div><?php echo($portfolio['description']); ?></div>
                    <div><?php echo($portfolio['video']); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(window).load(function () {
        var $ = jQuery;
        $('.portfolio-content-center').masonry({
            columnWidth: 200,
            itemSelector: '.gird-common'
        });
        var button_class = "portfolio-header-center-right-links-current";
        var $container = $('.portfolio-content-center');
        
        $('.zt_filter').click(function () {
            $container.isotope({filter: '.' + $(this).data('filter')});
            console.log('.' + $(this).data('filter'));
            $('.portfolio-header-center-right-links').removeClass(button_class);
            $(this).addClass(button_class);
            $container.isotope();
        });

    });
</script>

<?php
if($readmore == 1){
    ?>
    <input type="button" value="Read more" class="zt_readmore">
    <?php
}
?>
