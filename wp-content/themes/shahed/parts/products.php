<?php

$products = [];

$query = new WP_Query([
        'post_type'      => 'products',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_key' => 'price',
        'orderby' => 'meta_value_num', // для чисел
        'order' => 'ASC', // или 'DESC'
]);

if ($query->have_posts()) {
    foreach ($query->posts as $post) {
        $products[] = [
                'id'           => $post->ID,
                'title'        => get_the_title($post),
                'prices'        => get_post_meta($post->ID, 'prices', true),
                'description'  => $post->post_content,
                'discountPrices' => get_post_meta($post->ID, 'discount_prices', true),
                'isBestseller' => (bool) get_post_meta($post->ID, 'isBestseller', true),
        ];
    }
}

wp_reset_postdata();
?>


<div class="package-cards-cover">
    <div class="package-cards flex flex-col items-center justify-center  gap-[16px] px-[16px] md:vw-px-[32] relative z-50 xl:!flex-row xl:items-stretch xl:gap-[12px] lg:px-[42px]">
        <?php foreach ($products as $product) { ?>
            <div class="z-[1] w-full flex flex-col justify-between font-sans xl:vw-w-[388]">
                <div class="vw-rounded-[8] ltr:leading-en rtl:leading-ar h-full w-full bg-epgLightBlackBg p-4 md:p-md-16 lg:p-lg-16 xl:p-xl-16 2xl:p-2xl-16">
                    <div class="flex h-full w-full flex-col items-start vw-gap-[8]">
                        <div class="flex w-full flex-row items-center justify-between font-bold text-white xl:font-medium">
                            <div class="text-[16px] md:vw-text-[16] xl:vw-text-[18]"><?php  _e_($product['title']); ?></div>
                            <?php if ($product['isBestseller']) { ?>
                                <div class="text-[12px] font-bold text-white vw-rounded-[2] md:vw-text-[12] vw-px-[8] vw-py-[4] md:vw-px-[12] xl:vw-px-[8]" style="background-color:rgb(214,25,98)">&nbsp;الأكثر مبيعاً</div>
                            <?php } ?>
                        </div>
                        <div class="flex w-full flex-grow flex-col justify-between gap-[24px] xl:vw-gap-[24]">
                            <div class="flex w-full flex-col items-start">

                                <div class="font-black text-light-blue-5 text-[16px] md:vw-text-[20] xl:vw-text-[18] mb-[8px] md:vw-mb-[12] xl:vw-mb-[8] font-shahidBlack">
                                    <?php _e_priceFormat($product['prices'], 'eastern');?><span class="font-sans text-[14px] font-medium md:font-black md:vw-text-[16] xl:vw-text-[14] undefined"> / شهرياً</span>
                                </div>
                                <div class="flex w-full flex-col items-start justify-between">
                                    <div class="text-right font-shahid font-normal text-light-blue-4 ltr:text-left leading-ar ltr:leading-en ltr:md:vw-pr-[4] rtl:md:vw-pl-[4] text-[14px] lg:vw-text-[14] md:vw-text-[16]"><?php  _e_($product['description']); ?></div>
                                </div>
                            </div>
                            <div class="flex w-full items-center justify-between">
                                <div style="color:white; font-weight: bold; font-size: 18px;">
                                    <?php _e_priceFormat($product['discountPrices'], 'eastern');?>
                                    لأول ٣ أشهر

                                </div>
                                <form method="GET" action="<?php _e_(get_permalink(13));?>">
                                    <input type="hidden" name="product" value="<?php _e_($product['id']);?>">
                                    <?php
                                        if (!empty($_GET['countryCode'])) {
                                            ?>
                                            <input type="hidden" name="countryCode" value="<?php _e_($_GET['countryCode']);?>">
                                            <?php
                                        }
                                    ?>
                                    <button type="submit" class="btn xs:h-[40px] sm:h-[40px] md:vw-h-[40] lg:vw-h-[40] xl:vw-h-[40] 2xl:vw-h-[40] w-full btn-nsf-secondary bg-packageButtonBg !text-[12px] !vw-h-[24] md:mt-0 md:!vw-text-[12] vw-w-[112] md:vw-w-[156] lg:vw-w-[112]">
                                        <div class="btn"><span>اشتراك</span></div>
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>
    </div>
</div>
