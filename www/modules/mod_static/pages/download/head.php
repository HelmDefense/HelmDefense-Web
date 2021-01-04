<?php
Utils::addResource("<link href='/data/css/pagination.css' rel='stylesheet' />");
foreach (Utils::$components["markdowntext"]->getResources() as $resource)
	Utils::addResource($resource);
