@php
        $theme_name = 'default';
        $fix_header = false;
        $fix_sidebar = false;
        $theme_layout = '';
		
        if(auth()->user()){

            $user = auth()->user();

            $params = (object)json_decode($user->params);

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
                $theme_layout = $params->theme_layout;;
            }

            $experts = App\Expert::where('created_by', $user->id)->first();
            $data_session     =    HP::CheckSession();
        }

@endphp

<aside class="sidebar">
    <div class="scroll-sidebar">

        @if(auth()->check())

            @if($theme_layout != 'fix-header')
                <div class="user-profile">
                    <div class="dropdown user-pro-body ">
                        <div class="profile-image">

                            @if($user->picture == null)
                                <img src="{{ asset('storage/uploads/users/no_avatar.png') }}" alt="user-img" class="img-circle">
                            @else
                                <img src="{{ HP::getFileStorage('sso_users/'.$user->picture) }}" alt="user-img" class="img-circle">
                            @endif

                        </div>
                        <p class="profile-text m-t-15 font-16">
                            <a href="javascript:void(0);">
                                {{ $user->name }}
                            </a>
                        </p>
                    </div>
                    
                </div>
            @endif
            <nav class="sidebar-nav">
                <ul id="side-menu">
                    {{-- <li>
                        <a class="waves-effect" href="javascript:void(0);" aria-expanded="false"><i
                           class="icon-layers fa-fw"></i> <span class="hide-menu"> ตรวจติดตามออนไลน์</span>
                        </a>
                        <ul aria-expanded="false" class="collapse extra">
                          @foreach($laravelMenuEsurvs->menus as $section)
                            @if(count(collect($section->items)) > 0)
                                @foreach($section->items as $menu)
                                    @if(HP::CheckPermission('view-'.str_slug($menu->title)))
                                        <li>
                                            <a class="waves-effect" href="{{ url($menu->url) }}">
                                                <i class="{{$menu->icon}}" style="font-size:20px;"></i>
                                                {{ $menu->display }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                          @endforeach
                        </ul>
                    </li> --}}
                     <li>
                        <a class="waves-effect" href="javascript:void(0);" aria-expanded="false">
                          <i class="icon-badge fa-fw"></i> <span class="hide-menu"> ใบรับรองระบบงาน</span>
                        </a>
                        <ul aria-expanded="false" class="collapse extra">
                          @foreach($laravelMenuCertifys->menus as $section)
                            @if(count(collect($section->items)) > 0)
                                @foreach($section->items as $menu)
                                    @if(HP::CheckPermission('view-'.str_slug($menu->title)))
                                      <li>
                                          <a class="waves-effect" href="{{ url($menu->url) }}">
                                              <i class="{{$menu->icon}}" style="font-size:20px;"></i>
                                              {{ $menu->display }}
                                          </a>
                                      </li>
                                    @endif
                                @endforeach
                            @endif
                          @endforeach

                        </ul>
                    </li>
                   @if($data_session->applicanttype_id == 2  && is_null($data_session->agent_id))
                     <li>
                        <a class="waves-effect" href="javascript:void(0);" aria-expanded="false">
                          <i class="icon-badge fa-fw"></i> <span class="hide-menu"> ทะเบียนผู้เชี่ยวชาญ</span>
                        </a>
                        <ul aria-expanded="false" class="collapse extra">
                          @foreach($laravelMenuExperts->menus as $section)
                            @if(count(collect($section->items)) > 0)
                                @foreach($section->items as $menu)
                                    @if(HP::CheckPermission('view-'.str_slug($menu->title)))
                                        <li>
                                            <a class="waves-effect" href="{{ url($menu->url) }}">
                                                <i class="{{$menu->icon}}" style="font-size:20px;"></i>
                                                {{ $menu->display }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                          @endforeach
                    
                        </ul>
                      </li>
                    @endif
                    <li>
                        <a class="waves-effect" href="{{url('tisi/standard-offers')}}">
                              <i class=" icon-layers fa-fw"></i><span class="hide-menu"> กำหนดมาตรฐาน </span>
                        </a>
                      </li>

                      <li>
                        <a class="waves-effect" href="javascript:void(0);" aria-expanded="false">
                          <i class="icon-plus fa-fw"></i> <span class="hide-menu"> เพิ่มเติมขอบข่าย </span>
                        </a>
                        <ul aria-expanded="false" class="collapse extra">
                          @foreach($laravelMenuScopeRequests->menus as $section)
                          
                            @if(count(collect($section->items)) > 0)
                                @foreach($section->items as $menu)
                                    {{-- @if(HP::CheckPermission('view-'.str_slug($menu->title))) --}}
                                            <li>
                                                <a class="waves-effect" href="{{ url($menu->url) }}">
                                                    <i class="{{$menu->icon}}" style="font-size:20px;"></i>
                                                    {{ $menu->display }}
                                                </a>
                                            </li>
                                    {{-- @endif --}}
                                @endforeach
                            @endif
                          @endforeach
                        </ul>
                      </li>

                    <!-- <li>
                        <a class="waves-effect" href="javascript:void(0);" aria-expanded="true">
                          <i class="icon-badge fa fa-user"></i> <span class="hide-menu"> ทะเบียนผู้เชี่ยวชาญ</span>
                        </a>
                        <ul aria-expanded="true" class="collapse extra in">
                         
                                      <li>
                                          <a class="waves-effect" href="{{ url($menu->url) }}">
                                              <i class="mdi mdi-plus" style="font-size:20px;"></i>
                                                ขึ้นทะเบียน
                                          </a>
                                      </li>
                          
                        </ul>
                    </li> -->

                </ul>
            </nav>
        @endif
    </div>
</aside>
