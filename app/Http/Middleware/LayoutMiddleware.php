<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

use App\User;

class LayoutMiddleware
{


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $theme = ['normal','fix-header','mini-sidebar'];
        if(isset(request()->theme)){
            if($request->isMethod('get') && in_array($request->theme,$theme)){
                Session::put('theme-layout', str_slug(request()->theme,'-'));

                //ถ้าเปลี่ยน Layout type save ไปที่ user
                $user = User::findOrFail(auth()->user()->getKey());

                $params = (object)json_decode($user->params);
                $params->theme_layout = str_slug(request()->theme,'-');

                $user->params = json_encode($params);
                $user->save();

            }else{
                //dd($request->path());
                $query = $request->query();
                Session::put('theme-layout','normal');
            }
            return back();

        }else{
            if(!session()->has('theme-layout')){
                Session::put('theme-layout','normal');
            }
        }
        //session()->save();
        return $next($request);
    }
}
