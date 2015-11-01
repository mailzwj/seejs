<?php

    $info = mysql_query('SELECT * FROM siteinfo WHERE used=1');
    $infoData = mysql_fetch_array($info);

    $menu = mysql_query('SELECT * FROM menu');
    // $menuData = mysql_fetch_array($menu);

    $link = mysql_query('SELECT * FROM link');
    // $linkData = mysql_fetch_array($link);

?>

<div class="menubar">
    <a href="index.php" target="_self" class="logo">
        <img src="<?php echo $infoData['logo']; ?>" class="logo-pic">
    </a>
    <p class="site-name">
        <?php echo $infoData['sitename']; ?>
    </p>
    <div class="menus">
        <ul class="menu-list">
            <?php
                while($menuData = mysql_fetch_array($menu)) {
                    if ($menuData['parent'] == 0) {
            ?>
            <li class="menu">
                <a href="<?php echo $menuData['menulink']; ?>" class="menu-url">
                    <?php echo $menuData['menu']; ?> <span class="icons icon-chevron18"></span>
                </a>
            </li>
            <?php
                    }
                }
            ?>
        </ul>
    </div>
    <div class="other-link">
        <?php
            while($linkData = mysql_fetch_array($link)) {
        ?>
        <a href="<?php echo $linkData['linkaddr']; ?>" target="_blank" class="link">
            <span class="<?php echo $linkData['linkicon']; ?>"></span>
            <span class="link-name"><?php echo $linkData['linkname']; ?></span>
        </a>
        <?php } ?>
    </div>
</div>