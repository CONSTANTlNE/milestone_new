@extends('frontend.layouts.master')
@section('title') {{ __('strings.Home') }} @endsection

@section('header_background')
    <div class="pbmit-title-bar-wrapper" style="background-image: url({{asset($page->src ?: config('filemanager.default_backend_image'))}});">
        <div class="container">
            <div class="pbmit-title-bar-content">
                <div class="pbmit-title-bar-content-inner">
                    <div class="pbmit-tbar">
                        <div class="pbmit-tbar-inner container">
                            <h1 class="pbmit-tbar-title">{{$page->title}}</h1>
                        </div>
                    </div>
                    <div class="pbmit-breadcrumb">
                        <div class="pbmit-breadcrumb-inner">
								<span>
									<a title="" href="#" class="home"><span>{{__('page')}}</span></a>
								</span>
                            <span class="sep">
									<i class="pbmit-base-icon-angle-right"></i>
								</span>
                            <span><span class="post-root post post-post current-item"> {{$page->title}}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Service Details -->
    <section class="site-content service-details">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-xl-3 service-left-col sidebar">
                    <aside class="service-sidebar">
                        <aside class="widget post-list">
                            <h2 class="widget-title">Our Service</h2>
                            <div class="all-post-list">
                                <ul>
                                    <li class="post-active">
                                        <a href="service-details.html"> Warehouse Storage </a>
                                    </li>
                                    <li>
                                        <a href="service-details.html">
                                            Real Time Tracking
                                        </a>
                                    </li>
                                    <li>
                                        <a href="service-details.html">
                                            Distribution Centers
                                        </a>
                                    </li>
                                    <li>
                                        <a href="service-details.html">
                                            Bonded Warehousing
                                        </a>
                                    </li>
                                    <li>
                                        <a href="service-details.html">
                                            Last Mile Delivery
                                        </a>
                                    </li>
                                    <li>
                                        <a href="service-details.html"> Customs Clearance </a>
                                    </li>
                                    <li>
                                        <a href="service-details.html">
                                            Automated Warehousing
                                        </a>
                                    </li>
                                    <li>
                                        <a href="service-details.html"> Seasonal Storage </a>
                                    </li>
                                    <li>
                                        <a href="service-details.html">
                                            Fulfillment Centers
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </aside>
                        <aside class="widget pbmit-service-ad">
                            <div class="pbmit-widget-ads">
                                <img
                                    src="images/bg/service-ad-bg.jpg"
                                    class="bg-img"
                                    alt=""
                                />
                                <div class="pbmit-service-ad-wrapper">
                                    <div class="pbmit-service-ads">
                                        <div class="pbmit-ads-icon">
                                            <i class="pbmit-base-icon-phone-call"></i>
                                        </div>
                                        <span>We Offering Speed & Reliable Services.</span>
                                        <h3 class="pbmit-ads-call">
                                            <a href="tel:+0(123)456-789">+0(123)456-789</a>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </aside>
                        <aside class="widget pbmit-download-info">
                            <h2 class="widget-title">Company profile</h2>
                            <div class="textwidget">
                                <div class="pbmit-download">
                                    <div class="pbmit-item-download">
                                        <a href="#" target="_blank" rel="noopener">
                                            <div class="pbmit-download-content">
                                                <div class="pbmit-download-wrap">
                                                    <i class="pbmit-base-icon-pdf"></i>
                                                    <div class="pbmit-title-wrap">
                                                        <h3 class="pbmit-download-title">
                                                            Document of Business
                                                        </h3>
                                                        <span>Brouchers</span>
                                                    </div>
                                                </div>
                                                <span class="pbmit-download-item">
                                <i
                                    class="pbminfotech-base-icons pbmit-righticon pbmit-base-icon-download"
                                ></i>
                              </span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="pbmit-item-download">
                                        <a href="#" target="_blank" rel="noopener">
                                            <div class="pbmit-download-content">
                                                <div class="pbmit-download-wrap">
                                                    <i class="pbmit-base-icon-pdf"></i>
                                                    <div class="pbmit-title-wrap">
                                                        <h3 class="pbmit-download-title">
                                                            Download Word File
                                                        </h3>
                                                        <span>Brouchers</span>
                                                    </div>
                                                </div>
                                                <span class="pbmit-download-item">
                                <i
                                    class="pbminfotech-base-icons pbmit-righticon pbmit-base-icon-download"
                                ></i>
                              </span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </aside>
                </div>
                <div class="col-md-12 col-xl-9 service-right-col">
                    <div class="pbmit-service-feature-image">
                        <img
                            src="images/service/service-single-01.jpg"
                            class="img-fluid w-100"
                            alt=""
                        />
                    </div>
                    <div class="pbmit-entry-content">
                        <div class="pbmit-service_content">
                            <div class="pbmit-heading">
                                <h3 class="pbmit-title mb-3">
                                    Road freight delivering worldclass transport
                                </h3>
                            </div>
                            <p class="pbmit-firstletter">
                                More Logistics services are the of goods, materials, and
                                other resources from one place a to another this includes
                                the planning, implementation, and
                                <span class="pbmit-medium"
                                >control of the supply chain</span
                                >
                                , from the customer way to the fulfillment warehouse.
                            </p>
                            <p>
                                Logistics services can help businesses meet customer
                                expectations by ensuring products are delivered on time
                                and in good a condition. lead increased customer retention
                                much as loyalty. When choosing a logistic service,
                                <span class="pbmit-medium"
                                ><u>Quality of packaging and delivery,</u></span
                                >
                                and Technology and efficiency. Ability to meet more
                                demand, deliver products to your customer, and grow your
                                profit ot a margins. you can consider and a things like as
                                Capabilities and areas of expertise, Reliability and
                                reputation,
                            </p>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                            <span class="pbmit-icon-list-icon">
                              <i
                                  aria-hidden="true"
                                  class="pbmit-base-icon-check-mark"
                              ></i>
                            </span>
                                            Tracking inventory and ensuring proper storage space
                                        </li>
                                        <li class="list-group-item">
                            <span class="pbmit-icon-list-icon">
                              <i
                                  aria-hidden="true"
                                  class="pbmit-base-icon-check-mark"
                              ></i>
                            </span>
                                            Returns processing Handling returned or damaged
                                            goods
                                        </li>
                                        <li class="list-group-item">
                            <span class="pbmit-icon-list-icon">
                              <i
                                  aria-hidden="true"
                                  class="pbmit-base-icon-check-mark"
                              ></i>
                            </span>
                                            Storing products in warehouses and fulfillment
                                            centers
                                        </li>
                                        <li class="list-group-item">
                            <span class="pbmit-icon-list-icon">
                              <i
                                  aria-hidden="true"
                                  class="pbmit-base-icon-check-mark"
                              ></i>
                            </span>
                                            Picking, packing, and shipping products to customers
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                            <span class="pbmit-icon-list-icon">
                              <i
                                  aria-hidden="true"
                                  class="pbmit-base-icon-check-mark"
                              ></i>
                            </span>
                                            Assistance with customs, tariff, compliance, other
                                            regular
                                        </li>
                                        <li class="list-group-item">
                            <span class="pbmit-icon-list-icon">
                              <i
                                  aria-hidden="true"
                                  class="pbmit-base-icon-check-mark"
                              ></i>
                            </span>
                                            Packaging Design and manufacturing of packaging
                                        </li>
                                        <li class="list-group-item">
                            <span class="pbmit-icon-list-icon">
                              <i
                                  aria-hidden="true"
                                  class="pbmit-base-icon-check-mark"
                              ></i>
                            </span>
                                            Things like: Capabilities and areas of expertise
                                        </li>
                                        <li class="list-group-item">
                            <span class="pbmit-icon-list-icon">
                              <i
                                  aria-hidden="true"
                                  class="pbmit-base-icon-check-mark"
                              ></i>
                            </span>
                                            Transportation Selecting the best mode of shipmen
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="service-single-images pt-4 pb-5">
                                <div class="row">
                                    <div class="col-md-6 text-center">
                                        <div class="pbmit-animation-style7">
                                            <img
                                                src="images/service/service-single-02.jpg"
                                                class="img-fluid"
                                                alt=""
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <div class="pbmit-animation-style7 mt-md-0 mt-4">
                                            <img
                                                src="images/service/service-single-02.jpg"
                                                class="img-fluid"
                                                alt=""
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pbmit-heading animation-style2">
                            <h3 class="pbmit-title mb-3">Frequently asked questions</h3>
                        </div>
                        <p>
                            Consectetur adipisicing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna aliqua. Ut enim ad
                            minim veniam, quis nostrud laboris nisi ut aliquip ex ea
                            commodo consequat. fugiat nulla pariatur. Nemo enim ipsam
                            voluptatem quia voluptas voluptatem.
                        </p>
                        <div class="accordion style-3" id="accordionExample1">
                            <div class="accordion-item active" id="headingOne1">
                                <h2 class="accordion-header">
                                    <button
                                        class="accordion-button"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne1"
                                        aria-expanded="false"
                                        aria-controls="collapseOne1"
                                    >
                          <span class="pbmit-accordion-title">
                            <span class="pbmit-number">01</span>
                            How do I obtain insurance for my goods?
                          </span>
                                        <span class="pbmit-accordion-icon">
                            <span class="pbmit-accordion-icon-opened">
                              <i
                                  class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                              ></i>
                            </span>
                            <span class="pbmit-accordion-icon-closed">
                              <i
                                  class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                              ></i>
                            </span>
                          </span>
                                    </button>
                                </h2>
                                <div
                                    id="collapseOne1"
                                    class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne1"
                                    data-bs-parent="#accordionExample1"
                                >
                                    <div class="accordion-body">
                                        <p>
                                            Logistics refers to the process of planning,
                                            implementing, and controlling movement and storage
                                            of goods services or information from point of
                                            origin to the main point of consumption. Logistics
                                            refers to the process of planning, implementing, and
                                            controlling movement.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo1">
                                    <button
                                        class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo1"
                                        aria-expanded="false"
                                        aria-controls="collapseTwo1"
                                    >
                          <span class="pbmit-accordion-title">
                            <span class="pbmit-number">02</span>
                            What types of service does Moovit provide?
                          </span>
                                        <span class="pbmit-accordion-icon">
                            <span class="pbmit-accordion-icon-opened">
                              <i
                                  class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                              ></i>
                            </span>
                            <span class="pbmit-accordion-icon-closed">
                              <i
                                  class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                              ></i>
                            </span>
                          </span>
                                    </button>
                                </h2>
                                <div
                                    id="collapseTwo1"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="headingTwo1"
                                    data-bs-parent="#accordionExample1"
                                >
                                    <div class="accordion-body">
                                        <p>
                                            Logistics refers to the process of planning,
                                            implementing, and controlling movement and storage
                                            of goods services or information from point of
                                            origin to the main point of consumption. Logistics
                                            refers to the process of planning, implementing, and
                                            controlling movement.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree1">
                                    <button
                                        class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree1"
                                        aria-expanded="false"
                                        aria-controls="collapseThree1"
                                    >
                          <span class="pbmit-accordion-title">
                            <span class="pbmit-number">03</span>
                            Do you sign a safety guarantee?
                          </span>
                                        <span class="pbmit-accordion-icon">
                            <span class="pbmit-accordion-icon-opened">
                              <i
                                  class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                              ></i>
                            </span>
                            <span class="pbmit-accordion-icon-closed">
                              <i
                                  class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                              ></i>
                            </span>
                          </span>
                                    </button>
                                </h2>
                                <div
                                    id="collapseThree1"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="headingThree1"
                                    data-bs-parent="#accordionExample1"
                                >
                                    <div class="accordion-body">
                                        <p>
                                            Logistics refers to the process of planning,
                                            implementing, and controlling movement and storage
                                            of goods services or information from point of
                                            origin to the main point of consumption. Logistics
                                            refers to the process of planning, implementing, and
                                            controlling movement.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour1">
                                    <button
                                        class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseFour1"
                                        aria-expanded="false"
                                        aria-controls="collapseFour1"
                                    >
                          <span class="pbmit-accordion-title">
                            <span class="pbmit-number">04</span>
                            What are the different types of logistics?
                          </span>
                                        <span class="pbmit-accordion-icon">
                            <span class="pbmit-accordion-icon-opened">
                              <i
                                  class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                              ></i>
                            </span>
                            <span class="pbmit-accordion-icon-closed">
                              <i
                                  class="pbmit-shipex-icon pbmit-shipex-icon-levels"
                              ></i>
                            </span>
                          </span>
                                    </button>
                                </h2>
                                <div
                                    id="collapseFour1"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="headingFour1"
                                    data-bs-parent="#accordionExample1"
                                >
                                    <div class="accordion-body">
                                        <p>
                                            Logistics refers to the process of planning,
                                            implementing, and controlling movement and storage
                                            of goods services or information from point of
                                            origin to the main point of consumption. Logistics
                                            refers to the process of planning, implementing, and
                                            controlling movement.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Service Details End -->
@endsection
