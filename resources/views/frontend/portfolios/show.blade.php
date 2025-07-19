@extends('frontend.layouts.master')
@section('title') {{ __('strings.Home') }} @endsection

@section('header_background')
    <div class="pbmit-title-bar-wrapper">
        <div class="container">
            <div class="pbmit-title-bar-content">
                <div class="pbmit-title-bar-content-inner">
                    <div class="pbmit-tbar">
                        <div class="pbmit-tbar-inner container">
                            <h3 class="pbmit-tbar-subtitle"> Portfolio</h3>
                            <h1 class="pbmit-tbar-title"> Warehouse Inventory</h1>
                        </div>
                    </div>
                    <div class="pbmit-breadcrumb">
                        <div class="pbmit-breadcrumb-inner">
									<span>
										<a title="" href="#" class="home"><span>Portfolio</span></a>
									</span>
                            <span class="sep">
										<i class="pbmit-base-icon-angle-right"></i>
										</span>
                            <span><span class="post-root post post-post current-item"> Warehouse Inventory</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <!-- Single Detail Style 1 -->
    <section class="site-content">
        <div class="container">
            <article class="pbmit-portfolio-single">
                <div class="pbmit-featured-img-wrapper">
                    <img src="images/portfolio/portfolio-single-01.jpg" class="img-fluid w-100" alt="">
                </div>
{{--                <div class="pbmit-single-project-details-list">--}}
{{--                    <h3 class="mb-4">Project info</h3>--}}
{{--                    <div class="pbmit-portfolio-lines-wrapper">--}}
{{--                        <ul class="pbmit-portfolio-lines-ul">--}}
{{--                            <li class="pbmit-portfolio-line-li">--}}
{{--                                <span class="pbmit-portfolio-line-title">Client : </span>--}}
{{--                                <span class="pbmit-portfolio-line-value">Tom Olson</span>--}}
{{--                            </li>--}}
{{--                            <li class="pbmit-portfolio-line-li">--}}
{{--                                <span class="pbmit-portfolio-line-title">Tag : </span>--}}
{{--                                <span class="pbmit-portfolio-line-value">Fast Delivery</span>--}}
{{--                            </li>--}}
{{--                            <li class="pbmit-portfolio-line-li">--}}
{{--                                <span class="pbmit-portfolio-line-title">Date : </span>--}}
{{--                                <span class="pbmit-portfolio-line-value">20 Jan 2020</span>--}}
{{--                            </li>--}}
{{--                            <li class="pbmit-portfolio-line-li">--}}
{{--                                <span class="pbmit-portfolio-line-title">Status : </span>--}}
{{--                                <span class="pbmit-portfolio-line-value">Process</span>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="pbmit-entry-content">
                    <div class="pbmit-heading">
                        <h2 class="pbmit-title mb-4">Project Description</h2>
                    </div>
                    <p class="pbmit-firstletter">Project logistics is the planning, execution, and management of the <span class="pbmit-global-color" style="font-weight: 500;">transportation and movement of materials,</span> equipment, and goods for a specific project. It’s a part of supply chai <br> management, but differs from traditional logistics, which focuses on ongoing operations. Project logistics is used for temporary and unique projects, such as construction, event has <br> management, or infrastructure development. Each project has its own requirements, challenges, and timelines, so project logisticians successfully complete a project cover must adapt the <br> strategies and solutions a accordingly. The logistics activities needed tothe integrated process of planning and executing the complete flow of containerized and non-containerized cargo an <br> suppliers spread across the globe, ensuring that all cargo eventually converges at a given destination.</p>
                    <p>Project logistics can be complex due to the size of the project, the diversity of materials and equipment, and the project site’s geographical location. Project logistics is a specialised service offering within the global logistics industry. It combines traditional freight forwarding and transport capabilities with unique skills and competence needed for project planning.</p>
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
                    </div>
                </div>
            </article>
        </div>
    </section>
    <!-- Single Detail Style 1 End -->
@endsection
