<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Module;
use App\Models\Page;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * @var Page
     */
    private Page $page;

    /**
     * @var Module
     */
    private Module $module;

    /**
     * @var MenuItem
     */
    private MenuItem $menu;

    /**
     * PageController constructor.
     *
     * @param Page $page
     * @param Module $module
     * @param MenuItem $menu
     */
    public function __construct(Page $page, Module $module, MenuItem $menu)
    {
        $this->page = $page;
        $this->module = $module;
        $this->menu = $menu;
    }

    /**
     * Show dashboard page
     * @return View
     */
    public function index(): View
    {
        return \view('dashboard.dashboard');
    }

    /**
     * Show page with content and files
     *
     * @param Request $request
     * @param string $slug
     * @param string $puid
     * @param string|null $muid
     * @return RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function page(Request $request, string $slug, string $puid, ?string $muid = null)
    {
        $menuItem = $this->menu->findByUid($muid);
        $pageItem = $this->page->findByUid($puid);

        if ($pageItem && $pageItem->is_active) {
            return $this->page->getPage(
                $pageItem,
                $this->module->sortByOrder($this->module->getModulesWithAdditionalData($pageItem->id, true)),
                $menuItem
            );
        }

        $request->session()->flash('alert-error', trans('app.notify.something_went_wrong'));

        return redirect()->route('dashboard');
    }
}
