<?php get_header(); ?>

<div class="min-h-screen view_content__O9aFA mt-[48px] md:mt-md-48 xl:mt-[64px] 2xl:vw-mt-[64]" style="display:block">
    <div style="opacity:1;transform:none">
        <div id="page-transition">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <form method="POST" action="/wp-json/shahed/v1/reg" autocomplete="off" id="registration-form">
                    <div class="h-full font-reset flex flex-col items-center leading-ar ltr:leading-en" style="min-height: 0px; padding-left:10px; padding-right:10px;">
                        <div class="mt-[-48px] pt-[48px] md:-mt-md-48 md:pt-md-48 w-full overflow-x-hidden font-reset flex flex-col items-center leading-ar ltr:leading-en" style="max-width: 425px; min-height:550px">
                            <div class="text-center text-[16px] font-black md:vw-text-[24] lg:!font-bold text-light-blue-3"><span class="">إنشاء حساب شاهد</span></div>
                            <div class="mt-[32px] w-full text-center md:vw-mt-[16] lg:vw-mb-[24] xl:vw-mt-[16] 2xl:vw-mt-[16]">

                                <div class="relative w-full">
                                    <div class="flex items-center overflow-hidden rounded-[4px] border-[1px] leading-[14px] xs:h-[44px] sm:h-[44px] md:vw-h-[44] lg:vw-h-[44] xl:vw-h-[44] 2xl:vw-h-[44] border-dropdown bg-white relative">
                                        <input name="userName" id="userName" type="text" class="xs:h-[44px] sm:h-[44px] md:vw-h-[44] lg:vw-h-[44] xl:vw-h-[44] 2xl:vw-h-[44] pb-[8px] pt-[22px] text-[12px] md:vw-text-[12] lg:vw-text-[12] peer w-full appearance-none transition-all duration-200 ease-in-out px-[12px] text-inputText" placeholder=" " value="">
                                        <label for="userName" class="absolute z-10 origin-[0] -translate-y-[7px] transform cursor-text text-[12px] leading-[12px] duration-300 vw-top-[15] peer-focus:text-[10px] md:vw-text-[12] peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-[7px] peer-placeholder-shown:lg:vw-text-[12] peer-focus:lg:vw-text-[10] peer-placeholder-shown:leading-[14px] peer-focus:leading-[12px] ltr:left-[12px] rtl:right-[12px] text-light-blue-2">البريد الإلكتروني</label>
                                    </div>
                                    <div style="margin-top: 16px;" class="flex items-center overflow-hidden rounded-[4px] border-[1px] leading-[14px] xs:h-[44px] sm:h-[44px] md:vw-h-[44] lg:vw-h-[44] xl:vw-h-[44] 2xl:vw-h-[44] border-dropdown bg-white relative">
                                        <input name="password" id="password" type="password" class="xs:h-[44px] sm:h-[44px] md:vw-h-[44] lg:vw-h-[44] xl:vw-h-[44] 2xl:vw-h-[44] pb-[8px] pt-[22px] text-[12px] md:vw-text-[12] lg:vw-text-[12] peer w-full appearance-none transition-all duration-200 ease-in-out px-[12px] text-inputText" placeholder=" " value="">
                                        <label for="password" class="absolute z-10 origin-[0] -translate-y-[7px] transform cursor-text text-[12px] leading-[12px] duration-300 vw-top-[15] peer-focus:text-[10px] md:vw-text-[12] peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-[7px] peer-placeholder-shown:lg:vw-text-[12] peer-focus:lg:vw-text-[10] peer-placeholder-shown:leading-[14px] peer-focus:leading-[12px] ltr:left-[12px] rtl:right-[12px] text-light-blue-2"> أدخل كلمة السر</label>
                                    </div>
                                </div>
                            </div>
                            <div class="fixed-bottom fixed lg:relative  bottom-0 left-0 w-full">
                                <div class="w-full transition-all duration-[16ms] bg-fixedMainComponentBg p-4">
                                    <div class="font-shahidRegular text-[11px] font-normal md:vw-text-[11] lg:vw-text-[11] leading-ar ltr:leading-en text-light-blue-2 text-center text-[11px] text-light-blue-2 mb-4">هذا الموقع محمي بواسطة reCaptcha. تطبق
                                        <a href="https://policies.google.com/privacy" target="_blank" rel="noreferrer" class="cursor-pointer text-light-blue-3 underline">سياسة الخصوصية</a> و <a href="https://policies.google.com/terms" target="_blank" rel="noreferrer" class="cursor-pointer text-light-blue-3 underline">شروط الاستخدام</a> لموقع غوغل</div>


                                    <button onclick="gtag('event', 'submit_username_password');" type="submit" disabled="" class="btn xs:h-[40px] sm:h-[40px] md:vw-h-[40] lg:vw-h-[40] xl:vw-h-[40] 2xl:vw-h-[40] w-full btn-nsf-primary !bg-disableButtonLg !text-light-blue-2  text-center">
                                        متابعة
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="font-shahidRegular text-[11px] font-normal md:vw-text-[11] lg:vw-text-[11] leading-ar ltr:leading-en text-light-blue-3 mt-8  text-center text-light-blue-3 md:vw-max-w-[464] md:vw-min-w-[464] md:vw-mt-[24] md:vw-px-[64]">هذا الموقع محمي بواسطة reCaptcha. تطبق <a href="https://policies.google.com/privacy" target="_blank" rel="noreferrer" class="cursor-pointer text-light-blue-3 underline">سياسة الخصوصية</a> و <a href="https://policies.google.com/terms" target="_blank" rel="noreferrer" class="cursor-pointer text-light-blue-3 underline">شروط الاستخدام</a> لموقع غوغل</div>
                    </div>
                    <input type="hidden" name="product" value="<?php _e_($_GET['product']);?>">
                </form>
            <?php endwhile; endif; ?>
        </div>
    </div>
</div>


<?php get_footer(); ?>

