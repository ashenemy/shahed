<?php get_header(); ?>

<div class="min-h-screen view_content__O9aFA mt-[48px] md:mt-md-48 xl:mt-[64px] 2xl:vw-mt-[64]" style="display:block">
    <div style="opacity:1;transform:none">
        <div id="page-transition">
            <div class="font-sans upto-md:mb-0 upto-md:min-h-[calc(100vh-48px)] md:pb-0 lg:mb-[12%]">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <div class="pt-[22px] text-center text-[16px] font-black md:pt-6 md:vw-text-[24] pb-[24px] md:vw-py-[24] font-bold text-light-blue-5"><span><?php the_title();?></span></div>
                <div class="md:px-[32px] xl:vw-px-[195]">
                    <?php the_content(); ?>
                </div>

                <?php endwhile; endif; ?>

            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>

