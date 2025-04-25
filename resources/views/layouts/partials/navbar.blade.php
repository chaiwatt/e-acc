@php

    $theme_name = 'default';
    $fix_header = false;
    $fix_sidebar = false;
    $theme_layout = 'normal';

    if(auth()->user()){

        $params = (object)json_decode(auth()->user()->params);

        if(!empty($params->theme_name)){
            if(is_file('css/colors/'.$params->theme_name.'.css')){
                $theme_name = $params->theme_name;
            }
        }

        if(!empty($params->fix_header) && $params->fix_header=="true"){
            $fix_header = true;
        }

        if(!empty($params->fix_sidebar) && $params->fix_sidebar=="true"){
            $fix_sidebar = true;
        }

        if(!empty($params->theme_layout)){
            $theme_layout = $params->theme_layout;
        }
    }

    //Search Menus Json
    $json_search = [];
    $data_session     =    HP::CheckSession();
    if(!empty($data_session)){

    //เมนูทั้งหมด
        $all_menus = array($laravelMenuEsurvs,
                           $laravelMenuCertifys );

        foreach ($all_menus as $all_menu) {

            foreach ($all_menu as $menu_key => $menu_groups) {
             $menu_groups = $menu_groups[0];

              foreach ($menu_groups->items as $item_menu) {
                if( HP::CheckPermission('view-'.str_slug($item_menu->title,'-')) ) {
                  $json_search[] = ['value'=> url($item_menu->url),
                                    'label'=> $item_menu->display,
                                    'desc'=> $menu_groups->_comment.' <big><i class="mdi mdi-arrow-right-bold"/></i></big> '.$item_menu->display
                                   ];
                }
              }

            }

        }

    }

    $config = HP::getConfig();

@endphp

<nav class="navbar navbar-default navbar-static-top m-b-0">
    <div class="navbar-header">
        <a class="navbar-toggle font-20 hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse"
           data-target=".navbar-collapse">
            <i class="fa fa-bars"></i>
        </a>
        <div class="top-left-part">
            {{-- @if(auth()->check())
                <a class="logo" href="{{ url('/home') }}">
                    <b>
                        <img src="{{asset('plugins/images/logo.png')}}" alt="home"/>
                    </b>
                    <span>
                    <img src="{{asset('plugins/images/logo-text.png')}}" alt="homepage" class="dark-logo"/>
                </span>
                </a>
            @else --}}
                <a class="logo" href="{{ url('/home') }}">
                    {{-- <b>
                        <img src="{{asset('plugins/images/logo.png')}}" alt="home"/>
                    </b>
                    <span>
                    <img src="{{asset('plugins/images/logo-text.png')}}" alt="homepage" class="dark-logo"/>
                </span> --}}
                    <b>
                        <img src="{{asset('images/logo01.png')}}"  width="35px" alt="home"/>
                    </b>
                    <span>
                        บริการอิเล็กทรอนิกส์ สมอ.
                        {{-- <img src="{{asset('plugins/images/logo_text.png')}}" alt="homepage" class="dark-logo"/> --}}
                    </span>
                </a>
            {{-- @endif --}}

        </div>
        <ul class="nav navbar-top-links navbar-left hidden-xs">
            @if($theme_layout != 'fix-header' && auth()->check())
                <li class="sidebar-toggle">
                    <a href="javascript:void(0)" class="sidebartoggler font-20 waves-effect waves-light"><i class="icon-arrow-left-circle"></i></a>
                </li>
            @endif

            @if(auth()->check())
              <li>
                  <div role="search" class="app-search hidden-xs">
                      <i class="icon-magnifier"></i>
                      <input type="text" placeholder="ค้นหาเมนู..." class="form-control" id="search-menu">
                  </div>
              </li>
            @endif

        </ul>

        <ul class="nav navbar-top-links navbar-right pull-right">
            {{--  @if(auth()->check())
                <li class="right-side-toggle">
                    <a class="right-side-toggler waves-effect waves-light b-r-0 font-20" href="javascript:void(0)">
                        <i class="icon-settings"></i>
                    </a>
                </li>
            @else
               @if(@HP::getConfig()->url_register!='')
                  <li class="">
                      <a  class="waves-effect waves-light b-r-0 font-20" href="{{ HP::getConfig()->url_register }}" >
                          <i class="icon-user-follow"></i>
                      </a>
                  </li>
                @endif --}}
                @if (!empty($config->url_sso))
                    <li class="">
                        <a  class="waves-effect waves-light b-r-0 font-20" href="{{ $config->url_sso }}" >
                            <i class="fa fa-home" ></i> กลับหน้า Dashboard
                        </a>
                    </li>
                @endif
                @if (!empty($config->url_sso))
                <li class="">
                    <a  class="waves-effect waves-light b-r-0 font-20" href="{{ $config->url_sso.'/logout' }}" >
                        <i class="icon-login"></i>
                    </a>
                </li>
                 @endif
                    {{-- <li class="">
                        <a  class="waves-effect waves-light b-r-0 font-20" href="{{  route('login') }}" >
                            <i class="icon-login"></i>
                        </a>
                    </li> --}}
            {{-- @endif --}}

        </ul>
    </div>
</nav>

@push('js')

  <script type="text/javascript">

    $(document).ready(function () {

      @if(auth()->check())

          var projects = {!! json_encode($json_search) !!};

          $( "#search-menu" ).autocomplete({
            minLength: 1,
            source: projects,
            focus: function( event, ui ) {
              $( "#search-menu" ).val( ui.item.label );
              return false;
            },
            select: function( event, ui ) {
              $( "#search-menu" ).val( ui.item.label );
              window.location = ui.item.value;
              return false;
            }
          })
          .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
              .append( "<div>" + item.label + "<br><small class=\"text-muted\">" + item.desc + "</small></div>" )
              .appendTo( ul );
          };

      @endif

    });



  </script>

@endpush
