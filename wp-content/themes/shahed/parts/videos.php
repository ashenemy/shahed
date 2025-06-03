<?php
$videos = [
        [
                'icon' => 'video-1.avif',
                'src' => 'video-1.mp4',
                'title' => 'مشاهدة على أجهزة متعددة',
                'description' => 'استمتع بمشاهدة المحتوى المفضل لديك عبر عدة أجهزة لتجربة مشاهدة مريحة بلا حدود.'
        ],


        [
                'icon' => 'video-2.avif',
                'src' => 'video-2.mp4',
                'title' => 'خالٍ من الإعلانات',
                'description' => 'استمتع بتجربة مشاهدة خالية من الإعلانات وبدون انقطاع.'
        ],

        [
                'icon' => 'video-3.avif',
                'src' => 'video-3.mp4',
                'title' => 'قنوات مباشرة عالية الدقة',
                'description' => 'استمتع بتجربة مشاهدة مثيرة عبر قنوات مباشرة عالية الدقة توفر لك صورًا واضحة المعالم وجودة عالية.'
        ],

        [
                'icon' => 'video-4.avif',
                'src' => 'video-4.mp4',
                'title' => 'تنزيل ومشاهدة بدون اتصال بالإنترنت',
                'description' => 'قم بتنزيل المحتوى المفضل لديك واستمتع بمشاهدته بدون اتصال بالإنترنت في أي وقت وأي مكان.'
        ],

        [
                'icon' => 'video-5.avif',
                'src' => 'video-5.mp4',
                'title' => 'التحكم الأبوي',
                'description' => 'اضمن تجربة مشاهدة آمنة ومصممة خصيصا لأطفالك باستخدام ميزة التحكم الأبوي.'
        ]
];

?>

<div class="px-[16px] py-[48px] md:px-[32px] md:vw-py-[56] lg:mx-auto lg:px-0 lg:vw-py-[72] lg:vw-w-[974]">
    <div class="flex justify-center">
        <div class="text-center font-sans font-bold text-white text-[16px] md:vw-text-[20] xl:vw-text-[24] vw-pb-[8] xl:vw-pb-[12] border-solid border-b-4 vw-px-[12] md:vw-border-b-[4] border-b-[4px] [border-image:linear-gradient(to_right,rgba(0,204,153,0),#00906c,rgba(0,204,153,0))_1] md:text-[20px] lg:vw-text-[24]">اكتشف المزايا</div>
    </div>

    <div class="mt-[24px] overflow-hidden border-[1px] border-solid border-dark-blue bg-promoBottomGradient shadow-promoBox vw-rounded-[14] md:vw-mt-[32]">

        <?php
            $i=1;
            foreach ($videos as $video) {
                ?>
                <div class="px-[16px] md:px-0 lg:vw-px-[40] py-[24px] md:vw-py-[48] lg:vw-py-[40] w-full <?php _e_($i%2 === 0 ? 'bg-skeletonBg' : 'bg-darkBg');?> ">
                    <div class="w-full md:mx-auto md:vw-w-[490] lg:w-full lg:flex lg:items-center lg:vw-gap-[40] <?php _e_($i%2 === 0 ? 'lg:flex-row-reverse' : '');?>">
                        <div class="text-center lg:w-6/12 ltr:lg:text-left rtl:lg:text-right mb-[24px] md:vw-mb-[32] lg:mb-0 lg:vw-w-[436] ltr:leading-en rtl:leading-ar">
                            <div class="relative overflow-hidden mx-auto aspect-square h-[32px] w-[32px] lg:mx-0 md:h-[48px] md:w-[48px] lg:h-[56px] lg:!w-[56px]">
                                <img
                                        title="<?php _e_($video['title']);?> "
                                        alt="<?php _e_($video['title']);?>"
                                        fetchpriority="high"
                                        decoding="async"
                                        data-nimg="fill"
                                        class="mx-auto aspect-square h-[32px] w-[32px] lg:mx-0 md:h-[48px] md:w-[48px] lg:h-[56px] lg:!w-[56px] !w-auto"
                                        src="<?php _e_(\Shahed\Assets::toWpAssetSrc('/images/icons/'.$video['icon']));?>"
                                        style="position:absolute;height:100%;width:100%;inset:0px;color:transparent;visibility:visible" >
                            </div>

                            <p class="mt-[8px] font-shahidBold text-[18px] text-white md:vw-text-[28] md:vw-mt-[12] lg:vw-text-[36] lg:vw-mt-[16]"><?php _e_($video['title']);?> </p>
                            <p class="mt-[8px] text-[14px] font-medium text-light-blue-1 md:vw-text-[18] md:vw-mt-[12] lg:vw-text-[20]"><?php _e_($video['description']);?></p>

                        </div>

                        <div class="flex-grow">
                            <div class="h-[194px] w-full overflow-hidden text-center md:vw-h-[368] md:vw-w-[490] lg:vw-h-[312] lg:vw-w-[416]" style="position:relative!important">
                                <?php echo do_shortcode('[video src="'.$video['src'].'"]'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                $i++;
            }
        ?>

    </div>

</div>