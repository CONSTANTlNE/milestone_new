@extends('frontend.layouts.master')
@section('title') {{ __('strings.Home') }} @endsection

@section('header_background')
    <!-- Title Bar -->
    <div class="pbmit-title-bar-wrapper">
        <div class="container">
            <div class="pbmit-title-bar-content">
                <div class="pbmit-title-bar-content-inner">
                    <div class="pbmit-tbar">
                        <div class="pbmit-tbar-inner container">
                            <h1 class="pbmit-tbar-title"> About Us</h1>
                        </div>
                    </div>
                    <div class="pbmit-breadcrumb">
                        <div class="pbmit-breadcrumb-inner">
									<span>
										<a title="" href="#" class="home"><span>Shipex</span></a>
									</span>
                            <span class="sep">
										<i class="pbmit-base-icon-angle-right"></i>
									</span>
                            <span><span class="post-root post post-post current-item"> About Us</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Title Bar End-->
@endsection
@section('content')
    <!-- Single Detail Style 2 -->
    <section class="site-content">
        <div class="container">
            <article class="pbmit-portfolio-single">
                <div class="pbmit-entry-content">
                    <div class="pbmit-heading">
                        <h2 class="pbmit-title mb-4">Project Description</h2>
                    </div>
                    <p class="pbmit-firstletter">Project logistics is the planning, execution, and management of the <span class="pbmit-global-color" style="font-weight: 500;">transportation and movement of materials,</span> equipment, and goods for a specific project. It’s a part of supply chai <br> management, but differs from traditional logistics, which focuses on ongoing operations. Project logistics is used for temporary and unique projects, such as construction, event has <br> management, or infrastructure development. Each project has its own requirements, challenges, and timelines, so project logisticians successfully complete a project cover must adapt the <br> strategies and solutions a accordingly. The logistics activities needed tothe integrated process of planning and executing the complete flow of containerized and non-containerized cargo an <br> suppliers spread across the globe, ensuring that all cargo eventually converges at a given destination.</p>
                    <p>Project logistics can be complex due to the size of the project, the diversity of materials and equipment, and the project site’s geographical location. Project logistics is a specialised service offering within the global logistics industry. It combines traditional freight forwarding and transport capabilities with unique skills and competence needed for project planning.</p>
                    <div class="row py-md-4 mb-4">
                        <div class="col-md-6 pe-xl-4 mt-md-0 mt-4 text-center">
                            <div class="pbmit-animation-style1">
                                <img src="images/portfolio/portfolio-single-02.jpg" class="rounded-5 img-fluid" alt="">
                            </div>
                        </div>
                        <div class="col-md-6 ps-xl-4 mt-md-0 mt-4 text-center">
                            <div class="pbmit-animation-style1">
                                <img src="images/portfolio/portfolio-single-03.jpg" class="rounded-5 img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="pbmit-heading">
                        <h2 class="pbmit-title mb-4">Logistics through innovation, dedication, and technology.</h2>
                    </div>
                    <p>A heavy project cargo shipment has to deal with varying terrains and mediums such as oceans, inland waterways, hilly regions, air routes, rail routes, etc. Therefore, a logistics provider will have to assign an appropriate carrier to perform the job well. For instance, carrier vessels would be apt for transporting heavy equipment in an inland waterway, whereas an aircraft is more suitable for as intercontinental delivery. It is customary for project logistics experts to conduct feasibility studies before undertaking a complex project. </p>
                    <ul class="list-group mb-5">
                        <li class="list-group-item">
									<span class="pbmit-icon-list-icon">
										<i aria-hidden="true" class="pbmit-base-icon-check-mark"></i>
									</span>
                            Function of understanding stock mix of a company and the different demands on that stock
                        </li>
                        <li class="list-group-item">
									<span class="pbmit-icon-list-icon">
										<i aria-hidden="true" class="pbmit-base-icon-check-mark"></i>
									</span>
                            Legal demand by a shipper or consignee against a carrier in respect of damage or loss to a shipment
                        </li>
                        <li class="list-group-item">
									<span class="pbmit-icon-list-icon">
										<i aria-hidden="true" class="pbmit-base-icon-check-mark"></i>
									</span>
                            Performance based logistics  Defense acquisition strategy for cost-effective weapon system support
                        </li>
                        <li class="list-group-item">
									<span class="pbmit-icon-list-icon">
										<i aria-hidden="true" class="pbmit-base-icon-check-mark"></i>
									</span>
                            Sales territory  Geographic area or customer group managed by a sales representative
                        </li>
                    </ul>
                    <div class="pbmit-heading">
                        <h2 class="pbmit-title mb-4">Meet our team who work on project</h2>
                    </div>
                    <p>This is where project logistics services of third-party logistics companies come into play. A third-party logistics company provides logistics services. Depending on the contract, could undertake segment of the logistics process or even a complex project entirely. In the latter scenario, they take care of all the logistics transportation to warehousing to inventory management.</p>
                    <div class="swiper-slider pt-3 pb-5" data-autoplay="false" data-loop="true" data-dots="false" data-arrows="false" data-columns="4" data-margin="30" data-effect="slide">
                        <div class="swiper-wrapper">
                            <!-- Slide1 -->
                            <article class="pbmit-team-style-1 swiper-slide">
                                <div class="pbminfotech-post-item">
                                    <div class="pbmit-featured-wrap">
                                        <div class="pbmit-featured-inner">
                                            <div class="pbmit-featured-img-wrapper">
                                                <div class="pbmit-featured-wrapper">
                                                    <img src="images/team/team-01.jpg" class="img-fluid" alt="">
                                                </div>
                                            </div>
                                            <a class="pbmit-link" href="team-member-detail.html"></a>
                                        </div>
                                    </div>
                                    <div class="pbminfotech-box-content">
                                        <div class="pbminfotech-box-content-inner">
                                            <h3 class="pbmit-team-title">
                                                <a href="team-member-detail.html">Andrea Luies</a>
                                            </h3>
                                            <div class="pbminfotech-box-team-position">Laboratory Technician</div>
                                        </div>
                                        <div class="pbmit-team-btn">
                                            <a class="pbmit-team-text" href="#">
                                                <i class="pbmit-base-icon-share"></i>
                                            </a>
                                            <div class="pbminfotech-box-social-links">
                                                <ul class="pbmit-social-links pbmit-team-social-links">
                                                    <li class="pbmit-social-li pbmit-social-facebook">
                                                        <a href="#" title="Facebook" target="_blank">
                                                            <span><i class="pbmit-base-icon-facebook-f"></i></span>
                                                        </a>
                                                    </li>
                                                    <li class="pbmit-social-li pbmit-social-twitter">
                                                        <a href="#" title="Twitter" target="_blank">
                                                            <span><i class="pbmit-base-icon-twitter-2"></i></span>
                                                        </a>
                                                    </li>
                                                    <li class="pbmit-social-li pbmit-social-linkedin">
                                                        <a href="#" title="LinkedIn" target="_blank">
                                                            <span><i class="pbmit-base-icon-linkedin-in"></i></span>
                                                        </a>
                                                    </li>
                                                    <li class="pbmit-social-li pbmit-social-instagram">
                                                        <a href="#" title="Instagram" target="_blank">
                                                            <span><i class="pbmit-base-icon-instagram"></i></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <!-- Slide2 -->
                            <article class="pbmit-team-style-1 swiper-slide">
                                <div class="pbminfotech-post-item">
                                    <div class="pbmit-featured-wrap">
                                        <div class="pbmit-featured-inner">
                                            <div class="pbmit-featured-img-wrapper">
                                                <div class="pbmit-featured-wrapper">
                                                    <img src="images/team/team-02.jpg" class="img-fluid" alt="">
                                                </div>
                                            </div>
                                            <a class="pbmit-link" href="team-member-detail.html"></a>
                                        </div>
                                    </div>
                                    <div class="pbminfotech-box-content">
                                        <div class="pbminfotech-box-content-inner">
                                            <h3 class="pbmit-team-title">
                                                <a href="team-member-detail.html">Alex Mitchell</a>
                                            </h3>
                                            <div class="pbminfotech-box-team-position">Technical Lead</div>
                                        </div>
                                        <div class="pbmit-team-btn">
                                            <a class="pbmit-team-text" href="#">
                                                <i class="pbmit-base-icon-share"></i>
                                            </a>
                                            <div class="pbminfotech-box-social-links">
                                                <ul class="pbmit-social-links pbmit-team-social-links">
                                                    <li class="pbmit-social-li pbmit-social-facebook">
                                                        <a href="#" title="Facebook" target="_blank">
                                                            <span><i class="pbmit-base-icon-facebook-f"></i></span>
                                                        </a>
                                                    </li>
                                                    <li class="pbmit-social-li pbmit-social-twitter">
                                                        <a href="#" title="Twitter" target="_blank">
                                                            <span><i class="pbmit-base-icon-twitter-2"></i></span>
                                                        </a>
                                                    </li>
                                                    <li class="pbmit-social-li pbmit-social-linkedin">
                                                        <a href="#" title="LinkedIn" target="_blank">
                                                            <span><i class="pbmit-base-icon-linkedin-in"></i></span>
                                                        </a>
                                                    </li>
                                                    <li class="pbmit-social-li pbmit-social-instagram">
                                                        <a href="#" title="Instagram" target="_blank">
                                                            <span><i class="pbmit-base-icon-instagram"></i></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <!-- Slide3 -->
                            <article class="pbmit-team-style-1 swiper-slide">
                                <div class="pbminfotech-post-item">
                                    <div class="pbmit-featured-wrap">
                                        <div class="pbmit-featured-inner">
                                            <div class="pbmit-featured-img-wrapper">
                                                <div class="pbmit-featured-wrapper">
                                                    <img src="images/team/team-03.jpg" class="img-fluid" alt="">
                                                </div>
                                            </div>
                                            <a class="pbmit-link" href="team-member-detail.html"></a>
                                        </div>
                                    </div>
                                    <div class="pbminfotech-box-content">
                                        <div class="pbminfotech-box-content-inner">
                                            <h3 class="pbmit-team-title">
                                                <a href="team-member-detail.html">John Harris</a>
                                            </h3>
                                            <div class="pbminfotech-box-team-position">Shipping Head</div>
                                        </div>
                                        <div class="pbmit-team-btn">
                                            <a class="pbmit-team-text" href="#">
                                                <i class="pbmit-base-icon-share"></i>
                                            </a>
                                            <div class="pbminfotech-box-social-links">
                                                <ul class="pbmit-social-links pbmit-team-social-links">
                                                    <li class="pbmit-social-li pbmit-social-facebook">
                                                        <a href="#" title="Facebook" target="_blank">
                                                            <span><i class="pbmit-base-icon-facebook-f"></i></span>
                                                        </a>
                                                    </li>
                                                    <li class="pbmit-social-li pbmit-social-twitter">
                                                        <a href="#" title="Twitter" target="_blank">
                                                            <span><i class="pbmit-base-icon-twitter-2"></i></span>
                                                        </a>
                                                    </li>
                                                    <li class="pbmit-social-li pbmit-social-linkedin">
                                                        <a href="#" title="LinkedIn" target="_blank">
                                                            <span><i class="pbmit-base-icon-linkedin-in"></i></span>
                                                        </a>
                                                    </li>
                                                    <li class="pbmit-social-li pbmit-social-instagram">
                                                        <a href="#" title="Instagram" target="_blank">
                                                            <span><i class="pbmit-base-icon-instagram"></i></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <!-- Slide4 -->
                            <article class="pbmit-team-style-1 swiper-slide">
                                <div class="pbminfotech-post-item">
                                    <div class="pbmit-featured-wrap">
                                        <div class="pbmit-featured-inner">
                                            <div class="pbmit-featured-img-wrapper">
                                                <div class="pbmit-featured-wrapper">
                                                    <img src="images/team/team-04.jpg" class="img-fluid" alt="">
                                                </div>
                                            </div>
                                            <a class="pbmit-link" href="team-member-detail.html"></a>
                                        </div>
                                    </div>
                                    <div class="pbminfotech-box-content">
                                        <div class="pbminfotech-box-content-inner">
                                            <h3 class="pbmit-team-title">
                                                <a href="team-member-detail.html">David Handson</a>
                                            </h3>
                                            <div class="pbminfotech-box-team-position">Program Manager</div>
                                        </div>
                                        <div class="pbmit-team-btn">
                                            <a class="pbmit-team-text" href="#">
                                                <i class="pbmit-base-icon-share"></i>
                                            </a>
                                            <div class="pbminfotech-box-social-links">
                                                <ul class="pbmit-social-links pbmit-team-social-links">
                                                    <li class="pbmit-social-li pbmit-social-facebook">
                                                        <a href="#" title="Facebook" target="_blank">
                                                            <span><i class="pbmit-base-icon-facebook-f"></i></span>
                                                        </a>
                                                    </li>
                                                    <li class="pbmit-social-li pbmit-social-twitter">
                                                        <a href="#" title="Twitter" target="_blank">
                                                            <span><i class="pbmit-base-icon-twitter-2"></i></span>
                                                        </a>
                                                    </li>
                                                    <li class="pbmit-social-li pbmit-social-linkedin">
                                                        <a href="#" title="LinkedIn" target="_blank">
                                                            <span><i class="pbmit-base-icon-linkedin-in"></i></span>
                                                        </a>
                                                    </li>
                                                    <li class="pbmit-social-li pbmit-social-instagram">
                                                        <a href="#" title="Instagram" target="_blank">
                                                            <span><i class="pbmit-base-icon-instagram"></i></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <!-- Slide5 -->
                            <article class="pbmit-team-style-1 swiper-slide">
                                <div class="pbminfotech-post-item">
                                    <div class="pbmit-featured-wrap">
                                        <div class="pbmit-featured-inner">
                                            <div class="pbmit-featured-img-wrapper">
                                                <div class="pbmit-featured-wrapper">
                                                    <img src="images/team/team-05.jpg" class="img-fluid" alt="">
                                                </div>
                                            </div>
                                            <a class="pbmit-link" href="team-member-detail.html"></a>
                                        </div>
                                    </div>
                                    <div class="pbminfotech-box-content">
                                        <div class="pbminfotech-box-content-inner">
                                            <h3 class="pbmit-team-title">
                                                <a href="team-member-detail.html">Micheal Wagou</a>
                                            </h3>
                                            <div class="pbminfotech-box-team-position">Data Analyst</div>
                                        </div>
                                        <div class="pbmit-team-btn">
                                            <a class="pbmit-team-text" href="#">
                                                <i class="pbmit-base-icon-share"></i>
                                            </a>
                                            <div class="pbminfotech-box-social-links">
                                                <ul class="pbmit-social-links pbmit-team-social-links">
                                                    <li class="pbmit-social-li pbmit-social-facebook">
                                                        <a href="#" title="Facebook" target="_blank">
                                                            <span><i class="pbmit-base-icon-facebook-f"></i></span>
                                                        </a>
                                                    </li>
                                                    <li class="pbmit-social-li pbmit-social-twitter">
                                                        <a href="#" title="Twitter" target="_blank">
                                                            <span><i class="pbmit-base-icon-twitter-2"></i></span>
                                                        </a>
                                                    </li>
                                                    <li class="pbmit-social-li pbmit-social-linkedin">
                                                        <a href="#" title="LinkedIn" target="_blank">
                                                            <span><i class="pbmit-base-icon-linkedin-in"></i></span>
                                                        </a>
                                                    </li>
                                                    <li class="pbmit-social-li pbmit-social-instagram">
                                                        <a href="#" title="Instagram" target="_blank">
                                                            <span><i class="pbmit-base-icon-instagram"></i></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="pbmit-heading">
                        <h2 class="pbmit-title mb-4">Our Client Review</h2>
                    </div>
                    <p>Having a global network is essential for a logistics provider. The supplies can be sourced from entirely different locations such as the United States, the Middle East, Asia Pacific, South Africa, etc. <br> So, hiring a logistics provider with vast global connections will go a long way in enhancing business growth. To conclude, project logistics is vital to every large and complex project.</p>
                    <div class="ihbox-style-area pbmit-bg-color-white">
                        <div class="pbmit-ihbox-style-7">
                            <div class="pbmit-ihbox-box">
                                <div class="pbmit-icon-wrapper d-md-flex">
                                    <div class="pbmit-ihbox-icon">
                                        <div class="pbmit-ihbox-icon-wrapper pbmit-icon-type-icon">
                                            <svg id="Layer_1" enable-background="new 0 0 100 100" viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                                <path d="m54.75 61.7309799v-2.3699951c0-21.9786606 16.2715454-39.8894348 37.5211639-42.4388428 2.7931672-.3351097 5.2288361 1.917471 5.2288361 4.7306748v.0000095c0 2.4273148-1.8343735 4.4202805-4.2426605 4.7236137-7.4862671.9429264-14.1913986 4.3405972-19.203804 9.2676563-1.7802734 1.7499619-.5009689 4.7270927 1.9953613 4.7170334.0236969-.0000954.0474014-.000145.0710983-.000145 12.2492294 0 21.9682159 10.0996895 21.3522568 22.4834023-.538559 10.8274422-9.4114075 19.7002907-20.2388535 20.2388496-12.3837051.6159593-22.4833984-9.1030272-22.4833984-21.3522567z"></path>
                                                <path d="m2.5000021 61.2574081.000001-1.8964233c0-21.9786606 16.2715454-39.8894348 37.5211601-42.4388428 2.7931755-.3351097 5.2288368 1.917471 5.2288368 4.7306748v.0003147c0 2.4272079-1.8342209 4.4199734-4.2423592 4.7236252-7.481739.9434032-14.1888084 4.3410473-19.1987572 9.2678051-1.779623 1.7500687-.500473 4.7271957 1.9954643 4.7165833.025219-.0001068.0504398-.0001602.0756588-.0001602 11.8699932 0 21.3699932 9.5 21.3699932 21.3699951 0 12.0883865-9.8361855 21.7125397-21.996748 21.3711853-11.6399678-.3267442-20.7532557-10.200203-20.7532498-21.8447572z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="pbmit-title-wrap">
                                        <h2 class="pbmit-element-title">Know when to email vs. when to meet. Logistics are best handled over a non-immediate communication
                                            channel like email or Asana tasks. Detailed status meetings will suck the life out of your day.
                                        </h2>
                                        <div class="pbmit-heading-desc">Satisfied client</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <nav class="navigation post-navigation" aria-label="Posts">
                    <div class="nav-links">
                        <div class="nav-previous">
                            <a href="#" rel="prev">
										<span class="pbmit-post-nav-icon">
											<i class="pbmit-base-icon-left-arrow-1"></i>
											<span class="pbmit-post-nav-head">Previous Post</span>
										</span>
                                <span class="pbmit-post-nav-wrapper">
											<span class="pbmit-post-nav nav-title">Indian Logistic Hubs</span>
										</span>
                            </a>
                        </div>
                        <div class="nav-next">
                            <a href="#" rel="next">
										<span class="pbmit-post-nav-icon">
											<span class="pbmit-post-nav-head">Next Post</span>
											<i class="pbmit-base-icon-next"></i>
										</span>
                                <span class="pbmit-post-nav-wrapper">
											<span class="pbmit-post-nav nav-title">Autonomous Vehicles</span>
										</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </article>
        </div>
    </section>
    <!-- Single Detail Style 2 End -->
@endsection
