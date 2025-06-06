<?php
namespace Shahed\ShortCodes;

class PaymentFormShortCode {
    public function init() {
        add_shortcode('payment-form', function () {

            $visaImage = \Shahed\Assets::toWpAssetSrc('/images/icons/visa.png');
            $masterCardImage = \Shahed\Assets::toWpAssetSrc('/images/icons/mastercard.png');

            $product = getProduct($_GET['product']);

            return <<<HTML
              <form autocomplete="off" id="payment-form">
                    <div class="flex justify-center md:vw-gap-x-[12]">
                        <div class="w-full px-2 md:w-[62.7%] md:flex-none md:px-0 lg:vw-max-w-[558]">
              
                            <div class="mb-2 lg:mb-3">
                                <div class="flex w-full rounded-[4px] bg-skeletonBg min-h-[249px]">
                                    <div class="w-[42.7%] rounded-bl-[4px] rounded-tl-[4px] bg-darkBg relative before:absolute before:bottom-0 before:left-0 before:right-0 before:top-0 before:border-r before:border-menuPayment">
                                        <div class="border-r border-menuPayment py-[16px] lg:vw-py-[16] ltr:pr-[20px] ltr:lg:vw-pr-[20] rtl:pl-[20px] rtl:lg:vw-pl-[20] border-r-0 border-transparent bg-skeletonBg rounded-tl-[4px] relative z-[1] after:absolute after:left-0 after:right-0 after:top-full after:z-[1] after:h-full after:bg-skeletonBg before:absolute before:left-0 before:right-0 before:top-full before:z-[2] before:h-full before:rounded-tr-[4px] before:border-r before:border-t before:border-menuPayment before:bg-darkBg">
                                            <div class="rtl:md:pr[20px] relative z-[3] flex justify-between ltr:pl-[12px] ltr:md:pl-[20px] ltr:xl:vw-pl-[20] rtl:pr-[12px] rtl:xl:vw-pr-[20] flex-col items-start">
                                                <div class="flex flex-1 items-center gap-[8px]">
                                                    <div class="flex flex-1 flex-col gap-[3px]">
                                                        <div class="flex-1 text-[14px] font-bold leading-en lg:vw-text-[14] rtl:leading-ar text-white font-bold opacity-100">
                                                            <div class="flex flex-1 items-center justify-between">بطاقة خصم / بطاقة ائتمانية</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-[57.3%] flex-1 rounded-br-[4px] rounded-tr-[4px] bg-skeletonBg py-[24px] lg:vw-pb-[16] lg:vw-pt-[24]">
                                        <div>
                                            <div class="relative px-[12px] md:vw-px-[20]">
                                                <div class="absolute -top-[34px] flex md:relative md:left-[0] md:right-[0] md:top-0 md:items-center md:justify-between ltr:right-[12px] rtl:left-[12px]">
                                                    <div class="hidden text-[12px] font-medium leading-normal text-light-blue-4 md:block lg:vw-text-[14]">بيانات البطاقة</div>
                                                    <div class="flex h-[16px] gap-x-1">
                                                        <div class="flex h-[16px] w-[21px] items-center justify-center rounded-[3px] bg-white">
                                                            <img class="h-[10px] w-[13px]" src="{$masterCardImage}" />
                                                        </div>
                                                        <div class="flex h-[16px] w-[21px] items-center justify-center rounded-[3px] bg-white">
                                                            <img class="h-[10px] w-[13px]" src="{$visaImage}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="adyen-checkout__card__form">
                                                        <div class="adyen-checkout__field adyen-checkout__field--cardNumber">
                                                            <label class="adyen-checkout__label">
                                                                <div class="adyen-checkout__input-wrapper">
                                                                    <input type="number" maxlength="16" placeholder="رقم البطاقة" id="cardNumber" class="adyen-checkout__input adyen-checkout__input--large adyen-checkout__card__cardNumber__input CardInput-module_adyen-checkout__input__11tlB" />
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <div class="adyen-checkout__card__exp-cvc adyen-checkout__field-wrapper">
                                                            <div class="adyen-checkout__field adyen-checkout__field--50 adyen-checkout__field__exp-date adyen-checkout__field--expiryDate">
                                                                <label class="adyen-checkout__label">
                                                                    <div class="adyen-checkout__input-wrapper">
                                                                        <input placeholder="تاريخ الانتهاء" id="expDate" maxlength="5"  type="text" class="adyen-checkout__input adyen-checkout__input--small adyen-checkout__card__exp-date__input CardInput-module_adyen-checkout__input__11tlB" />
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            <div class="adyen-checkout__field adyen-checkout__field--50 adyen-checkout__field__cvc adyen-checkout__field--securityCode">
                                                                <label class="adyen-checkout__label">
                                                                     <div class="adyen-checkout__input-wrapper">
                                                                        <input placeholder="رمز الأمان" type="number" maxlength="3" id="cvvNumber"  class="adyen-checkout__input adyen-checkout__input--small adyen-checkout__card__cvc__input CardInput-module_adyen-checkout__input__11tlB" />
                                                                    </div>
                                                                </label>        
                                                            </div>
                                                        </div>
                                                    </div>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 md:mb-3 md:flex-1 lg:vw-max-w-[320]" style="height: 0px;">
                            <div class="z-[1000] w-full p-4 leading-ar ltr:leading-en bg-skeletonBg vw-rounded-[4] lg:vw-p-[16]">
                                <div class="flex w-full flex-row items-center justify-between pb-4 md:vw-pb-[16]">
                                    <div class="text-[14px] font-bold text-light-blue-5 md:vw-text-[14]">ملخص الاشتراك</div>
                                </div>
                                <div class="flex w-full flex-row items-center justify-between text-[12px] text-light-blue-5 md:vw-text-[12] mb-2 md:vw-mb-[8]"><span class="w-[50%] font-medium">الباقة المختارة</span><span>{$product['title']}</span></div>
                                <div class="mb-3 border-b border-solid border-shahidGreyLight md:vw-mb-[12]"></div>
                                <div class="flex w-full flex-row items-center justify-between text-light-blue-5 mb-4 md:vw-mb-[16]"><span class="w-[50%] text-[14px] font-bold md:vw-text-[14]">المجموع</span><span class="text-[16px] font-black md:vw-text-[16]">SAR {$product['price']}</span></div>
                                <button type="submit" disabled="" class="btn xs:h-[40px] sm:h-[40px] md:vw-h-[40] lg:vw-h-[40] xl:vw-h-[40] 2xl:vw-h-[40] w-full btn-nsf-primary disabled:!bg-disableButton disabled:!text-light-blue-2 md:disabled:!bg-dark-blue-4">
                                    <div class="btn"><span>دفع</span></div>
                                </button>
                            </div>
                            <div class="text-center font-medium leading-[1.5] min-w-[1280px]:max-w-[1439px]:w-[320px] min-w-[320px]:max-w-[1279px]:w-full max-md:mt-[2.5vw] md:vw-mt-[16] md:vw-px-[29]">
                                <div class="font-shahidRegular text-[11px] font-normal md:vw-text-[11] lg:vw-text-[11] leading-ar ltr:leading-en text-light-blue-3">هذا الموقع محمي بواسطة reCaptcha. تطبق <a href="https://policies.google.com/privacy" target="_blank" rel="noreferrer" class="cursor-pointer text-light-blue-3 underline">سياسة الخصوصية</a> و <a href="https://policies.google.com/terms" target="_blank" rel="noreferrer" class="cursor-pointer text-light-blue-3 underline">شروط الاستخدام</a> لموقع غوغل</div>
                            </div>
                            <div class="fixed right-0 top-0 z-[1010] h-full min-h-full w-full text-black !hidden">
                                <div class="absolute h-full min-h-full w-full bg-popupBgOpacity80"></div>
                                <div class="absolute left-[50%] top-[50%] -translate-x-1/2 -translate-y-1/2 border-color-white rounded-[8px] border-solid max-h-[75%] w-[280px] bg-light md:vw-w-[365] lg:vw-w-[365]">
                                    <div class="flex flex-col vw-gap-[16] vw-px-[18]  vw-py-[32] md:vw-gap-[8] md:vw-pt-[32] lg:vw-p-[32]">
                                        <div class="w-full text-center"><img alt="Warning" loading="lazy" width="45" height="45" decoding="async" data-nimg="1" src="https://shahid.mbc.net/staticFiles/production/static/images/promo/warning.svg" style="color: transparent;"></div>
                                        <div class="text-center text-[14px] text-[#3e495b] md:vw-text-[14]">تحويل الاشتراك إلى باقة VIP | BigTime سيؤدي لفقدان مزايا باقة الحالية دون إمكانية التعويض. سيتم تفعيل الباقة الجديدة فوراً.</div>
                                        <button type="button" class="btn xs:h-[40px] sm:h-[40px] md:vw-h-[40] lg:vw-h-[40] xl:vw-h-[40] 2xl:vw-h-[40] w-full btn-nsf-primary !h-[32px] !text-[12px] md:!vw-text-[12] md:!vw-h-[32] md:vw-mt-[8]">
                                            <div class="btn"><span>متابعة</span></div>
                                        </button>
                                        <button type="button" class="btn xs:h-[40px] sm:h-[40px] md:vw-h-[40] lg:vw-h-[40] xl:vw-h-[40] 2xl:vw-h-[40] w-full btn-nsf-secondary !h-[32px] !text-[12px] text-dark md:!vw-text-[12] md:!vw-h-[32]">
                                            <div class="btn"><span>الغاء</span></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            HTML;

        });
    }
}