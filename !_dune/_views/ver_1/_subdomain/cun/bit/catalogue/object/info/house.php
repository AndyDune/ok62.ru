<p id="object-page-house" class="object-page"><strong>Дом</strong></p>
<div id="object-info-photo"><?php
// catalogue/info_one_photo.css

if ($this->data->count())
{
    foreach ($this->data as $value)
    {
?><div class="div-one-object-photo"><a class="thickbox" href="<?php echo $value->getSourseFileUrl(); ?>"><img src="<?php echo $value->getPreviewFileUrl(170); ?>" alt="ФОТО"/></a></div>
<?php
    }
}
?></div>