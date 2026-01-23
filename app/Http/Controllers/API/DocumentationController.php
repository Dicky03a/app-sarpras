<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Web Sarpras API",
 *         version="1.0.0",
 *         description="API documentation for Web Sarpras application",
 *         @OA\Contact(
 *             email="admin@sarpras.com"
 *         ),
 *         @OA\License(
 *             name="MIT",
 *             url="http://www.opensource.org/licenses/mit-license.php"
 *         )
 *     ),
 *     @OA\Server(
 *         url=L5_SWAGGER_CONST_HOST,
 *         description="Development server"
 *     ),
 *     @OA\SecurityScheme(
 *         securityScheme="sanctum",
 *         type="apiKey",
 *         name="Authorization",
 *         in="header",
 *         description="Enter token in format (Bearer <token>)"
 *     )
 * )
 */
class DocumentationController extends Controller
{
    // This controller is just for API documentation purposes
}