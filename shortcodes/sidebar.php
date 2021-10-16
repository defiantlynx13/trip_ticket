<ul style="width:20%;float:right;padding:0;margin:0;font-size: 15px;">
        <li style="list-style:none;line-height:35px;"><a href="<?php bloginfo('url'); ?>/tt_list">جستجوی بلیط</a></li>
        <li style="list-style:none;line-height:35px;"><a href="<?php bloginfo('url'); ?>/tt_basket">سبد خرید</a></li>
        <li style="list-style:none;line-height:35px;"><a href="<?php bloginfo('url'); ?>/tt_buy">خرید بلیط</a></li>
        <li style="list-style:none;line-height:35px;"><a href="<?php bloginfo('url'); ?>/tt_lastticket">بلیط های قبلی</a></li>
		<?php if ( is_user_logged_in() ) : ?>

		<li style="list-style:none;line-height:35px;"><a href="<?php bloginfo('url'); ?>/tt_myfamily">خانواده من</a></li>
        <li style="list-style:none;line-height:35px;"><a href="<?php bloginfo('url'); ?>/tt_changepass">تغییر رمز عبور</a></li>
        <li style="list-style:none;line-height:35px;"><a href="<?php echo wp_logout_url( home_url().'/tt_login' ); ?>">خروج از پنل</a></li>

		<?php endif; ?>
</ul>