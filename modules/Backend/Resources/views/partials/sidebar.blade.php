<aside class="main-sidebar">
    <section class="sidebar">

        <ul class="sidebar-menu">

            <?php //var_dump($data['menu_links']); ?>

            <?php \Widget::printMenuLinks($data['menu_links'], $data['prefix']); ?>

        </ul>
    </section>
</aside>