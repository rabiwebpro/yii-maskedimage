<?php
class ImageMask extends CWidget {


public $shape = 'round';
public $imgpath = 'http://www.yiiframework.com/files/logo/yii.png';
public $maskpath = 'http://www.yiiframework.com/files/logo/yii.png';
public $maskimg = 'roundmask.png';
public $width = '100';
public $height = '100';
public $title = 'Masked Image';


public function init() {


if ($this->shape == 'round')
            $this->maskimg = 'roundmask.png';
			
if ($this->shape == 'oval')
            $this->maskimg = 'ovalmask.png';
			
if ($this->shape == 'roundedsquare')
            $this->maskimg = 'roundsquaremask.png';
			
if ($this->shape == 'polygon')
            $this->maskimg = 'polygonmask.png';
			


$this->maskpath = dirname(__FILE__) . '/' . 'assets'. '/' .$this->maskimg;



$srcpath = pathinfo($this->imgpath);
$basename = $srcpath['basename'];
$extensionname = $srcpath['extension'];
$mainfilename = $srcpath['filename'];


if($extensionname=='jpg' ||  $$extensionname=='jpeg'){
$source = @imagecreatefromjpeg($this->imgpath);	
}elseif($extensionname=='png'){
$source = @imagecreatefrompng($this->imgpath);	
}if($extensionname=='gif'){
$source = @imagecreatefromgif($this->imgpath);	
}


$mask = @imagecreatefrompng($this->maskpath);
$this->imagealphamask( $source, $mask );


$filename = $mainfilename.'.png';

$path=Yii::getPathOfAlias('webroot.images') . '/';
$file=$path.$filename;
			
$mainimg = @imagepng( $source,$file);
@ImageDestroy($source);

$maskimagesource = Yii::app()->getBaseUrl().'/images/'.$filename;

echo '<img src="'. $maskimagesource .'" alt="'.$filename.'" title="'.$this->title.'" width="'.$this->width.'" height="'.$this->height.'" border="0" />';			
}

protected function imagealphamask(&$picture, $mask ) {
    
    $xSize = imagesx( $picture );
    $ySize = imagesy( $picture );
    $newPicture = imagecreatetruecolor( $xSize, $ySize );
    imagesavealpha( $newPicture, true );
    imagefill( $newPicture, 0, 0, imagecolorallocatealpha( $newPicture, 0, 0, 0, 127 ) );

    
    if( $xSize != imagesx( $mask ) || $ySize != imagesy( $mask ) ) {
        $tempPic = imagecreatetruecolor( $xSize, $ySize );
        imagecopyresampled( $tempPic, $mask, 0, 0, 0, 0, $xSize, $ySize, imagesx( $mask ), imagesy( $mask ) );
        imagedestroy( $mask );
        $mask = $tempPic;
    }

    
    for( $x = 0; $x < $xSize; $x++ ) {
        for( $y = 0; $y < $ySize; $y++ ) {
            $alpha = imagecolorsforindex( $mask, imagecolorat( $mask, $x, $y ) );
            $alpha = 127 - floor( $alpha[ 'red' ] / 2 );
            $color = imagecolorsforindex( $picture, imagecolorat( $picture, $x, $y ) );
            imagesetpixel( $newPicture, $x, $y, imagecolorallocatealpha( $newPicture, $color[ 'red' ], $color[ 'green' ], $color[ 'blue' ], $alpha ) );
        }
    }

    
    imagedestroy( $picture );
    $picture = $newPicture;
}


	
}

?>

