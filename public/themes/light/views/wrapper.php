<?php
defined('VONZO') OR exit();
$v = rand(0, 10000);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title><?=e($this->docTitle())?></title>
    <meta name="description" content="<?=e($this->docMetaDesc())?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="<?=$data['url']?>/<?=$data['theme_path']?>/<?=$data['settings']['site_theme']?>/assets/images/favicon-32x32-dev.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <?php if($data['settings']['seo_privacy']): ?><meta name="referrer" content="same-origin"><?php endif ?>
    <link href="<?=$data['url']?>/<?=$data['theme_path']?>/<?=$data['settings']['site_theme']?>/assets/images/logos/favicon.png" rel="icon">
    <?php foreach(['jquery.flex-images', 'selectize.bootstrap3', 'style'] as $name): ?><link href="<?=$data['url']?>/<?=$data['theme_path']?>/<?=$data['settings']['site_theme']?>/assets/css/<?=$name?>.css?v=<?php echo $v;?>" rel="stylesheet" type="text/css">
    <?php endforeach ?>
    <script src="https://kit.fontawesome.com/d9ea851589.js" crossorigin="anonymous"></script>

</head>
<body>
    <div id="loading-bar"></div>
    <?=$data['header_view']?>
    <?=$data['content_view']?>
    <?=$data['footer_view']?>
</body>
<?php foreach(['jquery', 'jquery-ui', 'jquery.flex-images', 'dragscroll', 'jquery.tagsinput', 'paste', 'selectize.min', 'functions'] as $name): ?><script type="text/javascript" src="<?=$data['url']?>/<?=$data['theme_path']?>/<?=$data['settings']['site_theme']?>/assets/js/<?=$name?>.js"></script>
<?php endforeach ?>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</html>
