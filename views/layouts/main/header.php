<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<header>
    <div class="container">
        <a class="logotype" href=""><img src="/images/company_<?= \Yii::$app->controller->company->id?>.png" alt="Логотип FIXTIME"></a>
        <div id="block_user_guest" class="login clean popup_triger btn-show-modal-form" style="display:<?= Yii::$app->user->isGuest ? 'flex' : 'none' ?>"
             title="Вхід"
             data-action-url=<?= Url::to(['/login'])?>>Вхід<svg><use xlink:href="#login"></use></svg>
        </div>
        <div id="block_user_authorized" class="login clean popup_triger btn-show-modal-form" style="display:<?= !Yii::$app->user->isGuest ? 'flex' : 'none' ?>"
             title="Записи"
             data-action-url=<?= Url::to(['site/get-my-reservation-form/'])?>>Ваші записи <svg><use xlink:href="#wishlist"></use></svg>
        </div>
        <div style="<?= !Yii::$app->user->isGuest ? '' : 'display:none' ?>">
            <a class="login clean" href="<?= Url::to(['/logout'])?>"><svg><use xlink:href="#exit"></use></svg></a>
        </div>
    </div>
</header>









