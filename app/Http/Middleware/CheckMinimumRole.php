<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckMinimumRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $minimumRole)
    {
        //dd($minimumRole);
        $canAccess = false;

        if ( $request->user()->roles()->first()->id <= $minimumRole ) 
            $canAccess = true;

        /*$minimumRoles = $this->_getRequiredRoleForRoute($request->route());

        if ( is_array($minimumRoles) ) {

            foreach ($minimumRoles as $role) {

                $canAccess = false;
                if ( $request->user()->roles()->first()->id <= $role )
                    $canAccess = true;
            }
        } else {

            $canAccess = false;
            if ( $request->user()->roles()->first()->id <= $minimumRoles )
                $canAccess = true;
        }*/
        

        if ($canAccess) return $next($request);

		return response([
			'error' => [
				'code' => 'INSUFFICIENT_ROLE',
				'description' => 'You are not authorized to access this resource.'
			]
		], 401);
    }

    /*private function _getRequiredRoleForRoute($route)
	{
        $actions = $route->getAction();
		return isset($actions['roles']) ? $actions['roles'] : null;
	}*/
}