
<?php

    if (showAltHP()) {
        ?>
        <?php get_header('white'); ?>

        <section>
            <div class="container mx-auto px-4 py-8 flex flex-col justify-start items-stretch">
                <h1 class="font-bold text-4xl text-[#D4AF37]">أفضل الأفلام العربية</h1>
                <div class="my-8 flex items-center justify-center flex-col">
                    <iframe src="<?php WpAsset('/ads/ads-1');?>?>" class="w-[728px] h-[90px]" style="overflow: hidden"></iframe>
                </div>
                <div class="grid gap-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    <?php
                    $query = new WP_Query([
                            'post_type'      => 'cinema',
                            'posts_per_page' => -1,
                            'post_status'    => 'publish'
                    ]);

                    if ($query->have_posts()) {
                        foreach ($query->posts as $post) {

                            ?>

                            <div class="rounded-xl overflow-hidden relative">
                                <div class="w-full h-full">
                                    <img src="<?php _e_(get_the_post_thumbnail_url($post->ID, 'large'));?>" class="w-full h-full object-cover">
                                </div>

                                <div class="absolute bottom-0 left-0 w-full p-4 text-[#ffffff] bg-black/70">
                                    <h2 class="text-xl mb-2 text-[#D4AF37]"><?php _e_(get_the_title($post));?></h2>
                                    <div class="line-clamp-3 text-sm ">
                                        <?php _e_(get_the_content($post));?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }


                    ?>
                </div>
            </div>
        </section>

        <?php get_footer('white'); ?>
        <?php
    } else {
        ?>
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

        <?php
    }
?>





