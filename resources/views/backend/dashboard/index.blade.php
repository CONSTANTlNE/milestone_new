@extends('backend.layouts.master')
@section('title') {{ __('admin.sidebar_dashboard') }} @endsection
@section('content')
    <!-- Start::content  -->
    <div class="content">
        <!-- Start::main-content -->
        <div class="main-content">
            <!-- Page Header -->
            <div class="block justify-between page-header md:flex">
                <div>
                    <h3 class="!text-defaulttextcolor dark:!text-defaulttextcolor/70 dark:text-white dark:hover:text-white text-[1.125rem] font-semibold"> Dashboard</h3>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6 index-table-page white-bg">
                <div class="xl:col-span-12 col-span-12">
                    <div class="box custom-box">
                        <div class="box-body">
                            <ul>
                                <li>1) მენიუ : მენიუ ესაა საიტის მთავარი გვერდები რომელიც გვხვდება ზედა ჰედერში. მისი მენეჯმენტში გასათვალისწინებელი და შემზღუდავი არაფერია.</li>
                                <li>2) ფაილ მენეჯერი: ყველა სექციას მისი ფაილების წყობა აქვს თუ არ აქვს შეგიძლიათ შექმნა, ფაილები არ დავყაროთ გაფანტულად ისინი შესაბამისი სექციის ფოლდერს შეუსაბამოთ გამონაკლისი არის გვერდები = images ფოლდერის.
                                შენიშვნა: როცა სურათი გავქვს ატვირთული არ გვჭირდება ხელმეორედ ატვირთვა ის შეგვიძლია გამოვიყენოთ შესაბამის ფოლდერიდან რომც არ შეესაბამებოდეს სექციას.
                                რა უნდა ვიცოდეთ სურათი წონა არ უნდა იყოს მეგაბაიტზე მეტი, ასევე სურათებს სჭირდება დაჭრა შეგიძლიათ გამოიყენოთ AI ან ხელით ონლაინ ფოტოშოპით https://www.photopea.com/.
                                <br>
                                სურათების ზომები:<br>
                                სლაიდერ = 1900x900; გვერდების/კატეგორიების ქავერ ფოტო =  1900x550; სიახლეები = 900x400; სერვისები = 900x400; პორტფოლიო = 450x520;</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6 index-table-page white-bg">
                <div class="xl:col-span-12 col-span-12">
                    <div class="box custom-box">
                        <div class="box-body">
                            <ul>
                                <li>3) გვერდები</li>
                                <li>4) სლაიდერი</li>
                                <li>5) პორტფოლიო</li>
                                <li>6) სერვისები</li>
                                <li>7) სერვისების კატეგორიები</li>
                                <li>8) FAQ</li>
                                <li>9) სიახლეები</li>
                                <li>10) სიახლეების კატეგორიები</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6 index-table-page white-bg">
                <div class="xl:col-span-12 col-span-12">
                    <div class="box custom-box">
                        <div class="box-body">
                            <ul>
                                <li>11) იუზერები</li>
                                <li>12) როლები</li>
                                <li>13) პერმიშენები</li>
                                <li>14) ენები</li>
                                <li>15) საიტის სეთინგები</li>
                                <li>16) სოც ქსელები</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-6 index-table-page white-bg">
                <div class="xl:col-span-12 col-span-12">
                    <div class="box custom-box">
                        <div class="box-body">
                            <ul>
                                <li>17) ქვოთეიშენები</li>
                            </ul>
                            <br>
                            საერთო:<br>
                            არქივები - წაშლილი ინფორმაცია ყველა სეგმენტში<br>
                            სისტემაში გვაქვს არქივების სისტემა რაც გვეხმარება წაშლილი items აღდგენაში ან მის საბოლოო წაშლაში ის შედგება ორი ფუნქციისაგან<br>
                            1 - აღდგენა : ამ ღილაკის გამოყენების შემთხვევაში იგივე ადგილას დაბრუნდება წაშლილი item და აღუდგება ყველა უფლება<br>
                            2 - საბოლოო წაშლა : ამ ღილაკის გამოყენებით შეუძლებელი იქნება მისი უკან დაბრუნება/აღდგენა
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush

