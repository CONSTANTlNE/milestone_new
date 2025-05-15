<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a class="has-arrow ai-icon" href="{{ route('backend.index', app()->getLocale())}}">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">{{ __('strings.Dashboard') }}</span>
                </a>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="#" aria-expanded="false">
                    <i class="flaticon-381-layer-1"></i>
                    <span class="nav-text">{{ __('strings.Pages') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('backend.pages.index', app()->getLocale())}}">{{ __('strings.All Page') }}</a></li>
                    <li><a href="{{ route('backend.pages.create', app()->getLocale())}}">{{ __('strings.Create Page') }}</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="#" aria-expanded="false">
                    <i class="flaticon-381-network"></i>
                    <span class="nav-text">{{ __('strings.Content') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('backend.articles.index', app()->getLocale())}}">{{ __('strings.Articles') }}</a></li>
                    <li><a href="{{ route('backend.articleCategory.index', app()->getLocale())}}">{{ __('strings.Category Articles') }}</a></li>
                    <li><a href="{{ route('backend.versus.index', app()->getLocale())}}">{{ __('strings.Versus') }}</a></li>
                    <li><a href="{{ route('backend.medias.index', app()->getLocale())}}">{{ __('strings.Fact in Media') }}</a></li>
                    <li><a href="{{ route('backend.regions.index', app()->getLocale())}}">{{ __('strings.Regions') }}</a></li>
                    <li><a href="{{ route('backend.persons.index', app()->getLocale())}}">{{ __('strings.Persons') }}</a></li>
                    <li><a href="{{ route('backend.verdicts.index', app()->getLocale())}}">{{ __('strings.Verdicts') }}</a></li>
{{--                    <li><a href="{{ route('backend.index', app()->getLocale())}}">{{ __('strings.Quizzes') }}</a></li>--}}
                    <li><a href="{{ route('backend.data.index', app()->getLocale())}}">{{ __('strings.Database') }}</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="{{ route('backend.menus.index', app()->getLocale())}}" aria-expanded="false">
                    <i class="flaticon-381-menu"></i>
                    <span class="nav-text">{{ __('strings.MenuTrait') }}</span>
                </a>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="{{ route('backend.files.index', app()->getLocale()) }}" aria-expanded="false">
                    <i class="flaticon-381-upload"></i>
                    <span class="nav-text">{{ __('strings.Media Library') }}</span>
                </a>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="{{ route('backend.teams.index', app()->getLocale())}}" aria-expanded="false">
                    <i class="flaticon-381-user-9"></i>
                    <span class="nav-text">{{ __('strings.Company Team') }}</span>
                </a>
            </li>
            <li>
                <a class="has-arrow ai-icon" aria-expanded="false">
                    <i class="flaticon-381-album-2"></i>
                    <span class="nav-text">{{ __('strings.Banners') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('backend.banners.index', app()->getLocale())}}">{{ __('strings.Banners') }}</a></li>
                    <li><a href="{{ route('backend.partners.index', app()->getLocale())}}">{{ __('strings.Partners') }}</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" aria-expanded="false">
                    <i class="flaticon-381-flag-2"></i>
                    <span class="nav-text">{{ __('strings.Languages') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('backend.locales.index', app()->getLocale())}}">{{ __('strings.All Language') }}</a></li>
                    <li><a href="{{ route('backend.locales.static.index', app()->getLocale()) }}">{{ __('strings.Static Words') }}</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="#" aria-expanded="false">
                    <i class="flaticon-381-user"></i>
                    <span class="nav-text">{{ __('strings.User Management') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('backend.users.index', app()->getLocale())}}">{{ __('strings.All User') }}</a></li>
                    <li><a href="{{ route('backend.users.create', app()->getLocale())}}">{{ __('strings.Create User') }}</a></li>
                    <li><a href="{{ route('backend.roles.index', app()->getLocale())}}">{{ __('strings.Roles') }}</a></li>
                    <li><a href="{{ route('backend.permissions.index', app()->getLocale())}}">{{ __('strings.Permissions') }}</a></li>
                    <li><a href="{{ route('backend.subscribers.index', app()->getLocale())}}">{{ __('strings.Subscribers') }}</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="#" aria-expanded="false">
                    <i class="flaticon-381-settings"></i>
                    <span class="nav-text">{{ __('strings.Settings') }}</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('backend.settings.edit', [app()->getLocale(), 'id'=>1]) }}">{{ __('strings.Contact') }} / {{ __('strings.Settings') }}</a></li>
                    <li><a href="{{ route('backend.socials.index', app()->getLocale())}}">{{ __('strings.Social Network') }}</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="{{ route('backend.logout', app()->getLocale()) }}" aria-expanded="false" onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                    <i class="flaticon-381-turn-off"></i>
                    <span class="nav-text">{{ __('strings.Logout') }}</span>
                </a>
                <form id="logout-form" action="{{ route('backend.logout', app()->getLocale()) }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
        <div class="footer">
            <div class="copyright">
                <p>Copyright © {{date('Y')}} {{ __('site title') }}</p>
            </div>
        </div>
    </div>
</div>

