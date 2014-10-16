<div id="object-info-plan"><?php
// catalogue/info_one_plan.css

if ($this->data->count() == 1)
{
    foreach ($this->data as $value)
    {
?><div class="div-one-object-plan"><a class="thickbox" href="<?php echo $value->getSourseFileUrl(); ?>"><img src="<?php echo $value->getPreviewFileUrl(400); ?>" alt="План"/></a></div>
<?php
    }
}
?></div>