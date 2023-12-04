<?php

namespace App\WebPage\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\WebPage\Validators\WebPageRequestValidator;

class WebPageRequestValidatorMiddleware
{
    private WebPageRequestValidator $webPageRequestValidator;

    public function __construct(
        WebPageRequestValidator $webPageRequestValidator
    ) {
        $this->webPageRequestValidator = $webPageRequestValidator;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $validationResponse = $this->webPageRequestValidator->validateRequest($request);

        if ($validationResponse != null) {
            return response()->json($validationResponse, Response::HTTP_BAD_REQUEST);
        }

        return $next($request);
    }
}
