<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<?php  Loader::element('header_required'); 
?>
  
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyCAN9glhycnT_BKO557Zm2ncVDFPImMxdY&sensor=false"></script>
    <script src="//google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
    <script type="text/javascript" src="//use.typekit.net/lxq4ddc.js"></script>
    <script type="text/javascript">try{Typekit.load();}catch(e){}</script>

    <script src="<?=$this->getThemePath()?>/js/js-url.min.js"></script>
    <script src="<?=$this->getThemePath()?>/js/jquery.cookie.js"></script>
    <script src="//cdn.jsdelivr.net/flexslider/2.1/jquery.flexslider-min.js"></script>
    <script src="//cdn.jsdelivr.net/colorbox/1.4.4/jquery.colorbox-min.js"></script>

    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/bootstrap.wysihtml5/0.0.2/bootstrap-wysihtml5-0.0.2.min.js"></script>

    <script src="//cdn.jsdelivr.net/bootstrap.datepicker/0.1/js/bootstrap-datepicker.js"></script>
    <script src="//cdn.jsdelivr.net/spinjs/1.3.0/spin.min.js"></script>
    <script src="<?=$this->getThemePath()?>/js/jquery.calendar.js"></script>
    <script src="//cdn.jsdelivr.net/jquery.mcustomscrollbar/2.8.1/jquery.mCustomScrollbar.min.js"></script>
    <script src="<?=$this->getThemePath()?>/js/Eventbrite.jquery.js"></script>  
    <script src="//cdn.jsdelivr.net/modernizr/2.6.2/modernizr.min.js" type="text/javascript"></script>
 
    <script src="<?php echo $this->getThemePath()?>/js/main.js" type="text/javascript"></script>
    <script src="<?php echo $this->getThemePath()?>/js/app.js" type="text/javascript"></script>

    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?=$this->getStyleSheet('colorbox/colorbox.css')?>" />
    <link rel="stylesheet" href="//use.typekit.net/c/47d109/freight-sans-pro:i4:n3:n4:n5:n6:n7.TJC:N:2,TJ8:N:2,TJB:N:2,TJD:N:2,TJG:N:2,TJJ:N:2/d?3bb2a6e53c9684ffdc9a9bf01f5b2a62dc1020e61a7e41334f5590cfa9d950886e9d44ce579f893fbc5c512cf25da9af1c1dbc4fdcb233f6f8050029239c0599aa6ab7b6cb5962a391ac07cf5a57eff53c4963fb7c78a1f2c4c7a9b2b9d701b6adddcfc6ad97eacdd287c11f2e08f018bd743d77e7b3dfd6a90ffa7a9c4f0fd55979ffa3ce1d0aa3f68b7b750d6676b2cd4d3564924327e06044485e4e1fa118dbc6d748c6" />
    <link rel="stylesheet" href="<?php echo $this->getStyleSheet('/css/screen.css')?>">
</head>
