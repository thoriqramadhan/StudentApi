<?php

namespace App\Http\Middleware;

use App\Models\Contest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContestOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $currentUser = Auth::user();
        $post = Contest::findOrFail($request->id);
        
        if($post -> author != $currentUser->id){
            return response()->json([
                'message' => 'data not found'
            ], 404);
        }

        return $next($request);
    }
}
