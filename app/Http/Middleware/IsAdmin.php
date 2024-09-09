<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
class IsAdmin{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request 
     * @param  \Closure  $next
     * @return mixed
     */ 
    // public function handle($request, Closure $next){
    //     if(Auth::check()){
    //      //   exit('here');
    //         $user = Auth::user();
    //         if($user->hasRole('Admin')){
    //             return $next($request);
    //         }
    //     }
    //     return redirect('admin_login');
    // } 
    
   public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
           // $url = $request->url();
            // echo "<pre>"; print_r($request->is('admin/*')); exit();
           if ($user->roles->contains('name', 'Admin') && $request->is('admin/*')) {
                return $next($request);
            } else{
                return response('Unauthorized', 401);
            }
        }
        
        // Redirect to login or error page if the user is not an admin
        return redirect('login');
    }
}
