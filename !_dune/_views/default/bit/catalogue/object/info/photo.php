<div id="object-info-photo"><?php
// catalogue/info_one_photo.css

if ($this->data->count())
{
    foreach ($this->data as $value)
    {
?><div class="div-one-object-photo"><a class="thickbox" href="<?php echo $value->getSourseFileUrl(); ?>"><img src="<?php echo $value->getPreviewFileUrl(180); ?>" alt="тнрн"/></a></div>
<?php
    }
}
?></div>