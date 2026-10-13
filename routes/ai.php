<?php

use App\Mcp\Servers\PropertyServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::web('/mcp/properties', PropertyServer::class)->middleware('auth:sanctum');   // remote
Mcp::local('properties', PropertyServer::class);