<footer>
    <div class="container">
        <div class="top">
            <div>
                <div class="logotype"><img src="/images/template/logo.png" alt="Логотип FIXTIME"></div>
                <div class="social">
                    <a href="" class="icon"><svg><use xlink:href="#instagram"></use></svg></a>
                    <a href="" class="icon"><svg><use xlink:href="#twitter"></use></svg></a>
                    <a href="" class="icon"><svg><use xlink:href="#facebook"></use></svg></a>
                    <a href="" class="icon"><svg><use xlink:href="#youtube"></use></svg></a>
                </div>
            </div>
            <div>
                <div><!-- позиция 1 -->
                    <p>Контакты</p>
                    <?= $this->context->company->contacts?>
                </div>
                <div>
                    <p>Адрес</p>
                    <div><?= nl2br($this->context->company->address)?></div>
                </div>
            </div>
        </div>
        <div class="bottom">
            <p>© 2023 All rights reserved.</p>
            <a href="">by: TDS</a>
        </div>
    </div>
</footer>
<?php include 'svg.php';?>
<?php include 'modal.php';?>



