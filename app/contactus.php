<?php require_once '../vendor/autoload.php'; ?>
<?php $loader = new \Twig\Loader\FilesystemLoader('../views/'); ?>

<?php $twig = new \Twig\Environment($loader); ?>

<?php echo $twig->render('contactus.html'); ?>