@extends('frontend.layouts.master')
@section('title') {{ $blog->title }} - @endsection
@section('seo')
    @include('components.frontend.socials.seo', ['data' => $blog])
@endsection
@section('header_background')
    <div class="pbmit-title-bar-wrapper">
        <div class="container">
            <div class="pbmit-title-bar-content">
                <div class="pbmit-title-bar-content-inner">
                    <div class="pbmit-tbar">
                        <div class="pbmit-tbar-inner container">
                            <h1 class="pbmit-tbar-title"> {{$blog->title}}</h1>
                        </div>
                    </div>
                    <div class="pbmit-breadcrumb">
                        <div class="pbmit-breadcrumb-inner">
								<span>
									<a title="" href="#" class="home"><span>{{__('blog')}}</span></a>
								</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <!-- Blog Single Details -->
    <section class="site-content blog-details">
        <div class="container">
            <div class="row">
                <div class="col-md-9 blog-left-col">
                    <div class="row">
                        <div class="col-md-12">
                            <article>
                                <div class="post blog-classic">
                                    <div class="pbmit-img-wrapper">
                                        <div class="pbmit-featured-img-wrapper">
                                            <div class="pbmit-featured-wrapper">
                                                <img src="{{asset($blog->src ?: config('filemanager.default_backend_image'))}}" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                        <span class="pbmit-meta pbmit-meta-cat">
												<i class="pbmit-base-icon-calendar-3"></i>
												<a href="#" rel="category tag">Freight</a>
											</span>
                                    </div>
                                    <div class="pbmit-blog-classic-inner">
                                        <div class="pbmit-blog-meta pbmit-blog-meta-top">
                                            <div class="pbmit-meta pbmit-meta-cat">
                                                <a href="#" rel="category tag">Freight</a>
                                            </div>

                                            <span class="pbmit-meta pbmit-meta-date">
													<i class="pbmit-base-icon-calendar-3"></i>
													<a href="#" rel="bookmark">
														<span class="entry-date">27 Dec, 2024</span>
													</a>
												</span>

                                        </div>
                                        <div class="pbmit-entry-content">
                                            <p class="pbmit-firstletter">
                                                Logistic regression is a data analysis technique that uses mathematics to find the relationships between two data factors. then uses this relationship to predict the value of one of those factors based on the other. <span class="pbmit-medium">Prediction usually has a finite</span> number of outcome
                                            </p>
                                            <p>For example, let’s say you want to guess if your website visitor will click the checkout button in their shopping cart or not. It determine that,  the past, if visitors spent more than five minutes on. <span class="pbmit-medium"><u>Logistic regression analysis</u></span>  looks at past visitor behavior, such as time spent on the as website and the number of items in the cart site and added more than three items to the cart, they clicked the checkout button. Using as this information, the logistic regression function can then predict the behavior of a new website visitor.</p>
                                            <blockquote>
                                                <p>“I actually think it’s better I started by being close to customers. That foundation early on helped me later I went into logistics & other kinds of management.” <cite>satisfied client</cite></p>
                                            </blockquote>
                                            <h3 class="pbmit-title mb-3">Negotiate with several carriers</h3>
                                            <p>Logistics is the part of supply chain management that deals with the efficient forward and reverse flow of goods, services, and related information from the point of origin to the point of <span class="pbmit-medium"><u>Logistics management is a component</u></span>  that holds the supply chain together. acto consumption the needs of customers.</p>
                                            <p>Logistics deals with the movements of materials or products from one facility to another it does not include material flow within duction or assembly plants, production machine scheduling. Logistics occupies a significant amount operational cost of an organisation or country.</p>
                                            <ul class="list-group">
                                                <li class="list-group-item">
														<span class="pbmit-icon-list-icon">
															<i aria-hidden="true" class="pbmit-base-icon-check-mark"></i>
														</span>
                                                    Function of understanding stock mix of a company and the different demands on that stock.
                                                </li>
                                                <li class="list-group-item">
														<span class="pbmit-icon-list-icon">
															<i aria-hidden="true" class="pbmit-base-icon-check-mark"></i>
														</span>
                                                    Legal demand by a shipper or consignee against a carrier in respect of damage or loss to a shipment.
                                                </li>
                                                <li class="list-group-item">
														<span class="pbmit-icon-list-icon">
															<i aria-hidden="true" class="pbmit-base-icon-check-mark"></i>
														</span>
                                                    Performance based logistics  Defense acquisition strategy for cost-effective weapon system support.
                                                </li>
                                                <li class="list-group-item">
														<span class="pbmit-icon-list-icon">
															<i aria-hidden="true" class="pbmit-base-icon-check-mark"></i>
														</span>
                                                    Sales territory  Geographic area or customer group managed by a sales representative
                                                </li>
                                            </ul>
                                            <p class="mt-3">Order processing, inventory management, and freight transportation. Traditionally, order processing was a time-consuming activity that could take up to 70% of the order-cycle time.  and the availability of stocks can be checked in real time.</p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 blog-right-col">
                    <aside class="sidebar">
                        <aside class="widget widget-categories">
                            <h2 class="widget-title">{{__('catagories')}}</h2>
                            <ul>
                                @foreach($blogCategories as $category)
                                    <li>
										<span class="pbmit-cat-li">
											<a href="{{ route('frontend.blogCategories.show', ['id'=>$category->id, 'slug'=>$category->slug]) }}">{{$category->title}}</a>
											<span class="pbmit-brackets">( {{count($category->blogs)}} )</span>
										</span>
                                    </li>
                                @endforeach
                            </ul>
                        </aside>
                        <aside class="widget pbmit-service-ad">
                            <div class="pbmit-widget-ads">
                                <img
                                    src="{{asset('assets/images/bg/service-ad-bg.jpg')}}"
                                    class="bg-img"
                                    alt=""
                                />
                                <div class="pbmit-service-ad-wrapper">
                                    <div class="pbmit-service-ads">
                                        <div class="pbmit-ads-icon">
                                            <i class="pbmit-base-icon-phone-call"></i>
                                        </div>
                                        <span>{{__('contact_text_number')}}</span>
                                        @if(!empty(getContact()->phone) or !empty(getContact()->phone1))
                                            <h3 class="pbmit-ads-call">
                                                <a href="tel:{{getContact()->phone}}">{{getContact()->phone}}</a>
                                                <a href="tel:{{getContact()->phone1}}">{{getContact()->phone1}}</a>
                                            </h3>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Single Details End -->
@endsection
