<?php
use app\models\Service;
use app\widgets\SiteServicesWidget;

/** @var Service[] $items */
/** @var Service $item */
/** @var SiteServicesWidget $this */
?>
<div class="services container">
    <?php foreach ($items as $blockIndex => $services):?>
    <div class="box_item_<?= $blockIndex?>">
        <?php foreach ($services as $item):?>
            <a class="services_iten iten_0<?= $item->sort?>">
                <div class="star">0<?= $item->sort?></div>
                <?php if ($item->description):?>
                    <div class="prise">
                        <?php foreach (explode("\n",$item->description) as $descriptionItem):?>
                            <span><?= $descriptionItem?></span>
                        <?php endforeach;?>
                    </div>
                <?php elseif ($item->money_cost):?>
                    <div class="prise"><span>від <?= intval($item->money_cost)?>Грн</span></div>
                <?php endif;?>
                <div class="name"><?= $item->title?> <?php if ($item->time_processing):?><span class="name_time">зробимо за ~<?= date("H:i",strtotime($item->time_processing)) ?></span><?php endif?></div>
            </a>
        <?php endforeach;?>
    </div>
    <?php endforeach;?>
</div>