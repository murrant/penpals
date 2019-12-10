<?php

namespace App\Exceptions;

use Exception;

class MaxAddresses extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return $request->expectsJson()
            ? response()->json(['message' => __('exceptions.too-many-addresses')], 403)
            : response()->view('too-many-addresses');
    }
}
