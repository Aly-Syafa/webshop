<?php namespace App\Http\Middleware;

use Closure;

class AdminMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $user = \Auth::user();
        $user->load('roles');

        $roles = $user->roles->lists('id')->all();

        if(!in_array(1,$roles))
        {
            return redirect()->to('/');
        }

		return $next($request);
	}

}
