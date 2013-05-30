yii-maskedimage
===============

Now it's easy to create masked image with this user friendly extension. Mask your image with different shapes and dimension. More option coming in future.

Requirements 

-Developed and tested with Yii 1.1.12 but may working with older versions too 
-PHP GD library enabled.

Usage 

Extract the source file into protected/extensions folder.

Simply put this below widget in view file:

<?php $this->widget('ext.imagemask.ImageMask', array(
    'shape' => 'round',
    'imgpath' => Yii::app()->basePath.'/../images/mango.jpg',
    'width' => '200',
    'height' => '200',
    'title' => 'Sample Image',
    )); ?>
    
Available shape: round, roundedsquare, polygon, oval.
