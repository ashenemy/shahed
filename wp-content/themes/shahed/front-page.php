<?php get_header(); ?>

<div class="min-h-screen view_content__O9aFA mt-[48px] md:mt-md-48 xl:mt-[64px] 2xl:vw-mt-[64]" style="display:block">
    <div style="opacity:1;transform:none">
        <div id="page-transition">
            <div>
                <?php get_template_part('parts/banner'); ?>
                <?php get_template_part('parts/products'); ?>
                <?php get_template_part('parts/videos'); ?>
                <?php get_template_part('parts/subscribtion'); ?>
                <?php get_template_part('parts/faq'); ?>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>

