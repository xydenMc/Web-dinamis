<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Store display flashdata in its only supported presentation type: string.
     * Arrays (including validation-like nested arrays) are flattened before they
     * enter the session, keeping all views safe to pass the result through esc().
     *
     * @param mixed $value
     */
    protected function setFlashString(string $key, $value, string $separator = ' '): void
    {
        helper('flash');

        $normalize = static function ($item) use (&$normalize): array {
            if ($item === null) {
                return [];
            }

            if (is_array($item)) {
                $parts = [];
                foreach ($item as $child) {
                    array_push($parts, ...$normalize($child));
                }

                return $parts;
            }

            if (is_bool($item)) {
                return [$item ? 'true' : 'false'];
            }

            if (is_scalar($item) || $item instanceof \Stringable) {
                return [(string) $item];
            }

            return [];
        };

        session()->setFlashdata($key, implode($separator, $normalize($value)));
    }

    /**
     * Redirect after storing a normalized flash message.
     *
     * @param mixed $value
     */
    protected function redirectWithFlash(string $uri, string $key, $value)
    {
        $this->setFlashString($key, $value);

        return redirect()->to($uri);
    }

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
    }
}
