<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
//use yii\bootstrap\Alert;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- <script src="https://cdn.socket.io/socket.io-1.3.6.js"></script> -->
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Yii2CRM',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'Clients', 'url' => ['/clients/index']],
                ['label' => 'Contact', 'url' => ['/site/contact']],
                ['label' => 'Socket', 'url' => ['/site/socket']],
				//['label' => 'About', 'url' => ['/site/about']],
                //['label' => 'Chat', 'url' => ['/site/chat']],					
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
            $info = '1121312';
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>

        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; Yii2CRM <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    <?php
    //Получение информации о текущем пользователе для использования в Сокете
        if(Yii::$app->user->isGuest){
            $userId ='Guest';
            $currUser = ''; 
        }else{
            $userId = Yii::$app->user->identity->id;
            $currUser = Yii::$app->user->identity->username; 
        };

                       
    ?>
<script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
<script src="http://code.jquery.com/jquery-1.11.1.js"></script>
<script>
    var socket = io.connect('http://vm12721.hv8.ru:9090');
    //Заглушка для того, чтобы отправитель не получал уведомления в свои же открытые вкладки
    //Не уверен на сколько это правильно, но другого решения пока не нашёл
    socket.on('message', function(msg){
        if((msg.split('@')[0]).trim() != '<?= $currUser ?>')
            alert(msg);
    });
    //Эмитируем сообщение с указанием id текущего пользователя с каждой страницы 
    socket.emit('connectUser', '<?= $userId ?>');
</script>
</body>
</html>
<?php $this->endPage() ?>
