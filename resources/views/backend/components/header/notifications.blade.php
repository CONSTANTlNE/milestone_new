<!--Header Notifictaion -->
<div class="header-element py-[1rem] md:px-[0.65rem] px-2 notifications-dropdown header-notification hs-dropdown ti-dropdown !hidden md:!block [--placement:bottom-left]">
    <button id="dropdown-notification" type="button"
            class="hs-dropdown-toggle relative ti-dropdown-toggle !p-0 !border-0 flex-shrink-0  !rounded-full !shadow-none align-middle text-xs">
        <i class="bx bx-bell header-link-icon  text-[1.125rem]"></i>
        <span class="flex absolute h-5 w-5 -top-[0.25rem] end-0  -me-[0.6rem]">
              <span
                  class="animate-slow-ping absolute inline-flex -top-[2px] -start-[2px] h-full w-full rounded-full bg-secondary/40 opacity-75"></span>
              <span
                  class="relative inline-flex justify-center items-center rounded-full  h-[14.7px] w-[14px] bg-secondary text-[0.625rem] text-white"
                  id="notification-icon-badge">5</span>
            </span>
    </button>
    <div class="main-header-dropdown !-mt-3 !p-0 hs-dropdown-menu ti-dropdown-menu bg-white !w-[22rem] border-0 border-defaultborder hidden !m-0"
         aria-labelledby="dropdown-notification">

        <div class="ti-dropdown-header !m-0 !p-4 !bg-transparent flex justify-between items-center">
            <p class="mb-0 text-[1.0625rem] text-defaulttextcolor font-semibold dark:text-[#8c9097] dark:text-white/50">Notifications</p>
            <span class="text-[0.75em] py-[0.25rem/2] px-[0.45rem] font-[600] rounded-sm bg-secondary/10 text-secondary"
                  id="notifiation-data">5 Unread</span>
        </div>
        <div class="dropdown-divider"></div>
        <ul class="list-none !m-0 !p-0 end-0" id="header-notification-scroll">
            <li class="ti-dropdown-item dropdown-item ">
                <div class="flex items-start">
                    <div class="pe-2">
                    <span
                        class="inline-flex text-primary justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem] !bg-primary/10 !rounded-[50%]"><i
                            class="ti ti-gift text-[1.125rem]"></i></span>
                    </div>
                    <div class="grow flex items-center justify-between">
                        <div>
                            <p class="mb-0 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50 text-[0.8125rem] font-semibold"><a
                                    href="notifications.html">Your Order Has Been Shipped</a></p>
                            <span class="text-[#8c9097] dark:text-white/50 font-normal text-[0.75rem] header-notification-text">Order No: 123456
                        Has Shipped To Your Delivery Address</span>
                        </div>
                        <div>
                            <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit text-[#8c9097] dark:text-white/50 me-1 dropdown-item-close1"><i
                                    class="ti ti-x text-[1rem]"></i></a>
                        </div>
                    </div>
                </div>
            </li>
            <li class="ti-dropdown-item dropdown-item !flex-none">
                <div class="flex items-start">
                    <div class="pe-2">
                    <span
                        class="inline-flex text-secondary justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem]  bg-secondary/10 rounded-[50%]"><i
                            class="ti ti-discount-2 text-[1.125rem]"></i></span>
                    </div>
                    <div class="grow flex items-center justify-between">
                        <div>
                            <p class="mb-0 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50 text-[0.8125rem]  font-semibold"><a
                                    href="notifications.html">Discount Available</a></p>
                            <span class="text-[#8c9097] dark:text-white/50 font-normal text-[0.75rem] header-notification-text">Discount
                        Available On Selected Products</span>
                        </div>
                        <div>
                            <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit  text-[#8c9097] dark:text-white/50 me-1 dropdown-item-close1"><i
                                    class="ti ti-x text-[1rem]"></i></a>
                        </div>
                    </div>
                </div>
            </li>
            <li class="ti-dropdown-item dropdown-item">
                <div class="flex items-start">
                    <div class="pe-2">
                    <span
                        class="inline-flex text-pink justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem]  bg-pink/10 rounded-[50%]"><i
                            class="ti ti-user-check text-[1.125rem]"></i></span>
                    </div>
                    <div class="grow flex items-center justify-between">
                        <div>
                            <p class="mb-0 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50 text-[0.8125rem]  font-semibold"><a
                                    href="notifications.html">Account Has Been Verified</a></p>
                            <span class="text-[#8c9097] dark:text-white/50 font-normal text-[0.75rem] header-notification-text">Your Account Has
                        Been Verified Sucessfully</span>
                        </div>
                        <div>
                            <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit text-[#8c9097] dark:text-white/50 me-1 dropdown-item-close1"><i
                                    class="ti ti-x text-[1rem]"></i></a>
                        </div>
                    </div>
                </div>
            </li>
            <li class="ti-dropdown-item dropdown-item">
                <div class="flex items-start">
                    <div class="pe-2">
                    <span
                        class="inline-flex text-warning justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem]  bg-warning/10 rounded-[50%]"><i
                            class="ti ti-circle-check text-[1.125rem]"></i></span>
                    </div>
                    <div class="grow flex items-center justify-between">
                        <div>
                            <p class="mb-0 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50  text-[0.8125rem]  font-semibold"><a
                                    href="notifications.html">Order Placed <span class="text-warning">ID: #1116773</span></a></p>
                            <span class="text-[#8c9097] dark:text-white/50 font-normal text-[0.75rem] header-notification-text">Order Placed
                        Successfully</span>
                        </div>
                        <div>
                            <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit text-[#8c9097] dark:text-white/50 me-1 dropdown-item-close1"><i
                                    class="ti ti-x text-[1rem]"></i></a>
                        </div>
                    </div>
                </div>
            </li>
            <li class="ti-dropdown-item dropdown-item">
                <div class="flex items-start">
                    <div class="pe-2">
                    <span
                        class="inline-flex text-success justify-center items-center !w-[2.5rem] !h-[2.5rem] !leading-[2.5rem] !text-[0.8rem]  bg-success/10 rounded-[50%]"><i
                            class="ti ti-clock text-[1.125rem]"></i></span>
                    </div>
                    <div class="grow flex items-center justify-between">
                        <div>
                            <p class="mb-0 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50  text-[0.8125rem]  font-semibold"><a
                                    href="notifications.html">Order Delayed <span class="text-success">ID: 7731116</span></a></p>
                            <span class="text-[#8c9097] dark:text-white/50 font-normal text-[0.75rem] header-notification-text">Order Delayed
                        Unfortunately</span>
                        </div>
                        <div>
                            <a aria-label="anchor" href="javascript:void(0);" class="min-w-fit text-[#8c9097] dark:text-white/50 me-1 dropdown-item-close1"><i
                                    class="ti ti-x text-[1rem]"></i></a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

        <div class="p-4 empty-header-item1 border-t mt-2">
            <div class="grid">
                <a href="notifications.html" class="ti-btn ti-btn-primary-full !m-0 w-full p-2">View All</a>
            </div>
        </div>
        <div class="p-[3rem] empty-item1 hidden">
            <div class="text-center">
                <span class="!h-[4rem]  !w-[4rem] avatar !leading-[4rem] !rounded-full !bg-secondary/10 !text-secondary">
                  <i class="ri-notification-off-line text-[2rem]  "></i>
                </span>
                <h6 class="font-semibold mt-3 text-defaulttextcolor dark:text-[#8c9097] dark:text-white/50 text-[1rem]">No New Notifications</h6>
            </div>
        </div>
    </div>
</div>
<!--End Header Notifictaion -->
