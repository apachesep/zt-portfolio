<?php
ZtPortfolioHelperToolbar::addToolBar();
$portfolio = $this->get('portfolio', null);
$categories = $this->get('categories');
foreach ($categories as $key => $category) {
    if (!is_array($category['header'])) {
        $category['header'] = json_decode($category['header']);
        $categories[$key] = $category;
    }
}
$currentCategory = null;
if (empty($portfolio)) {
    if (!empty($categories)) {
        $currentCategory = reset($categories);
    }
} else {
    foreach ($categories as $item) {
        if ($item['id'] == $portfolio['category']) {
            $currentCategory = $item;
        }
    }
}
?>
<div class="row-fluid" >
    <div class="span9">
        <div class = "form-group">
            <label class = "control-label"><?php echo(JText::_('COM_ZTPORTFOLIO_LABEL_PORTFOLIO_HEADER')); ?></label>
            <div class = "controls">
                <div id="portfolio-header-edit">
                    <?php if (!empty($currentCategory)): ?>
                        <?php
                        $html = new ZtHtml();
                        if (!empty($portfolio)) {
                            $html->set('headers', $portfolio['header']);
                        } else {
                            $html->set('headers', $currentCategory['header']);
                        }
                        echo $html->fetch('com_ztportfolio://html/portfolio.header.php');
                        ?>
                    <?php endif; ?> 
                </div>
            </div>
        </div>
        <div class = "form-group">
            <label class = "control-label"><?php echo(JText::_('COM_ZTPORTFOLIO_LABEL_PORTFOLIO_CONTENT')); ?></label>
            <div class = "controls">
                <?php
                $editor = JFactory::getConfig()->get('editor');
                $editor = JEditor::getInstance($editor);
                echo $editor->display('portfolio-content', ((!empty($portfolio) ? $portfolio['content'] : '')), 100, 50, 20, 10, true, 'portfolio-content');
                ?>
            </div>
        </div>
    </div>
    <div class="span3">
        <div class="form-group">
            <label class="control-label"><?php echo(JText::_('COM_ZTPORTFOLIO_LABEL_PORTFOLIO_TITLE')); ?></label>
            <div class="controls">
                <input id="portfolio-title" minlength="5" type="text" value="<?php echo((!empty($portfolio) ? $portfolio['title'] : '')); ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo(JText::_('COM_ZTPORTFOLIO_LABEL_PORTFOLIO_CATEGORY')); ?></label>
            <div class="controls">
                <select id="portfolio-category" onchange="portfolioLoadHeader(this);">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo($category['id']); ?>" <?php echo(($category['id'] == $portfolio['category']) ? 'selected' : ''); ?>><?php echo($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label"><?php echo(JText::_('COM_ZTPORTFOLIO_LABEL_PORTFOLIO_THUMBNAIL')); ?></label>
            <div class="controls">
                <input id="portfolio-thumbnail" minlength="5" type="text"" readonly="true" value="<?php echo((!empty($portfolio) ? $portfolio['thumbnail'] : '')); ?>">
                <div id="portfolio-file-view" class="porfolio-file-view"></div>
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        jQuery('#portfolio-file-view').fileTree({root: '', script: '<?php echo (rtrim(JUri::root(true), '/') . '/administrator/index.php?option=com_ztportfolio&task=data.explorer'); ?>'}, function (file) {
                            jQuery('#portfolio-thumbnail').val(file);
                        });
                    });
                </script>
            </div>
        </div>
        <div id="zt-portfolio-portfolio-tools">
            <?php if (empty($portfolio)): ?>
                <button onclick="portfolioCreate();" class="btn btn-success"><?php echo(JText::_('COM_ZTPORTFOLIO_BUTTON_CREATE')); ?></button>
            <?php else: ?>
                <button onclick="portfolioSave(<?php echo($portfolio['id']); ?>);" class="btn btn-success"><?php echo(JText::_('COM_ZTPORTFOLIO_BUTTON_SAVE')); ?></button>
            <?php endif; ?>
            <button onclick="portfolioCancel();" class="btn btn-default pull-right"><?php echo(JText::_('COM_ZTPORTFOLIO_BUTTON_CANCEL')); ?></button>
        </div>
    </div>
</div>