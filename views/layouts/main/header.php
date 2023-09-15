<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<header>
    <div class="container">
        <a class="logotype" href=""><img src="/images/template/logo.png" alt="Логотип FIXTIME"></a>
        <div id="block_user_guest" class="login clean popup_triger btn-show-modal-form" style="display:<?= Yii::$app->user->isGuest ? 'block' : 'none' ?>"
             data-action-url=<?= Url::to(['/login'])?>>Вход<svg><use xlink:href="#login"></use></svg>
        </div>
        <div id="block_user_authorized" class="login clean popup_triger btn-show-modal-form" style="display:<?= !Yii::$app->user->isGuest ? 'block' : 'none' ?>"
             title="Записи"
             data-action-url=<?= Url::to(['site/get-my-reservation-form/'])?>><svg><use xlink:href="#person"></use></svg>
        </div>
        <div style="<?= !Yii::$app->user->isGuest ? '' : 'display:none' ?>">
            <a class="login clean" href="<?= Url::to(['/logout'])?>"><svg><use xlink:href="#close"></use></svg></a>
        </div>
    </div>
</header>









