<?php


namespace Glas\Utils;

use Glas\Models\CUserModel;

class CRouter
{
    private $realRoutes = [];

    function __construct()
    {
        include 'routes.php';
        foreach ($routesData as $rolesStr => $rolesRoutes) {

            foreach ($rolesRoutes as $urlTemplate => $handleOptions) {
                $this->realRoutes[] = [
                    'urlRegexp' => $this->templateToRegexp($urlTemplate),
                    'methods' => $handleOptions['methods'],
                    'availableTo' => explode('|', $rolesStr),
                    'varNames' => $this->extractTemplateVariables($urlTemplate),
                    'varValues' => [],
                    'varData' => [],
                    'handlerData' => $this->extractControllerAction($urlTemplate)
                ];
            }
        }
    }

    public function transofrmUriToRoute($uri) {
        list($url, $queryString) = explode('?', $uri);
        $url = preg_replace('/\/*$/is', '', $url);

        foreach ( $this->realRoutes as $route) {
            if (preg_match('/' . $route['urlRegexp'] . '/is', $url)) {
                preg_match('/'.$route['urlRegexp'].'/is', $url, $matches);
                array_shift($matches);
                $route['varValues'] = $matches;

                for ($i = 0; $i < count($route['varNames']); $i++) {
                    $route['varData'][$route['varNames'][$i]] = $route['varValues'][$i];
                }

                return $route;
            }
        }

        return [];
    }

    private function extractTemplateVariables($urlTemplate) {
        preg_match_all('/{([a-z]+)}/is', $urlTemplate, $matches);
        return ($matches[1]);
    }

    private function templateToRegexp($urlTemplate) {
        $urlTemplate = preg_replace('/\//is', '\/', $urlTemplate);
        $urlTemplate = preg_replace('/{userId}/is', '(\d+)', $urlTemplate);
        $urlTemplate = preg_replace('/{messageId}/is', '(\d+)', $urlTemplate);
        $urlTemplate = preg_replace('/{referendumId}/is', '(\d+)', $urlTemplate);
        $urlTemplate = preg_replace('/{appealId}/is', '(\d+)', $urlTemplate);
        $urlTemplate = preg_replace('/{uuid}/is', '([a-z0-9-]+)', $urlTemplate);
        $urlTemplate = preg_replace('/{page}/is', '(\d+)', $urlTemplate);
        $urlTemplate = '^' . $urlTemplate . '$';
        return $urlTemplate;
    }

    private function extractControllerAction($urlTemplate) {
        $urlTemplate = preg_replace('/\/*{[^}]+}/is', '', $urlTemplate);
        $urlTemplate = preg_replace('/\/*page\/*$/is', '', $urlTemplate);
        $urlTemplate = preg_replace('/\/+/is', '/', $urlTemplate);
        $urlTemplate = preg_replace('/^\/+/is', '', $urlTemplate);

        if ($urlTemplate == '') {
            return ['controllerName' => 'Glas\\Controllers\\CCommonController', 'controllerMethodName' => 'main'];
        }

        $parts = explode('/', $urlTemplate);
        if (count($parts) > 0) {
            $controllerName = 'C' . ucfirst(array_shift($parts)).'Controller';
            $controllerMethodName = array_shift($parts);

            for ($i = 0; $i < count($parts); $i++) {
                $controllerMethodName .= ucfirst($parts[$i]);
            }
        }

        return ['controllerName' => 'Glas\\Controllers\\' . $controllerName, 'controllerMethodName' => $controllerMethodName];
    }
}