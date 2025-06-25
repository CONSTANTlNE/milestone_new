@extends('backend.layouts.master')
@section('title') {{ __('strings.Home') }} @endsection
@section('content')
    <div class="container-fluid">
        <div class="form-head d-md-flex mb-sm-4 mb-3 align-items-start">
            <div class="mr-auto  d-lg-block">
                <h2 class="text-black font-w600">Dashboard</h2>
                <p class="mb-0 font-w600">{{ __('strings.Welcome') }}</p>
            </div>
            {{--<a href="javascript:void(0);" class="btn btn-primary rounded light mr-3">www.hotjar.com</a>--}}
            <a href="{{route('frontend.index')}}" class="btn btn-primary rounded" target="blank">www.factcheck.ge</a>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card house-bx">
                    <div class="card-body">
                        <div class="media align-items-center user-info">
                            <i class="flaticon-381-user-4"></i>
                            <div class="media-body">
                                <h4 class="fs-22 text-white">{{ __('strings.User Information') }}</h4>
                                <p class="mb-0" style="color: #fff;"><strong>{{ __('strings.Email') }}:</strong> {{ Auth::user()->email }} |
                                    <strong>{{ __('strings.Role') }}:</strong> {{ Auth::user()->roles()->pluck('name')->implode(' ') }}</p>
                                <p class="mb-0" style="color: #fff;">{{ __('strings.About') }}: {{ Auth::user()->about }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="media-body">
                                <h2 class="fs-36 text-black font-w600"></h2>
                                <span class="fs-18 text-black">{{ __('strings.User') }}</span>
                                <a href="" style="margin-bottom: 0 !important; display: block">{{ __('strings.View All') }}</a>
                            </div>
                            <span class="bg-primary rounded p-3">
                                <svg width="38" height="38" viewBox="0 0 32 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M30.0833 38H1.58333C1.16341 38 0.76068 37.8332 0.463748 37.5363C0.166815 37.2393 0 36.8366 0 36.4167V34.846C0.00454968 32.3984 0.823669 30.022 2.32819 28.0915C3.83271 26.161 5.93704 24.7861 8.30933 24.1838C8.64572 24.1014 8.94519 23.9096 9.1607 23.6385C9.37622 23.3673 9.49557 23.0323 9.5 22.686V21.0932L7.73142 19.3262C7.2884 18.8912 6.93657 18.3723 6.69651 17.7997C6.45645 17.2272 6.33298 16.6125 6.33333 15.9917V9.43984C6.36235 6.99347 7.32801 4.65129 9.03156 2.8953C10.7351 1.13932 13.047 0.103143 15.4913 8.17276e-06C16.7821 -0.00165631 18.0606 0.250939 19.2538 0.743372C20.447 1.23581 21.5315 1.95843 22.4454 2.86999C23.3594 3.78156 24.0848 4.8642 24.5803 6.05611C25.0758 7.24803 25.3317 8.52587 25.3333 9.81667V15.9917C25.3329 16.6169 25.2072 17.2358 24.9638 17.8117C24.7205 18.3876 24.3643 18.909 23.9163 19.3452L22.1667 21.0932V22.686C22.1712 23.0325 22.2908 23.3677 22.5066 23.6389C22.7224 23.91 23.0222 24.1017 23.3589 24.1838C25.7308 24.7867 27.8346 26.1617 29.3388 28.0922C30.8429 30.0226 31.6619 32.3987 31.6667 34.846V36.4167C31.6667 36.8366 31.4999 37.2393 31.2029 37.5363C30.906 37.8332 30.5033 38 30.0833 38ZM3.16667 34.8333H28.5C28.4927 33.091 27.9061 31.4005 26.8326 30.0281C25.7591 28.6556 24.2597 27.6791 22.5704 27.2523C21.5532 26.9949 20.6503 26.4066 20.004 25.58C19.3576 24.7534 19.0045 23.7353 19 22.686V20.4377C19.0001 20.0178 19.167 19.6151 19.4639 19.3183L21.6964 17.0873C21.8445 16.9458 21.9625 16.7758 22.0433 16.5875C22.1241 16.3992 22.1661 16.1966 22.1667 15.9917V9.81667C22.1693 8.06695 21.4812 6.3869 20.252 5.14168C19.0228 3.89645 17.3518 3.1867 15.6022 3.16667C13.9751 3.23184 12.4352 3.91887 11.2998 5.08606C10.1644 6.25326 9.52019 7.81164 9.5 9.43984V15.9917C9.49967 16.1922 9.53942 16.3907 9.61691 16.5756C9.69441 16.7605 9.80808 16.928 9.95125 17.0683L12.2028 19.3167C12.4997 19.6135 12.6666 20.0162 12.6667 20.4361V22.6844C12.6623 23.7335 12.3093 24.7514 11.6633 25.578C11.0173 26.4046 10.1148 26.9931 9.09783 27.2508C7.40797 27.6773 5.90801 28.6539 4.8342 30.0267C3.76039 31.3995 3.17375 33.0905 3.16667 34.8333Z" fill="white"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="media align-items-center">
                            <div class="media-body">
                                <h2 class="fs-36 text-black font-w600"></h2>
                                <span class="fs-18 text-black">{{ __('strings.Subscribers') }}</span>
                                <a href="" style="margin-bottom: 0 !important; display: block">{{ __('strings.View All') }}</a>
                            </div>
                            <span class="bg-primary rounded p-3">
                                <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.1208 37.6042H1.97909C1.10825 37.6042 0.395752 36.8917 0.395752 36.0208V14.1708C0.395752 13.775 0.554085 13.3 0.870752 13.0625L14.0124 0.791659C14.4874 0.395825 15.1208 0.237492 15.6749 0.474992C16.3083 0.791659 16.6249 1.34583 16.6249 1.97916V36.1C16.6249 36.8917 15.9124 37.6042 15.1208 37.6042ZM3.48325 34.5167H13.5374V5.54166L3.48325 14.8833V34.5167Z" fill="white"/>
                                    <path d="M36.0208 37.6042H15.0416C14.1708 37.6042 13.4583 36.8917 13.4583 36.0208V17.4167C13.4583 16.5458 14.1708 15.8333 15.0416 15.8333H36.0208C36.8916 15.8333 37.6041 16.5458 37.6041 17.4167V36.1C37.6041 36.8917 36.8916 37.6042 36.0208 37.6042ZM16.6249 34.5167H34.5166V18.9208H16.6249V34.5167Z" fill="white"/>
                                    <path d="M28.5791 37.6042H22.4832C21.6124 37.6042 20.8999 36.8917 20.8999 36.0208V26.3625C20.8999 25.4917 21.6124 24.7792 22.4832 24.7792H28.5791C29.4499 24.7792 30.1624 25.4917 30.1624 26.3625V36.0208C30.1624 36.8917 29.4499 37.6042 28.5791 37.6042ZM24.0666 34.5167H27.0749V27.9458H24.0666V34.5167Z" fill="white"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-sm-6">
                <div class="widget-stat card bg-primary">
                    <div class="card-body  p-4">
                        <div class="media">
                            <span class="mr-3">
                                <i class="fa fa-newspaper-o"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1">{{ __('strings.Articles') }}</p>
                                <h3 class="text-white"></h3>
                                <a href="" style="color:#fff; margin-bottom: 0 !important; display: block">{{ __('strings.View All') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-6">
                <div class="widget-stat card bg-warning">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="mr-3">
                                <i class="fa fa-users"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1">{{ __('strings.Persons') }}</p>
                                <h3 class="text-white"></h3>
                                <a href="" style="color:#fff; margin-bottom: 0 !important; display: block">{{ __('strings.View All') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-6">
                <div class="widget-stat card bg-secondary">
                    <div class="card-body p-4">
                        <div class="media">
									<span class="mr-3">
										<i class="fa fa-calendar-check-o"></i>
									</span>
                            <div class="media-body text-white">
                                <p class="mb-1">{{ __('strings.Verdicts') }}</p>
                                <h3 class="text-white"></h3>
                                <a href="" style="color:#fff; margin-bottom: 0 !important; display: block">{{ __('strings.View All') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-sm-6">
                <div class="widget-stat card bg-danger ">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="mr-3">
                                <i class="fa fa-book"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1">{{ __('strings.Database') }}</p>
                                <h3 class="text-white"></h3>
                                <a href="" style="color:#fff; margin-bottom: 0 !important; display: block">{{ __('strings.View All') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
